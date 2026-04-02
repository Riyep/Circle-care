<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MTIssueUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'mt_issue_id',
        'user_id'
    ];
}
