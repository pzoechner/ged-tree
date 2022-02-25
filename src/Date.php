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
        $date = $lines->filter(fn (Line $line) => $line->first === RecordType::DATE)->first();
        $type = $lines->first();

        return new static($date?->second, $type?->first);
    }
}
