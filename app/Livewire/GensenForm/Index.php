<?php

namespace App\Livewire\GensenForm;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public $objId;

    public $nama_lengkap;
    public $tanggal_lahir;
    public $tanggal_kepulangan;
    public $nama_facebook;
    public $nomor_whatsapp;
    public $email;
    public $alamat_jepang;
    public $kode_pos_jepang;
    public $nama_lpk;

    // REK PENERIMA
    public $no_rekening_penerima;
    public $nama_bank_penerima;
    public $nama_penerima;

    public $status;
    public $tahun_gensen;
    public $tahun_transfer;

    // UPLOAD 
    public $kertas_gensen;
    public $my_number;
    public $zairyou_card_front;
    public $zairyou_card_back;
    public $kartu_keluarga;
    public $rekap_pengiriman_uang;
    public $rekening_indonesia;

    public function mount() {}

    #[On('on-dialog-confirm')]
    public function onDialogConfirm() {}

    #[On('on-dialog-cancel')]
    public function onDialogCancel() {}

    public function store()
    {
        dd([
            $this->nama_lengkap,
            $this->tanggal_lahir,
            $this->tanggal_kepulangan,
            $this->nama_facebook,
            $this->nomor_whatsapp,
            $this->email,
            $this->alamat_jepang,
            $this->kode_pos_jepang,
            $this->nama_lpk,

            // REK PENERIMA
            $this->no_rekening_penerima,
            $this->nama_bank_penerima,
            $this->nama_penerima,

            $this->status,
            $this->tahun_gensen,
            $this->tahun_transfer,

            // UPLOAD 
            $this->kertas_gensen,
            $this->my_number,
            $this->zairyou_card_front,
            $this->zairyou_card_back,
            $this->kartu_keluarga,
            $this->rekap_pengiriman_uang,
            $this->rekening_indonesia,
        ]);
        // try {
        //     DB::transaction(function () {
        //         // Vehicle
        //         $validateData = [
        //             'name' => $this->name,
        //         ];
        //         $vehicle_id = null;
        //         // $vehicle = RegencyRepository::create($validateData);
        //     });


        //     DB::commit();
        //     Alert::confirmation(
        //         $this,
        //         Alert::ICON_SUCCESS,
        //         "Berhasil",
        //         "Data Berhasil Diperbarui",
        //         "on-dialog-confirm",
        //         "on-dialog-cancel",
        //         "Oke",
        //         "Tutup",
        //     );
        // } catch (Exception $e) {
        //     DB::rollBack();
        //     Alert::fail($this, "Gagal", $e->getMessage());
        // }
    }

    public function coba()
    {
        dd("OKE");
    }
    public function render()
    {
        return view('livewire.gensen-form.index');
    }
}
