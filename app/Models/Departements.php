<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departements extends Model
{
    use HasFactory;
    protected $table = 'departements';
    protected $fillable = [
        'mt_departements_name'
       
    ];

    public function issues()
    {
        return $this->hasMany(MtIssue::class, 'department_id', 'id');
    }
}

