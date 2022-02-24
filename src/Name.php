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

        if ((! $first || ! strlen($first->second)) && (! $surname || ! strlen($surname->second))) {
            preg_match('/\/(.+)\//', $nameLines->first()->second, $matches);
            $firstNames = str_replace($matches[0], '', $nameLines->first()->second);

            return new static($firstNames, $matches[1], null);
        }

        return new static($first?->second, $surname?->second, $married?->second);
    }
}
