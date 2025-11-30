<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Tiket Reservasi {{ $reservasi->id }}</title>
    <style>
        /* CSS harus di-inline atau di dalam tag <style> agar dompdf bisa membacanya */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 14px;
        }
        .container {
            width: 90%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #0d6efd; /* Warna biru primary */
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 25px;
        }
        .ticket-id {
            text-align: center;
            font-size: 1.5em;
            font-weight: bold;
            color: #fff;
            background-color: #0d6efd;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border-bottom: 1px solid #eee;
            padding: 12px 0;
            text-align: left;
        }
        th {
            width: 40%;
            font-weight: normal;
            color: #666;
        }
        td {
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>MedConnect</h1>
            <p>Bukti Reservasi Janji Temu</p>
        </div>

        <div class="card">
            <div class="ticket-id">
                NOMOR ANTRIAN: {{ $reservasi->nomor_antrian }}
            </div>

            <table>
                <tr>
                    <th>ID Reservasi</th>
                    <td>{{ $reservasi->id }}</td>
                </tr>
                <tr>
                    <th>Nama Pasien</th>
                    <td>{{ $reservasi->pasien->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Dokter</th>
                    <td>{{ $reservasi->dokter?->user?->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Layanan</th>
                    <td>{{ $reservasi->dokter?->layanan?->nama_layanan ?? 'Layanan tidak terdaftar' }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ \Carbon\Carbon::parse($reservasi->tanggal_reservasi)->isoFormat('dddd, D MMMM YYYY') }}</td>
                </tr>
                <tr>
                    <th>Jam Praktek</th>
                    <td>
                        {{ \Carbon\Carbon::parse($reservasi->jadwal->jam_mulai)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($reservasi->jadwal->jam_selesai)->format('H:i') }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Tunjukkan tiket ini kepada petugas saat tiba di klinik.<br>
            &copy; {{ date('Y') }} Klinik MedConnect.
            </p>
        </div>
    </div>
</body>
</html>
