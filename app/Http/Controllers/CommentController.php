<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;
use App\Models\MtIssue;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $issueId)
    {
        Comments::create([
            'issue_id' => $issueId,
            'user_id' => Auth::user()->id,
            'content' => $request->input('content'),
        ]);
        
    
        return redirect()->back()->with('success', 'Komentar berhasil disimpan!');
    }
    
}
