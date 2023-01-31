<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Url extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'destination', 'slug', 'views', 'enforce_https', 'enable_tracking', 'last_visited_at'
    ];

    protected $appends = [
        'shortened_url'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'enforce_https' => 'boolean',
        'enable_tracking' => 'boolean',
        'views' => 'integer',
        'last_visited_at' => 'timestamp'
    ];

    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function shortenedUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => route('short-url.show', $this),
        );
    }

    public function trackers()
    {
        return $this->hasMany(Tracker::class);
    }
}
