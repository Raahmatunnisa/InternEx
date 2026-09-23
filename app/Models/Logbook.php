<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Logbook extends Model
{
    /** @use HasFactory<\Database\Factories\LogbookFactory> */
    use HasFactory;

    protected $fillable = [
        'internship_id',
        'date',
        'start_time',
        'end_time',
        'activity',
        'description',
        'output',
        'obstacle',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
        ];
    }

    public function internship(): BelongsTo
    {
        return $this->belongsTo(Internship::class);
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(LogbookFeedback::class);
    }

    public function latestFeedback(): HasMany
    {
        return $this->feedbacks()->latest();
    }
}
