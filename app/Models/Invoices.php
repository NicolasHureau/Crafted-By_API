<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Invoices extends Model
{
    use HasFactory, HasUuids;

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function status(): BelongsToMany
    {
        return $this->belongsToMany(Status::class)
            ->withTimestamps();
    }

    public function product(): BelongsToMany
    {
        return $this->belongsToMany(Products::class)
            ->withPivotValue('quantity');
    }
}
