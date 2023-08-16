<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogOption extends Model
{
    use HasFactory;
    protected $table = 'blogoption';
    protected $fillable = ['blogid','blogoption','voting'];
}
