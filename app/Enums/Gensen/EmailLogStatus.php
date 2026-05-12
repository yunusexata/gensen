<?php

namespace App\Enums\Gensen;

enum EmailLogStatus: string
{
    case PENDING = 'pending';
    case SENDING = 'sending';
    case SENT = 'sent';
    case FAILED = 'failed';
}
