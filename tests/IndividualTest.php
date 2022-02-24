<?php

namespace Pzoechner\GedTree\Test;

use PHPUnit\Framework\TestCase;
use Pzoechner\GedTree\Individual;
use Pzoechner\GedTree\Name;
use Pzoechner\GedTree\Tree;

class IndividualTest extends TestCase
{
    protected Tree $gedcom;

    protected function setUp(): void
    {
        $this->gedcom = Tree::load(
            __DIR__.'/stubs/555SAMPLE.GED'
        );
    }

    /** @test */
    public function it_extracts_individuals()
    {
        $this->assertCount(3, $this->gedcom->getIndividuals());
    }

    /** @test */
    public function it_loads_an_individual()
    {
        /** @var Individual $individual */
        $individual = $this->gedcom->getIndividuals()->first();

        $this->assertInstanceOf(Individual::class, $individual);
        $this->assertInstanceOf(Name::class, $individual->name);
        $this->assertCount(2, $individual->dates);
    }

    /**
     * @test
     * @dataProvider individualGender
     */
    public function it_parses_an_individuals_sex(Individual $individual, string $gender)
    {
        $this->assertEquals($gender, $individual->gender);
    }

    public function individualGender(): array
    {
        $gedcom = Tree::load(
            __DIR__.'/stubs/555SAMPLE.GED'
        );

        $individuals = $gedcom->getIndividuals();

        return [
            [$individuals->get(0), 'M'],
            [$individuals->get(1), 'F'],
            [$individuals->get(2), 'M'],
        ];
    }
}
