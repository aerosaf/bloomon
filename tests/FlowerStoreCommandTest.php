<?php

use PHPUnit\Framework\TestCase;
use Aero\FlowerStoreCommand;

class FlowerStoreCommandTest extends TestCase {

    public $FlowerStoreCommand;

    function setUp() {
        $this->FlowerStoreCommand = new FlowerStoreCommand;
        $this->FlowerStoreCommand->readFile('./sample/input.txt');		
    }

    public function testInitialOutput(): void
    {
        $FlowerStoreCommand = new FlowerStoreCommand;

        $this->assertEquals(
            'HelloTest',
            $FlowerStoreCommand->unitTesting('Hello')
        );
    }

    public function testSmapleDirectoryExsists(): void
    {
        $this->assertDirectoryExists('./sample/');
    }

    public function testCanFindFlower(): void
    {
        $this->assertEquals(
            1,
            $this->FlowerStoreCommand->getFlowers('L', ['10a' ,'15b' ,'5c'])
        );
    }

    public function testCanMakeBouquet(): void
    {
        $this->assertEquals(
            1,
            $this->FlowerStoreCommand->getBouquet()
        );
    }

    public function testFindFlowerThatMatchTheSpecAndDeductFromStorage(): void
    {
        $flowerGroup_aL = $this->FlowerStoreCommand->flowerGroup['aL'];
            
        $this->assertEquals(
            1,
            $this->FlowerStoreCommand->matchFlowers('L', [10, 'a'])
        );

        $flowerGroup_aL_after_assert = $this->FlowerStoreCommand->flowerGroup['aL'];

        $this->assertEquals(
            $flowerGroup_aL-10,
            $flowerGroup_aL_after_assert
        );
    }
}