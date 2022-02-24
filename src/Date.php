<?php

namespace Pzoechner\GedTree;

use Illuminate\Support\Collection;

class Date
{
    public function __construct(
        public ?string $date,
        public ?string $type,
    ) {
        //
    }

    public static function parse(Collection $lines): static
    {
        return new static(
            type: $lines->values()->get(0) ? trim($lines->values()->get(0)->first) : null,
            date: $lines->values()->get(1) ? trim($lines->values()->get(1)->second) : null,
        );
    }
}
