<?php
namespace App\Http\Controllers;

use App\Models\Departements;
use Illuminate\Http\Request;
use App\Models\MtIssue;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Menangani pencarian berdasarkan judul thread
        $search = $request->input('search');
        
        // Ambil semua departemen dengan issues-nya, dan jika ada pencarian, filter berdasarkan judul
        $departments = Departements::with(['issues' => function ($query) use ($search) {
            if ($search) {
                $query->where('issue_title', 'like', '%' . $search . '%');
            }
        }])->get();

        // Hitung jumlah total thread setelah filter pencarian
        $countIssue = MtIssue::when($search, function ($query) use ($search) {
            return $query->where('issue_title', 'like', '%' . $search . '%');
        })->count();

        return view('dashboard.index', compact('departments', 'countIssue', 'search'));
    }

}