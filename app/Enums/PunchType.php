<?php

namespace App\Enums;

enum PunchType: string
{
    case TIME_IN = 'time-punch.time_in';
    case LUNCH_OUT = 'time-punch.lunch_out';
    case LUNCH_IN = 'time-punch.lunch_in';
    case TIME_OUT = 'time-punch.time_out';

    public function action(): string {
        return match ($this) {
            self::TIME_IN => 'time_in',
            self::LUNCH_OUT => 'lunch_out',
            self::LUNCH_IN => 'lunch_in',
            self::TIME_OUT => 'time_out'
        };
    }

    public static function checkPunchType($punchType): string {
        $punch = self::tryFrom($punchType);

        return $punch->action();
    }
}
