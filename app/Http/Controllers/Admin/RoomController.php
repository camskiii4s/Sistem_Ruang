<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Room;
use App\Http\Requests\Admin\RoomRequest;

use DataTables;

class RoomController extends Controller
{
    public function json()
{
    $data = Room::all();

    return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('facilities', function($row) {
            return $row->facilities ?? '-';
        })
        ->editColumn('photo', function($row) {
            return $row->photo;
        })
        ->make(true);
}
    public function index()
    {
        return view('pages.admin.room.index');
    }

    public function create()
    {
        return view('pages.admin.room.edit_or_create');
    }

    public function store(RoomRequest $request)
    {
        $data = $request->all();

        // Upload Foto
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store(
                'assets/image/room',
                'public'
            );
        }

        // Simpan data ruang
        $create = Room::create($data);
        
        if ($create) {
            $request->session()->flash('alert-success', 'Ruang ' . $data['name'] . ' berhasil ditambahkan');
        } else {
            $request->session()->flash('alert-failed', 'Ruang ' . $data['name'] . ' gagal ditambahkan');
        }

        return redirect()->route('room.index');
    }

    public function edit($id)
    {
        $item = Room::findOrFail($id);

        return view('pages.admin.room.edit_or_create', [
            'item' => $item
        ]);
    }

    public function update(RoomRequest $request, $id)
    {
        $data = $request->all();
        $item = Room::findOrFail($id);

        // Upload Foto baru jika ada
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store(
                'assets/image/room',
                'public'
            );
        }

        // Update data
        if ($item->update($data)) {
            $request->session()->flash('alert-success', 'Ruang ' . $item->name . ' berhasil diupdate');
        } else {
            $request->session()->flash('alert-failed', 'Ruang ' . $item->name . ' gagal diupdate');
        }
        
        return redirect()->route('room.index');
    }

    public function destroy($id)
    {
        $item = Room::findOrFail($id);
        
        if ($item->delete()) {
            session()->flash('alert-success', 'Ruang ' . $item->name . ' berhasil dihapus!');
        } else {
            session()->flash('alert-failed', 'Ruang ' . $item->name . ' gagal dihapus');
        }

        return redirect()->route('room.index');
    }
}
