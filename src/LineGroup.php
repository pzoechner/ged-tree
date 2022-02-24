<?php

namespace Pzoechner\GedTree;

class LineGroup
{
    public function __construct(
        public array $lines,
    ) {
        //
    }

    public function isIndividual(): bool
    {
        return $this->lines[0]->second === RecordType::INDI;
    }

    public function isFamily(): bool
    {
        return $this->lines[0]->second === RecordType::FAM;
    }
}
