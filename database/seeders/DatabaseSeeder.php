<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Store;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create sample stores
        $store1 = Store::create(['name' => 'Store 1', "slug" => "s1"]);
        $store2 = Store::create(['name' => 'Store 2', "slug" => "s2"]);

        // Create sample roles
        $adminRole = Role::create(['name' => 'Admin']);
        $managerRole = Role::create(['name' => 'Manager']);

        // Create sample permissions
        $productCreate = Permission::create(['name' => 'product.create']);
        $productUpdate = Permission::create(['name' => 'product.update']);
        $dashboardAccess = Permission::create(['name' => 'dashboard.access']);

        // Attach permissions to roles
        $adminRole->permissions()->attach([$productCreate->id, $productUpdate->id, $dashboardAccess->id]);
        $managerRole->permissions()->attach([$productCreate->id, $dashboardAccess->id]);

        // Create sample users
        $user1 = User::create([
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => bcrypt('password') // You can change this to a more secure password
        ]);

        $user2 = User::create([
            'firstName' => 'Jane',
            'lastName' => 'Doe',
            'email' => 'c',

            'password' => bcrypt('password') // You can change this to a more secure password
        ]);

        // Assign roles to users for specific stores
        $user1->storeUserRoles()->create([
            'role_id' => $adminRole->id,
            'store_id' => $store1->id
        ]);

        $user2->storeUserRoles()->create([
            'role_id' => $managerRole->id,
            'store_id' => $store2->id
        ]);

        // Attach permissions to store-user roles (optional if permissions need to be store-specific)
        $store1AdminRole = $user1->storeUserRoles->first();
        $store2ManagerRole = $user2->storeUserRoles->first();

        $store1AdminRole->permissions()->attach([$productCreate->id, $productUpdate->id, $dashboardAccess->id]);
        $store2ManagerRole->permissions()->attach([$productCreate->id, $dashboardAccess->id]);

        // Output to console for confirmation
        $this->command->info('Database seeded with sample data!');
    }
}
