<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Barang</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 40px;
            color: #333;
            font-size: 12px;
        }
        h1 {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
            color: #1f2937;
        }
        .info {
            text-align: left;
            margin-bottom: 25px;
            line-height: 1.6;
        }
        .info strong {
            display: inline-block;
            width: 140px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #444;
            padding: 8px;
        }
        th {
            background-color: #1a56be;
            color: white;
            text-align: center;
        }
        td {
            text-align: center;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 11px;
            color: #6b7280;
        }
    </style>
</head>
<body>

    <h1>LAPORAN DATA BARANG</h1>

    <div class="info">
        <p><strong>Tanggal Unduh</strong> {{ $tanggalUnduh }}</p>
        <p><strong>Nama Pengguna</strong> {{ $user->username }}</p>
        <p><strong>Email</strong> {{ $user->email }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Lokasi</th>
                <th>Kode RFID</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $index => $barang)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="text-align: left;">{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->jumlah }}</td>
                    <td>{{ $barang->lokasi->lokasi }}</td>
                    <td>{{ $barang->kode_rfid }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Tidak ada data barang tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada {{ now()->format('d-m-Y H:i') }} melalui InventoriKu
    </div>

</body>
</html>
