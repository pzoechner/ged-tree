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

    public static function parse(Collection $individualLines): static
    {
        $nameLines = self::getNameLines($individualLines);

        $first = $nameLines->filter(fn (Line $line) => $line->first === RecordType::GIVN)->first();

        $surname = $nameLines->filter(fn (Line $line) => $line->first === RecordType::SURN)->first();

        $married = $nameLines->filter(fn (Line $line) => $line->first === RecordType::MARR)->first();

        $isDetailLinesNotHavingEnoughInformation = (! $first || ! strlen($first->second)) && (! $surname || ! strlen($surname->second));

        if ($isDetailLinesNotHavingEnoughInformation) {
            return self::parseNameFromTopLine($nameLines);
        }

        return new static($first?->second, $surname?->second, $married?->second);
    }

    private static function getNameLines(Collection $individualLines): Collection
    {
        return $individualLines
            ->filter(fn (Collection $lineGroup) => $lineGroup->first()->first === RecordType::NAME)
            ->flatten();
    }

    private static function parseNameFromTopLine(Collection $nameLines): static
    {
        $firstName = $nameLines->first()?->second;

        if ($firstName) {
            preg_match('/\/(.+)\//', $firstName, $matches);
            $isLastNameFound = is_array($matches) && count($matches) >= 2;
            $lastNameMatch = $isLastNameFound ? $matches[0] : null;

            if ($lastNameMatch) {
                $firstName = trim(str_replace($lastNameMatch, '', $nameLines->first()->second));
                $lastName = trim($matches[1]);

                return new static($firstName, $lastName, null);
            }

            return new static($firstName, null, null);
        }

        return new static($firstName, null, null);
    }
}
