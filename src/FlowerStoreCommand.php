<?php namespace Aero;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

Class FlowerStoreCommand extends Command {

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
}