<?php

namespace Pzoechner\GedTree\Test;

use PHPUnit\Framework\TestCase;
use Pzoechner\GedTree\Individual;
use Pzoechner\GedTree\Name;
use Pzoechner\GedTree\Tree;

class NameTest extends TestCase
{
    protected Tree $gedcom;

    /**
     * @test
     * @dataProvider provideNames
     */
    public function it_parses_name_from_individual(
        string $fileName,
        int $individualPosition,
        string $first,
        string $last,
    ) {
        $tree = Tree::load(
            __DIR__.'/stubs/'.$fileName
        );

        /** @var Individual $individual */
        $individual = $tree->getIndividuals()->get($individualPosition);

        $this->assertInstanceOf(Name::class, $individual->name);
        $this->assertEquals($first, $individual->name->first);
        $this->assertEquals($last, $individual->name->last);
    }

    private function provideNames(): array
    {
        return [
            // fileName, individual position, first name, last name
            ['555SAMPLE.GED', 0, 'Robert Eugene', 'Williams'],
            ['555SAMPLE.GED', 1, 'Mary Ann', 'Wilson'],
            ['555SAMPLE.GED', 2, 'Joe', 'Williams'],

            ['555SAMPLE16BE.GED', 0, 'Robert Eugene', 'Williams'],
            ['555SAMPLE16BE.GED', 1, 'Mary Ann', 'Wilson'],
            ['555SAMPLE16BE.GED', 2, 'Joe', 'Williams'],

            ['555SAMPLE16LE.GED', 0, 'Robert Eugene', 'Williams'],
            ['555SAMPLE16LE.GED', 1, 'Mary Ann', 'Wilson'],
            ['555SAMPLE16LE.GED', 2, 'Joe', 'Williams'],

            ['REMARR.GED', 0, 'Peter', 'Sweet'],
            ['REMARR.GED', 1, 'Mary', 'Encore'],
            ['REMARR.GED', 2, 'Juan', 'Donalds'],

            ['SSMARR.GED', 0, 'John', 'Smith'],
            ['SSMARR.GED', 1, 'Steven', 'Stevens'],

            ...$this->tgc5GedTemplate('TGC55C.GED'),
            ...$this->tgc5GedTemplate('TGC55CLF.GED'),
            ...$this->tgc5GedTemplate('TGC551.GED'),
            ...$this->tgc5GedTemplate('TGC551LF.GED'),
        ];
    }

    private function tgc5GedTemplate(string $fileName): array
    {
        return [
            [$fileName, 0, 'Charlie Accented', 'ANSEL'],
            [$fileName, 1, 'Lucy Special', 'ANSEL'],
            [$fileName, 2, 'Teresa Mary', 'Caregiver'],
            [$fileName, 3, 'Extra URL', 'Filelinks'],
            [$fileName, 4, 'General Custom', 'Filelinks'],
            [$fileName, 5, 'Nonstandard Multimedia', 'Filelinks'],
            [$fileName, 6, 'Standard GEDCOM', 'Filelinks'],
            [$fileName, 7, 'Mary First', 'Jones'],
            [$fileName, 8, 'Torture GEDCOM', 'Matriarch'],
            [$fileName, 9, 'Elizabeth Second', 'Smith'],
            [$fileName, 10, 'Chris Locked', 'Torture'],
            [$fileName, 11, 'Joseph', 'Torture'],
            [$fileName, 12, 'Pat Smith', 'Torture'],
            [$fileName, 13, 'Sandy Privacy', 'Torture'],
            [$fileName, 14, 'William Joseph', 'Torture'],
        ];
    }
}
