<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Booking Ruangan</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 0;
            padding: 0;
            position: relative;
        }

        /* BRAND COLOR */
        :root {
            --primary: #0078C2; /* Angkasa Pura Blue */
        }

        /* WATERMARK */
        .watermark {
            position: fixed;
            top: 35%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 80px;
            color: rgba(0, 120, 194, 0.08);
            font-weight: bold;
            letter-spacing: 5px;
            z-index: -1;
            white-space: nowrap;
        }

        /* HEADER */
        #header {
            position: fixed;
            top: -80px;
            left: 0;
            right: 0;
            background: var(--primary);
            color: #fff;
            padding: 15px 20px;
            text-align: left;
            font-size: 16px;
            font-weight: bold;
        }

        /* HEADER SUBTITLE */
        #header span {
            font-size: 12px;
            font-weight: normal;
        }

        /* FOOTER */
        #footer {
            position: fixed;
            bottom: -40px;
            left: 0;
            right: 0;
            padding: 5px 20px;
            font-size: 12px;
            color: #444;
            border-top: 1px solid #ccc;
        }

        .page-number:after {
            content: counter(page);
        }

        /* CONTENT */
        .title {
            text-align: center;
            margin-top: 10px;
            font-size: 17px;
            color: var(--primary);
            font-weight: bold;
        }

        .periode {
            text-align: center;
            margin-top: -5px;
            margin-bottom: 15px;
            font-size: 13px;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            font-size: 12px;
        }

        th {
            background: #e7f2fb;
            padding: 6px;
            border: 1px solid #ccc;
            text-align: center;
            font-weight: bold;
            color: #000;
        }

        td {
            padding: 6px;
            border: 1px solid #ccc;
        }

        .right {
            text-align: right;
        }
    </style>
</head>

<body>

{{-- WATERMARK --}}
<div class="watermark">ANGKASA PURA INDONESIA</div>

{{-- HEADER --}}
<div id="header">
    ANGKASA PURA INDONESIA <br>
    <span>Laporan Booking Ruangan</span>
</div>

{{-- MAIN CONTENT --}}
<div style="padding: 10px;">

    <h2 class="title">LAPORAN BOOKING RUANGAN</h2>

    @if($start && $end)
    <p class="periode">
        Periode: <strong>{{ $start }}</strong> s/d <strong>{{ $end }}</strong>
    </p>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Ruangan</th>
                <th>Unit</th>
                <th>User</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Konsumsi</th>
                <th>Keperluan</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($bookings as $b)
            <tr>
                <td style="text-align:center">{{ $loop->iteration }}</td>
                <td>{{ $b->room->name ?? '-' }}</td>
                <td>{{ $b->unit ?? '-' }}</td>
                <td>{{ $b->user->name ?? '-' }}</td>
                <td>{{ $b->date }}</td>
                <td>{{ $b->start_time }} - {{ $b->end_time }}</td>
                <td>{{ $b->konsumsi ?? '-' }}</td>
                <td>{{ $b->purpose ?? '-' }}</td>
                <td>{{ ucfirst($b->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center; padding: 10px;">
                    <em>Tidak ada data.</em>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

{{-- FOOTER --}}
<div id="footer">
    Dokumen resmi — Dicetak pada {{ now()->translatedFormat('d F Y') }}  
    <span style="float:right">Halaman: <span class="page-number"></span></span>
</div>

</body>
</html>
