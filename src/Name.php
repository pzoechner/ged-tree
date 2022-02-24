<?php

namespace Pzoechner\GedTree;

use Illuminate\Support\Collection;

class Name
{
    public function __construct(
        public ?string $first,
        public ?string $last,
        public ?string $married,
    ) {
        //
    }

    public static function parse(Collection $lines): static
    {
        $nameLines = $lines
            ->filter(fn (Collection $lineGroup) => $lineGroup->first()->first === RecordType::NAME)
            ->flatten();

        $first = $nameLines->filter(fn (Line $line) => $line->first === RecordType::GIVN)->first();
        $surname = $nameLines->filter(fn (Line $line) => $line->first === RecordType::SURN)->first();
        $married = $nameLines->filter(fn (Line $line) => $line->first === RecordType::MARR)->first();

        return new static($first?->second, $surname?->second, $married?->second);
    }
}
