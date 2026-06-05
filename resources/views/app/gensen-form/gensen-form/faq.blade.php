@extends('app.layouts.public')

@section('title', 'FAQ Gensen')

@section('content')
    <main>
        
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Aside-->
            <div class="d-flex flex-lg-row-fluid">
                <!--begin::Content-->
                <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                    <img class="theme-light-show mx-auto mw-100 w-450px w-lg-600px mb-4 p-5 rounded bg-{{ config('template.logo_auth_background') }}"
                        src="{{ asset(config('template.logo_auth')) }}" alt="" />
                </div>
            </div>
        </div>
        <div class="mx-auto p-4 pb-20 md:p-6 md:pb-6">
            
            <!-- Breadcrumb End -->
            <div class="space-y-5 sm:space-y-6">
                
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    
                    <div class="border-t border-gray-100 p-4 sm:p-6 dark:border-gray-800">
                    <!-- FAQ Two -->
                        <div x-data="{ openItem: 1 }" class="gap-y- gird-cols-1 grid gap-x-8 xl:grid-cols-2 d-flex justify-content-center">
                            <div class="space-y-3 mx-auto">
                                <!-- item 1 -->
                                <div x-data="{ id: 1 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 1, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 1 }" class="overflow-hidden mx-auto rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                                    <div @click="openItem = openItem === 1 ? null : 1" class="flex cursor-pointer items-center justify-between px-6 py-4">
                                    <h4 :class="{ 'text-gray-800': openItem === 1, 'text-gray-800 dark:text-white/90': openItem !== 1 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                    1.	Apa itu GENSEN ?
                                    </h4>
                                    <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 1, 'text-gray-500 dark:text-gray-400': openItem !== 1 }" class="text-gray-500 dark:text-gray-400">
                                        <span x-show="openItem !== 1">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                            </svg>
                                        </span>
                                        <span x-show="openItem === 1" style="display: none;">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    </div>
                                    <div x-show="openItem === 1" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                                    <p class="text-base text-gray-800">
                                        ➤ Gensen adalah sisa pajak penghasilan tahunan (jika di indonesia namanya SPT tahunan)
                                    </p>
                                    </div>
                                </div>
                                <!-- item 2 -->
                                <div x-data="{ id: 2 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 2, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 2 }" class="overflow-hidden mx-auto rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                                    <div @click="openItem = openItem === 2 ? null : 2" class="flex cursor-pointer items-center justify-between px-6 py-4">
                                    <h4 :class="{ 'text-gray-800': openItem === 2, 'text-gray-800 dark:text-white/90': openItem !== 2 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                    2.	Bagaimana/kapan slip/kertas GENSEN itu di dapatkan ?
                                    </h4>
                                    <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 2, 'text-gray-500 dark:text-gray-400': openItem !== 2 }" class="text-gray-500 dark:text-gray-400">
                                        <span x-show="openItem !== 2">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                            </svg>
                                        </span>
                                        <span x-show="openItem === 2" style="display: none;">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    </div>
                                    <div x-show="openItem === 2" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                                    <p class="text-base text-gray-800">
                                        ➤ Gensen di dapat setiap 1 tahun sekali bersamaan dengan gaji di bulan Desember atau Januari dan kertas Gensen di dapatkan dari perusahaan tempat anda bekerja 
                                    </p>
                                    </div>
                                </div>
                                <!-- item 3 -->
                                <div x-data="{ id: 3 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 3, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 3 }" class="overflow-hidden mx-auto rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                                    <div @click="openItem = openItem === 3 ? null : 3" class="flex cursor-pointer items-center justify-between px-6 py-4">
                                    <h4 :class="{ 'text-gray-800': openItem === 3, 'text-gray-800 dark:text-white/90': openItem !== 3 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                    3.	Apa saja dokumen persyaratan yang di perlukan untuk pengurusan GENSEN ?
                                    </h4>
                                    <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 3, 'text-gray-500 dark:text-gray-400': openItem !== 3 }" class="text-gray-500 dark:text-gray-400">
                                        <span x-show="openItem !== 3">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                            </svg>
                                        </span>
                                        <span x-show="openItem === 3" style="display: none;">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    </div>
                                    <div x-show="openItem === 3" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                                    <p class="text-base text-gray-800">
                                        {!! nl2br(e('
                                        a.	Foto/Scan Kertas Gensen (asli) 
                                        b.	Foto/Scan kartu keluarga 
                                        c.	Foto/Scan KTP Jepang terakhir (depan belakang)
                                        d.	Foto/Scan Rekapan pengiriman uang selama tahun Gensen tersebut ( Kyodai, SBI, Smiles,DCOM, dll )
                                        e.	Foto/Scan my number (depan belakang)
                                        f.	Foto/Scan rekening bank (jika masih di Jepang pakai rek Japan dan jika sudah di Indonesia pakai rek Indonesia)')) !!}

                                    </p>
                                    </div>
                                </div>
                                <!-- item 4 -->
                                <div x-data="{ id: 4 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 4, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 4 }" class="overflow-hidden mx-auto rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                                    <div @click="openItem = openItem === 4 ? null : 4" class="flex cursor-pointer items-center justify-between px-6 py-4">
                                    <h4 :class="{ 'text-gray-800': openItem === 4, 'text-gray-800 dark:text-white/90': openItem !== 4 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                        4.	Apa saja kriteria persyaratan gensen agar bisa di urus & di cairkan ( menurut regulasi saat ini di kantor pajak jepang ) ?
                                    </h4>
                                    <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 4, 'text-gray-500 dark:text-gray-400': openItem !== 4 }" class="text-gray-500 dark:text-gray-400">
                                        <span x-show="openItem !== 4">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                            </svg>
                                        </span>
                                        <span x-show="openItem === 4" style="display: none;">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    </div>
                                    <div x-show="openItem === 4" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                                    <p class="text-base text-gray-800">
                                        {!! nl2br(e('
                                        a.	Punya tanggungan keluarga saat kerja di jepang, cara membuktikan nya dengan kirim uang ke anggota keluarga yang ada di indonesia dan dalam 1 KK atau bisa juga beda KK. 
                                    Contoh : 1 KK ( Ayah, Ibu, Kakak, Adik, Suami/Istri ), Beda KK ( Paman/Bibi, Keponakan, Kakek/nenek, Sepupu ).
                                    b.	Jumlah kirim uang per orang nya kumulatif selama 1 tahun minimal ¥380.000
                                    c.	Umur tanggungan keluarga yang masuk kriteria minimal 16 tahun 
                                    ')) !!}

                                    </p>
                                    </div>
                                </div>
                                <!-- item 5 -->
                                <div x-data="{ id: 5 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 5, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 5 }" class="overflow-hidden mx-auto rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                                    <div @click="openItem = openItem === 5 ? null : 5" class="flex cursor-pointer items-center justify-between px-6 py-4">
                                    <h4 :class="{ 'text-gray-800': openItem === 5, 'text-gray-800 dark:text-white/90': openItem !== 5 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                    5.	Apa keuntungan dan kerugian jika mengurus Gensen dan tidak mengurus GENSEN ?
                                    </h4>
                                    <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 5, 'text-gray-500 dark:text-gray-400': openItem !== 5 }" class="text-gray-500 dark:text-gray-400">
                                        <span x-show="openItem !== 5">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                            </svg>
                                        </span>
                                        <span x-show="openItem === 5" style="display: none;">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    </div>
                                    <div x-show="openItem === 5" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                                    <p class="text-base text-gray-800">
                                        {!!
                                        '<p>➤ Keuntungan anda mengurus Gensen adalah anda akan mendapatkan keringanan pajak daerah/shiminzei bahkan bisa sampai dengan NOL&nbsp; dan kalaupun masih bayar tidak lebih dari &yen;1.000 (NB: jika jumlah rekening penerima dan jumlah kirim uang ke indo memenuhi syarat)</p>
                                    <p>➤ Kerugian anda jika tidak mengurus Gensen tepat waktu, anda akan kena potongan pajak daerah/shiminzei langsung dari gaji anda, nilai pajak daerah/shiminzei 2x lebih besar dari nilai Gensen dan itu akan mulai di tagihkan pada bulan Juni s/d Mei tahun depan nya Contoh hitungan pajak daerah : jika nominal Gensen anda &yen;38.000 maka nilai shiminzei anda &yen;66.000/tahun rumusnya adalah: &yen;66.000: 12 bulan&nbsp;=&nbsp;&yen;5.500/bulan</p>
                                    <p>&nbsp;</p>
                                    <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                    <td width="312">
                                    <p><strong>NOMINAL GENSEN</strong></p>
                                    </td>
                                    <td width="312">
                                    <p><strong>SHIMINZEI YANG HARUS DI BAYAR</strong></p>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td width="312">
                                    <p>&yen;19.000</p>
                                    </td>
                                    <td width="312">
                                    <p>&yen;33.000</p>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td width="312">
                                    <p>&yen;38.000</p>
                                    </td>
                                    <td width="312">
                                    <p>&yen;66.000</p>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td width="312">
                                    <p>&yen;54.000</p>
                                    </td>
                                    <td width="312">
                                    <p>&yen;99.000</p>
                                    </td>
                                    </tr>
                                    </tbody>
                                    </table>'
                                        !!}

                                    </p>
                                    </div>
                                </div>
                                <!-- item 6 -->
                                <div x-data="{ id: 6 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 6, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 6 }" class="overflow-hidden mx-auto rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                                    <div @click="openItem = openItem === 6 ? null : 6" class="flex cursor-pointer items-center justify-between px-6 py-4">
                                    <h4 :class="{ 'text-gray-800': openItem === 6, 'text-gray-800 dark:text-white/90': openItem !== 6 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                    6.	Bagiamana jika mengurus gensen nya terlambat ?
                                    </h4>
                                    <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 6, 'text-gray-500 dark:text-gray-400': openItem !== 6 }" class="text-gray-500 dark:text-gray-400">
                                        <span x-show="openItem !== 6">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                            </svg>
                                        </span>
                                        <span x-show="openItem === 6" style="display: none;">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    </div>
                                    <div x-show="openItem === 6" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                                    <p class="text-base text-gray-800">
                                        {!! nl2br(e('
                                        ➤ Selama anda masih di Jepang dengan waktu yang lama maka tidak ada kata terlambat, segera hubungi team EXATA untuk membantu anda, namun bagaimana jika sudah mau pulang ke Indonesia baru mengerti tentang Gensen ? jangan khawatir, Gensen tetap bisa di cairkan meskipun anda di Indonesia.')) !!}

                                    </p>
                                    </div>
                                </div>
                                <!-- item 7 -->
                                <div x-data="{ id: 7 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 7, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 7 }" class="overflow-hidden mx-auto rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                                    <div @click="openItem = openItem === 7 ? null : 7" class="flex cursor-pointer items-center justify-between px-6 py-4">
                                    <h4 :class="{ 'text-gray-800': openItem === 7, 'text-gray-800 dark:text-white/90': openItem !== 7 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                    7.	Berapa lama masa kadaluarsa GENSEN ?
                                    </h4>
                                    <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 7, 'text-gray-500 dark:text-gray-400': openItem !== 7 }" class="text-gray-500 dark:text-gray-400">
                                        <span x-show="openItem !== 7">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                            </svg>
                                        </span>
                                        <span x-show="openItem === 7" style="display: none;">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    </div>
                                    <div x-show="openItem === 7" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                                    <p class="text-base text-gray-800">
                                        {!! nl2br(e('
                                        ➤ Batas kadaluarasa Gensen Maximal 5 Tahun, terhitung dari tahun dikeluarkan nya Gensen tersebut.')) !!}

                                    </p>
                                    </div>
                                </div>
                                <!-- item 8 -->
                                <div x-data="{ id: 8 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 8, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 8 }" class="overflow-hidden mx-auto rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                                    <div @click="openItem = openItem === 8 ? null : 8" class="flex cursor-pointer items-center justify-between px-6 py-4">
                                    <h4 :class="{ 'text-gray-800': openItem === 8, 'text-gray-800 dark:text-white/90': openItem !== 8 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                    8.	Berapa biaya administrasi pengurusan GENSEN ?
                                    </h4>
                                    <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 8, 'text-gray-500 dark:text-gray-400': openItem !== 8 }" class="text-gray-500 dark:text-gray-400">
                                        <span x-show="openItem !== 8">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                            </svg>
                                        </span>
                                        <span x-show="openItem === 8" style="display: none;">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    </div>
                                    <div x-show="openItem === 8" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                                    <p class="text-base text-gray-800">
                                        {!! nl2br(e('
                                        ➤ 40% dari nominal Gensen yang bisa di cairkan di kantor pajak + biaya perwakilan pajak 3.000 Yen ')) !!}

                                    </p>
                                    </div>
                                </div>
                                <!-- item 9 -->
                                <div x-data="{ id: 9 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 9, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 9 }" class="overflow-hidden mx-auto rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                                    <div @click="openItem = openItem === 9 ? null : 9" class="flex cursor-pointer items-center justify-between px-6 py-4">
                                    <h4 :class="{ 'text-gray-800': openItem === 9, 'text-gray-800 dark:text-white/90': openItem !== 9 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                    9.	Berapa lama waktu yang di butuhkan untuk mencairakn GENSEN ?
                                    </h4>
                                    <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 9, 'text-gray-500 dark:text-gray-400': openItem !== 9 }" class="text-gray-500 dark:text-gray-400">
                                        <span x-show="openItem !== 9">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                            </svg>
                                        </span>
                                        <span x-show="openItem === 9" style="display: none;">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    </div>
                                    <div x-show="openItem === 9" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                                    <p class="text-base text-gray-800">
                                        {!! nl2br(e('
                                        ➤ Proses pencairan Gensen memakan waktu rata-rata 2-4 bulan, terhitung berkas masuk kantor pajak ( Tergantung dari Tingkat crowded kantor pajak ) ')) !!}

                                    </p>
                                    </div>
                                </div>
                                <!-- item 10 -->
                                <div x-data="{ id: 10 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 10, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 10 }" class="overflow-hidden mx-auto rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                                    <div @click="openItem = openItem === 10 ? null : 10" class="flex cursor-pointer items-center justify-between px-6 py-4">
                                    <h4 :class="{ 'text-gray-800': openItem === 10, 'text-gray-800 dark:text-white/90': openItem !== 10 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                    10.	Apa itu SHIMINZEI/JUMINZEI dan bagaimana cara mengurus nya ?
                                    </h4>
                                    <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 10, 'text-gray-500 dark:text-gray-400': openItem !== 10 }" class="text-gray-500 dark:text-gray-400">
                                        <span x-show="openItem !== 10">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                            </svg>
                                        </span>
                                        <span x-show="openItem === 10" style="display: none;">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    </div>
                                    <div x-show="openItem === 10" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                                    <p class="text-base text-gray-800">
                                        {!! nl2br(e('
                                        ➤ Shiminzei/juminzei adalah pajak daerah/pajak penduduk, semua orang asing di Jepang dikenakan pajak daerah dan cara mendapatkan keringanan pajak daerah, maka di sarankan untuk mengurus Gensen tepat waktu.
                                    ➤ Shiminzei tidak perlu di urus, because secara sistem di perpajakan Jepang, bagi yang sudah selesai mengurus Gensen maka Shiminzei nya juga akan berkurang dengan sendirinya dan jika Shiminzei yg tahun sebelum nya sudah pernah potong dari gaji tiap bulan dan posisi di Jepang masih minimal 6 bulan maka dari Shiyakusho akan ada pengembalian Shiminzei tersebut, nilai yang di kembalikan sesuai dengan jumlah/total Shiminzei yang anda bayarkan.
                                    ')) !!}

                                    </p>
                                    </div>
                                </div>
                                <!-- item 11 -->
                                <div x-data="{ id: 11 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 11, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 11 }" class="overflow-hidden mx-auto rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                                    <div @click="openItem = openItem === 11 ? null : 11" class="flex cursor-pointer items-center justify-between px-6 py-4">
                                    <h4 :class="{ 'text-gray-800': openItem === 11, 'text-gray-800 dark:text-white/90': openItem !== 11 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                    11.	Bagaimana jika kirim uang nya ke rekening atas nama sendiri ?
                                    </h4>
                                    <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 11, 'text-gray-500 dark:text-gray-400': openItem !== 11 }" class="text-gray-500 dark:text-gray-400">
                                        <span x-show="openItem !== 11">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                            </svg>
                                        </span>
                                        <span x-show="openItem === 11" style="display: none;">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    </div>
                                    <div x-show="openItem === 11" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                                    <p class="text-base text-gray-800">
                                        {!! nl2br(e('
                                        ➤ Jika kirim uang ke Indonesia nya ke rekening pribadi/sendiri maka Gensen TIDAK bisa di urus dan anda akan kena potongan pajak daerah/Shiminzei periode 1 tahun ke depan')) !!}

                                    </p>
                                    </div>
                                </div>
                                <!-- item 12 -->
                                <div x-data="{ id: 12 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 12, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 12 }" class="overflow-hidden mx-auto rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                                    <div @click="openItem = openItem === 12 ? null : 12" class="flex cursor-pointer items-center justify-between px-6 py-4">
                                    <h4 :class="{ 'text-gray-800': openItem === 12, 'text-gray-800 dark:text-white/90': openItem !== 12 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                    12.	Bagaimana jika penerima uang di Indonesia tersebut tidak ada di dalam 1 kartu keluarga (KK) tapi masih saudara kandung ?contoh kakak yg sudah menikah dan sudah pasti memiliki KK sendiri ?
                                    </h4>
                                    <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 12, 'text-gray-500 dark:text-gray-400': openItem !== 12 }" class="text-gray-500 dark:text-gray-400">
                                        <span x-show="openItem !== 12">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                            </svg>
                                        </span>
                                        <span x-show="openItem === 12" style="display: none;">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    </div>
                                    <div x-show="openItem === 12" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                                    <p class="text-base text-gray-800">
                                        {!! nl2br(e('
                                        ➤ Walaupun berbeda KK tapi masih ada hubungan kandung maka, anda wajib melampirkan 2 KK, pertama KK anda sendiri dan KK kakak anda.')) !!}

                                    </p>
                                    </div>
                                </div>
                                <!-- item 13 -->
                                <div x-data="{ id: 13 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 13, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 13 }" class="overflow-hidden mx-auto rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                                    <div @click="openItem = openItem === 13 ? null : 13" class="flex cursor-pointer items-center justify-between px-6 py-4">
                                    <h4 :class="{ 'text-gray-800': openItem === 13, 'text-gray-800 dark:text-white/90': openItem !== 13 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                    13.	Bagaimana jika penerima uang di Indonesia bukan anggota keluarga? (calon istri atau pacar/tunangan?)
                                    </h4>
                                    <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 13, 'text-gray-500 dark:text-gray-400': openItem !== 13 }" class="text-gray-500 dark:text-gray-400">
                                        <span x-show="openItem !== 13">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                            </svg>
                                        </span>
                                        <span x-show="openItem === 13" style="display: none;">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    </div>
                                    <div x-show="openItem === 13" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                                    <p class="text-base text-gray-800">
                                        {!! nl2br(e('
                                        ➤ Bagi penerima uang di Indonesia yang bukan bagian dari keluarga, maka tidak di anggap sebagai tanggungan keluarga dan Gensen tidak bisa di urus, kasus ini sama dengan jika kita kirim ke rekening sendiri.')) !!}

                                    </p>
                                    </div>
                                </div>
                                <!-- item 14 -->
                                <div x-data="{ id: 14 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 14, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 14 }" class="overflow-hidden mx-auto rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                                    <div @click="openItem = openItem === 14 ? null : 14" class="flex cursor-pointer items-center justify-between px-6 py-4">
                                    <h4 :class="{ 'text-gray-800': openItem === 14, 'text-gray-800 dark:text-white/90': openItem !== 14 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                    14.	Bagaimana cara meminta rekapan pengiriman uang selama di jepang?
                                    </h4>
                                    <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 14, 'text-gray-500 dark:text-gray-400': openItem !== 14 }" class="text-gray-500 dark:text-gray-400">
                                        <span x-show="openItem !== 14">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                            </svg>
                                        </span>
                                        <span x-show="openItem === 14" style="display: none;">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    </div>
                                    <div x-show="openItem === 14" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                                    <p class="text-base text-gray-800">
                                        {!! nl2br(e('
                                        ➤ Anda bisa langsung menghubungi pihak jasa pengiriman uang di Jepang (remit) melalui medsos mereka di facebook/messenger atau IG dan rekapan nya akan dikirim ke e-mail kamu.')) !!}

                                    </p>
                                    </div>
                                </div>
                                <!-- item 15 -->
                                <div x-data="{ id: 15 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 15, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 15 }" class="overflow-hidden mx-auto rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                                    <div @click="openItem = openItem === 15 ? null : 15" class="flex cursor-pointer items-center justify-between px-6 py-4">
                                    <h4 :class="{ 'text-gray-800': openItem === 15, 'text-gray-800 dark:text-white/90': openItem !== 15 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                    15.	Bagaimana cara meminta kertas Gensen sewaktu masih di Jepang?
                                    </h4>
                                    <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 15, 'text-gray-500 dark:text-gray-400': openItem !== 15 }" class="text-gray-500 dark:text-gray-400">
                                        <span x-show="openItem !== 15">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                            </svg>
                                        </span>
                                        <span x-show="openItem === 15" style="display: none;">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    </div>
                                    <div x-show="openItem === 15" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                                    <p class="text-base text-gray-800">
                                        {!! nl2br(e('
                                        ➤ Biasanya kertas Gensen langsung di berikan berbarengan dengan slip gaji di bulan Desember atau Januari, tapi jika tidak ada, maka anda bisa meminta langsung ke tantosa perusahaan/kaisha.')) !!}

                                    </p>
                                    </div>
                                </div>
                                <!-- item 16 -->
                                <div x-data="{ id: 16 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 16, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 16 }" class="overflow-hidden mx-auto rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                                    <div @click="openItem = openItem === 16 ? null : 16" class="flex cursor-pointer items-center justify-between px-6 py-4">
                                    <h4 :class="{ 'text-gray-800': openItem === 16, 'text-gray-800 dark:text-white/90': openItem !== 16 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                    16.	Bagaimana cara meminta kertas Gensen jika sudah di Indonesia?
                                    </h4>
                                    <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 16, 'text-gray-500 dark:text-gray-400': openItem !== 16 }" class="text-gray-500 dark:text-gray-400">
                                        <span x-show="openItem !== 16">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                            </svg>
                                        </span>
                                        <span x-show="openItem === 16" style="display: none;">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    </div>
                                    <div x-show="openItem === 16" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                                    <p class="text-base text-gray-800">
                                        {!! nl2br(e('
                                        ➤ Anda bisa menghubungi sensei atau tantosa kaisha, minta tolong untuk dikirim ke email/dititipkan kohai dan kirim ke alamat Exata Jepang.
                                    ➤ Atau minta tolong kohai yang masih di jepang untuk meminta ke pihak kaisha
                                    ')) !!}

                                    </p>
                                    </div>
                                </div>
                                <!-- item 17 -->
                                <div x-data="{ id: 17 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 17, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 17 }" class="overflow-hidden mx-auto rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                                    <div @click="openItem = openItem === 17 ? null : 17" class="flex cursor-pointer items-center justify-between px-6 py-4">
                                    <h4 :class="{ 'text-gray-800': openItem === 17, 'text-gray-800 dark:text-white/90': openItem !== 17 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                    17.	Mengurus Gensen sebaiknya masih di Jepang atau setelah di Indonesia ?
                                    </h4>
                                    <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 17, 'text-gray-500 dark:text-gray-400': openItem !== 17 }" class="text-gray-500 dark:text-gray-400">
                                        <span x-show="openItem !== 17">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                            </svg>
                                        </span>
                                        <span x-show="openItem === 17" style="display: none;">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    </div>
                                    <div x-show="openItem === 17" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                                    <p class="text-base text-gray-800">
                                        {!! nl2br(e('
                                        ➤ Mengurus sebaiknya setahun sekali artinya selama di Jepang anda rutin mengurus Gensen dan anda mendapatkan 2 keuntungan, pertama nominal yang cair dari kertas Gensen dan ke 2 adalah pajak daerah/Shiminzei anda akan diringankan, bahkan bisa sampai NOL ¥
                                        ➤ Tapi jika mengurus Gensen setelah di Indonesia, maka anda hanya dapat dari nilai yang cair saja, Shiminzei nya sudah tidak bisa di kembalikan.
                                        ')) !!}

                                    </p>
                                    </div>
                                </div>
                                <!-- item 18 -->
                                <div x-data="{ id: 18 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 18, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 18 }" class="overflow-hidden mx-auto rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                                    <div @click="openItem = openItem === 18 ? null : 18" class="flex cursor-pointer items-center justify-between px-6 py-4">
                                    <h4 :class="{ 'text-gray-800': openItem === 18, 'text-gray-800 dark:text-white/90': openItem !== 18 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                    18.	Apa perbedaan Exata dengan konsultan lain?
                                    </h4>
                                    <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 18, 'text-gray-500 dark:text-gray-400': openItem !== 18 }" class="text-gray-500 dark:text-gray-400">
                                        <span x-show="openItem !== 18">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                            </svg>
                                        </span>
                                        <span x-show="openItem === 18" style="display: none;">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    </div>
                                    <div x-show="openItem === 18" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                                    <p class="text-base text-gray-800">
                                        {!! nl2br(e('
                                        ➤ Exata		: legal, transparan, mudah konsultasi, online 24 jam, alamat kantor jelas, team nya banyak.
                                        ➤ Akuntan lain	: perorangan, tidak ada kantornya, sulit konsultasi.
                                        ')) !!}

                                    </p>
                                    </div>
                                </div>
                                
                                <div class="row d-flex justify-content-center">
                                    <div class="btn-container col-auto">
                                        <a target="_blank"
                                        href="https://api.whatsapp.com/send/?phone=6281199896308&type=phone_number&app_absent=0&text=Halo%20kak,%20saya%20akan%20mau%20tanya%20perihal%20gensen"
                                        class="btn-action d-flex flex-nowrap">
                        
                                            <img src="{{ asset('assets/media/logos/whatsapp_logo.svg') }}"
                                                alt="WhatsApp"
                                                width="20"
                                                height="20"
                                                style="vertical-align: middle; border: 0; margin-right: 8px; color: white;">
                        
                                            <span style="vertical-align: middle;">
                                                Hubungi Sales
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- FAQ Two -->
                    </div>
                </div>
            </div>
            
        </div>
        
    </main>
@endsection

@push('css')
    <style>
        .btn-container {
            text-align: center;
            margin: 25px 0 15px;
        }

        .btn-action {
            display: inline-block;
            background-color: #46e995;
            color: black !important;
            padding: 12px 30px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            font-size: 15px;
            line-height: 20px;
        }
    </style>
@endpush