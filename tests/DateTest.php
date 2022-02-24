<?php

namespace Pzoechner\GedTree\Test;

use PHPUnit\Framework\TestCase;
use Pzoechner\GedTree\Date;
use Pzoechner\GedTree\Individual;
use Pzoechner\GedTree\RecordType;
use Pzoechner\GedTree\Tree;

class DateTest extends TestCase
{
    protected Tree $gedcom;

    /**
     * @test
     * @dataProvider individuals
     */
    public function it_parses_dates_from_individual(Individual $individual, $dateCount)
    {
        $this->assertCount($dateCount, $individual->dates);
    }

    private function individuals(): array
    {
        $gedcom = Tree::load(
            __DIR__.'/stubs/555SAMPLE.GED'
        );

        $individuals = $gedcom->getIndividuals();

        return [
            [$individuals->get(0), 2, 10],
            [$individuals->get(1), 1, 100],
            [$individuals->get(2), 1, 1000],
        ];
    }

    /**
     * @test
     * @dataProvider dates
     */
    public function it_parses_parts_from_date(Date $date, $dateString, $dateType)
    {
        $this->assertEquals($dateString, $date->date);
        $this->assertEquals($dateType, $date->type);
    }

    private function dates(): array
    {
        $gedcom = Tree::load(
            __DIR__.'/stubs/555SAMPLE.GED'
        );

        $dates = $gedcom->getIndividuals()->get(0)->dates;

        return [
            [$dates[0], '2 Oct 1822', RecordType::BIRT],
            [$dates[1], '14 Apr 1905', RecordType::DEAT],
        ];
    }
}
