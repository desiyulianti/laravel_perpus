<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBookBorrow extends Model
{
    protected $table = 'detail_book_borrow';
    protected $primarykey = 'id';
    public $timestamps = false;
    protected $fillable = ['book_borrow_id', 'book_id', 'qty'];

    use HasFactory;
}
