<?php
namespace App\Http\Controllers;

use App\Models\Departements;
use App\Models\MtIssue;
use Illuminate\Http\Request;

class PelaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Pastikan hanya pengguna yang sudah login yang dapat mengakses
    }

    public function index()
    {
        // Ambil role dari pengguna yang login
        $role = auth()->user()->role->mt_roles_name;

        // Cek apakah role Admin atau Mod
        if ($role == 'Admin') {
            // Admin bisa memilih semua departemen
            $departments = Departements::all();
        } elseif ($role == 'Mod') {
            // Mod hanya bisa memilih departemennya sendiri
            $departments = Departements::where('id', auth()->user()->mt_departements_id)->get();
        } else {
            // Jika User biasa, tampilkan error 403 Unauthorized
            return abort(403, 'Unauthorized action');
        }

        return view('pelaporan.index', compact('departments'));
    }

    public function download(Request $request)
    {
        // Validasi input
        $request->validate([
            'department_id' => 'required|exists:departements,id',  // Pastikan ada validasi untuk ID departemen
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
    
        // Ambil parameter dari form
        $departmentId = $request->input('department_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Ambil data laporan berdasarkan departemen dan tanggal
        $issues = MtIssue::where('department_id', $departmentId)  // Gunakan department_id yang benar
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
    
        // Jika tidak ada data
        if ($issues->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data untuk rentang waktu tersebut.');
        }
    
        // Generate CSV
        $fileName = 'report_' . now()->format('YmdHis') . '.csv';
        $filePath = storage_path('app/' . $fileName);
        $file = fopen($filePath, 'w');
        fputcsv($file, ['ID', 'Judul Thread', 'Deskripsi', 'Tanggal Dibuat', 'Departemen']);
        foreach ($issues as $issue) {
            fputcsv($file, [
                $issue->id,
                $issue->issue_title,
                $issue->issue_description,
                $issue->created_at->format('d M Y'),
                $issue->department->mt_departements_name,  // Pastikan relasi department benar
            ]);
        }
        fclose($file);
    
        // Return file untuk di-download
        return response()->download($filePath)->deleteFileAfterSend();
    }
    
}

