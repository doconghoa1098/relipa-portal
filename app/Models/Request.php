<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'requests';

    protected $dates = ['checkin', 'checkout'];

    protected $fillable = [
        'member_id',
        'request_type',
        'request_for_date',
        'request_ot_time',
        'checkin',
        'checkout',
        'error_count',
        'reason',
        'status',
    ];
}
