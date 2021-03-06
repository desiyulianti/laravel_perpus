<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $table = 'students'; //$table menyimpan informasi nama tabel customers
    //save customer table name information
    public $timestamps = true;

    protected $fillable = ['student_name', 'date_of_birth', 'gender', 'address', 'class_id'];
}