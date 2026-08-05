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

class Generate extends Component
{

    public $objId;

    public $nama;
    public $tanggal_lahir;
    public $alamat_jepang;
    public $tanggal_kepulangan;

    public $companies;

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

    public function render()
    {
        return view('livewire.buku-nenkin.generate');
    }
}
