<?php

namespace App\Enums;

enum TaskStatusEnum : string
{
    use EnumHelpers;
    case NEW = "new";

    case IN_PROGRESS = "in_progress";

    case DONE = "done";
}
