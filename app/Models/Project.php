<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function productFile(){
        return $this->hasMany(ProjectFile::class, 'project_id');
    }

    public function getClient()
    {
        return $this->hasOne(Client::class, 'id','client_id');
    }

    public function getUser(){
        return $this->hasOne(Admin::class, 'id', 'assigned_team_members');
    }
}
