<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTimelineFile extends Model
{
    use HasFactory;

    protected $table = 'project_timeline_files';
    protected $guarded = [];
}
