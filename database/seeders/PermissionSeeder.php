<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        Permission::updateOrCreate(
            [
                'id' => 1,
                'name' => 'view_role',
                'guard_name' => 'web',
            ],
            [
                'id' => 1,
                'name' => 'view_role',
                'guard_name' => 'web',
                'created_at' => '2025-08-06 14:33:47',
                'updated_at' => '2025-08-06 14:33:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 2,
                'name' => 'view_any_role',
                'guard_name' => 'web',
            ],
            [
                'id' => 2,
                'name' => 'view_any_role',
                'guard_name' => 'web',
                'created_at' => '2025-08-06 14:33:47',
                'updated_at' => '2025-08-06 14:33:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 3,
                'name' => 'create_role',
                'guard_name' => 'web',
            ],
            [
                'id' => 3,
                'name' => 'create_role',
                'guard_name' => 'web',
                'created_at' => '2025-08-06 14:33:47',
                'updated_at' => '2025-08-06 14:33:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 4,
                'name' => 'update_role',
                'guard_name' => 'web',
            ],
            [
                'id' => 4,
                'name' => 'update_role',
                'guard_name' => 'web',
                'created_at' => '2025-08-06 14:33:47',
                'updated_at' => '2025-08-06 14:33:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 5,
                'name' => 'delete_role',
                'guard_name' => 'web',
            ],
            [
                'id' => 5,
                'name' => 'delete_role',
                'guard_name' => 'web',
                'created_at' => '2025-08-06 14:33:47',
                'updated_at' => '2025-08-06 14:33:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 6,
                'name' => 'delete_any_role',
                'guard_name' => 'web',
            ],
            [
                'id' => 6,
                'name' => 'delete_any_role',
                'guard_name' => 'web',
                'created_at' => '2025-08-06 14:33:47',
                'updated_at' => '2025-08-06 14:33:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 7,
                'name' => 'view_academic::staff',
                'guard_name' => 'web',
            ],
            [
                'id' => 7,
                'name' => 'view_academic::staff',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 8,
                'name' => 'view_any_academic::staff',
                'guard_name' => 'web',
            ],
            [
                'id' => 8,
                'name' => 'view_any_academic::staff',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 9,
                'name' => 'create_academic::staff',
                'guard_name' => 'web',
            ],
            [
                'id' => 9,
                'name' => 'create_academic::staff',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 10,
                'name' => 'update_academic::staff',
                'guard_name' => 'web',
            ],
            [
                'id' => 10,
                'name' => 'update_academic::staff',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 11,
                'name' => 'restore_academic::staff',
                'guard_name' => 'web',
            ],
            [
                'id' => 11,
                'name' => 'restore_academic::staff',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 12,
                'name' => 'restore_any_academic::staff',
                'guard_name' => 'web',
            ],
            [
                'id' => 12,
                'name' => 'restore_any_academic::staff',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 13,
                'name' => 'replicate_academic::staff',
                'guard_name' => 'web',
            ],
            [
                'id' => 13,
                'name' => 'replicate_academic::staff',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 14,
                'name' => 'reorder_academic::staff',
                'guard_name' => 'web',
            ],
            [
                'id' => 14,
                'name' => 'reorder_academic::staff',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 15,
                'name' => 'delete_academic::staff',
                'guard_name' => 'web',
            ],
            [
                'id' => 15,
                'name' => 'delete_academic::staff',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 16,
                'name' => 'delete_any_academic::staff',
                'guard_name' => 'web',
            ],
            [
                'id' => 16,
                'name' => 'delete_any_academic::staff',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 17,
                'name' => 'force_delete_academic::staff',
                'guard_name' => 'web',
            ],
            [
                'id' => 17,
                'name' => 'force_delete_academic::staff',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 18,
                'name' => 'force_delete_any_academic::staff',
                'guard_name' => 'web',
            ],
            [
                'id' => 18,
                'name' => 'force_delete_any_academic::staff',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 19,
                'name' => 'view_category',
                'guard_name' => 'web',
            ],
            [
                'id' => 19,
                'name' => 'view_category',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 20,
                'name' => 'view_any_category',
                'guard_name' => 'web',
            ],
            [
                'id' => 20,
                'name' => 'view_any_category',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 21,
                'name' => 'create_category',
                'guard_name' => 'web',
            ],
            [
                'id' => 21,
                'name' => 'create_category',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 22,
                'name' => 'update_category',
                'guard_name' => 'web',
            ],
            [
                'id' => 22,
                'name' => 'update_category',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 23,
                'name' => 'restore_category',
                'guard_name' => 'web',
            ],
            [
                'id' => 23,
                'name' => 'restore_category',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 24,
                'name' => 'restore_any_category',
                'guard_name' => 'web',
            ],
            [
                'id' => 24,
                'name' => 'restore_any_category',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 25,
                'name' => 'replicate_category',
                'guard_name' => 'web',
            ],
            [
                'id' => 25,
                'name' => 'replicate_category',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 26,
                'name' => 'reorder_category',
                'guard_name' => 'web',
            ],
            [
                'id' => 26,
                'name' => 'reorder_category',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 27,
                'name' => 'delete_category',
                'guard_name' => 'web',
            ],
            [
                'id' => 27,
                'name' => 'delete_category',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 28,
                'name' => 'delete_any_category',
                'guard_name' => 'web',
            ],
            [
                'id' => 28,
                'name' => 'delete_any_category',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 29,
                'name' => 'force_delete_category',
                'guard_name' => 'web',
            ],
            [
                'id' => 29,
                'name' => 'force_delete_category',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 30,
                'name' => 'force_delete_any_category',
                'guard_name' => 'web',
            ],
            [
                'id' => 30,
                'name' => 'force_delete_any_category',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 31,
                'name' => 'view_document',
                'guard_name' => 'web',
            ],
            [
                'id' => 31,
                'name' => 'view_document',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 32,
                'name' => 'view_any_document',
                'guard_name' => 'web',
            ],
            [
                'id' => 32,
                'name' => 'view_any_document',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 33,
                'name' => 'create_document',
                'guard_name' => 'web',
            ],
            [
                'id' => 33,
                'name' => 'create_document',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 34,
                'name' => 'update_document',
                'guard_name' => 'web',
            ],
            [
                'id' => 34,
                'name' => 'update_document',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 35,
                'name' => 'restore_document',
                'guard_name' => 'web',
            ],
            [
                'id' => 35,
                'name' => 'restore_document',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 36,
                'name' => 'restore_any_document',
                'guard_name' => 'web',
            ],
            [
                'id' => 36,
                'name' => 'restore_any_document',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 37,
                'name' => 'replicate_document',
                'guard_name' => 'web',
            ],
            [
                'id' => 37,
                'name' => 'replicate_document',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 38,
                'name' => 'reorder_document',
                'guard_name' => 'web',
            ],
            [
                'id' => 38,
                'name' => 'reorder_document',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 39,
                'name' => 'delete_document',
                'guard_name' => 'web',
            ],
            [
                'id' => 39,
                'name' => 'delete_document',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 40,
                'name' => 'delete_any_document',
                'guard_name' => 'web',
            ],
            [
                'id' => 40,
                'name' => 'delete_any_document',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 41,
                'name' => 'force_delete_document',
                'guard_name' => 'web',
            ],
            [
                'id' => 41,
                'name' => 'force_delete_document',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 42,
                'name' => 'force_delete_any_document',
                'guard_name' => 'web',
            ],
            [
                'id' => 42,
                'name' => 'force_delete_any_document',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 43,
                'name' => 'lock_document',
                'guard_name' => 'web',
            ],
            [
                'id' => 43,
                'name' => 'lock_document',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 44,
                'name' => 'publish_document',
                'guard_name' => 'web',
            ],
            [
                'id' => 44,
                'name' => 'publish_document',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 45,
                'name' => 'view_faculty',
                'guard_name' => 'web',
            ],
            [
                'id' => 45,
                'name' => 'view_faculty',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 46,
                'name' => 'view_any_faculty',
                'guard_name' => 'web',
            ],
            [
                'id' => 46,
                'name' => 'view_any_faculty',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 47,
                'name' => 'create_faculty',
                'guard_name' => 'web',
            ],
            [
                'id' => 47,
                'name' => 'create_faculty',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 48,
                'name' => 'update_faculty',
                'guard_name' => 'web',
            ],
            [
                'id' => 48,
                'name' => 'update_faculty',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 49,
                'name' => 'restore_faculty',
                'guard_name' => 'web',
            ],
            [
                'id' => 49,
                'name' => 'restore_faculty',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 50,
                'name' => 'restore_any_faculty',
                'guard_name' => 'web',
            ],
            [
                'id' => 50,
                'name' => 'restore_any_faculty',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 51,
                'name' => 'replicate_faculty',
                'guard_name' => 'web',
            ],
            [
                'id' => 51,
                'name' => 'replicate_faculty',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 52,
                'name' => 'reorder_faculty',
                'guard_name' => 'web',
            ],
            [
                'id' => 52,
                'name' => 'reorder_faculty',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 53,
                'name' => 'delete_faculty',
                'guard_name' => 'web',
            ],
            [
                'id' => 53,
                'name' => 'delete_faculty',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 54,
                'name' => 'delete_any_faculty',
                'guard_name' => 'web',
            ],
            [
                'id' => 54,
                'name' => 'delete_any_faculty',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 55,
                'name' => 'force_delete_faculty',
                'guard_name' => 'web',
            ],
            [
                'id' => 55,
                'name' => 'force_delete_faculty',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 56,
                'name' => 'force_delete_any_faculty',
                'guard_name' => 'web',
            ],
            [
                'id' => 56,
                'name' => 'force_delete_any_faculty',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:47',
                'updated_at' => '2025-08-07 02:36:47',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 57,
                'name' => 'view_forum::thread',
                'guard_name' => 'web',
            ],
            [
                'id' => 57,
                'name' => 'view_forum::thread',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 58,
                'name' => 'view_any_forum::thread',
                'guard_name' => 'web',
            ],
            [
                'id' => 58,
                'name' => 'view_any_forum::thread',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 59,
                'name' => 'create_forum::thread',
                'guard_name' => 'web',
            ],
            [
                'id' => 59,
                'name' => 'create_forum::thread',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 60,
                'name' => 'update_forum::thread',
                'guard_name' => 'web',
            ],
            [
                'id' => 60,
                'name' => 'update_forum::thread',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 61,
                'name' => 'restore_forum::thread',
                'guard_name' => 'web',
            ],
            [
                'id' => 61,
                'name' => 'restore_forum::thread',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 62,
                'name' => 'restore_any_forum::thread',
                'guard_name' => 'web',
            ],
            [
                'id' => 62,
                'name' => 'restore_any_forum::thread',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 63,
                'name' => 'replicate_forum::thread',
                'guard_name' => 'web',
            ],
            [
                'id' => 63,
                'name' => 'replicate_forum::thread',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 64,
                'name' => 'reorder_forum::thread',
                'guard_name' => 'web',
            ],
            [
                'id' => 64,
                'name' => 'reorder_forum::thread',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 65,
                'name' => 'delete_forum::thread',
                'guard_name' => 'web',
            ],
            [
                'id' => 65,
                'name' => 'delete_forum::thread',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 66,
                'name' => 'delete_any_forum::thread',
                'guard_name' => 'web',
            ],
            [
                'id' => 66,
                'name' => 'delete_any_forum::thread',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 67,
                'name' => 'force_delete_forum::thread',
                'guard_name' => 'web',
            ],
            [
                'id' => 67,
                'name' => 'force_delete_forum::thread',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 68,
                'name' => 'force_delete_any_forum::thread',
                'guard_name' => 'web',
            ],
            [
                'id' => 68,
                'name' => 'force_delete_any_forum::thread',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 69,
                'name' => 'view_forum::topic',
                'guard_name' => 'web',
            ],
            [
                'id' => 69,
                'name' => 'view_forum::topic',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 70,
                'name' => 'view_any_forum::topic',
                'guard_name' => 'web',
            ],
            [
                'id' => 70,
                'name' => 'view_any_forum::topic',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 71,
                'name' => 'create_forum::topic',
                'guard_name' => 'web',
            ],
            [
                'id' => 71,
                'name' => 'create_forum::topic',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 72,
                'name' => 'update_forum::topic',
                'guard_name' => 'web',
            ],
            [
                'id' => 72,
                'name' => 'update_forum::topic',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 73,
                'name' => 'restore_forum::topic',
                'guard_name' => 'web',
            ],
            [
                'id' => 73,
                'name' => 'restore_forum::topic',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 74,
                'name' => 'restore_any_forum::topic',
                'guard_name' => 'web',
            ],
            [
                'id' => 74,
                'name' => 'restore_any_forum::topic',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 75,
                'name' => 'replicate_forum::topic',
                'guard_name' => 'web',
            ],
            [
                'id' => 75,
                'name' => 'replicate_forum::topic',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 76,
                'name' => 'reorder_forum::topic',
                'guard_name' => 'web',
            ],
            [
                'id' => 76,
                'name' => 'reorder_forum::topic',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 77,
                'name' => 'delete_forum::topic',
                'guard_name' => 'web',
            ],
            [
                'id' => 77,
                'name' => 'delete_forum::topic',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 78,
                'name' => 'delete_any_forum::topic',
                'guard_name' => 'web',
            ],
            [
                'id' => 78,
                'name' => 'delete_any_forum::topic',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 79,
                'name' => 'force_delete_forum::topic',
                'guard_name' => 'web',
            ],
            [
                'id' => 79,
                'name' => 'force_delete_forum::topic',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 80,
                'name' => 'force_delete_any_forum::topic',
                'guard_name' => 'web',
            ],
            [
                'id' => 80,
                'name' => 'force_delete_any_forum::topic',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 81,
                'name' => 'view_lecturer',
                'guard_name' => 'web',
            ],
            [
                'id' => 81,
                'name' => 'view_lecturer',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 82,
                'name' => 'view_any_lecturer',
                'guard_name' => 'web',
            ],
            [
                'id' => 82,
                'name' => 'view_any_lecturer',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 83,
                'name' => 'create_lecturer',
                'guard_name' => 'web',
            ],
            [
                'id' => 83,
                'name' => 'create_lecturer',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 84,
                'name' => 'update_lecturer',
                'guard_name' => 'web',
            ],
            [
                'id' => 84,
                'name' => 'update_lecturer',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 85,
                'name' => 'restore_lecturer',
                'guard_name' => 'web',
            ],
            [
                'id' => 85,
                'name' => 'restore_lecturer',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 86,
                'name' => 'restore_any_lecturer',
                'guard_name' => 'web',
            ],
            [
                'id' => 86,
                'name' => 'restore_any_lecturer',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 87,
                'name' => 'replicate_lecturer',
                'guard_name' => 'web',
            ],
            [
                'id' => 87,
                'name' => 'replicate_lecturer',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 88,
                'name' => 'reorder_lecturer',
                'guard_name' => 'web',
            ],
            [
                'id' => 88,
                'name' => 'reorder_lecturer',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 89,
                'name' => 'delete_lecturer',
                'guard_name' => 'web',
            ],
            [
                'id' => 89,
                'name' => 'delete_lecturer',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 90,
                'name' => 'delete_any_lecturer',
                'guard_name' => 'web',
            ],
            [
                'id' => 90,
                'name' => 'delete_any_lecturer',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 91,
                'name' => 'force_delete_lecturer',
                'guard_name' => 'web',
            ],
            [
                'id' => 91,
                'name' => 'force_delete_lecturer',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 92,
                'name' => 'force_delete_any_lecturer',
                'guard_name' => 'web',
            ],
            [
                'id' => 92,
                'name' => 'force_delete_any_lecturer',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 93,
                'name' => 'view_student',
                'guard_name' => 'web',
            ],
            [
                'id' => 93,
                'name' => 'view_student',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 94,
                'name' => 'view_any_student',
                'guard_name' => 'web',
            ],
            [
                'id' => 94,
                'name' => 'view_any_student',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 95,
                'name' => 'create_student',
                'guard_name' => 'web',
            ],
            [
                'id' => 95,
                'name' => 'create_student',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 96,
                'name' => 'update_student',
                'guard_name' => 'web',
            ],
            [
                'id' => 96,
                'name' => 'update_student',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 97,
                'name' => 'restore_student',
                'guard_name' => 'web',
            ],
            [
                'id' => 97,
                'name' => 'restore_student',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 98,
                'name' => 'restore_any_student',
                'guard_name' => 'web',
            ],
            [
                'id' => 98,
                'name' => 'restore_any_student',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 99,
                'name' => 'replicate_student',
                'guard_name' => 'web',
            ],
            [
                'id' => 99,
                'name' => 'replicate_student',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 100,
                'name' => 'reorder_student',
                'guard_name' => 'web',
            ],
            [
                'id' => 100,
                'name' => 'reorder_student',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 101,
                'name' => 'delete_student',
                'guard_name' => 'web',
            ],
            [
                'id' => 101,
                'name' => 'delete_student',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 102,
                'name' => 'delete_any_student',
                'guard_name' => 'web',
            ],
            [
                'id' => 102,
                'name' => 'delete_any_student',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 103,
                'name' => 'force_delete_student',
                'guard_name' => 'web',
            ],
            [
                'id' => 103,
                'name' => 'force_delete_student',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 104,
                'name' => 'force_delete_any_student',
                'guard_name' => 'web',
            ],
            [
                'id' => 104,
                'name' => 'force_delete_any_student',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 105,
                'name' => 'view_study::program',
                'guard_name' => 'web',
            ],
            [
                'id' => 105,
                'name' => 'view_study::program',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 106,
                'name' => 'view_any_study::program',
                'guard_name' => 'web',
            ],
            [
                'id' => 106,
                'name' => 'view_any_study::program',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 107,
                'name' => 'create_study::program',
                'guard_name' => 'web',
            ],
            [
                'id' => 107,
                'name' => 'create_study::program',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 108,
                'name' => 'update_study::program',
                'guard_name' => 'web',
            ],
            [
                'id' => 108,
                'name' => 'update_study::program',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 109,
                'name' => 'restore_study::program',
                'guard_name' => 'web',
            ],
            [
                'id' => 109,
                'name' => 'restore_study::program',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 110,
                'name' => 'restore_any_study::program',
                'guard_name' => 'web',
            ],
            [
                'id' => 110,
                'name' => 'restore_any_study::program',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 111,
                'name' => 'replicate_study::program',
                'guard_name' => 'web',
            ],
            [
                'id' => 111,
                'name' => 'replicate_study::program',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 112,
                'name' => 'reorder_study::program',
                'guard_name' => 'web',
            ],
            [
                'id' => 112,
                'name' => 'reorder_study::program',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 113,
                'name' => 'delete_study::program',
                'guard_name' => 'web',
            ],
            [
                'id' => 113,
                'name' => 'delete_study::program',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 114,
                'name' => 'delete_any_study::program',
                'guard_name' => 'web',
            ],
            [
                'id' => 114,
                'name' => 'delete_any_study::program',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 115,
                'name' => 'force_delete_study::program',
                'guard_name' => 'web',
            ],
            [
                'id' => 115,
                'name' => 'force_delete_study::program',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 116,
                'name' => 'force_delete_any_study::program',
                'guard_name' => 'web',
            ],
            [
                'id' => 116,
                'name' => 'force_delete_any_study::program',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 117,
                'name' => 'view_tag',
                'guard_name' => 'web',
            ],
            [
                'id' => 117,
                'name' => 'view_tag',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 118,
                'name' => 'view_any_tag',
                'guard_name' => 'web',
            ],
            [
                'id' => 118,
                'name' => 'view_any_tag',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 119,
                'name' => 'create_tag',
                'guard_name' => 'web',
            ],
            [
                'id' => 119,
                'name' => 'create_tag',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 120,
                'name' => 'update_tag',
                'guard_name' => 'web',
            ],
            [
                'id' => 120,
                'name' => 'update_tag',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 121,
                'name' => 'restore_tag',
                'guard_name' => 'web',
            ],
            [
                'id' => 121,
                'name' => 'restore_tag',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 122,
                'name' => 'restore_any_tag',
                'guard_name' => 'web',
            ],
            [
                'id' => 122,
                'name' => 'restore_any_tag',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 123,
                'name' => 'replicate_tag',
                'guard_name' => 'web',
            ],
            [
                'id' => 123,
                'name' => 'replicate_tag',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 124,
                'name' => 'reorder_tag',
                'guard_name' => 'web',
            ],
            [
                'id' => 124,
                'name' => 'reorder_tag',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 125,
                'name' => 'delete_tag',
                'guard_name' => 'web',
            ],
            [
                'id' => 125,
                'name' => 'delete_tag',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 126,
                'name' => 'delete_any_tag',
                'guard_name' => 'web',
            ],
            [
                'id' => 126,
                'name' => 'delete_any_tag',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 127,
                'name' => 'force_delete_tag',
                'guard_name' => 'web',
            ],
            [
                'id' => 127,
                'name' => 'force_delete_tag',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 128,
                'name' => 'force_delete_any_tag',
                'guard_name' => 'web',
            ],
            [
                'id' => 128,
                'name' => 'force_delete_any_tag',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 129,
                'name' => 'view_user',
                'guard_name' => 'web',
            ],
            [
                'id' => 129,
                'name' => 'view_user',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 130,
                'name' => 'view_any_user',
                'guard_name' => 'web',
            ],
            [
                'id' => 130,
                'name' => 'view_any_user',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 131,
                'name' => 'create_user',
                'guard_name' => 'web',
            ],
            [
                'id' => 131,
                'name' => 'create_user',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 132,
                'name' => 'update_user',
                'guard_name' => 'web',
            ],
            [
                'id' => 132,
                'name' => 'update_user',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 133,
                'name' => 'restore_user',
                'guard_name' => 'web',
            ],
            [
                'id' => 133,
                'name' => 'restore_user',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:48',
                'updated_at' => '2025-08-07 02:36:48',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 134,
                'name' => 'restore_any_user',
                'guard_name' => 'web',
            ],
            [
                'id' => 134,
                'name' => 'restore_any_user',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:49',
                'updated_at' => '2025-08-07 02:36:49',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 135,
                'name' => 'replicate_user',
                'guard_name' => 'web',
            ],
            [
                'id' => 135,
                'name' => 'replicate_user',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:49',
                'updated_at' => '2025-08-07 02:36:49',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 136,
                'name' => 'reorder_user',
                'guard_name' => 'web',
            ],
            [
                'id' => 136,
                'name' => 'reorder_user',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:49',
                'updated_at' => '2025-08-07 02:36:49',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 137,
                'name' => 'delete_user',
                'guard_name' => 'web',
            ],
            [
                'id' => 137,
                'name' => 'delete_user',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:49',
                'updated_at' => '2025-08-07 02:36:49',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 138,
                'name' => 'delete_any_user',
                'guard_name' => 'web',
            ],
            [
                'id' => 138,
                'name' => 'delete_any_user',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:49',
                'updated_at' => '2025-08-07 02:36:49',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 139,
                'name' => 'force_delete_user',
                'guard_name' => 'web',
            ],
            [
                'id' => 139,
                'name' => 'force_delete_user',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:49',
                'updated_at' => '2025-08-07 02:36:49',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 140,
                'name' => 'force_delete_any_user',
                'guard_name' => 'web',
            ],
            [
                'id' => 140,
                'name' => 'force_delete_any_user',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:49',
                'updated_at' => '2025-08-07 02:36:49',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 141,
                'name' => 'view_user::type',
                'guard_name' => 'web',
            ],
            [
                'id' => 141,
                'name' => 'view_user::type',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:49',
                'updated_at' => '2025-08-07 02:36:49',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 142,
                'name' => 'view_any_user::type',
                'guard_name' => 'web',
            ],
            [
                'id' => 142,
                'name' => 'view_any_user::type',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:49',
                'updated_at' => '2025-08-07 02:36:49',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 143,
                'name' => 'create_user::type',
                'guard_name' => 'web',
            ],
            [
                'id' => 143,
                'name' => 'create_user::type',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:49',
                'updated_at' => '2025-08-07 02:36:49',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 144,
                'name' => 'update_user::type',
                'guard_name' => 'web',
            ],
            [
                'id' => 144,
                'name' => 'update_user::type',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:49',
                'updated_at' => '2025-08-07 02:36:49',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 145,
                'name' => 'restore_user::type',
                'guard_name' => 'web',
            ],
            [
                'id' => 145,
                'name' => 'restore_user::type',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:49',
                'updated_at' => '2025-08-07 02:36:49',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 146,
                'name' => 'restore_any_user::type',
                'guard_name' => 'web',
            ],
            [
                'id' => 146,
                'name' => 'restore_any_user::type',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:49',
                'updated_at' => '2025-08-07 02:36:49',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 147,
                'name' => 'replicate_user::type',
                'guard_name' => 'web',
            ],
            [
                'id' => 147,
                'name' => 'replicate_user::type',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:49',
                'updated_at' => '2025-08-07 02:36:49',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 148,
                'name' => 'reorder_user::type',
                'guard_name' => 'web',
            ],
            [
                'id' => 148,
                'name' => 'reorder_user::type',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:49',
                'updated_at' => '2025-08-07 02:36:49',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 149,
                'name' => 'delete_user::type',
                'guard_name' => 'web',
            ],
            [
                'id' => 149,
                'name' => 'delete_user::type',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:49',
                'updated_at' => '2025-08-07 02:36:49',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 150,
                'name' => 'delete_any_user::type',
                'guard_name' => 'web',
            ],
            [
                'id' => 150,
                'name' => 'delete_any_user::type',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:49',
                'updated_at' => '2025-08-07 02:36:49',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 151,
                'name' => 'force_delete_user::type',
                'guard_name' => 'web',
            ],
            [
                'id' => 151,
                'name' => 'force_delete_user::type',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:49',
                'updated_at' => '2025-08-07 02:36:49',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 152,
                'name' => 'force_delete_any_user::type',
                'guard_name' => 'web',
            ],
            [
                'id' => 152,
                'name' => 'force_delete_any_user::type',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:49',
                'updated_at' => '2025-08-07 02:36:49',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 153,
                'name' => 'widget_ForumThreadStatsWidget',
                'guard_name' => 'web',
            ],
            [
                'id' => 153,
                'name' => 'widget_ForumThreadStatsWidget',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:49',
                'updated_at' => '2025-08-07 02:36:49',
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => 154,
                'name' => 'widget_RecommendationWidget',
                'guard_name' => 'web',
            ],
            [
                'id' => 154,
                'name' => 'widget_RecommendationWidget',
                'guard_name' => 'web',
                'created_at' => '2025-08-07 02:36:49',
                'updated_at' => '2025-08-07 02:36:49',
            ]
        );

        // Create roles
        Role::updateOrCreate(
            [
                'id' => 1,
                'name' => 'super_admin',
                'guard_name' => 'web',
            ],
            [
                'id' => 1,
                'name' => 'super_admin',
                'guard_name' => 'web',
                'created_at' => '2025-08-05 14:38:13',
                'updated_at' => '2025-08-05 14:38:13',
            ]
        );

        Role::updateOrCreate(
            [
                'id' => 2,
                'name' => 'lecturer',
                'guard_name' => 'web',
            ],
            [
                'id' => 2,
                'name' => 'lecturer',
                'guard_name' => 'web',
                'created_at' => '2025-08-05 14:38:13',
                'updated_at' => '2025-08-05 14:38:13',
            ]
        );

        Role::updateOrCreate(
            [
                'id' => 3,
                'name' => 'academic_staff',
                'guard_name' => 'web',
            ],
            [
                'id' => 3,
                'name' => 'academic_staff',
                'guard_name' => 'web',
                'created_at' => '2025-08-05 14:38:13',
                'updated_at' => '2025-08-05 14:38:13',
            ]
        );

        Role::updateOrCreate(
            [
                'id' => 4,
                'name' => 'student',
                'guard_name' => 'web',
            ],
            [
                'id' => 4,
                'name' => 'student',
                'guard_name' => 'web',
                'created_at' => '2025-08-05 14:38:13',
                'updated_at' => '2025-08-05 14:38:13',
            ]
        );

        // Assign permissions to roles
        $role = Role::find(1);
        $permission = Permission::find(1);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(2);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(3);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(4);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(5);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(6);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(7);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(8);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(9);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(10);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(11);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(12);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(13);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(14);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(15);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(16);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(17);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(18);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(19);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(20);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(21);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(22);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(23);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(24);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(25);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(26);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(27);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(28);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(29);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(30);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(31);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(32);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(33);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(34);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(35);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(36);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(37);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(38);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(39);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(40);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(41);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(42);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(43);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(44);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(45);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(46);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(47);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(48);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(49);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(50);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(51);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(52);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(53);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(54);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(55);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(56);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(57);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(58);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(59);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(60);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(61);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(62);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(63);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(64);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(65);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(66);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(67);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(68);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(69);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(70);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(71);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(72);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(73);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(74);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(75);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(76);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(77);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(78);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(79);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(80);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(81);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(82);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(83);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(84);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(85);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(86);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(87);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(88);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(89);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(90);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(91);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(92);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(93);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(94);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(95);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(96);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(97);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(98);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(99);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(100);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(101);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(102);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(103);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(104);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(105);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(106);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(107);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(108);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(109);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(110);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(111);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(112);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(113);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(114);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(115);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(116);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(117);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(118);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(119);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(120);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(121);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(122);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(123);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(124);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(125);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(126);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(127);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(128);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(129);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(130);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(131);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(132);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(133);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(134);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(135);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(136);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(137);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(138);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(139);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(140);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(141);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(142);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(143);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(144);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(145);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(146);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(147);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(148);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(149);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(150);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(151);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(152);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(153);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(1);
        $permission = Permission::find(154);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(31);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(32);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(33);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(34);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(35);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(36);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(37);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(38);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(39);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(40);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(41);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(42);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(43);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(57);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(58);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(59);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(60);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(61);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(62);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(63);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(64);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(65);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(66);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(67);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(2);
        $permission = Permission::find(68);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(3);
        $permission = Permission::find(31);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(3);
        $permission = Permission::find(32);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(3);
        $permission = Permission::find(34);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(3);
        $permission = Permission::find(44);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(4);
        $permission = Permission::find(31);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(4);
        $permission = Permission::find(32);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(4);
        $permission = Permission::find(57);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(4);
        $permission = Permission::find(58);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(4);
        $permission = Permission::find(59);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(4);
        $permission = Permission::find(60);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(4);
        $permission = Permission::find(61);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(4);
        $permission = Permission::find(62);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(4);
        $permission = Permission::find(63);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(4);
        $permission = Permission::find(64);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(4);
        $permission = Permission::find(65);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(4);
        $permission = Permission::find(66);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(4);
        $permission = Permission::find(67);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $role = Role::find(4);
        $permission = Permission::find(68);
        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        $this->command->info('Permissions and role-permission relationships seeded successfully!');
    }
}
