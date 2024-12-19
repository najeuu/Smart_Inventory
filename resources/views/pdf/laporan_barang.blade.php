<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
        }
        h1 {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            color: #4a4a4a;
        }
        p {
            text-align: center;
            color: #6c757d;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f59e0b; /* Warna latar belakang untuk header */
            color: #fff; /* Warna teks untuk header */
        }
        tr:hover {
            background-color: #f3f4f6; /* Warna latar belakang saat hover */
        }
    </style>
</head>
<body>
    <h1>Laporan Barang</h1>

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
            @foreach ($data as $index => $barang)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $barang->nama_barang }}</td>
                <td>{{ $barang->jumlah }}</td>
                <td>{{ $barang->lokasi }}</td>
                <td>{{ $barang->kode_rfid }}</td> <!-- Menampilkan Kode RFID -->
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
