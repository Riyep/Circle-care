<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $primaryKey = 'id'; // Pastikan ini adalah kolom ID

    use HasFactory;
    protected $fillable = [
    'mt_username',
    'mt_departements_id',
    'mt_positions_id',
    'mt_useremail',
    'mt_userpass',
    'mt_role_id',
];

    public function comments()
{
    return $this->hasMany(Comments::class, 'user_id');
}

    public function role()
    {
    return $this->belongsTo(Roles::class, 'mt_role_id'); // Pastikan nama field foreign key benar
    }

    // Relasi ke Departements
    public function departement()
    {
        return $this->belongsTo(Departements::class, 'mt_departements_id');
    }
    // User.php
    public function department()
    {
        return $this->belongsTo(Departements::class, 'mt_departements_id', 'id');
    }
    public function getEmailForNotification()
    {
    return $this->mt_useremail;
    }


    // Relasi ke Positions
    public function position()
{
    return $this->belongsTo(Positions::class, 'mt_positions_id', 'id'); // Sesuaikan jika nama kolom berbeda
}

    public function getAuthIdentifierName()
    {
        return 'mt_useremail';
    }
    public function getAuthPassword()
    {
        return $this->mt_userpass;
    }
    
    public function issues()
    {
        return $this->belongsToMany(MtIssue::class, 'mt_issue_user', 'user_id', 'mt_issue_id');
    }
    
    public function taggedIssues()
    {
        return $this->belongsToMany(MtIssue::class, 'mt_issue_user', 'user_id', 'issue_id');
    }

}

