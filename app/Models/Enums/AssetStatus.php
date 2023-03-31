<?php

namespace App\Models\Enums;

enum AssetStatus: string
{
    case Temporary = 'temporary';
    case Customer = 'customer';
}