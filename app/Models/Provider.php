<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable=[
        'city_id',
        'name',
        'nit',
        'email',
        'phone',
        'address',
        'name_contact',
    ];

    public function products(){
        //relacion muchos a muchos productos proveedores
        return $this->belongsToMany(Product::class)->withPivot(
                                                        'quantity',
                                                        'purchase_price',
                                                        'subtotal',
                                                        'color',
                                                        'size');
        
    }

    public function city(){
        return $this->belongsTo(City::class);
    }
}
