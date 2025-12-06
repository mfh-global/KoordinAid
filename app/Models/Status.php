<?php

namespace App\Models;

enum Status: string {
    case New = 'new';
    case InProgress = 'in_progress';
    case Closed = 'closed';

    public static function getValues()
    {
        $attributes = [];
        foreach (Status::cases() as $state)
        {
            $attributes[] = $state->value;
        }
        return $attributes;
    }
}
