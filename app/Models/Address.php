<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'label',
        'first_name',
        'last_name',
        'phone',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fullName(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function fullAddress(): string
    {
        $parts = array_filter([
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->getCountryName()
        ]);

        return implode(', ', $parts);
    }

    private function getCountryName(): string
    {
        $countries = [
            'US' => 'United States',
            'CA' => 'Canada',
            'GB' => 'United Kingdom',
            'AU' => 'Australia',
        ];

        return $countries[$this->country] ?? $this->country;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($address) {
            if (!$address->user->addresses()->exists()) {
                $address->is_default = true;
            }

            if ($address->is_default) {
                $address->user->addresses()->update(['is_default' => false]);
            }
        });

        static::updating(function ($address) {
            if ($address->is_default && $address->isDirty('is_default')) {
                $address->user->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
            }
        });

        static::deleting(function ($address) {
            if ($address->is_default) {
                $nextDefault = $address->user->addresses()
                    ->where('id', '!=', $address->id)
                    ->first();

                if ($nextDefault) {
                    $nextDefault->update(['is_default' => true]);
                }
            }
        });
    }
}
