<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'requests';

    protected $fillable = [        
        'member_id',
        'request_type',
        'request_for_date',
        'checkin',
        'checkout',
        'reason',
        'status',
        'manager_confirmed_status',
        'admin_approved_status',
        'error_count',
    ];
}
