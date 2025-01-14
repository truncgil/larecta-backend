<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class TypeMeta extends Model
{
    use HasFactory;

    protected $fillable = ['type_id', 'name', 'field_type', 'order'];

    public function type()
    {   
        return $this->belongsTo(Type::class);
    }

    /**
     * Route model binding için anahtar tanımı
     * Bu, URL'den gelen parametrelerin doğru şekilde eşleşmesini sağlar
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

}
