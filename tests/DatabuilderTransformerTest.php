<?php

namespace DatabuilderTests;

use Databuilder\DatabuilderTransformer;
use DatabuilderTests\data\TestDatabuilder;
use DOMDocument;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class DatabuilderTransformerTest extends TestCase
{
    private DatabuilderTransformer $transformer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $this->transformer = new DatabuilderTransformer();
    }

    public function testTransformsPhpDatabuilderToXmlDatabuilder(): void
    {
        $phpDatabuilder = $this->getPhpDatabuilder();
        $xmlDatabuilder = $this->getXmlDatabuilder();

        $transformerPhpDatabuilder = $this->transformer->transform($phpDatabuilder);

        $this->assertEquals(
            $xmlDatabuilder,
            $transformerPhpDatabuilder,
            'Databuilder transformation has failed!'
        );
    }

    protected function getPhpDatabuilder(): TestDatabuilder
    {
        return new TestDatabuilder();
    }

    private function getXmlDatabuilder(): DOMDocument
    {
        $doc = new DOMDocument('1.0');
        $xmlDatabuilder = $doc->createElement('transfers');
        $xmlDatabuilder->setAttribute('xmlns', 'spryker:databuilder-01');
        $xmlDatabuilder->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $xmlDatabuilder->setAttribute(
            'xsi:schemaLocation',
            'spryker:databuilder-01 http://static.spryker.com/databuilder-01.xsd'
        );

        $transfer = $doc->createElement('transfer');
        $transfer->setAttribute('name', 'TestRegistration');

        $property = $doc->createElement('property');
        $property->setAttribute('name', 'store');
        $property->setAttribute('dataBuilderRule', 'word()');

        $transfer->appendChild($property);
        $xmlDatabuilder->appendChild($transfer);
        $doc->appendChild($xmlDatabuilder);

        return $doc;
    }
}