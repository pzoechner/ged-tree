<?php

namespace Pzoechner\GedTree;

use Illuminate\Support\Collection;

class Family
{
    public function __construct(
        public string $id,
        public array $pointers,
    ) {
        //
    }

    public static function parse(LineGroup $lineGroup): static
    {
        $items = collect($lineGroup->lines)
            ->chunkWhile(fn ($value, $key, $chunk) => $value->level != 1);

        return new static(
            id: self::parseId($items->first()->flatten()->first()),
            pointers: self::parsePointers($items),
        );
    }

    public static function parseId(Line $line): string
    {
        return $line->first;
    }

    public static function parsePointers(Collection $lineChunks): array
    {
        return $lineChunks
            ->filter(fn (Collection $lines) => $lines->count())
            ->filter(fn (Collection $lines) => $lines->first()->isHusband() || $lines->first()->isWife())
            ->flatten()
            ->map(fn (Line $line) => $line->second)
            ->all();
    }
}
