<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeAdjustmentDetail extends Model
{
    use HasFactory;

    public function timeAdjustment()
    {
        return $this->belongsTo(TimeAdjustment::class);
    }

}
