<?php

namespace Database\Seeders;

use App\Features\Roles\Enums\Roles;
use App\Http\Enums\Guards;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // gets all permissions via Gate::before rule; see AuthServiceProvider
        Role::create(['name' => Roles::SuperAdmin->value(), 'guard_name' => Guards::API->value()]);
        Role::create(['name' => Roles::Staff->value(), 'guard_name' => Guards::API->value()]);
        Role::create(['name' => Roles::ContentManager->value(), 'guard_name' => Guards::API->value()]);
        Role::create(['name' => Roles::InventoryManager->value(), 'guard_name' => Guards::API->value()]);
        Role::create(['name' => Roles::WarehouseManager->value(), 'guard_name' => Guards::API->value()]);
        Role::create(['name' => Roles::DeliveryAgent->value(), 'guard_name' => Guards::API->value()]);
        Role::create(['name' => Roles::User->value(), 'guard_name' => Guards::API->value()]);
        Role::create(['name' => Roles::AppPromoter->value(), 'guard_name' => Guards::API->value()]);
        Role::create(['name' => Roles::RewardRiders->value(), 'guard_name' => Guards::API->value()]);
        Role::create(['name' => Roles::ReferralRockstars->value(), 'guard_name' => Guards::API->value()]);
    }
}
