<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account_Role extends Model
{
    use HasFactory;
    protected $table = 'account_role';
    protected $fillable = [
        'account_id',
        'role_id',
    ];
    public $timestamps = false;
}
