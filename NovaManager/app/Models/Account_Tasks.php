<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account_Tasks extends Model
{
    use HasFactory;
    protected $table = 'account_tasks';
    protected $fillable = [
        'account_id',
        'task_id',
    ];
    public $timestamps = false;
}
