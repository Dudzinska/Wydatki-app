<?php

namespace Tests\Feature;

use App\Models\Bill;
use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_browse_group_catalog_and_details(): void
    {
        $owner = User::factory()->create();
        $group = Group::create([
            'name' => 'Chroniona grupa',
            'description' => 'Dostepna po zalogowaniu',
            'owner_id' => $owner->id,
        ]);
        $group->users()->attach($owner->id);

        $this->get(route('public.groups.index'))
            ->assertRedirect(route('login'));

        $this->get(route('public.groups.show', $group))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_browse_group_catalog_and_details(): void
    {
        $owner = User::factory()->create();
        $group = Group::create([
            'name' => 'Chroniona grupa',
            'description' => 'Dostepna po zalogowaniu',
            'owner_id' => $owner->id,
        ]);
        $group->users()->attach($owner->id);

        $this->actingAs($owner)
            ->get(route('public.groups.index'))
            ->assertOk()
            ->assertSee('Chroniona grupa');

        $this->actingAs($owner)
            ->get(route('public.groups.show', $group))
            ->assertOk()
            ->assertSee('Podglad grupy')
            ->assertSee('Chroniona grupa');
    }

    public function test_guest_cannot_create_group_without_login(): void
    {
        $this->post(route('groups.store'), [
            'name' => 'Nowa grupa',
            'description' => 'Opis',
        ])->assertRedirect(route('login'));
    }

    public function test_guest_cannot_access_group_and_bill_management_routes(): void
    {
        $owner = User::factory()->create();
        $group = Group::create([
            'name' => 'Wyjazd',
            'owner_id' => $owner->id,
        ]);
        $group->users()->attach($owner->id);
        $bill = Bill::create([
            'group_id' => $group->id,
            'payer_id' => $owner->id,
            'description' => 'Nocleg',
            'amount' => 120,
            'date' => now(),
        ]);

        $this->get(route('groups.index'))->assertRedirect(route('login'));
        $this->get(route('groups.show', $group))->assertRedirect(route('login'));
        $this->get(route('groups.edit', $group))->assertRedirect(route('login'));
        $this->patch(route('groups.update', $group))->assertRedirect(route('login'));
        $this->delete(route('groups.destroy', $group))->assertRedirect(route('login'));
        $this->post(route('groups.add-user', $group))->assertRedirect(route('login'));
        $this->post(route('bills.store', $group))->assertRedirect(route('login'));
        $this->delete(route('bills.destroy', [$group, $bill]))->assertRedirect(route('login'));
        $this->post(route('bill-items.store', [$group, $bill]))->assertRedirect(route('login'));
    }
}
