<?php

namespace App\Enums\Gensen;

enum JobStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case DONE = 'done';
    case FAILED = 'failed';
}
