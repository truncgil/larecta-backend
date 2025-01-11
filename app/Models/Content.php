<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'slug',
        'status',
        'content',
        'meta',
    ];

    // Content modelinde type_id'yi dinamik olarak kullanmak
    public function type()
    {
        return $this->belongsTo(Type::class, 'type');
    }
}

