<?php

namespace App\Http\Controllers;

use App\Models\Departements;
use App\Models\MtIssue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ThreadOpenedNotification;
use App\Mail\ThreadClosedNotification;

class MtIssueController extends Controller
{
    public function index()
    {
        $issues = MtIssue::with(['taggedUsers', 'department']) // Tambahkan relasi department
            ->where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan created_at (terbaru di atas)
             ->get();
        return view('mt_issues.index', compact('issues'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q'); // Ambil query dari parameter
        $users = User::where('mt_username', 'LIKE', "%{$query}%")
            ->select('id', 'mt_username') // Ambil ID dan username saja
            ->get();

        return response()->json($users); // Kembalikan hasil pencarian dalam format JSON
    }


    public function indexTag()
    {
        $userId = Auth::user()->id;

        $issues = MtIssue::whereHas('taggedUsers', function ($query) use ($userId) {
            $query->where('mt_issue_user.user_id', $userId);
             // Cocokkan user_id di tabel pivot
        })
        ->orderBy('created_at', 'desc') // Urutkan berdasarkan created_at (terbaru di atas)
        ->with(['taggedUsers'])->get();

        return view('mt_issues.indexTag', compact('issues'));
    }
    /**
     * Show form for creating a new issue.
     */

    public function create()
    {
        $users = User::all(); // Mengambil semua pengguna
        $departments = Departements::all(); // Mengambil semua departemen
        return view('mt_issues.create', compact('users', 'departments'));
    }
    public function show($id)
    {
        // Menampilkan detail issue berdasarkan ID
        $issue = MtIssue::findOrFail($id); // Mengambil data issue atau 404 jika tidak ditemukan

        return view('mt_issues.show', compact('issue')); // Mengirim data issue ke view
    }

    /**
     * Store a newly created issue in storage.
     */
public function store(Request $request)
{
    $request->validate([
        'issue_title' => 'required|string|max:100',
        'issue_description' => 'required|string',
        'department' => 'required',
        'issue_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $issue = MtIssue::create([
        'user_id' => Auth::user()->id,
        'issue_title' => $request->issue_title,
        'issue_description' => $request->issue_description,
        'department_id' => $request->department,
    ]);

    if ($request->hasFile('issue_image')) {
        $file = $request->file('issue_image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/issues'), $filename);
        $issue->issue_image = $filename;
        $issue->save();
    }

    $validUsers = [];
    if ($request->filled('tagged_users')) {
        $taggedUsers = explode(',', $request->input('tagged_users')[0]);
        $taggedUsers = array_map('intval', $taggedUsers);

        $validUsers = User::whereIn('id', $taggedUsers)->pluck('id')->toArray();

        if (!empty($validUsers)) {
            logger()->info('Valid user IDs for tagging (on open thread):', $validUsers);
            $issue->taggedUsers()->sync($validUsers);
        } else {
            logger()->error('No valid user IDs found in tagged_users (on open thread).');
        }
    }

    // ✅ Kirim email ke user yang membuat thread
    try {
        $emailPembuat = Auth::user()->getEmailForNotification();
        Mail::to($emailPembuat)->send(new ThreadOpenedNotification($issue));
        logger('✅ Email berhasil dikirim ke pembuat thread: ' . $emailPembuat);
    } catch (\Exception $e) {
        logger('❌ Gagal kirim email ke pembuat thread: ' . $emailPembuat . ' | Error: ' . $e->getMessage());
    }

    // ✅ Kirim email ke user yang ditag
    if (!empty($validUsers)) {
        $taggedUserEmails = User::whereIn('id', $validUsers)->pluck('mt_useremail')->toArray();

        foreach ($taggedUserEmails as $email) {
            try {
                Mail::to($email)->send(new ThreadOpenedNotification($issue));
                logger('✅ Email berhasil dikirim ke tagged user: ' . $email);
            } catch (\Exception $e) {
                logger('❌ Gagal kirim email ke tagged user: ' . $email . ' | Error: ' . $e->getMessage());
            }
        }
    }

    return redirect()->route('mt_issues.index')
        ->with('success', 'Thread berhasil dibuat!');
}
    public function edit(MtIssue $issue)
    {

        // Kirim data issue dan departemen ke view
        $user = auth()->user()->load('role', 'department');

        if (auth()->user()->role->mt_roles_name !== 'Admin') {
            abort(403, 'Unauthorized action');
        }

        $users = User::all(); // Anda bisa menyesuaikan query ini sesuai kebutuhan
        $departments = Departements::all();

        // Kirim data issue, departemen, dan users ke view
        return view('mt_issues.edit', compact('issue', 'departments', 'users'));
    }

    public function destroy($id)
    {
        $issue = MtIssue::findOrFail($id);
        
        if (auth()->user()->id !== $issue->user_id && auth()->user()->role->mt_roles_name !== 'Admin') {
            return redirect()->route('mt_issues.index')
                ->with('error', 'You do not have permission to delete this thread.');
        }
    
        $issue->delete();
    
        return redirect()->route('mt_issues.index')
            ->with('success', 'Thread berhasil dihapus.');
    }
    public function close($id)
{
    $issue = MtIssue::findOrFail($id);
    $user = auth()->user();

    $canClose = $user->role->mt_roles_name === 'Admin' ||
                ($user->role->mt_roles_name === 'Mod' && $user->department_id === $issue->department_id) ||
                ($user->id === $issue->user_id);

    if (!$canClose) {
        abort(403, 'Anda tidak memiliki izin untuk menutup thread ini.');
    }

    $issue->status = 'closed';
    $issue->save();

    // Kirim email ke pembuat thread
    $emailPembuat = $user->getEmailForNotification();
    try {
        Mail::to($emailPembuat)->send(new ThreadClosedNotification($issue));
        logger('✅ Email berhasil dikirim ke pembuat thread: ' . $emailPembuat);
    } catch (\Exception $e) {
        logger('❌ Email gagal dikirim ke pembuat thread: ' . $emailPembuat . ' | Error: ' . $e->getMessage());
    }

    // Kirim email ke user yang ditag (ambil dari relasi)
    $taggedUserIds = $issue->taggedUsers->pluck('id')->toArray();

    if (!empty($taggedUserIds)) {
        $taggedUserEmails = User::whereIn('id', $taggedUserIds)->pluck('mt_useremail')->toArray();

        foreach ($taggedUserEmails as $email) {
            try {
                Mail::to($email)->send(new ThreadClosedNotification($issue));
                logger('✅ Email berhasil dikirim ke tagged user: ' . $email);
            } catch (\Exception $e) {
                logger('❌ Email gagal dikirim ke tagged user: ' . $email . ' | Error: ' . $e->getMessage());
            }
        }
    }

    return redirect()->back()->with('success', 'Thread berhasil ditutup.');
}





    /**
     * Show the form for editing an issue.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'issue_title' => 'required|string|max:255',
            'issue_description' => 'required|string',
            'department_id' => 'required', 
            'tagged_users' => 'nullable|array',
            'tagged_users.*' => 'exists:users,id', 
        ]);

        $issue = MtIssue::findOrFail($id);

        $issue->update([
            'issue_title' => $request->issue_title,
            'issue_description' => $request->issue_description,
            'department_id' => $request->department_id,
        ]);

        // Perbarui relasi tagging jika ada
        if ($request->has('tagged_users') && !empty($request->tagged_users)) {
            $validatedTaggedUsers = array_map('intval', $request->tagged_users); // Pastikan semua elemen adalah integer
            $issue->taggedUsers()->sync($validatedTaggedUsers);
        } else {
            $issue->taggedUsers()->detach(); 
        }
        // if ($request->filled('tagged_users')) {
        //     $taggedUsers = explode(',', $request->input('tagged_users')); // Pecah string menjadi array
        //     $issue->taggedUsers()->sync($taggedUsers); // Perbarui relasi tagging
        // }

        if (auth()->user()->role->mt_roles_name !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'issue_title' => 'required|string|max:255',
            'issue_description' => 'required|string',
        ]);

        $issue->update([
            'issue_title' => $request->issue_title,
            'issue_description' => $request->issue_description,
        ]);
    
        if ($request->has('tagged_users')) {
            $issue->taggedUsers()->sync($request->input('tagged_users'));
        } else {
            $issue->taggedUsers()->sync([]); 
        }

        return redirect()->route('issues.show', $issue->id)
            ->with('success', 'Issue updated successfully.');
    }

}
