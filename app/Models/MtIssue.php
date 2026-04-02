<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtIssue extends Model
{
    use HasFactory;    protected $fillable = ['department_id', 'user_id', 'issue_title', 'issue_description','issue_image'];

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function comments()
    {
        return $this->hasMany(Comments::class, 'issue_id');
    }
    

    public function taggedUsers()
    {
        return $this->belongsToMany(User::class, 'mt_issue_user', 'issue_id', 'user_id');
    }
    public function departement()
    {
        return $this->belongsTo(Departements::class, 'mt_departements_id');
    }
    public function department()
    {
        return $this->belongsTo(Departements::class, 'department_id','id');
    }
    
}

