<?php

use PHPUnit\Framework\TestCase;
use Aero\FlowerStoreCommand;

class FlowerStoreCommandTest extends TestCase {

    public function testInitialOutput(): void
    {
        $FlowerStoreCommand = new FlowerStoreCommand;

        $this->assertEquals(
            'HelloTest',
            $FlowerStoreCommand->unitTesting('Hello')
        );
    }

}