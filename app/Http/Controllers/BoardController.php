<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;
use Illuminate\Support\Facades\Cache;

class BoardController extends Controller
{
    public function index()
    {
        $current = Antrian::where('status', 'called')
            ->orderBy('updated_at', 'desc')
            ->first();
            
        if (!$current) {
            $currentId = Cache::get('current_queue_id');
            if ($currentId) {
                if (is_object($currentId)) {
                    Cache::forget('current_queue_id');
                    $currentId = null;
                } else {
                    $current = Antrian::find($currentId);
                    if ($current && $current->status !== 'called') {
                        $current = null;
                        Cache::forget('current_queue_id');
                    }
                }
            }
        }
        
        // Fetch last 3 called queues (excluding the current one) to display history
        $excludeId = $current ? $current->id : 0;
        $history = Antrian::whereIn('status', ['called', 'completed', 'late'])
            ->where('id', '!=', $excludeId)
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();
        
        return view('board.index', compact('current', 'history'));
    }
}
