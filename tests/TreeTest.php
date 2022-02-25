<?php

namespace Pzoechner\GedTree\Test;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use PHPUnit\Framework\TestCase;
use Pzoechner\GedTree\Tree;

class TreeTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideTrees
     */
    public function it_parses_individuals(string $fileName, int $individualCount, int $familyCount)
    {
        $tree = Tree::load(
            __DIR__.'/stubs/'.$fileName
        );

        $this->assertCount($individualCount, $tree->getIndividuals());
        $this->assertCount($familyCount, $tree->getFamilies());
    }

    private function provideTrees()
    {
        return [
            // fileName, individual count, family count
            ['555SAMPLE.GED', 3, 2],
            ['555SAMPLE16BE.GED', 3, 2],
            ['555SAMPLE16LE.GED', 3, 2],
            ['MINIMAL555.GED', 0, 0],
            ['REMARR.GED', 3, 3],
            ['SSMARR.GED', 2, 1],
            ['TGC55C.GED', 15, 7],
            ['TGC55CLF.GED', 15, 7],
            ['TGC551.GED', 15, 7],
            ['TGC551LF.GED', 15, 7],
        ];
    }

    /** @test */
    public function it_throws_an_exception_if_the_file_could_not_be_found()
    {
        $this->expectException(FileNotFoundException::class);

        Tree::load(__DIR__.'/stubs/does-not-exist.txt');
    }
}
