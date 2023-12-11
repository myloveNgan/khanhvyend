<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account_Permision extends Model
{
    use HasFactory;
    protected $table = 'account_permision';
    protected $fillable = [
        'account_id',
        'per_id',
    ];
    public $timestamps = false;
}
