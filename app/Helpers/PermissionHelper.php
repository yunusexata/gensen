<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PermissionHelper
{
    const SEPARATOR =  ".";

    const TYPE_CREATE = "create";
    const TYPE_READ = "read";
    const TYPE_UPDATE = "update";
    const TYPE_DELETE = "delete";
    const TYPE_ALL = [self::TYPE_CREATE, self::TYPE_READ, self::TYPE_UPDATE, self::TYPE_DELETE];
    const TRANSLATE_TYPE = [
        self::TYPE_CREATE => "Buat",
        self::TYPE_READ => "Lihat",
        self::TYPE_UPDATE => "Edit",
        self::TYPE_DELETE => "Hapus",
    ];

    const ROUTE_TYPE_CREATE = ['create', 'store'];
    const ROUTE_TYPE_READ = ['index', 'show', 'print', 'export', 'find'];
    const ROUTE_TYPE_UPDATE = ['edit', 'update'];
    const ROUTE_TYPE_DELETE = ['destroy'];

    const ACCESS_DASHBOARD = "dashboard";
    const ACCESS_USER = "user";
    const ACCESS_PERMISSION = "permission";
    const ACCESS_ROLE = "role";

    // Form Gensen
    const ACCESS_GENSEN_DATA = 'gensen_data';
    const ACCESS_GENSEN_FORM_LINK = 'gensen_form_link';

    // EXPORT IMPORT
    const ACCESS_GENSEN_EXPORT_IMPORT = 'gensen_form_export_import';

    // JOBKEY
    // EXPORT
    const EXPORT_LIST_DATA_BELUM_LENGKAP = 'export_list_data_belum_lengkap';
    const EXPORT_LIST_DATA_SIAP_VERIFIKASI = 'export_list_data_siap_verifikasi';
    const EXPORT_LIST_DATA_VERIFIED = 'export_list_data_verified';
    const EXPORT_LIST_DATA_NO_INPUT_JAPAN = 'export_list_data_no_input_japan';
    const EXPORT_LIST_DATA_DALAM_PENGAJUAN = 'export_list_data_dalam_pengajuan';
    const EXPORT_LIST_DATA_TARIK_DATA_ACC = 'export_list_data_tarik_data_acc';

    // IMPORT
    const IMPORT_LIST_DATA_LENGKAP = 'import_list_data_lengkap';
    const IMPORT_LIST_DATA_VERIFIED = 'import_list_data_verified';
    const IMPORT_LIST_DATA_NO_INPUT_JAPAN = 'import_list_data_no_input_japan';
    const IMPORT_LIST_DATA_DALAM_PENGAJUAN = 'import_list_data_dalam_pengajuan';
    const IMPORT_LIST_DATA_GENSEN_CAIR = 'import_list_data_gensen_cair';

    const UPDATE_GENSEN_TANGGAL_LENGKAP = 'update_gensen_tanggal_lengkap';
    const UPDATE_GENSEN_TANGGAL_VERIFIED = 'update_gensen_tanggal_verified';
    const UPDATE_GENSEN_TANGGAL_PENGAJUAN = 'update_gensen_tanggal_pangajuan';
    const UPDATE_GENSEN_NO_INPUT_JEPANG = 'update_gensen_tanggal_no_input_jepang';

    // BUKU NENKIN
    const ACCESS_BUKU_NENKIN = 'buku_nenkin';

    const ACCESS_ALL = [
        self::ACCESS_DASHBOARD,
        self::ACCESS_USER,
        self::ACCESS_PERMISSION,
        self::ACCESS_ROLE,

        // Form Gensen
        self::ACCESS_GENSEN_DATA,
        self::ACCESS_GENSEN_FORM_LINK,

        // Import Export
        self::ACCESS_GENSEN_EXPORT_IMPORT,
    ];

    const TRANSLATE_ACCESS = [
        self::ACCESS_DASHBOARD => "Dashboard",
        self::ACCESS_USER => "Pengguna",
        self::ACCESS_PERMISSION => "Akses",
        self::ACCESS_ROLE => "Jabatan",

        // Form Gensen
        self::ACCESS_GENSEN_DATA => 'Data Gensen',
        self::ACCESS_GENSEN_FORM_LINK => 'Form Gensen - Link',

        // EXPORT IMPORT
        self::ACCESS_GENSEN_EXPORT_IMPORT => 'Form Gensen - Export Import',

        // JOBKEY
        // EXPORT
        self::EXPORT_LIST_DATA_BELUM_LENGKAP => 'Data Gensen - Export Belum lengkap',
        self::EXPORT_LIST_DATA_SIAP_VERIFIKASI => 'Data Gensen - Export Siap verifikasi',
        self::EXPORT_LIST_DATA_VERIFIED => 'Data Gensen - Export Verified',
        self::EXPORT_LIST_DATA_NO_INPUT_JAPAN => 'Data Gensen - Export No input Japan',
        self::EXPORT_LIST_DATA_DALAM_PENGAJUAN => 'Data Gensen - Export Dalam pengajuan',
        self::EXPORT_LIST_DATA_TARIK_DATA_ACC => 'Data Gensen - Export Data Tarik Data ACC',

        // IMPORT
        self::IMPORT_LIST_DATA_LENGKAP => 'Data Gensen - Import Lengkap',
        self::IMPORT_LIST_DATA_VERIFIED => 'Data Gensen - Import Verified',
        self::IMPORT_LIST_DATA_NO_INPUT_JAPAN => 'Data Gensen - Import No input Japan',
        self::IMPORT_LIST_DATA_DALAM_PENGAJUAN => 'Data Gensen - Import Dalam pengajuan',
        self::IMPORT_LIST_DATA_GENSEN_CAIR => 'Data Gensen - Import Gensen cair',

        // UPDATE GENSEN
        self::UPDATE_GENSEN_TANGGAL_LENGKAP => 'Data Gensen - Update Tanggal Lengkap',
        self::UPDATE_GENSEN_TANGGAL_VERIFIED => 'Data Gensen - Update Tanggal Verified',
        self::UPDATE_GENSEN_TANGGAL_PENGAJUAN => 'Data Gensen - Update Tanggal Pengajuan',
        self::UPDATE_GENSEN_NO_INPUT_JEPANG => 'Data Gensen - Update No Input Jepang',

        // BUKU NENKIN
        self::ACCESS_BUKU_NENKIN => 'Data Pengganti Buku Nenkin',
    ];

    const ACCESS_TYPE_ALL = [
        self::ACCESS_DASHBOARD => [self::TYPE_READ],
        self::ACCESS_USER => self::TYPE_ALL,
        self::ACCESS_ROLE => self::TYPE_ALL,
        self::ACCESS_PERMISSION => self::TYPE_ALL,

        // Form Gensen
        self::ACCESS_GENSEN_DATA => self::TYPE_ALL,
        self::ACCESS_GENSEN_FORM_LINK => self::TYPE_ALL,

        // Export Import
        self::ACCESS_GENSEN_EXPORT_IMPORT => self::TYPE_ALL,

        // Export Gensen

        // JOBKEY
        // EXPORT
        self::EXPORT_LIST_DATA_BELUM_LENGKAP => [self::TYPE_READ],
        self::EXPORT_LIST_DATA_SIAP_VERIFIKASI => [self::TYPE_READ],
        self::EXPORT_LIST_DATA_VERIFIED => [self::TYPE_READ],
        self::EXPORT_LIST_DATA_NO_INPUT_JAPAN => [self::TYPE_READ],
        self::EXPORT_LIST_DATA_DALAM_PENGAJUAN => [self::TYPE_READ],
        self::EXPORT_LIST_DATA_TARIK_DATA_ACC => [self::TYPE_READ],

        // IMPORT
        self::IMPORT_LIST_DATA_LENGKAP => [self::TYPE_CREATE],
        self::IMPORT_LIST_DATA_VERIFIED => [self::TYPE_CREATE],
        self::IMPORT_LIST_DATA_NO_INPUT_JAPAN => [self::TYPE_CREATE],
        self::IMPORT_LIST_DATA_DALAM_PENGAJUAN => [self::TYPE_CREATE],
        self::IMPORT_LIST_DATA_GENSEN_CAIR => [self::TYPE_CREATE],

        // UPDATE GENSEN 
        self::UPDATE_GENSEN_TANGGAL_LENGKAP => [self::TYPE_UPDATE],
        self::UPDATE_GENSEN_TANGGAL_VERIFIED => [self::TYPE_UPDATE],
        self::UPDATE_GENSEN_TANGGAL_PENGAJUAN => [self::TYPE_UPDATE],
        self::UPDATE_GENSEN_NO_INPUT_JEPANG => [self::TYPE_UPDATE],

        // Export Import
        self::ACCESS_BUKU_NENKIN => self::TYPE_ALL,
    ];

    /*
    | Parameters
    | permission (string) : merupakan nama dari permission
    */
    public static function translate($permission)
    {
        $explode = explode(self::SEPARATOR, $permission);
        $access = $explode[0];
        $type = $explode[1];

        $translateAccess = isset(self::TRANSLATE_ACCESS[$access]) ? self::TRANSLATE_ACCESS[$access] : $access;
        $translateType = isset(self::TRANSLATE_TYPE[$type]) ? self::TRANSLATE_TYPE[$type] : $type;

        return $translateAccess . " - " . $translateType;
    }

    /*
    | Parameters
    | access (string) : merupakan access yang tersedia pada helper ini
    | type (string) : merupakan type yang tersedia pada helper ini
    */
    public static function transform($access, $type)
    {
        return $access . self::SEPARATOR . $type;
    }

    /*
    | Parameters
    | permission (string) : merupakan nama dari permission
    */
    public static function getAccess($permission)
    {
        return explode(self::SEPARATOR, $permission)[0];
    }


    /*
    | Parameters
    | permission (string) : merupakan nama dari permission
    */
    public static function getTranslatedAccess($permission)
    {
        return self::TRANSLATE_ACCESS[self::getAccess($permission)];
    }


    /*
    | Parameters
    | permission (string) : merupakan nama dari permission
    */
    public static function getType($permission)
    {
        return explode(self::SEPARATOR, $permission)[1];
    }

    /*
    | Parameters
    | permission (string) : merupakan nama dari permission
    */
    public static function getTranslatedType($permission)
    {
        return self::TRANSLATE_TYPE[self::getType($permission)];
    }

    /*
    | Parameters
    | route_name (string) : Nama Route
    */
    public static function isRoutePermitted($route_name, $user = null)
    {
        // Identifikasi Route
        $exploded_route_names = explode(".", $route_name);
        $access = $exploded_route_names[0];
        $route_type = $exploded_route_names[1];

        if (in_array($route_type, self::ROUTE_TYPE_CREATE)) {
            $type = self::TYPE_CREATE;
        } else if (in_array($route_type, self::ROUTE_TYPE_READ)) {
            $type = self::TYPE_READ;
        } else if (in_array($route_type, self::ROUTE_TYPE_UPDATE)) {
            $type = self::TYPE_UPDATE;
        } else {
            $type = self::TYPE_DELETE;
        }

        // Pemeriksaan Hak Akses
        $user = $user == null ? User::find(Auth::id()) : $user;
        return $user->hasPermissionTo(self::transform($access, $type));
    }
}
