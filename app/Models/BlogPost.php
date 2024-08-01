<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'content', 'blog_category_id'];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class,'blog_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
