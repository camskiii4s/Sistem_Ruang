<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

use App\Models\BookingList;
use App\Models\Room;
use App\Models\User;

use App\Jobs\SendEmail;
use DataTables;
use App\Http\Requests\User\MyBookingListRequest;

class MyBookingListController extends Controller
{
    /**
     * JSON untuk DataTables
     */
    public function json()
    {
        $data = BookingList::where('user_id', Auth::user()->id)
            ->with(['room']);

        return DataTables::of($data)
            ->addIndexColumn()

            // FOTO RUANGAN - untuk DataTables "room.photo"
            ->addColumn('room.photo', function($row){
                return $row->room ? $row->room->photo : null;
            })

            // NAMA RUANGAN - untuk DataTables "room.name"
            ->addColumn('room.name', function($row){
                return $row->room ? $row->room->name : '-';
            })

            // UNIT
            ->addColumn('unit', function($row){
                return $row->unit ?? '-';
            })

            // KONSUMSI — FIX (ini yang kamu butuhkan)
            ->addColumn('konsumsi', function($row){
                return $row->konsumsi ?? '-';
            })

            // STATUS BADGE
            ->addColumn('status_badge', function($row){
                switch($row->status){
                    case 'DISETUJUI': return '<span class="badge badge-primary">DISETUJUI</span>';
                    case 'DITOLAK': return '<span class="badge badge-danger">DITOLAK</span>';
                    case 'PENDING': return '<span class="badge badge-info">PENDING</span>';
                    case 'EXPIRED':
                    case 'BATAL': return '<span class="badge badge-warning">'.$row->status.'</span>';
                    case 'SELESAI': return '<span class="badge badge-success">SELESAI</span>';
                    default: return '<span class="badge badge-secondary">'.$row->status.'</span>';
                }
            })
            ->rawColumns(['status_badge'])
            ->make(true);
    }

    /**
     * Halaman index booking list
     */
    public function index()
    {
        return view('pages.user.my-booking-list.index');
    }

    /**
     * Form create booking
     */
    public function create()
    {
        $rooms = Room::orderBy('name')->get();

        return view('pages.user.my-booking-list.create', [
            'rooms' => $rooms,
        ]);
    }

    /**
     * Store booking baru
     */
    public function store(MyBookingListRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['status']  = 'PENDING';

        $room = Room::select('name')->where('id', $data['room_id'])->firstOrFail();

        // Cek konflik booking
        $conflict = BookingList::where('room_id', $data['room_id'])
            ->where('date', $data['date'])
            ->where('status', 'DISETUJUI')
            ->where(function($q) use ($data){
                $q->whereBetween('start_time', [$data['start_time'], $data['end_time']])
                  ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']])
                  ->orWhere(function($q2) use ($data){
                      $q2->where('start_time', '<=', $data['start_time'])
                         ->where('end_time', '>=', $data['end_time']);
                  });
            })
            ->count();

        if($conflict > 0){
            $request->session()->flash('alert-failed', 'Ruangan '.$room->name.' di waktu itu sudah dibooking');
            return redirect()->route('my-booking-list.create');
        }

        if(BookingList::create($data)){
            $request->session()->flash('alert-success', 'Booking ruang '.$room->name.' berhasil ditambahkan');

            $user_name  = Auth::user()->name;
            $user_email = Auth::user()->email;
            $admin      = $this->getAdminData();
            $status     = 'DIBUAT';

            // Email user
            dispatch(new SendEmail(
                $user_email,
                $user_name,
                $room->name,
                $data['date'],
                $data['start_time'],
                $data['end_time'],
                $data['purpose'],
                'USER',
                $user_name,
                URL::to('/my-booking-list'),
                $status,
                $data['konsumsi'] ?? null
            ));

            // Email admin
            dispatch(new SendEmail(
                $admin->email,
                $user_name,
                $room->name,
                $data['date'],
                $data['start_time'],
                $data['end_time'],
                $data['purpose'],
                'ADMIN',
                $admin->name,
                URL::to('/admin/booking-list'),
                $status,
                $data['konsumsi'] ?? null
            ));

        } else {
            $request->session()->flash('alert-failed', 'Booking ruang '.$room->name.' gagal ditambahkan');
            return redirect()->route('my-booking-list.create');
        }

        return redirect()->route('my-booking-list.index');
    }

    /**
     * Cancel booking
     */
    public function cancel($id)
    {
        $item = BookingList::findOrFail($id);
        $data['status'] = 'BATAL';

        $room = Room::select('name')->where('id', $item->room_id)->firstOrFail();

        if($item->update($data)){
            session()->flash('alert-success', 'Booking Ruang '.$room->name.' berhasil dibatalkan');

            $user_name  = Auth::user()->name;
            $user_email = Auth::user()->email;
            $admin      = $this->getAdminData();
            $status     = $data['status'];

            // Email user
            dispatch(new SendEmail(
                $user_email,
                $user_name,
                $room->name,
                $item->date,
                $item->start_time,
                $item->end_time,
                $item->purpose,
                'USER',
                $user_name,
                URL::to('/my-booking-list'),
                $status,
                $item->konsumsi ?? null
            ));

            // Email admin
            dispatch(new SendEmail(
                $admin->email,
                $user_name,
                $room->name,
                $item->date,
                $item->start_time,
                $item->end_time,
                $item->purpose,
                'ADMIN',
                $admin->name,
                URL::to('/admin/booking-list'),
                $status,
                $item->konsumsi ?? null
            ));

        } else {
            session()->flash('alert-failed', 'Booking Ruang '.$room->name.' gagal dibatalkan');
        }

        return redirect()->route('my-booking-list.index');
    }

    /**
     * Ambil admin
     */
    private function getAdminData()
    {
        return User::select('name','email')->where('role', 'ADMIN')->firstOrFail();
    }
}
