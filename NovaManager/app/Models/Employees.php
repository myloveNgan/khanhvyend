<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;
    protected $table = 'employees';
    protected $primaryKey = 'account_id';
    protected $fillable = [
        'name',
        'email',
        'date',
        'phone',
        'gender',
        'images',
        'account_id',
        'EmploymentStatus',
        'StartDate',
    ];

    public $timestamps = false;
}
