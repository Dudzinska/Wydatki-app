<?php

namespace Tests\Feature;

use App\Models\Bill;
use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillAdvancedLogicTest extends TestCase
{
    use RefreshDatabase;

    public function test_bill_items_trigger_split_recalculation(): void
    {
        $owner = User::factory()->create();
        $friend = User::factory()->create();

        $group = Group::create([
            'name' => 'Wyjazd',
            'description' => 'Test podzialu',
            'owner_id' => $owner->id,
        ]);
        $group->users()->attach([$owner->id, $friend->id]);

        $this->actingAs($owner)
            ->post(route('bills.store', $group), [
                'description' => 'Obiad',
                'amount' => 100,
                'payer_id' => $owner->id,
            ])->assertRedirect();

        $bill = Bill::firstOrFail();
        $this->assertEquals(50.0, (float) $bill->splits()->where('user_id', $friend->id)->value('amount'));
        $this->assertEquals(50.0, (float) $bill->splits()->where('user_id', $owner->id)->value('amount'));

        $this->actingAs($owner)
            ->post(route('bill-items.store', [$group, $bill]), [
                'bill_item_bill_id' => $bill->id,
                'name' => 'Danie glowne',
                'price' => 100,
                'quantity' => 1,
            ])->assertRedirect();

        $friendShare = (float) $bill->splits()->where('user_id', $friend->id)->value('amount');
        $ownerShare = (float) $bill->splits()->where('user_id', $owner->id)->value('amount');

        $this->assertEquals(50.0, $friendShare);
        $this->assertEquals(50.0, $ownerShare);
    }

    public function test_group_can_generate_minimal_settlement_plan_from_items(): void
    {
        $owner = User::factory()->create();
        $debtorOne = User::factory()->create();
        $debtorTwo = User::factory()->create();

        $group = Group::create([
            'name' => 'Mieszkanie',
            'owner_id' => $owner->id,
        ]);
        $group->users()->attach([$owner->id, $debtorOne->id, $debtorTwo->id]);

        $this->actingAs($owner)->post(route('bills.store', $group), [
            'description' => 'Zakupy',
            'amount' => 90,
            'payer_id' => $owner->id,
        ])->assertRedirect();

        $bill = Bill::firstOrFail();

        $this->actingAs($owner)->post(route('bill-items.store', [$group, $bill]), [
            'bill_item_bill_id' => $bill->id,
            'name' => 'Pozycja 1',
            'price' => 30,
            'quantity' => 1,
        ])->assertRedirect();

        $this->actingAs($owner)->post(route('bill-items.store', [$group, $bill]), [
            'bill_item_bill_id' => $bill->id,
            'name' => 'Pozycja 2',
            'price' => 60,
            'quantity' => 1,
        ])->assertRedirect();

        $plan = $group->fresh()->getSettlementPlan();

        $this->assertCount(2, $plan);
        $this->assertSame($owner->id, $plan[0]['to']->id);
        $this->assertSame($owner->id, $plan[1]['to']->id);
        $this->assertEquals(30.00, $plan[0]['amount']);
        $this->assertEquals(30.00, $plan[1]['amount']);
    }

    public function test_missing_bill_amount_is_split_equally_between_members(): void
    {
        $owner = User::factory()->create();
        $friend = User::factory()->create();

        $group = Group::create([
            'name' => 'Kolacja',
            'owner_id' => $owner->id,
        ]);
        $group->users()->attach([$owner->id, $friend->id]);

        $this->actingAs($owner)->post(route('bills.store', $group), [
            'description' => 'Kolacja',
            'amount' => 234,
            'payer_id' => $owner->id,
        ])->assertRedirect();

        $bill = Bill::firstOrFail();

        $this->actingAs($owner)->post(route('bill-items.store', [$group, $bill]), [
            'bill_item_bill_id' => $bill->id,
            'name' => 'Desery',
            'price' => 60,
            'quantity' => 2,
        ])->assertRedirect();

        $friendShare = (float) $bill->splits()->where('user_id', $friend->id)->value('amount');
        $ownerShare = (float) $bill->splits()->where('user_id', $owner->id)->value('amount');

        $this->assertEquals(117.0, $friendShare);
        $this->assertEquals(117.0, $ownerShare);
    }
    public function test_bill_without_items_is_split_equally_between_members(): void
    {
        $payer = User::factory()->create();
        $member = User::factory()->create();

        $group = Group::create([
            'name' => 'Weekend',
            'owner_id' => $payer->id,
        ]);
        $group->users()->attach([$payer->id, $member->id]);

        $this->actingAs($payer)->post(route('bills.store', $group), [
            'description' => 'Nocleg',
            'amount' => 800,
            'payer_id' => $payer->id,
        ])->assertRedirect();

        $bill = Bill::firstOrFail();

        $this->assertEquals(400.0, (float) $bill->splits()->where('user_id', $payer->id)->value('amount'));
        $this->assertEquals(400.0, (float) $bill->splits()->where('user_id', $member->id)->value('amount'));
    }
}
