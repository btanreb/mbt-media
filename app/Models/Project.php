<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'client_id',
        'client_logo_id',
        'deadline',
        'description',
    ];

    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }

    public function logo()
    {
        return $this->hasOne(ClientLogo::class, 'id', 'client_logo_id');
    }
}
