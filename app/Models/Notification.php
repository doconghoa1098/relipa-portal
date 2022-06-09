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

    public function authorInfo()
    {
        return $this->belongsTo(Member::class, 'created_by');
    }

    public function getPublishedToAttribute()
    {
        if ($this->attributes['published_to'] !== '["all"]') {
            $publishedTo = json_decode($this->attributes['published_to']);

            return Division::select('division_name')->whereIn('id', $publishedTo)->get();
        }

        return $this->attributes['published_to'];
    }
}
