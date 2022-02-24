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
    public function it_parses_families()
    {
        $this->assertCount(2, $this->gedcom->getFamilies());
    }

    /** @test */
    public function it_parses_family_events()
    {
        dd($this->gedcom->getFamilies()->get(0)->events);
        $this->assertCount(1, $this->gedcom->getFamilies()->get(0)->events);
        $this->assertCount(0, $this->gedcom->getFamilies()->get(1)->events);
    }
}
