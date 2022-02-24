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
            $firstName = $nameLines->first()->second;

            preg_match('/\/(.+)\//', $nameLines->first()->second, $matches);
            $lastNameMatch = $matches[0];

            if ($lastNameMatch) {
                $firstName = str_replace($lastNameMatch, '', $nameLines->first()->second);
            }

            return new static(trim($firstName), trim($matches[1]), null);
        }

        return new static($first?->second, $surname?->second, $married?->second);
    }
}
