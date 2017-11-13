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
				->addArgument('Year', InputArgument::REQUIRED, 'Which year would you like to see the pay dates for?)')
				->addArgument('FileName', InputArgument::REQUIRED, 'What file name would you like to use?)');
				
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		$year = $input->getArgument('Year');
		$output->writeln("The pay dates for {$year} are: ");
		$payRoll = new Payroll();
		$rows = $payRoll->payDates($year);
		$fileName = $input->getArgument('FileName');
		$handle = fopen($fileName, 'w') or die('Cannot create or open file:  '.$fileName);
		fwrite($handle, 'Month Name, 1st Expenses Day, 2nd Expenses Day, Salary Day');	
		foreach($rows as $row){
			fwrite($handle, $row[0] . "," . $row[1] . "," . $row[2] . "\n");
		}	
		$table = new Table($output);
        $table->setHeaders(['Month Name', '1st Expenses Day', '2nd Expenses Day', 'Salary Day'])
            ->setRows($rows)
            ->render();
	}
}
