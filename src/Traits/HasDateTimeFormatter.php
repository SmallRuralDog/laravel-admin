<?php

namespace SmallRuralDog\Admin\Traits;

use Carbon\Carbon;
use DateTimeInterface;

trait HasDateTimeFormatter
{
    protected function serializeDate(DateTimeInterface $date)
    {
        return Carbon::parse($date)
            ->format($this->getDateFormat());
    }
}
