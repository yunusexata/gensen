<?php

namespace Database\Seeders\User;

use App\Helpers\PermissionHelper;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    const hs = [
        PermissionHelper::ACCESS_DASHBOARD => [PermissionHelper::TYPE_READ],

        // Form Gensen
        PermissionHelper::ACCESS_GENSEN_DATA => PermissionHelper::TYPE_ALL,

        // Export Import
        PermissionHelper::ACCESS_GENSEN_EXPORT_IMPORT => PermissionHelper::TYPE_ALL,

        // Export Gensen

        // JOBKEY
        // EXPORT
        PermissionHelper::EXPORT_LIST_DATA_BELUM_LENGKAP => [PermissionHelper::TYPE_READ],

        // IMPORT
        PermissionHelper::IMPORT_LIST_DATA_LENGKAP => [PermissionHelper::TYPE_CREATE],
    ];
    const hs2 = [
        PermissionHelper::ACCESS_DASHBOARD => [PermissionHelper::TYPE_READ],

        // Export Import
        PermissionHelper::ACCESS_GENSEN_EXPORT_IMPORT => PermissionHelper::TYPE_ALL,

        // Export Gensen

        // JOBKEY
        // EXPORT
        PermissionHelper::EXPORT_LIST_DATA_SIAP_VERIFIKASI => [PermissionHelper::TYPE_READ],
        PermissionHelper::EXPORT_LIST_DATA_DALAM_PENGAJUAN => [PermissionHelper::TYPE_READ],

        // IMPORT
        PermissionHelper::IMPORT_LIST_DATA_VERIFIED => [PermissionHelper::TYPE_CREATE],
        PermissionHelper::IMPORT_LIST_DATA_GENSEN_CAIR => [PermissionHelper::TYPE_CREATE],
    ];
    const sales = [
        PermissionHelper::ACCESS_DASHBOARD => [PermissionHelper::TYPE_READ],
        // Form Gensen
        PermissionHelper::ACCESS_GENSEN_DATA => PermissionHelper::TYPE_ALL,
        PermissionHelper::ACCESS_GENSEN_FORM_LINK => PermissionHelper::TYPE_ALL,
    ];
    const admin_japan = [
        PermissionHelper::ACCESS_DASHBOARD => [PermissionHelper::TYPE_READ],

        // Export Import
        PermissionHelper::ACCESS_GENSEN_EXPORT_IMPORT => PermissionHelper::TYPE_ALL,

        // Export Gensen

        // JOBKEY
        // EXPORT
        PermissionHelper::EXPORT_LIST_DATA_VERIFIED => [PermissionHelper::TYPE_READ],
        PermissionHelper::EXPORT_LIST_DATA_NO_INPUT_JAPAN => [PermissionHelper::TYPE_READ],

        // IMPORT
        PermissionHelper::IMPORT_LIST_DATA_NO_INPUT_JAPAN => [PermissionHelper::TYPE_CREATE],
        PermissionHelper::IMPORT_LIST_DATA_DALAM_PENGAJUAN => [PermissionHelper::TYPE_CREATE],

    ];
    const supervisor = [
        PermissionHelper::ACCESS_DASHBOARD => [PermissionHelper::TYPE_READ],

        // Form Gensen
        PermissionHelper::ACCESS_GENSEN_DATA => [PermissionHelper::TYPE_READ],

        // Export Import
        PermissionHelper::ACCESS_GENSEN_EXPORT_IMPORT => [PermissionHelper::TYPE_READ],
    ];
    public function run(): void
    {
        // create role
        $role = Role::create(['name' => User::ROLE_SUPER_ADMIN]);
        foreach (PermissionHelper::ACCESS_TYPE_ALL as $access => $types) {
            foreach ($types as $type) {
                $role->givePermissionTo(PermissionHelper::transform($access, $type));
            }
        }
        $role = Role::create(['name' => User::ROLE_SALES]);
        foreach (self::sales as $access => $types) {
            foreach ($types as $type) {
                $role->givePermissionTo(PermissionHelper::transform($access, $type));
            }
        }
        $role = Role::create(['name' => User::ROLE_HS]);
        foreach (self::hs as $access => $types) {
            foreach ($types as $type) {
                $role->givePermissionTo(PermissionHelper::transform($access, $type));
            }
        }
        $role = Role::create(['name' => User::ROLE_HS2]);
        foreach (self::hs2 as $access => $types) {
            foreach ($types as $type) {
                $role->givePermissionTo(PermissionHelper::transform($access, $type));
            }
        }
        $role = Role::create(['name' => User::ROLE_ADMIN_JAPAN]);
        foreach (self::admin_japan as $access => $types) {
            foreach ($types as $type) {
                $role->givePermissionTo(PermissionHelper::transform($access, $type));
            }
        }
        $role = Role::create(['name' => User::ROLE_ACC_EXATA]);
        foreach (self::hs2 as $access => $types) {
            foreach ($types as $type) {
                $role->givePermissionTo(PermissionHelper::transform($access, $type));
            }
        }
        $role = Role::create(['name' => User::ROLE_SUPERVISOR]);
        foreach (self::supervisor as $access => $types) {
            foreach ($types as $type) {
                $role->givePermissionTo(PermissionHelper::transform($access, $type));
            }
        }
    }
}
