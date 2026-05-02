<div class="detail-item">
    <div class="detail-text">
        <h3>Data Tersimpan</h3>
        @foreach ($data as $item)
            <p>{{$item['nama_lengkap']}}, Tanggal Lahir {{$item['tanggal_lahir']}}</p>
        @endforeach
    </div>
</div>

