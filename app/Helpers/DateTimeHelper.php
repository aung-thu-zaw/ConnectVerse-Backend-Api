<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateTimeHelper
{
    public static function formatLastActiveTime(?string $createdAt): ?string
    {
        if ($createdAt === null) {
            return null;
        }

        $createdAt = Carbon::parse($createdAt);

        if ($createdAt->isToday()) {

            return $createdAt->format('h:i A');
        } elseif ($createdAt->isCurrentWeek()) {

            return $createdAt->format('D');
        } else {

            return $createdAt->format('m/d/Y');
        }
    }

}
