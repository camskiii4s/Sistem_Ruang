<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\BookingList;
use App\Jobs\SendEmail;

use DataTables;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingListController extends Controller
{
    /**
     * JSON for DataTables
     */
    public function json()
    {
        $data = BookingList::with(['room', 'user']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('room_name', fn($row) => $row->room->name ?? '-')
            ->addColumn('user_name', fn($row) => $row->user->name ?? '-')
            ->addColumn('unit_name', fn($row) => $row->unit ?? '-')
            ->addColumn('konsumsi_name', fn($row) => $row->konsumsi ?? '-')
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Index Page
     */
    public function index()
    {
        return view('pages.admin.booking-list.index');
    }

    /**
     * Update Status Booking
     */
    public function update($id, $value)
    {
        $item = BookingList::findOrFail($id);
        $today  = Carbon::today()->toDateString();
        $now    = Carbon::now()->toTimeString();

        $user_name  = $item->user->name;
        $user_email = $item->user->email;

        $admin_name  = Auth::user()->name;
        $admin_email = Auth::user()->email;

        if ($value == 1) {
            $data['status'] = 'DISETUJUI';
        } elseif ($value == 0) {
            $data['status'] = 'DITOLAK';
        } else {
            session()->flash('alert-failed', 'Perintah tidak dimengerti');
            return redirect()->route('booking-list.index');
        }

        // Booking harus tanggal depan
        if (
            $item['date'] > $today ||
            ($item['date'] == $today && $item['start_time'] > $now)
        ) {

            // Jika disetujui → cek bentrok jadwal
            if ($data['status'] == 'DISETUJUI') {

                $conflict = BookingList::where([
                        ['date', '=', $item['date']],
                        ['room_id', '=', $item['room_id']],
                        ['status', '=', 'DISETUJUI'],
                    ])
                    ->where(function ($q) use ($item) {
                        $q->whereBetween('start_time', [$item['start_time'], $item['end_time']])
                          ->orWhereBetween('end_time', [$item['start_time'], $item['end_time']])
                          ->orWhere(function ($qq) use ($item) {
                              $qq->where('start_time', '<=', $item['start_time'])
                                 ->where('end_time', '>=', $item['end_time']);
                          });
                    })
                    ->count();

                if ($conflict <= 0) {

                    if ($item->update($data)) {
                        session()->flash('alert-success', 'Booking Ruang ' . $item->room->name . ' sekarang ' . $data['status']);

                        // EMAIL USER
                        dispatch(new SendEmail(
                            $user_email, $user_name,
                            $item->room->name,
                            $item['date'], $item['start_time'], $item['end_time'],
                            $item['purpose'], 'USER', $user_name,
                            'https://google.com', $data['status']
                        ));

                        // EMAIL ADMIN
                        dispatch(new SendEmail(
                            $admin_email, $user_name,
                            $item->room->name,
                            $item['date'], $item['start_time'], $item['end_time'],
                            $item['purpose'], 'ADMIN', $admin_name,
                            'https://google.com', $data['status']
                        ));
                    }

                } else {
                    session()->flash('alert-failed', 'Ruangan di waktu itu sudah dibooking');
                }
            }

            // Jika ditolak
            if ($data['status'] == 'DITOLAK') {

                if ($item->update($data)) {

                    session()->flash('alert-success', 'Booking Ruang ' . $item->room->name . ' sekarang ' . $data['status']);

                    dispatch(new SendEmail(
                        $user_email, $user_name,
                        $item->room->name,
                        $item['date'], $item['start_time'], $item['end_time'],
                        $item['purpose'], 'USER', $user_name,
                        'https://google.com', $data['status']
                    ));

                    dispatch(new SendEmail(
                        $admin_email, $user_name,
                        $item->room->name,
                        $item['date'], $item['start_time'], $item['end_time'],
                        $item['purpose'], 'ADMIN', $admin_name,
                        'https://google.com', $data['status']
                    ));
                }
            }

        } else {
            session()->flash('alert-failed', 'Permintaan booking tidak lagi bisa diupdate');
        }

        return redirect()->route('booking-list.index');
    }

    /**
     * PREVIEW HTML (tampilan responsive)
     */
    public function preview(Request $request)
{
    $start = $request->start_date;
    $end   = $request->end_date;

    $data = BookingList::with(['room', 'user'])
        ->when($start && $end, function ($q) use ($start, $end) {
            $q->whereBetween('date', [$start, $end]);
        })
        ->orderBy('date', 'ASC')
        ->get();

    return view('pages.admin.booking-list.preview', [
        'bookings' => $data,
        'start' => $start,
        'end'   => $end
    ]);
}

public function report(Request $request)
{
    $request->validate([
        'start_date' => 'required|date',
        'end_date'   => 'required|date|after_or_equal:start_date',
    ]);

    $start = $request->start_date;
    $end   = $request->end_date;

    $data = BookingList::with(['room', 'user'])
        ->whereBetween('date', [$start, $end])
        ->orderBy('date', 'ASC')
        ->get();

    return Pdf::loadView('pages.admin.booking-list.report', [
        'bookings' => $data,
        'start' => $start,
        'end'   => $end
    ])
    ->setPaper('A4', 'portrait')
    ->download("laporan-booking-{$start}-{$end}.pdf");
}
}
