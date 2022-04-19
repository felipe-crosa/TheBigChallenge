<?php

namespace App\Models;

use App\Scopes\ListSubmissionsScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submission extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::addGlobalScope(new ListSubmissionsScope());
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id', 'id');
    }
}
