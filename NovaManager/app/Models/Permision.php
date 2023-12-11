<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permision extends Model
{
    use HasFactory;
    protected $table = 'permision';
    protected $primaryKey = 'per_id';
    public $timestamps = false;
}
