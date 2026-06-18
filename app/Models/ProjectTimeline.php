<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTimeline extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function projectTimelineFile(){
        return $this->hasMany(ProjectTimelineFile::class, 'project_timeline_id');
    }


}
