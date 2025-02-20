<?php

namespace App\Enums;

enum TaskStatusEnum: string
{
    use EnumHelpers;

    case PENDING = "pending";
    case COMPLETED = 'completed';
}
