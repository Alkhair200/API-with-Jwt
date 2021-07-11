<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = "posts";
    protected $fillable = ['name_ar' , 'name_en'];


    public function scopeSelector($query){

        return $query->select('id' , 'name_' .app()->getlocale())->get();
    }
}
