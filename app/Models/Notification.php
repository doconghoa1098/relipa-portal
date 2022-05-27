<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    const DRAFT = 0;
    const PUBLISHED = 1;
    const SCHEDULED = 2;


    protected $table = 'notifications';

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
