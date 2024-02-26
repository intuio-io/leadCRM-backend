<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }

    public function buyers()
    {
        return $this->hasMany(Buyer::class);
    }

    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    public function filters()
    {
        return $this->hasMany(Filter::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}