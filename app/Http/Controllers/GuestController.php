<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class GuestController extends Controller
{
    public function index()
    {
        return view('guest.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $antrian = Antrian::create([
            'name' => $request->name,
            'status' => 'waiting',
            'number' => DB::table('antrian')->max('number') + 1,
        ]);

        Cache::put('antrian_data', [
            'action' => 'store',
            'antrian' => $antrian,
            'timestamp' => microtime(true)
        ], 60);

        return redirect()->route('guest.tiket', ['id' => $antrian->id]);
    }

    public function tiket($id)
    {
        $antrian = Antrian::findOrFail($id);
        return view('guest.tiket', compact('antrian'));
    }

    public function status($id)
    {
        $antrian = Antrian::findOrFail($id);
        return response()->json([
            'status' => $antrian->status,
        ]);
    }
}
