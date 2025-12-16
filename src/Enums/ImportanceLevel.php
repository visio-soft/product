<?php

namespace Visio\Product\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ImportanceLevel: string implements HasLabel, HasColor
{
    case NOT_IMPORTANT = 'not_important';
    case NICE_TO_HAVE = 'nice_to_have';
    case IMPORTANT = 'important';
    case CRITICAL = 'critical';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::NOT_IMPORTANT => 'Not important',
            self::NICE_TO_HAVE => 'Nice-to-have',
            self::IMPORTANT => 'Important',
            self::CRITICAL => 'Critical',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::NOT_IMPORTANT => 'gray',
            self::NICE_TO_HAVE => 'info',
            self::IMPORTANT => 'warning',
            self::CRITICAL => 'danger',
        };
    }
}
