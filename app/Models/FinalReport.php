<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinalReport extends Model
{
    /** @use HasFactory<\Database\Factories\FinalReportFactory> */
    use HasFactory;

    protected $fillable = [
        'internship_id',
        'title',
        'abstract',
        'file_path',
        'status',
    ];

    public function internship(): BelongsTo
    {
        return $this->belongsTo(Internship::class);
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(FinalReportFeedback::class);
    }
}
