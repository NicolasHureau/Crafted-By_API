<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Business extends Model
{
    use HasFactory, HasUuids;

//    protected $keyType = 'string';
//    public $incrementing = false;
//
//    public static function booted(): void
//    {
//        static::creating(function($model) {
//            $model->id = Str::uuid();
//        });
//    }

    protected $fillable = [
        'name',
        'description',
        'history',
        'email',
        'address',
        'logo',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Owner(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_id');
    }

    public function speciality(): BelongsToMany
    {
        return $this->belongsToMany(Speciality::class);
    }

    public function zip_code(): BelongsTo
    {
        return $this->belongsTo(Zip_code::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

}
