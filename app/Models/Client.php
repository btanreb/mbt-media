<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tax_no',
        'address',
        'country'
    ];

    /**
     * Get the comments for the blog post.
     */
    public function logos(): HasMany
    {
        return $this->hasMany(ClientLogo::class);
    }
}
