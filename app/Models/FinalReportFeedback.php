<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinalReportFeedback extends Model
{
    /** @use HasFactory<\Database\Factories\FinalReportFeedbackFactory> */
    use HasFactory;

    protected $table = 'final_report_feedbacks';

    protected $fillable = [
        'final_report_id',
        'mentor_id',
        'feedback',
    ];

    public function finalReport(): BelongsTo
    {
        return $this->belongsTo(FinalReport::class);
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }
}