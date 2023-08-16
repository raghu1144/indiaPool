<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogmodel extends Model
{
    use HasFactory;
    protected $table = 'blog';
    protected $fillable = ['blogid','hastag','blogTitle','blogDescription','blogImage','blogQuestion'];
}
