<?php

namespace Pzoechner\GedTree;

use Illuminate\Support\Collection;

class Individual
{
    public function __construct(
        public string $id,
        public Name $name,
        public ?string $gender,
        public array $dates,
    ) {
        //
    }

    public static function parse(LineGroup $lineGroup): static
    {
        $items = collect($lineGroup->lines)
            ->chunkWhile(fn (Line $value, $key, $chunk) => $value->level != 1)
            ->map(fn (Collection $lines) => $lines->values());

        return new static(
            id: self::parseId($items->first()[0]),
            name: self::parseName($items),
            gender: self::parseGender($items),
            dates: self::parseDates($items),
        );
    }

    private static function parseId(Line $line): string
    {
        return trim($line->first);
    }

    private static function parseName(Collection $items): Name
    {
        return  Name::parse($items);
    }

    private static function parseGender(Collection $items): ?string
    {
        $genderLine = $items
            ->filter(fn ($chunk) => count($chunk) && $chunk[0]->first === RecordType::SEX)
            ->flatten()->first();

        return $genderLine?->second;
    }

    private static function parseDates(Collection $items): array
    {
        $datesLines = $items->filter(function (Collection $lines) {
            $firstLine = $lines->first();

            $isBirthEvent = $firstLine->first === RecordType::BIRT;
            $isDeathEvent = $firstLine->first === RecordType::DEAT;

            return $isBirthEvent || $isDeathEvent;
        });

        return $datesLines->map(fn (Collection $dateLines) => Date::parse($dateLines))
            ->values()
            ->all();
    }
}
