<?php

namespace Pzoechner\GedTree\Test;

use PHPUnit\Framework\TestCase;
use Pzoechner\GedTree\Date;
use Pzoechner\GedTree\Individual;
use Pzoechner\GedTree\RecordType;
use Pzoechner\GedTree\Tree;

class DateTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideDates
     */
    public function it_parses_dates_from_individual(
        string $fileName,
        int $individualPosition,
        int $datePosition,
        ?string $date,
        string $type,
        int $individualDateCount,
    ) {
        $tree = Tree::load(
            __DIR__.'/stubs/'.$fileName
        );

        /** @var Individual $individual */
        $individual = $tree->getIndividuals()->get($individualPosition);

        $this->assertCount($individualDateCount, $individual->dates);
    }

    /**
     * @test
     * @dataProvider provideDates
     */
    public function it_parses_parts_from_date(
        string $fileName,
        int $individualPosition,
        int $datePosition,
        ?string $date,
        string $type,
        int $individualDateCount,
    ) {
        $tree = Tree::load(
            __DIR__.'/stubs/'.$fileName
        );

        /** @var Individual $individual */
        $individual = $tree->getIndividuals()->get($individualPosition);
        /** @var Date $date */
        $eventDate = $individual->dates[$datePosition];

        $this->assertEquals($date, $eventDate->date);
        $this->assertEquals($type, $eventDate->type);
    }

    private function provideDates(): array
    {
        return [
            // fileName, individual position, date position, date, type, individual date count
            ['555SAMPLE.GED', 0, 0, '2 Oct 1822', RecordType::BIRT, 2],
            ['555SAMPLE.GED', 0, 1, '14 Apr 1905', RecordType::DEAT, 2],
            ['555SAMPLE.GED', 1, 0, 'BEF 1828', RecordType::BIRT, 1],
            ['555SAMPLE.GED', 2, 0, '11 Jun 1861', RecordType::BIRT, 1],

            ['555SAMPLE16BE.GED', 0, 0, '2 Oct 1822', RecordType::BIRT, 2],
            ['555SAMPLE16BE.GED', 0, 1, '14 Apr 1905', RecordType::DEAT, 2],
            ['555SAMPLE16BE.GED', 1, 0, 'BEF 1828', RecordType::BIRT, 1],
            ['555SAMPLE16BE.GED', 2, 0, '11 Jun 1861', RecordType::BIRT, 1],

            ['555SAMPLE16LE.GED', 0, 0, '2 Oct 1822', RecordType::BIRT, 2],
            ['555SAMPLE16LE.GED', 0, 1, '14 Apr 1905', RecordType::DEAT, 2],
            ['555SAMPLE16LE.GED', 1, 0, 'BEF 1828', RecordType::BIRT, 1],
            ['555SAMPLE16LE.GED', 2, 0, '11 Jun 1861', RecordType::BIRT, 1],

            ['REMARR.GED', 0, 0, '7 Jul 1877', RecordType::BIRT, 1],
            ['REMARR.GED', 1, 0, '4 May 1876', RecordType::BIRT, 1],
            ['REMARR.GED', 2, 0, '8 Aug 1888', RecordType::BIRT, 1],

            ['SSMARR.GED', 0, 0, '1 Sep 1991', RecordType::BIRT, 1],
            ['SSMARR.GED', 1, 0, '8 Aug 1988', RecordType::BIRT, 1],

            ...$this->tgc5GedTemplate('TGC55C.GED'),
            ...$this->tgc5GedTemplate('TGC55CLF.GED'),
            ...$this->tgc5GedTemplate('TGC551.GED'),
            ...$this->tgc5GedTemplate('TGC551LF.GED'),
        ];
    }

    private function tgc5GedTemplate(string $fileName): array
    {
        return [
            [$fileName, 0, 0, '15 JUN 1900', RecordType::BIRT, 2],
            [$fileName, 0, 1, '5 JUL 1974', RecordType::DEAT, 2],
            [$fileName, 1, 0, '12 AUG 1905', RecordType::BIRT, 2],
            [$fileName, 1, 1, '31 DEC 1990', RecordType::DEAT, 2],
            [$fileName, 2, 0, '6 JUN 1944', RecordType::BIRT, 1],
            [$fileName, 3, 0, '1875', RecordType::BIRT, 1],
            [$fileName, 4, 0, '1872', RecordType::BIRT, 2],
            [$fileName, 4, 1, '7 DEC 1941', RecordType::DEAT, 2],
            [$fileName, 5, 0, '1870', RecordType::BIRT, 2],
            [$fileName, 5, 1, null, RecordType::DEAT, 2],
            [$fileName, 6, 0, '1835', RecordType::BIRT, 1],
            [$fileName, 7, 0, 'BEF 1970', RecordType::BIRT, 2],
            [$fileName, 7, 1, 'AFT 2000', RecordType::DEAT, 2],
            [$fileName, 8, 0, '12 FEB 1840', RecordType::BIRT, 2],
            [$fileName, 8, 1, '15 JUN 1915', RecordType::DEAT, 2],
            [$fileName, 9, 0, 'BET MAY 1979 AND AUG 1979', RecordType::BIRT, 2],
            [$fileName, 9, 1, 'FROM APR 2000 TO 5 MAR 2001', RecordType::DEAT, 2],
            [$fileName, 10, 0, 'MAR 1999', RecordType::BIRT, 1],
            [$fileName, 11, 0, '31 DEC 1965', RecordType::BIRT, 2],
            [$fileName, 11, 1, 'ABT 15 JAN 2001', RecordType::DEAT, 2],
            [$fileName, 12, 0, '1 JAN 2001', RecordType::BIRT, 1],
            [$fileName, 13, 0, '15 FEB 2000', RecordType::BIRT, 1],
            [$fileName, 14, 0, 'ABT 1930', RecordType::BIRT, 2],
            [$fileName, 14, 1, 'INT 1995 (from estimated age)', RecordType::DEAT, 2],
        ];
    }
}
