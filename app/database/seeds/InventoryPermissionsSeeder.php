<?php

class InventoryPermissionsSeeder extends DatabaseSeeder
{
    public function run()
    {

        /* Permissions table */
        $manageInvPerm = Permission::create(array("name" => "manage_inventory", "display_name" => "Can manage Inventory"));
        $requestTopupPerm = Permission::create(array("name" => "request_topup", "display_name" => "Can request Inventory topup"));

        $this->command->info('Permissions table seeded');

        $roleIM = Role::create(array("name" => "Inventory Manager"));

        $this->command->info('Roles table seeded');

        //Assign permissions to ADMIN
        Role::find(1)->attachPermission($manageInvPerm);
        Role::find(1)->attachPermission($requestTopupPerm);
    }

}