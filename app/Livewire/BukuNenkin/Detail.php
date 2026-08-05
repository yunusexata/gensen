<?php

namespace App\Livewire\BukuNenkin;

use App\Helpers\Alert;
use App\Helpers\AppCrypt;
use App\Repositories\BukuNenkin\BukuNenkinCompanyRepository;
use App\Repositories\BukuNenkin\BukuNenkinRepository;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Detail extends Component
{

    public $objId;

    public $nama;
    public $tanggal_lahir;
    public $alamat_jepang;
    public $tanggal_kepulangan;

    public $companies = [
        [
            'id' => null,
            'nama_perusahaan' => null,
            'alamat_perusahaan' => null,
            'no_telp' => null,
            'tanggal_kerja_awal' => null,
            'tanggal_kerja_akhir' => null,
            'jenis_nenkin' => null,
        ]
    ];

    public function mount()
    {
        if ($this->objId) {

            $id = AppCrypt::decrypt($this->objId);
            if (!$id) {
                abort(404, 'Link tidak valid atau telah dimanipulasi.');
            }
            $buku_nenkin = BukuNenkinRepository::find($id);
            $this->nama = $buku_nenkin->nama;
            $this->tanggal_lahir = $buku_nenkin->tanggal_lahir;
            $this->alamat_jepang = $buku_nenkin->alamat_jepang;
            $this->tanggal_kepulangan = $buku_nenkin->tanggal_kepulangan;

            $this->companies = [];
            foreach ($buku_nenkin->companies as $company) {
                $this->companies[] = [
                    'id' => $company->id,
                    'nama_perusahaan' => $company->nama_perusahaan,
                    'alamat_perusahaan' => $company->alamat_perusahaan,
                    'no_telp' => $company->no_telp,
                    'tanggal_kerja_awal' => $company->tanggal_kerja_awal,
                    'tanggal_kerja_akhir' => $company->tanggal_kerja_akhir,
                    'jenis_nenkin' => $company->jenis_nenkin,
                ];
            }
        }
    }

    public function addCompany()
    {
        $this->companies[] =  [
            'id' => null,
            'nama_perusahaan' => null,
            'alamat_perusahaan' => null,
            'no_telp' => null,
            'tanggal_kerja_awal' => null,
            'tanggal_kerja_akhir' => null,
            'jenis_nenkin' => null,
        ];
    }

    #[On('on-dialog-confirm')]
    public function onDialogConfirm()
    {
        if ($this->objId) {
            $this->redirectRoute('buku_nenkin.edit', $this->objId);
        } else {
            $this->redirectRoute('buku_nenkin.create');
        }
    }

    #[On('on-dialog-cancel')]
    public function onDialogCancel()
    {
        $this->redirectRoute('buku_nenkin.index');
    }

    public function store()
    {
        try {
            DB::transaction(function () {
                // Vehicle
                $validateData = [
                    'nama' => $this->nama,
                    'tanggal_lahir' => $this->tanggal_lahir,
                    'alamat_jepang' => $this->alamat_jepang,
                    'tanggal_kepulangan' => $this->tanggal_kepulangan,
                ];
                $vehicle_id = null;
                if ($this->objId) {

                    $id = AppCrypt::decrypt($this->objId);
                    if (!$id) {
                        abort(404, 'Link tidak valid atau telah dimanipulasi.');
                    }
                    BukuNenkinRepository::update($id, $validateData);
                } else {
                    $buku_nenkin = BukuNenkinRepository::create($validateData);
                    $objId = $buku_nenkin->id;
                }

                foreach ($this->companies as $index => $company) {
                    $validateData = [
                        'buku_nenkin_id' => $objId,
                        'nama_perusahaan' => $company['nama_perusahaan'],
                        'alamat_perusahaan' => $company['alamat_perusahaan'],
                        'no_telp' => $company['no_telp'],
                        'tanggal_kerja_awal' => $company['tanggal_kerja_awal'],
                        'tanggal_kerja_akhir' => $company['tanggal_kerja_akhir'],
                        'jenis_nenkin' => $company['jenis_nenkin'],
                    ];
                    if ($company['id']) {
                        $company = BukuNenkinCompanyRepository::update($company['id'], $validateData);
                    } else {
                        $company = BukuNenkinCompanyRepository::create($validateData);
                    }
                }
            });


            DB::commit();
            Alert::confirmation(
                $this,
                Alert::ICON_SUCCESS,
                "Berhasil",
                "Data Berhasil Diperbarui",
                "on-dialog-confirm",
                "on-dialog-cancel",
                "Oke",
                "Tutup",
            );
        } catch (Exception $e) {
            DB::rollBack();
            Alert::fail($this, "Gagal", $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.buku-nenkin.detail');
    }
}
