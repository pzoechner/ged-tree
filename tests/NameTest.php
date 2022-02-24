<?php

namespace Pzoechner\GedTree\Test;

use PHPUnit\Framework\TestCase;
use Pzoechner\GedTree\Individual;
use Pzoechner\GedTree\Tree;

class NameTest extends TestCase
{
    protected Tree $gedcom;

    /**
     * @test
     * @dataProvider individuals
     */
    public function it_parses_name_from_individual(Individual $individual, $first, $last, $married)
    {
        $this->assertEquals($first, $individual->name->first);
        $this->assertEquals($last, $individual->name->last);
        $this->assertEquals($married, $individual->name->married);
    }

    private function individuals(): array
    {
        $gedcom = Tree::load(
            __DIR__.'/stubs/555SAMPLE.GED'
        );

        $individuals = $gedcom->getIndividuals();

        return [
            [$individuals->get(0), 'Robert Eugene', 'Williams', null],
            [$individuals->get(1), 'Mary Ann', 'Wilson', null],
            [$individuals->get(2), 'Joe', 'Williams', null],
        ];
    }
}
