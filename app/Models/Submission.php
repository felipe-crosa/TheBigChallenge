<?php

namespace App\Models;

use App\Scopes\ListSubmissionsScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function scopeFilter($query, array $filters)
    {
        $query->when(
            $filters['status'] ?? false,
            function ($query, $status) {
                if ($status == 'pending') {
                    $query->whereNull('doctor_id');
                } elseif ($status == 'in-review') {
                    $query->whereNotNull('doctor_id')->whereNull('diagnosis');
                } elseif ($status == 'resolved') {
                    $query->whereNotNull('diagnosis');
                }
            }
        );

        $query->when(
            $filters['search'] ?? false,
            fn ($query, $search) => $query->where('symptoms', 'LIKE', '%'.$search.'%')
        );
    }

    protected function status(): Attribute
    {
        $status = 'pending';
        if ($this->doctor_id) {
            $status = 'in-review';
        }
        if ($this->diagnosis) {
            $status = 'resolved';
        }

        return Attribute::make(
            get: fn () => $status,
        );
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
