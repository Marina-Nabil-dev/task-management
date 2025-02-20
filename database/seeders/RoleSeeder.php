<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [ 'user','admin'];
        foreach ($roles as $role) {
            Role::updateOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }

        $resources = $this->fetchResources();
        $resources->each(function ($resource) {
            $this->createCrudPermissions($resource);
            $this->syncPermissionsToUser();
            $this->syncPermissionsToAdmin();
        });


    }

    public static function fetchResources(): Collection
    {
        $modelPath = app_path('Models');

        $files = scandir($modelPath);

        return collect($files)
            ->filter(fn ($file) => Str::endsWith($file, '.php'))
            ->map(fn ($file) => Str::replaceLast('.php', '', $file));
    }

    public static function generateResourcePermissions(string $resourceName): Collection
    {
        return collect([
            'viewAny' . $resourceName,
            'view' . $resourceName,
            'update' . $resourceName,
            'create' . $resourceName,
            'delete' . $resourceName,
            'forceDelete' . $resourceName,
            'restore' . $resourceName,
            'destroy' . $resourceName,
        ]);
    }

    public static function createCrudPermissions($resource): void
    {
        $permissions = self::generateResourcePermissions($resource);
        $permissions->each(
            function ($permission) use ($resource) {
                Permission::firstOrCreate([
                    'guard_name' => 'web',
                    'group' => $resource,
                    'name' => $permission,
                ]);
            }
        );
    }

    public static function syncPermissionsToUser()
    {
        $role = Role::where('name', 'user')->first();

        $role->givePermissionTo(Permission::all());
    }

    public static function syncPermissionsToAdmin()
    {
        $role = Role::where('name', 'admin')->first();

        $role->givePermissionTo(Permission::all());
    }
}
