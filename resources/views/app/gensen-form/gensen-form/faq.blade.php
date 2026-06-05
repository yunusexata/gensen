@extends('app.layouts.public')

@section('title', 'FAQ Gensen')

@section('content')
    <main>
    <div class="mx-auto max-w-(--breakpoint-2xl) p-4 pb-20 md:p-6 md:pb-6">
        
        <!-- Breadcrumb End -->
        <div class="space-y-5 sm:space-y-6">
            
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                    Faq’s Gensen
                </h3>
                </div>
                <div class="border-t border-gray-100 p-4 sm:p-6 dark:border-gray-800">
                <!-- FAQ Two -->
                <div x-data="{ openItem: 1 }" class="gap-y- gird-cols-1 grid gap-x-8 xl:grid-cols-2">
                    <div class="space-y-3">
                        <!-- item 1 -->
                        <div x-data="{ id: 1 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 1, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 1 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
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
                        <!-- item 1 -->
                        <div x-data="{ id: 1 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 1, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 1 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 1 ? null : 1" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 1, 'text-gray-800 dark:text-white/90': openItem !== 1 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                            2.	Bagaimana/kapan slip/kertas GENSEN itu di dapatkan ?
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
                                ➤ Gensen di dapat setiap 1 tahun sekali bersamaan dengan gaji di bulan Desember atau Januari dan kertas Gensen di dapatkan dari perusahaan tempat anda bekerja 
                            </p>
                            </div>
                        </div>
                        <!-- item 1 -->
                        <div x-data="{ id: 1 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 1, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 1 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 1 ? null : 1" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 1, 'text-gray-800 dark:text-white/90': openItem !== 1 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                            3.	Apa saja dokumen persyaratan yang di perlukan untuk pengurusan GENSEN ?
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
                        <!-- item 1 -->
                        <div x-data="{ id: 1 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 1, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 1 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 1 ? null : 1" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 1, 'text-gray-800 dark:text-white/90': openItem !== 1 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                4.	Apa saja kriteria persyaratan gensen agar bisa di urus & di cairkan ( menurut regulasi saat ini di kantor pajak jepang ) ?
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
                                {!! nl2br(e('
                                a.	Punya tanggungan keluarga saat kerja di jepang, cara membuktikan nya dengan kirim uang ke anggota keluarga yang ada di indonesia dan dalam 1 KK atau bisa juga beda KK. 
Contoh : 1 KK ( Ayah, Ibu, Kakak, Adik, Suami/Istri ), Beda KK ( Paman/Bibi, Keponakan, Kakek/nenek, Sepupu ).
b.	Jumlah kirim uang per orang nya kumulatif selama 1 tahun minimal ¥380.000
c.	Umur tanggungan keluarga yang masuk kriteria minimal 16 tahun 
')) !!}

                            </p>
                            </div>
                        </div>
                        <!-- item 1 -->
                        <div x-data="{ id: 1 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 1, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 1 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 1 ? null : 1" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 1, 'text-gray-800 dark:text-white/90': openItem !== 1 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                            5.	Apa keuntungan dan kerugian jika mengurus Gensen dan tidak mengurus GENSEN ?
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
                                {!!
                                `<p>➤ Keuntungan anda mengurus Gensen adalah anda akan mendapatkan keringanan pajak daerah/shiminzei bahkan bisa sampai dengan NOL&nbsp; dan kalaupun masih bayar tidak lebih dari &yen;1.000 (NB: jika jumlah rekening penerima dan jumlah kirim uang ke indo memenuhi syarat)</p>
<p>➤ Kerugian anda jika tidak mengurus Gensen tepat waktu, anda akan kena potongan pajak daerah/shiminzei langsung dari gaji anda, nilai pajak daerah/shiminzei 2x lebih besar dari nilai Gensen dan itu akan mulai di tagihkan pada bulan Juni s/d Mei tahun depan nya Contoh hitungan pajak daerah : jika nominal Gensen anda &yen;38.000 maka nilai shiminzei anda &yen;66.000/tahun rumusnya adalah: &yen;66.000: 12 bulan&nbsp;=&nbsp;&yen;5.500/bulan</p>
<p>&nbsp;</p>
<table>
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
</table>`
                                !!}

                            </p>
                            </div>
                        </div>
                        <!-- item 1 -->
                        <div x-data="{ id: 1 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 1, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 1 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 1 ? null : 1" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 1, 'text-gray-800 dark:text-white/90': openItem !== 1 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                            6.	Bagiamana jika mengurus gensen nya terlambat ?
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
                                {!! nl2br(e('
                                ➤ Selama anda masih di Jepang dengan waktu yang lama maka tidak ada kata terlambat, segera hubungi team EXATA untuk membantu anda, namun bagaimana jika sudah mau pulang ke Indonesia baru mengerti tentang Gensen ? jangan khawatir, Gensen tetap bisa di cairkan meskipun anda di Indonesia.')) !!}

                            </p>
                            </div>
                        </div>
                        <!-- item 1 -->
                        <div x-data="{ id: 1 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 1, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 1 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 1 ? null : 1" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 1, 'text-gray-800 dark:text-white/90': openItem !== 1 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                            7.	Berapa lama masa kadaluarsa GENSEN ?
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
                                {!! nl2br(e('
                                ➤ Batas kadaluarasa Gensen Maximal 5 Tahun, terhitung dari tahun dikeluarkan nya Gensen tersebut.')) !!}

                            </p>
                            </div>
                        </div>
                        <!-- item 1 -->
                        <div x-data="{ id: 1 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 1, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 1 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 1 ? null : 1" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 1, 'text-gray-800 dark:text-white/90': openItem !== 1 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                            8.	Berapa biaya administrasi pengurusan GENSEN ?
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
                                {!! nl2br(e('
                                ➤ 40% dari nominal Gensen yang bisa di cairkan di kantor pajak + biaya perwakilan pajak 3.000 Yen ')) !!}

                            </p>
                            </div>
                        </div>
                        <!-- item 1 -->
                        <div x-data="{ id: 1 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 1, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 1 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 1 ? null : 1" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 1, 'text-gray-800 dark:text-white/90': openItem !== 1 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                            9.	Berapa lama waktu yang di butuhkan untuk mencairakn GENSEN ?
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
                                {!! nl2br(e('
                                ➤ Proses pencairan Gensen memakan waktu rata-rata 2-4 bulan, terhitung berkas masuk kantor pajak ( Tergantung dari Tingkat crowded kantor pajak ) ')) !!}

                            </p>
                            </div>
                        </div>
                        <!-- item 1 -->
                        <div x-data="{ id: 1 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 1, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 1 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 1 ? null : 1" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 1, 'text-gray-800 dark:text-white/90': openItem !== 1 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                            10.	Apa itu SHIMINZEI/JUMINZEI dan bagaimana cara mengurus nya ?
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
                                {!! nl2br(e('
                                ➤ Shiminzei/juminzei adalah pajak daerah/pajak penduduk, semua orang asing di Jepang dikenakan pajak daerah dan cara mendapatkan keringanan pajak daerah, maka di sarankan untuk mengurus Gensen tepat waktu.
➤ Shiminzei tidak perlu di urus, karena secara sistem di perpajakan Jepang, bagi yang sudah selesai mengurus Gensen maka Shiminzei nya juga akan berkurang dengan sendirinya dan jika Shiminzei yg tahun sebelum nya sudah pernah potong dari gaji tiap bulan dan posisi di Jepang masih minimal 6 bulan maka dari Shiyakusho akan ada pengembalian Shiminzei tersebut, nilai yang di kembalikan sesuai dengan jumlah/total Shiminzei yang anda bayarkan.
')) !!}

                            </p>
                            </div>
                        </div>
                        <!-- item 1 -->
                        <div x-data="{ id: 1 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 1, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 1 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 1 ? null : 1" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 1, 'text-gray-800 dark:text-white/90': openItem !== 1 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                            11.	Bagaimana jika kirim uang nya ke rekening atas nama sendiri ?
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
                                {!! nl2br(e('
                                ➤ Jika kirim uang ke Indonesia nya ke rekening pribadi/sendiri maka Gensen TIDAK bisa di urus dan anda akan kena potongan pajak daerah/Shiminzei periode 1 tahun ke depan')) !!}

                            </p>
                            </div>
                        </div>
                        <!-- item 1 -->
                        <div x-data="{ id: 1 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 1, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 1 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 1 ? null : 1" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 1, 'text-gray-800 dark:text-white/90': openItem !== 1 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                            12.	Bagaimana jika penerima uang di Indonesia tersebut tidak ada di dalam 1 kartu keluarga (KK) tapi masih saudara kandung ?contoh kakak yg sudah menikah dan sudah pasti memiliki KK sendiri ?
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
                                {!! nl2br(e('
                                ➤ Walaupun berbeda KK tapi masih ada hubungan kandung maka, anda wajib melampirkan 2 KK, pertama KK anda sendiri dan KK kakak anda.')) !!}

                            </p>
                            </div>
                        </div>
                        <!-- item 1 -->
                        <div x-data="{ id: 1 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 1, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 1 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 1 ? null : 1" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 1, 'text-gray-800 dark:text-white/90': openItem !== 1 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                            13.	Bagaimana jika penerima uang di Indonesia bukan anggota keluarga? (calon istri atau pacar/tunangan?)
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
                                {!! nl2br(e('
                                ➤ Bagi penerima uang di Indonesia yang bukan bagian dari keluarga, maka tidak di anggap sebagai tanggungan keluarga dan Gensen tidak bisa di urus, kasus ini sama dengan jika kita kirim ke rekening sendiri.')) !!}

                            </p>
                            </div>
                        </div>
                        <!-- item 1 -->
                        <div x-data="{ id: 1 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 1, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 1 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 1 ? null : 1" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 1, 'text-gray-800 dark:text-white/90': openItem !== 1 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                            14.	Bagaimana cara meminta rekapan pengiriman uang selama di jepang?
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
                                {!! nl2br(e('
                                ➤ Anda bisa langsung menghubungi pihak jasa pengiriman uang di Jepang (remit) melalui medsos mereka di facebook/messenger atau IG dan rekapan nya akan dikirim ke e-mail kamu.')) !!}

                            </p>
                            </div>
                        </div>
                        <!-- item 1 -->
                        <div x-data="{ id: 1 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 1, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 1 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 1 ? null : 1" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 1, 'text-gray-800 dark:text-white/90': openItem !== 1 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                            15.	Bagaimana cara meminta kertas Gensen sewaktu masih di Jepang?
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
                                {!! nl2br(e('
                                ➤ Biasanya kertas Gensen langsung di berikan berbarengan dengan slip gaji di bulan Desember atau Januari, tapi jika tidak ada, maka anda bisa meminta langsung ke tantosa perusahaan/kaisha.')) !!}

                            </p>
                            </div>
                        </div>
                        <!-- item 1 -->
                        <div x-data="{ id: 1 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 1, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 1 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 1 ? null : 1" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 1, 'text-gray-800 dark:text-white/90': openItem !== 1 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                            16.	Bagaimana cara meminta kertas Gensen jika sudah di Indonesia?
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
                                {!! nl2br(e('
                                ➤ Anda bisa menghubungi sensei atau tantosa kaisha, minta tolong untuk dikirim ke email/dititipkan kohai dan kirim ke alamat Exata Jepang.
➤ Atau minta tolong kohai yang masih di jepang untuk meminta ke pihak kaisha
')) !!}

                            </p>
                            </div>
                        </div>
                        <!-- item 1 -->
                        <div x-data="{ id: 1 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 1, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 1 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 1 ? null : 1" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 1, 'text-gray-800 dark:text-white/90': openItem !== 1 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                            17.	Mengurus Gensen sebaiknya masih di Jepang atau setelah di Indonesia ?
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
                                {!! nl2br(e('
                                ➤ Mengurus sebaiknya setahun sekali artinya selama di Jepang anda rutin mengurus Gensen dan anda mendapatkan 2 keuntungan, pertama nominal yang cair dari kertas Gensen dan ke 2 adalah pajak daerah/Shiminzei anda akan diringankan, bahkan bisa sampai NOL ¥
➤ Tapi jika mengurus Gensen setelah di Indonesia, maka anda hanya dapat dari nilai yang cair saja, Shiminzei nya sudah tidak bisa di kembalikan.
')) !!}

                            </p>
                            </div>
                        </div>
                        <!-- item 1 -->
                        <div x-data="{ id: 1 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 1, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 1 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 1 ? null : 1" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 1, 'text-gray-800 dark:text-white/90': openItem !== 1 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                            18.	Apa perbedaan Exata dengan konsultan lain?
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
                                {!! nl2br(e('
                                ➤ Exata		: legal, transparan, mudah konsultasi, online 24 jam, alamat kantor jelas, team nya banyak.
➤ Akuntan lain	: perorangan, tidak ada kantornya, sulit konsultasi.
')) !!}

                            </p>
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