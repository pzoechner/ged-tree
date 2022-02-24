<?php

namespace Pzoechner\GedTree;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\LazyCollection;

class Tree
{
    protected LazyCollection $lineGroups;

    protected LazyCollection $individuals;

    protected LazyCollection $families;

    public function __construct(array $lines)
    {
        $this->lineGroups = $this->collectLineGroups($lines);

        $this->individuals = new LazyCollection();

        $this->families = new LazyCollection();
    }

    /**
     * @throws FileNotFoundException
     */
    public static function load(string $filePath): static
    {
        $file = file($filePath);

        if (! $file) {
            throw new FileNotFoundException();
        }

        return new static($file);
    }

    public function getIndividuals(): LazyCollection
    {
        if (! count($this->individuals)) {
            $this->individuals = $this->lineGroups
                ->filter(fn (LineGroup $lineGroup) => $lineGroup->isIndividual())
                ->map(fn (LineGroup $lineGroup) => Individual::parse($lineGroup))
                ->values();
        }

        return $this->individuals;
    }

    public function getFamilies(): LazyCollection
    {
        if (! count($this->families)) {
            $this->families = $this->lineGroups
                ->filter(fn (LineGroup $lineGroup) => $lineGroup->isFamily())
                ->map(fn (LineGroup $lineGroup) => Family::parse($lineGroup))
                ->values();
        }

        return $this->families;
    }

    private function collectLineGroups(array $lines): LazyCollection
    {
        return (new LazyCollection($lines))
            ->map(fn (string $line) => Line::parse($line))
            ->chunkWhile(fn (Line $value, $key, $chunk) => $value->level != 0)
            ->map(fn (LazyCollection $chunks) => new LineGroup($chunks->values()->all()))
            ->values();
    }
}
