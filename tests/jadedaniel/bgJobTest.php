<?php

namespace jadedaniel;

use PHPUnit\Framework\TestCase;

class bgJobTest extends TestCase
{
    public function testPrepareArgs() {
        $args = [
            "",
            null,
            false,
            0,
            "actualData"
        ];

        $bgJob = new bgJob();
        $prepared = $bgJob->prepareArgs($args);

        foreach ($prepared as $argument) {
            $this->assertNotSame(null, $argument);
            $this->assertNotSame(false, $argument);
            $this->assertNotSame(0, $argument);
        }

        $this->assertEquals("''", $prepared[0]);
        $this->assertEquals("''", $prepared[1]);
        $this->assertEquals("0", $prepared[2]);
        $this->assertEquals("0", $prepared[3]);
        $this->assertEquals("'actualData'", $prepared[4]);
    }

}
