<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_browse_public_group_catalog_and_details(): void
    {
        $owner = User::factory()->create();
        $group = Group::create([
            'name' => 'Publiczna grupa',
            'description' => 'Dostepna bez logowania',
            'owner_id' => $owner->id,
        ]);
        $group->users()->attach($owner->id);

        $this->get(route('public.groups.index'))
            ->assertOk()
            ->assertSee('Publiczna grupa');

        $this->get(route('public.groups.show', $group))
            ->assertOk()
            ->assertSee('Podglad publiczny')
            ->assertSee('Publiczna grupa');
    }

    public function test_guest_cannot_create_group_without_login(): void
    {
        $this->post(route('groups.store'), [
            'name' => 'Nowa grupa',
            'description' => 'Opis',
        ])->assertRedirect(route('login'));
    }
}
