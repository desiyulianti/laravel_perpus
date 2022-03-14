<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'class';
    public $timestamps = true;

    protected $fillable = ['class_name', 'group'];
}