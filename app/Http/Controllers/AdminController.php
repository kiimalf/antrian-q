<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function index()
    {
        $today = today();
        
        $total = Antrian::whereDate('created_at', $today)->count();
        $waiting = Antrian::whereDate('created_at', $today)->where('status', 'waiting')->count();
        $late = Antrian::whereDate('created_at', $today)->where('status', 'late')->count();
        $completed = Antrian::whereDate('created_at', $today)->where('status', 'completed')->count();
        
        // Find the most recently called queue
        $current = Antrian::where('status', 'called')->orderBy('updated_at', 'desc')->first();
        if (!$current) {
            $currentId = Cache::get('current_queue_id');
            if ($currentId) {
                if (is_object($currentId)) {
                    Cache::forget('current_queue_id');
                    $currentId = null;
                } else {
                    // Verify it is still called in DB
                    $current = Antrian::find($currentId);
                    if ($current && $current->status !== 'called') {
                        $current = null;
                        Cache::forget('current_queue_id');
                    }
                }
            }
        }

        // Get top 5 waiting queues
        $next = Antrian::where('status', 'waiting')
            ->orderBy('number', 'asc')
            ->take(5)
            ->get();
        
        // Get last 10 non-waiting events as activity logs
        $activities = Antrian::whereIn('status', ['called', 'late', 'completed'])
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();
            
        return view('admin.dashboard', compact('total', 'waiting', 'late', 'completed', 'current', 'next', 'activities'));
    }

    public function callNext()
    {
        // Find next waiting queue
        $nextQueue = Antrian::where('status', 'waiting')->orderBy('number', 'asc')->first();
        
        if (!$nextQueue) {
            return redirect()->route('admin.dashboard')->with('info', 'Tidak ada antrian dalam daftar tunggu.');
        }

        // Auto-complete any existing called queues to clean up the screen
        Antrian::where('status', 'called')->update(['status' => 'completed']);

        // Update the next queue to 'called'
        $nextQueue->status = 'called';
        $nextQueue->save();

        // Update cache for board and dashboard (store ID and array to avoid serialization issue)
        Cache::put('current_queue_id', $nextQueue->id, 86400);
        Cache::put('antrian_data', [
            'action' => 'call',
            'antrian' => $nextQueue->toArray(),
            'timestamp' => microtime(true)
        ], 60);

        return redirect()->route('admin.dashboard')->with('success', 'Berhasil memanggil antrian A-' . sprintf('%03d', $nextQueue->number));
    }

    public function recall($id)
    {
        $antrian = Antrian::findOrFail($id);
        
        // Update updated_at time to push it to the top of logs/SSE
        $antrian->touch();

        // Trigger SSE broadcast via antrian_data
        Cache::put('antrian_data', [
            'action' => 'recall',
            'antrian' => $antrian->toArray(),
            'timestamp' => microtime(true)
        ], 60);

        return redirect()->route('admin.dashboard')->with('success', 'Memanggil ulang antrian A-' . sprintf('%03d', $antrian->number));
    }

    public function complete($id)
    {
        $antrian = Antrian::findOrFail($id);
        $antrian->status = 'completed';
        $antrian->save();

        if (Cache::get('current_queue_id') == $id) {
            Cache::forget('current_queue_id');
        }

        // Trigger SSE broadcast via antrian_data
        Cache::put('antrian_data', [
            'action' => 'update',
            'antrian' => $antrian->toArray(),
            'timestamp' => microtime(true)
        ], 60);

        return redirect()->route('admin.dashboard')->with('success', 'Antrian A-' . sprintf('%03d', $antrian->number) . ' selesai dilayani.');
    }

    public function late($id)
    {
        $antrian = Antrian::findOrFail($id);
        $antrian->status = 'late';
        $antrian->save();

        if (Cache::get('current_queue_id') == $id) {
            Cache::forget('current_queue_id');
        }

        // Trigger SSE broadcast via antrian_data
        Cache::put('antrian_data', [
            'action' => 'update',
            'antrian' => $antrian->toArray(),
            'timestamp' => microtime(true)
        ], 60);

        return redirect()->route('admin.dashboard')->with('success', 'Antrian A-' . sprintf('%03d', $antrian->number) . ' ditandai terlambat.');
    }

    public function stream()
    {
        // Prevent PHP script timeout
        @set_time_limit(0);

        // Release session lock to prevent blocking concurrent requests in other tabs
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_write_close();
        }

        // Clear buffering for output
        if (function_exists('apache_setenv')) {
            @apache_setenv('no-gzip', 1);
        }
        @ini_set('zlib.output_compression', 0);
        @ini_set('implicit_flush', 1);
        
        return response()->stream(function () {
            $lastEventTime = microtime(true);
            $heartbeatInterval = 5;
            $lastHeartbeat = time();

            while (true) {
                if (connection_aborted()) {
                    break;
                }

                $event = Cache::get('antrian_data');
                if ($event && isset($event['timestamp']) && $event['timestamp'] > $lastEventTime) {
                    echo 'event: queue-update' . PHP_EOL;
                    echo 'data: ' . json_encode($event) . PHP_EOL;
                    echo PHP_EOL; // Double newline represents end of message
                    ob_flush();
                    flush();
                    $lastEventTime = $event['timestamp'];
                }

                // Periodic heartbeat comment to keep connection alive
                if (time() - $lastHeartbeat >= $heartbeatInterval) {
                    echo ": keep-alive ping" . PHP_EOL . PHP_EOL;
                    ob_flush();
                    flush();
                    $lastHeartbeat = time();
                }

                usleep(500000); // 0.5s check interval
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no',
        ]);
    }
}
