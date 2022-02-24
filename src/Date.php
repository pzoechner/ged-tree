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
        $linesArray = $lines->values()->all();

        return new static(
            type: $linesArray[0] ? trim($linesArray[0]->first) : null,
            date: $linesArray[1] ? trim($linesArray[1]->second) : null,
        );
    }
}
