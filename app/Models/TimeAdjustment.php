<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeAdjustment extends Model
{
    use HasFactory;
    
    public function adjustmentDetails()
    {
        return $this->hasMany(TimeAdjustmentDetail::class, 'time_adj_id');
    }


}
