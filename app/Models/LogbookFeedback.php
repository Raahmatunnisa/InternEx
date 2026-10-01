<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogbookFeedback extends Model
{
    /** @use HasFactory<\Database\Factories\LogbookFeedbackFactory> */
    use HasFactory;

    protected $table = 'logbook_feedbacks';

    protected $fillable = [
        'logbook_id',
        'mentor_id',
        'feedback',
    ];

    public function logbook(): BelongsTo
    {
        return $this->belongsTo(Logbook::class);
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }
}