<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveQuota extends Model
{
    use HasFactory;

    protected $table = "leave_quotas";


    protected $fillable = [
        'member_id',
        'year',
        'paid_leave',
        'unpaid_leave',
        'remain'
    ];
}
