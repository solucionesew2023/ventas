<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'subcategory_id'      
            ];

    public function subcategory(){
        return $this->belongsTo(Subcategory::class);
    }
    public function colors(){
        return $this->belongsToMany(Color::class)->withPivot('cantidad');
        
    }
   
}
