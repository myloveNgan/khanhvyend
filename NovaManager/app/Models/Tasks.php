<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;
    protected $table = 'tasks';
    protected $primaryKey = 'task_id';
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'priority',
        'assigned_by',
        'status',
        'estimated_completion_time',
        'notes',
        'paths',
        'files',
    ];
    public $timestamps = false;
}
