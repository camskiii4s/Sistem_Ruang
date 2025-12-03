<!DOCTYPE html>
<html>
<head>
    <title>Preview Laporan Booking Ruangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: #f7f9fc;
            position: relative;
        }

        /* =====================
           BRAND COLOR
        ======================= */
        .brand {
            color: #0078C2;
        }

        /* =====================
           HEADER KOP SURAT
        ======================= */
        .header {
            width: 100%;
            border-bottom: 3px solid #0078C2;
            padding-bottom: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .header img {
            width: 80px;
            margin-right: 15px;
        }

        .header .title {
            font-size: 20px;
            font-weight: bold;
            line-height: 1.2;
            color: #0078C2;
        }

        /* =====================
           FOOTER TANDA TANGAN
        ======================= */
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 14px;
        }

        .footer .ttd {
            margin-top: 60px;
        }

        /* =====================
           PAGE NUMBER
        ======================= */
        .page-number {
            position: fixed;
            bottom: 10px;
            right: 20px;
            font-size: 12px;
            color: #0078C2;
        }

        /* =====================
           TABEL
        ======================= */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            border: 1px solid #333;
            padding: 8px;
            font-size: 13px;
        }

        th {
            background: #e7f2fb;
            text-align: center;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .periode {
            text-align: center;
            font-size: 14px;
            color: #444;
            margin-top: -10px;
            margin-bottom: 20px;
        }

        /* =====================
           RESPONSIVE
        ======================= */
        @media (max-width: 768px) {

            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead tr { display: none; }

            td {
                border: none;
                border-bottom: 1px solid #ddd;
                position: relative;
                padding-left: 55%;
            }

            td:before {
                position: absolute;
                left: 10px;
                width: 45%;
                font-weight: bold;
                white-space: nowrap;
            }

            td:nth-child(1)::before { content: "No"; }
            td:nth-child(2)::before { content: "Ruangan"; }
            td:nth-child(3)::before { content: "Unit"; }
            td:nth-child(4)::before { content: "User"; }
            td:nth-child(5)::before { content: "Tanggal"; }
            td:nth-child(6)::before { content: "Waktu"; }
            td:nth-child(7)::before { content: "Konsumsi"; }
            td:nth-child(8)::before { content: "Keperluan"; }
            td:nth-child(9)::before { content: "Status"; }
        }
    </style>
</head>
<body>

{{-- ============================= --}}
{{-- HEADER / KOP SURAT --}}
{{-- ============================= --}}
<div class="header">
    <img src="{{ asset('storage/images/injourney1.png') }}" alt="Logo" width="120">
    <div class="title">
        ANGKASA PURA INDONESIA <br>
        <span style="font-size:14px; font-weight: normal;">Laporan Booking Ruangan</span>
    </div>
</div>

<h2 class="brand">LAPORAN BOOKING RUANGAN</h2>

@if($start && $end)
    <p class="periode">Periode: <strong>{{ $start }}</strong> s/d <strong>{{ $end }}</strong></p>
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
            <td>{{ $loop->iteration }}</td>
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
            <td colspan="9" style="text-align:center; padding:20px;">
                <em>Tidak ada data pada periode tersebut.</em>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- ============================= --}}
{{-- FOOTER TANDA TANGAN --}}
{{-- ============================= --}}
<div class="footer">
    Pekanbaru, {{ now()->translatedFormat('d F Y') }} <br>
    <strong>Admin Booking Ruangan</strong>
    <div class="ttd">
        ____________________________ <br>
        <span style="font-size: 13px;">(........................................)</span>
    </div>
</div>

<div class="page-number">
    Halaman: 1
</div>

</body>
</html>
