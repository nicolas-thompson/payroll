<?php

namespace Payroll;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

use Payroll\Payroll;

class PayrollCommand extends Command{

	protected function configure(){
		$this->setName("Payroll:Payroll")
				->setDescription("Output the pay dates for any given year.")
				->addArgument('Year', InputArgument::REQUIRED, 'Which year would you like to see the pay dates for?)');
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		
		$output->writeln('The pay dates are: ');
		$payRoll = new Payroll();
		$input = $input->getArgument('Year');

		$rows = $payRoll->payDates($input);
		$table = new Table($output);
        $table->setHeaders(['Month Name', 'Days in Month'])
            ->setRows($rows)
            ->render();
	}

}
