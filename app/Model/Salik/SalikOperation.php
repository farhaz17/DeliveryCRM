<?php

namespace App\Model\Salik;

use App\Model\BikeDetail;
use App\Model\Lpo\SalikTag;
use Illuminate\Database\Eloquent\Model;

class SalikOperation extends Model
{
    public function bike()
    {
        return $this->belongsTo(BikeDetail::class);
    }
    public function salik()
    {
        return $this->belongsTo(SalikTag::class);
    }
}
