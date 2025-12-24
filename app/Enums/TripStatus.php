<?php

namespace App\Enums;

enum TripStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Assigned = 'assigned';
    case Accepted = 'accepted';
    case Started = 'started';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case Delayed = 'delayed';
}


