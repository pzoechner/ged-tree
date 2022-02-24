<?php

namespace Pzoechner\GedTree\Test;

use PHPUnit\Framework\TestCase;
use Pzoechner\GedTree\Tree;

class FamilyTest extends TestCase
{
    protected Tree $gedcom;

    protected function setUp(): void
    {
        $this->gedcom = Tree::load(
            __DIR__.'/stubs/555SAMPLE.GED'
        );
    }

    /** @test */
    public function it_extracts_families()
    {
        $this->assertCount(2, $this->gedcom->getFamilies());
    }
}
