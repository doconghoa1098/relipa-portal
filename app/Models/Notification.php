<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notifications';

    protected $dates = ['published_date'];

    protected $fillable = [
        'published_date',
        'subject',
        'message',
        'status',
        'attachment',
        'published_to',
        'created_by',
    ];
}
