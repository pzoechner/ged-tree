<?php

namespace Pzoechner\GedTree\Test;

use PHPUnit\Framework\TestCase;
use Pzoechner\GedTree\Tree;

class GedcomTest extends TestCase
{
    protected Tree $gedcom;

    protected function setUp(): void
    {
        $this->gedcom = Tree::load(
            __DIR__.'/stubs/555SAMPLE.GED'
        );
    }

    /** @test */
    public function it_parses_individuals()
    {
        $this->assertCount(3, $this->gedcom->getIndividuals());
    }
}
