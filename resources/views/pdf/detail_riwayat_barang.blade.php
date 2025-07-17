<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Riwayat Barang - {{ $barang->nama_barang }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: rgb(71, 177, 244); }
    </style>
</head>
<body>
    <h2>Riwayat Barang : {{ $barang->nama_barang }}</h2>
    <p>Kategori: {{ $barang->kategori->nama_kategori ?? '-' }}</p>
    <p>Lokasi: {{ $barang->lokasi->lokasi ?? '-' }}</p>
    <p>Stok Saat Ini: {{ $barang->jumlah }}</p>

    <table>
        <thead>
            <tr>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali Terakhir</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($riwayatPeminjaman as $r)
                <tr>
                    <td>{{ $r['nama_mahasiswa'] }}</td>
                    <td>{{ $r['nim'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($r['tanggal_pinjam'])->format('d-m-Y') }}</td>
                    <td>{{ $r['tanggal_pengembalian_terakhir'] ? \Carbon\Carbon::parse($r['tanggal_pengembalian_terakhir'])->format('d-m-Y') : '-' }}</td>
                    <td>{{ $r['status'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
