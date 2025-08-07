<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class GeneratePermissionSeederCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:permission-seeder {--name=PermissionSeeder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a permission seeder from current database state';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $seederName = $this->option('name');

        try {
            // Get all permissions from the database
            $permissions = DB::table('permissions')->get();

            // Get all role-permission relationships
            $rolePermissions = DB::table('role_has_permissions')->get();

            // Get all roles
            $roles = DB::table('roles')->get();

            if ($permissions->isEmpty() && $roles->isEmpty()) {
                $this->error('No permissions or roles found in the database.');
                return 1;
            }

            // Generate the seeder code
            $seederCode = $this->generateSeederCode($permissions, $roles, $rolePermissions, $seederName);

            // Write the seeder code to a file
            $this->writeSeederFile($seederCode, $seederName);

            $this->info("Permission seeder '{$seederName}' generated successfully!");
            $this->info("File created: database/seeders/{$seederName}.php");

            return 0;

        } catch (\Exception $e) {
            $this->error("Error generating seeder: " . $e->getMessage());
            return 1;
        }
    }

    /**
     * Generate the seeder code from database data.
     */
    private function generateSeederCode($permissions, $roles, $rolePermissions, $seederName): string
    {
        $code = "<?php\n\n";
        $code .= "namespace Database\\Seeders;\n\n";
        $code .= "use Illuminate\\Database\\Seeder;\n";
        $code .= "use Spatie\\Permission\\Models\\Permission;\n";
        $code .= "use Spatie\\Permission\\Models\\Role;\n\n";
        $code .= "class {$seederName} extends Seeder\n";
        $code .= "{\n";
        $code .= "    /**\n";
        $code .= "     * Run the database seeds.\n";
        $code .= "     */\n";
        $code .= "    public function run(): void\n";
        $code .= "    {\n";

        // Generate permissions
        if ($permissions->isNotEmpty()) {
            $code .= "        // Create permissions\n";
            foreach ($permissions as $permission) {
                $code .= "        Permission::updateOrCreate(\n";
                $code .= "            [\n";
                $code .= "                'id' => {$permission->id},\n";
                $code .= "                'name' => '{$permission->name}',\n";
                $code .= "                'guard_name' => '{$permission->guard_name}',\n";
                $code .= "            ],\n";
                $code .= "            [\n";
                $code .= "                'id' => {$permission->id},\n";
                $code .= "                'name' => '{$permission->name}',\n";
                $code .= "                'guard_name' => '{$permission->guard_name}',\n";
                $code .= "                'created_at' => '{$permission->created_at}',\n";
                $code .= "                'updated_at' => '{$permission->updated_at}',\n";
                $code .= "            ]\n";
                $code .= "        );\n\n";
            }
        }

        // Generate roles
        if ($roles->isNotEmpty()) {
            $code .= "        // Create roles\n";
            foreach ($roles as $role) {
                $code .= "        Role::updateOrCreate(\n";
                $code .= "            [\n";
                $code .= "                'id' => {$role->id},\n";
                $code .= "                'name' => '{$role->name}',\n";
                $code .= "                'guard_name' => '{$role->guard_name}',\n";
                $code .= "            ],\n";
                $code .= "            [\n";
                $code .= "                'id' => {$role->id},\n";
                $code .= "                'name' => '{$role->name}',\n";
                $code .= "                'guard_name' => '{$role->guard_name}',\n";
                $code .= "                'created_at' => '{$role->created_at}',\n";
                $code .= "                'updated_at' => '{$role->updated_at}',\n";
                $code .= "            ]\n";
                $code .= "        );\n\n";
            }
        }

        // Generate role-permission relationships
        if ($rolePermissions->isNotEmpty()) {
            $code .= "        // Assign permissions to roles\n";
            foreach ($rolePermissions as $rolePermission) {
                $code .= "        \$role = Role::find({$rolePermission->role_id});\n";
                $code .= "        \$permission = Permission::find({$rolePermission->permission_id});\n";
                $code .= "        if (\$role && \$permission) {\n";
                $code .= "            \$role->givePermissionTo(\$permission);\n";
                $code .= "        }\n\n";
            }
        }

        $code .= "        \$this->command->info('Permissions and role-permission relationships seeded successfully!');\n";
        $code .= "    }\n";
        $code .= "}\n";

        return $code;
    }

    /**
     * Write the seeder code to a file.
     */
    private function writeSeederFile(string $code, string $seederName): void
    {
        $filePath = database_path("seeders/{$seederName}.php");
        File::put($filePath, $code);
    }
}
