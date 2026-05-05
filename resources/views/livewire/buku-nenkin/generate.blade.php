<div class="content-layer mx-auto st shadow-sm rounded-lg overflow-hidden border border-outline-variant/15">

        {{-- HEADER --}}
        <div class="header">
            
            <div class="p-0 border-b border-outline-variant/10" id="header"
                style="display:flex; justify-content: space-evenly; align-items: center;"
                >
            </div>
            <div class="row flex items-center flex-col mt-[60px]" id="input">
                <div class="">
                    <button class="bg-green-600  mb-2 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200" onclick="printPDF()">
                        Save PDF
                    </button>
                </div>
                <div class="w-5/12">
                    <input type="text" placeholder="Nama LPK" wire:model.live="nama_lpk" class="w-full px-3 mb-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="w-5/12">
                    <textarea placeholder="Nama LPK" wire:model.live="alamat_lpk" cols="30" rows="3" class="w-full px-3 mb-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div class="w-5/12">
                    <input type="text" placeholder="Nama LPK" wire:model.live="telp_lpk" class="w-full px-3 mb-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>
        {{-- CONTENT --}}
        <table class="report-container">
            <thead class="report-header">
                <tr>
                    <th class="report-header-cell">
                    </th>
                </tr>
            </thead>
            <tbody class="report-content">
                <tr>
                    <td class="report-content-cell">
                        <div class="main">
                            <!-- Table Section -->
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <table class="w-full table-fixed">
                                        <thead>
                                            <tr class="bg-primary-container text-on-primary">
                                                <th class="w-[30px] px-0 text-[10px] py-4 text-center break-words">No</th>
                                                <th class="w-[80px] px-0 text-[10px] py-4 text-center break-words">Kode</th>
                                                <th class="w-[60px] px-0 text-[10px] py-4 text-center break-words">Usia</th>
                                                <th class="w-[80px] px-0 text-[10px] py-4 text-center break-words">Jenis kelamin</th>
                                                <th class="w-[100px] px-0 text-[10px] py-4 text-center break-words">Pendidikan</th>
                                                <th class="w-[120px] px-0 text-[10px] py-4 text-center break-words">Domisili</th>
                                                <th class="w-[130px] px-0 text-[10px] py-4 text-center break-words">Penempatan</th>
                                                <th class="w-[120px] px-0 text-[10px] py-4 text-center break-words">Level Bahasa</th>
                                                <th class="w-[120px] px-0 text-[10px] py-4 text-center break-words">Lama di Jepang</th>
                                                <th class="w-[180px] px-0 text-[10px] py-4 text-center break-words">Bidang Kerja Jepang</th>
                                                <th class="w-[80px] px-0 text-[10px] py-4 text-center break-words">Sensei</th>
                                                <th class="w-[80px] px-0 text-[10px] py-4 text-center break-words">Admin</th>
                                                <th class="w-[100px] px-0 text-[10px] py-4 text-center break-words">Penerjemah</th>
                                                <th class="w-[140px] px-0 text-[10px] py-4 text-center break-words">Ketersediaan mulai kerja</th>
                                                <th class="w-[100px] px-0 text-[10px] py-4 text-center break-words">Salary</th>
                                                
                                            </tr>
                                        </thead>
                                </table>
                            </div>
                            <div class="max-w-5xl w-full">
         <!-- Document Header Section -->
         <header class="mb-10 space-y-4">
            <div class="flex items-center gap-4 text-black text-center justify-center">
               <h1 class="font-headline text-3xl font-extrabold tracking-tight uppercase text-center">
                  Data Pemohon Bagi Yang Tidak Punya Buku Nenkin
               </h1>
            </div>
            <div class="flex items-center gap-4 text-black text-center justify-center">   
               <h1 class="font-headline text-3xl font-extrabold tracking-tight uppercase text-center">
                  履歴（公的年金制度加入経過）
               </h1>
            </div>
            <div class="flex items-center gap-4 text-black text-center justify-center">   
               <h1 class="font-headline text-3xl font-extrabold tracking-tight uppercase text-center">
                 できるだけくわしく、正確に記入してください。
               </h1>
            </div>
            <div class="flex items-center gap-4 text-black text-center justify-center">   
               <h1 class="font-headline text-3xl font-extrabold tracking-tight uppercase text-center">
                 歴（公的年金制度加入経過）
               </h1>
            </div>
         </header>
         <!-- Administrative Data Grid -->
         <div class="bg-primary rounded-xl overflow-hidden shadow-2xl p-0.5 space-y-0.5 border-4 border-primary">
            <!-- Row 1: Name -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Nama</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">氏名</span>
               </div>
               <div class="bg-primary-container-lowest flex-1 p-6 flex items-center">
                  <span class="text-white text-xl font-bold tracking-wide">SARIZON</span>
               </div>
            </div>
            <!-- Row 2: Birth Date -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Tanggal lahir</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">生年月日</span>
               </div>
               <div class="bg-surface-container-lowest flex-1 p-6 flex items-center">
                  <span class="text-on-surface text-lg">1999年 09月 01日</span>
               </div>
            </div>
            <!-- Row 3: Address in Japan -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Alamat tinggal ketika di Jepang</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">日本における最終居: 住居地</span>
               </div>
               <div class="bg-surface-container-lowest flex-1 p-6 flex flex-col justify-center">
                  <span class="text-on-surface text-lg leading-relaxed">大阪府南河内郡太子町大字春日10番地の3</span>
                  <span class="text-secondary font-medium mt-1">〒583-0991</span>
               </div>
            </div>
            <!-- Row 4: Departure Date -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Tanggal kepulangan</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">日本出国日</span>
               </div>
               <div class="bg-surface-container-lowest flex-1 p-6 flex items-center">
                  <span class="text-on-surface text-lg">2026年 03月 17日</span>
               </div>
            </div>
            <!-- Row 5: Company Name -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Nama Perusahaan</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">所属会社名</span>
               </div>
               <div class="bg-primary-container-lowest flex-1 p-6 flex items-center">
                  <span class="text-on-surface text-lg font-bold text-white">(有) SAITETSU CO., LTD. <span class="font-normal opacity-80">(株式会社斉鉄)</span></span>
               </div>
            </div>
            <!-- Row 6: Company Address -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Alamat Perusahaan</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">所属会社居住地</span>
               </div>
               <div class="bg-surface-container-lowest flex-1 p-6 flex flex-col justify-center">
                  <span class="text-on-surface text-lg">(大阪府富田林市小金台1丁目12-10)</span>
                  <span class="text-secondary font-medium mt-1">〒584-0083</span>
               </div>
            </div>
            <!-- Row 7: Phone Number -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Nomor Telepon</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">同電話番号</span>
               </div>
               <div class="bg-surface-container-lowest flex-1 p-6 flex items-center">
                  <span class="text-on-surface text-lg font-mono tracking-wider">072-123-8430</span>
               </div>
            </div>
            <!-- Row 8: Working Period -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Jangka waktu bekerja</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">勤務期間または国民年金の加入期間</span>
               </div>
               <div class="bg-surface-container-lowest flex-1 p-6 flex items-center">
                  <div class="flex items-center gap-3">
                     <span class="text-on-surface text-lg">2022年 03月 22日</span>
                     <span class="text-outline-variant">—</span>
                     <span class="text-on-surface text-lg">2026年 03月 15日</span>
                  </div>
               </div>
            </div>
            <!-- Row 9: Nenkin Type -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Jenis Nenkin</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">加入していた年金制度の種別</span>
               </div>
               <div class="bg-surface-container-lowest flex-1 p-6 flex items-center">
                  <span class="text-on-surface text-lg">KOUSEI NENKIN / </span>
                  <span class="text-on-surface text-lg">厚生年金保険</span>
               </div>
            </div>
            <!-- Row 5: Company Name -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Nama Perusahaan</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">所属会社名</span>
               </div>
               <div class="bg-primary-container-lowest flex-1 p-6 flex items-center">
                  <span class="text-on-surface text-lg font-bold text-white">(有) SAITETSU CO., LTD. <span class="font-normal opacity-80">(株式会社斉鉄)</span></span>
               </div>
            </div>
            <!-- Row 6: Company Address -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Alamat Perusahaan</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">所属会社居住地</span>
               </div>
               <div class="bg-surface-container-lowest flex-1 p-6 flex flex-col justify-center">
                  <span class="text-on-surface text-lg">(大阪府富田林市小金台1丁目12-10)</span>
                  <span class="text-secondary font-medium mt-1">〒584-0083</span>
               </div>
            </div>
            <!-- Row 7: Phone Number -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Nomor Telepon</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">同電話番号</span>
               </div>
               <div class="bg-surface-container-lowest flex-1 p-6 flex items-center">
                  <span class="text-on-surface text-lg font-mono tracking-wider">072-123-8430</span>
               </div>
            </div>
            <!-- Row 8: Working Period -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Jangka waktu bekerja</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">勤務期間または国民年金の加入期間</span>
               </div>
               <div class="bg-surface-container-lowest flex-1 p-6 flex items-center">
                  <div class="flex items-center gap-3">
                     <span class="text-on-surface text-lg">2022年 03月 22日</span>
                     <span class="text-outline-variant">—</span>
                     <span class="text-on-surface text-lg">2026年 03月 15日</span>
                  </div>
               </div>
            </div>
            <!-- Row 9: Nenkin Type -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Jenis Nenkin</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">加入していた年金制度の種別</span>
               </div>
               <div class="bg-surface-container-lowest flex-1 p-6 flex items-center">
                  <span class="text-on-surface text-lg">KOUSEI NENKIN / </span>
                  <span class="text-on-surface text-lg">厚生年金保険</span>
               </div>
            </div>
         </div>
      </div>
      <div class="max-w-5xl w-full">
         <!-- Document Header Section -->
         <header class="mb-10 space-y-4">
            <div class="flex items-center gap-4 text-black text-center justify-center">
               <h1 class="font-headline text-3xl font-extrabold tracking-tight uppercase text-center">
                  Data Pemohon Bagi Yang Tidak Punya Buku Nenkin
               </h1>
            </div>
            <div class="flex items-center gap-4 text-black text-center justify-center">   
               <h1 class="font-headline text-3xl font-extrabold tracking-tight uppercase text-center">
                  履歴（公的年金制度加入経過）
               </h1>
            </div>
            <div class="flex items-center gap-4 text-black text-center justify-center">   
               <h1 class="font-headline text-3xl font-extrabold tracking-tight uppercase text-center">
                 できるだけくわしく、正確に記入してください。
               </h1>
            </div>
            <div class="flex items-center gap-4 text-black text-center justify-center">   
               <h1 class="font-headline text-3xl font-extrabold tracking-tight uppercase text-center">
                 歴（公的年金制度加入経過）
               </h1>
            </div>
         </header>
         <!-- Administrative Data Grid -->
         <div class="bg-primary rounded-xl overflow-hidden shadow-2xl p-0.5 space-y-0.5 border-4 border-primary">
            <!-- Row 1: Name -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Nama</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">氏名</span>
               </div>
               <div class="bg-primary-container-lowest flex-1 p-6 flex items-center">
                  <span class="text-white text-xl font-bold tracking-wide">SARIZON</span>
               </div>
            </div>
            <!-- Row 2: Birth Date -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Tanggal lahir</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">生年月日</span>
               </div>
               <div class="bg-surface-container-lowest flex-1 p-6 flex items-center">
                  <span class="text-on-surface text-lg">1999年 09月 01日</span>
               </div>
            </div>
            <!-- Row 3: Address in Japan -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Alamat tinggal ketika di Jepang</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">日本における最終居: 住居地</span>
               </div>
               <div class="bg-surface-container-lowest flex-1 p-6 flex flex-col justify-center">
                  <span class="text-on-surface text-lg leading-relaxed">大阪府南河内郡太子町大字春日10番地の3</span>
                  <span class="text-secondary font-medium mt-1">〒583-0991</span>
               </div>
            </div>
            <!-- Row 4: Departure Date -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Tanggal kepulangan</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">日本出国日</span>
               </div>
               <div class="bg-surface-container-lowest flex-1 p-6 flex items-center">
                  <span class="text-on-surface text-lg">2026年 03月 17日</span>
               </div>
            </div>
            <!-- Row 5: Company Name -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Nama Perusahaan</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">所属会社名</span>
               </div>
               <div class="bg-primary-container-lowest flex-1 p-6 flex items-center">
                  <span class="text-on-surface text-lg font-bold text-white">(有) SAITETSU CO., LTD. <span class="font-normal opacity-80">(株式会社斉鉄)</span></span>
               </div>
            </div>
            <!-- Row 6: Company Address -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Alamat Perusahaan</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">所属会社居住地</span>
               </div>
               <div class="bg-surface-container-lowest flex-1 p-6 flex flex-col justify-center">
                  <span class="text-on-surface text-lg">(大阪府富田林市小金台1丁目12-10)</span>
                  <span class="text-secondary font-medium mt-1">〒584-0083</span>
               </div>
            </div>
            <!-- Row 7: Phone Number -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Nomor Telepon</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">同電話番号</span>
               </div>
               <div class="bg-surface-container-lowest flex-1 p-6 flex items-center">
                  <span class="text-on-surface text-lg font-mono tracking-wider">072-123-8430</span>
               </div>
            </div>
            <!-- Row 8: Working Period -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Jangka waktu bekerja</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">勤務期間または国民年金の加入期間</span>
               </div>
               <div class="bg-surface-container-lowest flex-1 p-6 flex items-center">
                  <div class="flex items-center gap-3">
                     <span class="text-on-surface text-lg">2022年 03月 22日</span>
                     <span class="text-outline-variant">—</span>
                     <span class="text-on-surface text-lg">2026年 03月 15日</span>
                  </div>
               </div>
            </div>
            <!-- Row 9: Nenkin Type -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Jenis Nenkin</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">加入していた年金制度の種別</span>
               </div>
               <div class="bg-surface-container-lowest flex-1 p-6 flex items-center">
                  <span class="text-on-surface text-lg">KOUSEI NENKIN / </span>
                  <span class="text-on-surface text-lg">厚生年金保険</span>
               </div>
            </div>
            <!-- Row 5: Company Name -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Nama Perusahaan</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">所属会社名</span>
               </div>
               <div class="bg-primary-container-lowest flex-1 p-6 flex items-center">
                  <span class="text-on-surface text-lg font-bold text-white">(有) SAITETSU CO., LTD. <span class="font-normal opacity-80">(株式会社斉鉄)</span></span>
               </div>
            </div>
            <!-- Row 6: Company Address -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Alamat Perusahaan</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">所属会社居住地</span>
               </div>
               <div class="bg-surface-container-lowest flex-1 p-6 flex flex-col justify-center">
                  <span class="text-on-surface text-lg">(大阪府富田林市小金台1丁目12-10)</span>
                  <span class="text-secondary font-medium mt-1">〒584-0083</span>
               </div>
            </div>
            <!-- Row 7: Phone Number -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Nomor Telepon</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">同電話番号</span>
               </div>
               <div class="bg-surface-container-lowest flex-1 p-6 flex items-center">
                  <span class="text-on-surface text-lg font-mono tracking-wider">072-123-8430</span>
               </div>
            </div>
            <!-- Row 8: Working Period -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Jangka waktu bekerja</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">勤務期間または国民年金の加入期間</span>
               </div>
               <div class="bg-surface-container-lowest flex-1 p-6 flex items-center">
                  <div class="flex items-center gap-3">
                     <span class="text-on-surface text-lg">2022年 03月 22日</span>
                     <span class="text-outline-variant">—</span>
                     <span class="text-on-surface text-lg">2026年 03月 15日</span>
                  </div>
               </div>
            </div>
            <!-- Row 9: Nenkin Type -->
            <div class="flex flex-col md:flex-row gap-0.5">
               <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                  <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Jenis Nenkin</span>
                  <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">加入していた年金制度の種別</span>
               </div>
               <div class="bg-surface-container-lowest flex-1 p-6 flex items-center">
                  <span class="text-on-surface text-lg">KOUSEI NENKIN / </span>
                  <span class="text-on-surface text-lg">厚生年金保険</span>
               </div>
            </div>
         </div>
      </div>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th class="report-footer-cell">
                    </th>
                </tr>
            </tfoot>
        </table>

        <p class="text-center mb-0 pb-0 page-number"></p>
        {{-- FOOTER --}}
        <div class="footer">        
            <div class="mt-12 px-12 pb-0 w-full">
                <div class="flex flex-col w-full gap-0">
                    <p class="font-bold text-lg text-center mb-0 pb-0">Contact Person:</p>
                    <p class="font-extrabold text-xl text-center text-primary tracking-tight mt-0 pt-0">Tanjung - 0812 2000 4752</p>
                </div>
            </div>
        </div>
    </div>

@push('js')
    <script>
        function printPDF(){
            $('#input').hide()
            $(() => {
                window.print();
                const afterPrint = setTimeout(() => {
                    window.close()
                }, 500);
            });
        }
    </script>
@endpush