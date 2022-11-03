<?php

namespace Unit;

use App\SimilarityAlgorithms\HammingAlgorithm;
use PHPUnit\Framework\TestCase;

class HammingAlgorithmTest extends TestCase
{
    public function testCompareTrue():void
    {
        $hammingAlgorithm = new HammingAlgorithm();

        $hammingAlgorithm->setTexts([
            'text1' => '1111',
            'text2' => '0000'
        ]);

        $this->assertEquals(4, $hammingAlgorithm->compare());
    }

    public function testCompareFalse():void
    {
        $hammingAlgorithm = new HammingAlgorithm();

        $hammingAlgorithm->setTexts([
            'text1' => '1111',
            'text2' => '0000'
        ]);

        $this->assertNotEquals(5, $hammingAlgorithm->compare());
    }

    public function testCompareStringsFalse():void
    {
        $hammingAlgorithm = new HammingAlgorithm();

        $hammingAlgorithm->setTexts([
            'text1' => 'mine',
            'text2' => 'time'
        ]);

        $this->assertNotEquals(2, $hammingAlgorithm->compare());
    }

    public function testCompareStringsTrue():void
    {
        $hammingAlgorithm = new HammingAlgorithm();

        $hammingAlgorithm->setTexts([
            'text1' => 'mine',
            'text2' => 'nine'
        ]);

        $this->assertEquals(2, $hammingAlgorithm->compare());
    }
}

