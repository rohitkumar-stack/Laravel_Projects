<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class curd extends Model
{
    use HasFactory;
    protected $table = 'curds';
    protected $fillable = ['title', 'post', 'description'];
}
