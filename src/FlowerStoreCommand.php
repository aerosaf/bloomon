<?php namespace Aero;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

Class FlowerStoreCommand extends Command {

    public $bouquetSpecs = [];
    public $flowers = [];
    public $flowerGroup = [];
    public $bouquets = [];
    public $cycle = 0;

    public function configure()
    {
        $this->setName('total')
             ->setDescription('Display optimum available bouquets and remaining flowers');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        // Reads the input in the sample folder.
        $this->readFile('./sample/input.txt');

        // Output options
        $output->writeln($this->bouquets($output));
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


    public function bouquets($output)
    {
        // Go through all bouquet spec untill no bouquet can be found in a cycle
        while ($this->getBouquet() == 1) {
            $this->cycle++;
        }

        $output = $this->getOutput();

        return $output;
    }

    public function getBouquet()
    {
        $result = 0;

        foreach($this->bouquetSpecs as $bouquetSpec) {
            
            // Get bouquet size
            preg_match('/(?<=[A-Z])L|S(?=\d)/', $bouquetSpec, $bouquetSize);
            
            // Get bouquet rules
            preg_match_all('/\d+[a-z]/', $bouquetSpec, $bouquetRules);
            
            // Get Bouquets from input
            foreach($bouquetRules as $rules) {
                if($this->getFlowers($bouquetSize[0], $rules) == 1){

                    // Set one bouquet every cycle found
                    if(!isset($this->bouquets[$bouquetSpec])){
                        $this->bouquets[$bouquetSpec] = 1;
                    } else {
                        $this->bouquets[$bouquetSpec]++;
                    }
                    $result = 1;
                } else {
                    if(!isset($this->bouquets[$bouquetSpec])){
                        $this->bouquets[$bouquetSpec] = 0;
                    }
                }
            }
        }

        return $result;
    }

    public function getFlowers($bouquetSize, $rules)
    {
        $haveFlower = 0;
       
        // Run through all the flower in the specs
        foreach($rules as $rule) {

            // Seporate the flower name from the quantity
            $rule = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$rule);

            // Look for flowers
            $foundFlower = $this->matchFlowers($bouquetSize, $rule);

            // Stop search for the rest of the spec if flower is not found
            if($foundFlower == 0){
                break;
            } else {
                $haveFlower = 1;
            }
        }

        return $haveFlower;
    }

    public function getOutput()
    {
        $output = "<comment>Created bouquets</comment>\n";
        foreach($this->bouquets as $bouquet => $quantity) {
            $output .= $bouquet . " : <info>" . $quantity . "</info>\n";
        }

        $output .= "\n<comment>With leftover flowers</comment>\n";

        foreach($this->flowerGroup as $flower => $quantity) {
            $output .= $flower . " : <info>" . $quantity . "</info>\n";
        }

        return $output;
    }

    public function matchFlowers($bouquetSize, $rule)
    {
        // Go through the input to macth found flowers
        $foundFlower = 0;
        foreach($this->flowerGroup as $flower => $quantity) {
            $flowerSize = substr($flower, -1);
            $flowerName = substr($flower, 0, -1);
            
            // Deduct flowers from from input used for the bouquet
            if($flowerSize == $bouquetSize && $flowerName == $rule[1] && $quantity >= $rule[0]) {
                $this->flowerGroup[$flower] = $quantity - $rule[0];
                $foundFlower = 1;
            }
        }

        return $foundFlower;
    }
}