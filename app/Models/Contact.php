<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    // Supaya kolom ini boleh diisi data
    protected $fillable = [
        'name',
        'email',
        'message',
    ];
}