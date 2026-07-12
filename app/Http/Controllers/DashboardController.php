<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\SystemLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = [];
        
        if($user->role === 'user') {
            // total pengaduan yang dilakukan oleh user
            $data['total_complaints'] = Complaint::where('user_id', $user->id)->count();
            // total pengaduan aktif
            $data['active_complaints'] = Complaint::where('user_id', $user->id)->whereIn('status', ['menunggu', 'diproses'])->count();
            // pengambilan data 5 terbaru berdasarkan tanggal pembuatan laporan
            $data['latest_complaints'] = Complaint::where('user_id', $user->id)->latest()->take(5)->get(['id', 'title', 'status', 'created_at']);
        } elseif ($user->role === 'teknisi') {
            // jumlah tugas yang diserahkan kepada teknisi
            $data['total_assigned'] = Complaint::where('assigned_to', $user->id)->where('assigned_to', $user->id)->count();
            // jumlah yang sudah dilesaikan
            $data['in_progress'] = Complaint::where('assigned_to', $user->id)->where('status', 'selesai')->count();
            // pengambilan tugas terbaru teratas
            $data['in_progress'] = Complaint::where('assigned_to', $user->id)->where('assigned_to', $user->id)->where('status', 'diproses')->latest()->take(5)->get(['id', 'title', 'status', 'created_at']);

        } elseif ($user->role === 'admin') {
            // total semua pengaduan
            $data['total_complaints'] = Complaint::count();
            // jumlah per status bosss;
            $data['menunggu'] = Complaint::where('status', 'menunggu')->count();
            $data['diproses'] = Complaint::where('status', 'diproses')->count();
            $data['selesai'] = Complaint::where('status', 'selesai')->count();
            $data['ditolak'] = Complaint::where('status', 'ditolak')->count();

            // jumlah teknisi
            $data['total_technicians'] = User::where('role', 'teknisi')->count();

            // pengaduan data terbaru

            $data['latest_complaints'] = Complaint::with('user')->latest()->take(5)->get(['id', 'title', 'status', 'user_id', 'created_at']);

        } elseif ($user->role === 'dev') {
            // total semua pengaduan
            $data['total_complaints'] = Complaint::count();
            // jumlah per status bosss;
            $data['menunggu'] = Complaint::where('status', 'menunggu')->count();
            $data['diproses'] = Complaint::where('status', 'diproses')->count();
            $data['selesai'] = Complaint::where('status', 'selesai')->count();
            $data['ditolak'] = Complaint::where('status', 'ditolak')->count();

            $data['total_errors'] = SystemLog::where('is_error', true)->count();

            $data['latest_complaints'] = Complaint::with('user')->latest()->take(5)->get(['id', 'title', 'status', 'user_id', 'created_at']);
        }
        return view('dashboard', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort(404);
    }
}
