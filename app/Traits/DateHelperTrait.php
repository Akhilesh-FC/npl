<?php

namespace App\Traits;

use Carbon\Carbon;

trait DateHelperTrait
{
      public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s');
    }
}
