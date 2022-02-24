<?php

namespace Pzoechner\GedTree;

class Line
{
    public function __construct(
        public int $level,
        public ?string $first,
        public ?string $second,
    ) {
        //
    }

    public static function parse(string $line): static
    {
        $level = (int) explode(' ', $line)[0];
        $first = trim(explode(' ', $line)[1]);
        $second = trim(implode(' ', array_slice(explode(' ', $line), 2)));

        return new static($level, $first, $second);
    }

    public function isHusband(): bool
    {
        return $this->first === RecordType::HUSB;
    }

    public function isWife(): bool
    {
        return $this->first === RecordType::WIFE;
    }

    public function isMarriage(): bool
    {
        return $this->first === RecordType::MARR;
    }

    public function isDate(): bool
    {
        return $this->first === RecordType::DATE;
    }
}
