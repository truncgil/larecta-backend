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
        'parent_id',
        'level',
        'order',
    ];

    public function parent()
    {
        return $this->belongsTo(Content::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Content::class, 'parent_id');
    }

    public function getBreadcrumb()
    {
        $breadcrumb = collect();
        $current = $this;

        while ($current !== null) {
            $breadcrumb->prepend($current);
            $current = $current->parent;
        }

        return $breadcrumb;
    }

    public function getBreadcrumbArray()
    {
        $breadcrumb = collect();
        $current = $this;

        while ($current !== null) {
            $breadcrumb->prepend([
                'id' => $current->id,
                'title' => $current->title,
                'slug' => $current->slug,
                'level' => $current->level
            ]);
            $current = $current->parent;
        }

        return $breadcrumb->toArray();
    }

    // Content modelinde type_id'yi dinamik olarak kullanmak
    public function type()
    {
        return $this->belongsTo(Type::class, 'type');
    }
}

