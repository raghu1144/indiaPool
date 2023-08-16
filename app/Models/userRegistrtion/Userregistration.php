<?php

namespace App\Models\userRegistrtion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userregistration extends Model
{
    use HasFactory;
    protected $table = "userregistration";
    protected $fillable = ['name','userid','mobile','email','address','otp','password'];
}
