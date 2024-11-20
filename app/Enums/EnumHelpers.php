<?php

namespace App\Enums;

use Illuminate\Support\Str;

trait EnumHelpers
{
    public static function options()
    {
        return array_map(
            fn ($value) => [
                'label' => Str::of($value->value)->replace('-', ' ')->replace('_', ' ')->title()->value(),
                'value' => $value->value,
            ],
            self::cases()
        );
    }

    public static function values()
    {
        return array_map(
            fn ($value) => $value->value,
            self::cases()
        );
    }

    public static function random()
    {
        return self::cases()[array_rand(self::cases())];
    }

    public function equals($value): bool
    {
        return $this->value === $value;
    }

    public function prettifyName()
    {
        return Str::of($this->value)->replace('-', ' ')->replace('_', ' ')->title()->value();
    }

    public function key()
    {
        return Str::of($this->name)->replace('-', '_')->lower()->replace('vehicle_', '')->value();
    }

    public function getLabel(): ?string
    {
        return $this->prettifyName();
    }
}
