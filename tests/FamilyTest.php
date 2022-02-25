<?php

namespace Pzoechner\GedTree\Test;

use PHPUnit\Framework\TestCase;
use Pzoechner\GedTree\Date;
use Pzoechner\GedTree\Family;
use Pzoechner\GedTree\RecordType;
use Pzoechner\GedTree\Tree;

class FamilyTest extends TestCase
{
    /** @test */
    public function it_parses_families()
    {
        $tree = Tree::load(
            __DIR__.'/stubs/555SAMPLE.GED'
        );

        /** @var Family $family */
        $family = $tree->getFamilies()->first();

        $this->assertCount(2, $tree->getFamilies());
        $this->assertEquals('@F1@', $family->id);
        $this->assertEquals(['@I1@', '@I2@'], $family->pointers);
        $this->assertEquals([new Date('Dec 1859', RecordType::MARR)], $family->events);
    }

    /**
     * @test
     * @dataProvider provideFamilies
     */
    public function it_parses_family_events(string $fileName, int $familyCount)
    {
        $tree = Tree::load(
            __DIR__.'/stubs/'.$fileName
        );

        $this->assertCount($familyCount, $tree->getFamilies());
    }

    private function provideFamilies(): array
    {
        return [
            // fileName, family count
            ['555SAMPLE.GED', 2],
            ['555SAMPLE16BE.GED', 2],
            ['555SAMPLE16LE.GED', 2],
            ['REMARR.GED', 3],
            ['SSMARR.GED', 1],

            ['TGC55C.GED', 7],
            ['TGC55CLF.GED', 7],
            ['TGC551.GED', 7],
            ['TGC551LF.GED', 7],
        ];
    }
}
