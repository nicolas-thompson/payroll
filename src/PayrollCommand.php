<?php

namespace Payroll;

use Payroll\Payroll;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

/**
 * Payroll Command Class
 * 
 * methods(configure, execute)
 */
class PayrollCommand extends Command
{
	/**
	 * Configure
	 *
	 * @return void
	 */
	protected function configure()
	{
		$this->setName("Payroll")
				->setDescription("Output the pay dates for any given year.")
				->addArgument('Year', InputArgument::REQUIRED, 'Which year would you like to see the pay dates for?)')
				->addArgument('FileName', InputArgument::REQUIRED, 'What file name would you like to use?)');			
	}

	/**
	 * Excecute
	 *
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return void
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$year = $input->getArgument('Year');
		$payRoll = new Payroll();
		$rows = $payRoll->payDates($year);
		$fileName = $input->getArgument('FileName');
        if (file_exists($fileName)) {
			$helper = $this->getHelper('question');
			$question = new ConfirmationQuestion("Do you want to overwrite {$fileName} ? Please enter y or n ", false);
			if ( ! $helper->ask($input, $output, $question )) {
				return;
			}    
        }
		$handle = fopen($fileName, 'w') or die('Cannot create or open file:  '.$fileName);
		fwrite($handle, "Month Name, 1st Expenses Day, 2nd Expenses Day, Salary Day \n");	
		foreach($rows as $row) {
			fwrite($handle, $row[0] . "," . $row[1] . "," . $row[2] . "\n");
		}
		$output->writeln("The pay dates have been written to {$fileName}...");
		$output->writeln("The pay dates for {$year} are: ");
		$table = new Table($output);
        $table->setHeaders(['Month Name', '1st Expenses Day', '2nd Expenses Day', 'Salary Day'])
        		->setRows($rows)
            	->render();
	}
}
