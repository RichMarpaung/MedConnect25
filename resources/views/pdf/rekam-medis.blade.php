<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Rekam Medis - {{ $reservasi->id }}</title>
    <style>
        /* CSS Wajib diletakkan di dalam tag <style> untuk dompdf */
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
            color: #0d6efd; /* Biru */
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
            text-align: left;
            vertical-align: top;
        }
        th {
            width: 30%;
            font-weight: normal;
            color: #555;
        }
        td {
            font-weight: bold;
        }
        .soap-label {
            font-size: 1.2em;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 5px;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .soap-content {
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            /* 'pre-wrap' menjaga format paragraf dari textarea */
            white-space: pre-wrap;
            font-family: 'Helvetica', 'Arial', sans-serif;
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
            <p>Rekam Medis Pasien</p>
        </div>

        <div class="card">
            <h3>Detail Kunjungan</h3>
            <table>
                <tr>
                    <th>ID Reservasi</th>
                    <td>{{ $reservasi->id }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ \Carbon\Carbon::parse($reservasi->tanggal_reservasi)->isoFormat('dddd, D MMMM YYYY') }}</td>
                </tr>
                <tr>
                    <th>Pasien</th>
                    <td>{{ $reservasi->pasien->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Dokter</th>
                    <td>{{ $reservasi->dokter?->user?->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Layanan</th>
                    <td>{{ $reservasi->dokter?->layanan?->nama_layanan ?? '-' }}</td>
                </tr>
            </table>

            @if($rekamMedis)
                <h3 style="margin-top: 30px;">Catatan Dokter (SOAP)</h3>

                <div class="soap-label">S (Subjektif / Keluhan)</div>
                <div class="soap-content">{{ $rekamMedis->subjektif ?? '-' }}</div>

                <div class="soap-label">O (Objektif / Temuan)</div>
                <div class="soap-content">{{ $rekamMedis->objektif ?? '-' }}</div>

                <div class="soap-label">A (Assessment / Diagnosa)</div>
                <div class="soap-content">{{ $rekamMedis->assessment ?? '-' }}</div>

                <div class="soap-label">P (Plan / Rencana & Resep)</div>
                <div class="soap-content">{{ $rekamMedis->plan ?? '-' }}</div>
            @else
                <p style="text-align: center; color: #777;">Rekam medis belum diisi oleh dokter.</p>
            @endif
        </div>

        <div class="footer">
            <p>Ini adalah dokumen rahasia yang dibuat oleh sistem MedConnect.<br>
            &copy; {{ date('Y') }} Klinik MedConnect.
            </p>
        </div>
    </div>
</body>
</html>
