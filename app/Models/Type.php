<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'icon', 'order', 'status',];

    public function metas()
    {
        return $this->hasMany(TypeMeta::class);
    }

    
}
