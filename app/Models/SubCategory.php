<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'subcategory_name',
        'slug',
        'parent_category',
        'ordering',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id', 'id');
    }

    public function parentcategory()
    {
        return $this->belongsTo(Category::class, 'parent_category', 'id');
    }
}
