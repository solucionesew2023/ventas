<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

        protected $fillable = [
        'nombre',
        'slug'
            ];

            public function subcategories(){
                return $this->hasMany(Subcategy::class);
            }          

}
