<?php namespace Aero;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

Class FlowerStoreCommand extends Command {

    public $bouquetSpecs = [];
    public $flowers = [];
    
    public function configure()
    {
        $this->setName('total')
             ->setDescription('Display optimum available bouquets and remaining flowers');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        // Output options
        $output->writeln("Hello");
    }

    public function unitTesting($input)
    {
        return $input . 'Test';
    }

    public function readFile($file)
    {
        $flower = 0;
        $handle = fopen($file, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                // process the line read.
                if ($flower == 1) {
                    array_push($this->flowers, trim($line));
                } else if (strlen($line) > 3){
                    array_push($this->bouquetSpecs, trim($line));
                }
                if (strlen($line) == 1) {
                    $flower = 1;
                }
            }
            fclose($handle);
        } else {
            // error opening the file.
            return 'Error opening file.';
        } 
        $this->flowerGroup = array_count_values($this->flowers);
    }
}