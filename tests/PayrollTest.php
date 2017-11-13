<?php

use Payroll\PayrollCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

require_once  './vendor/autoload.php'; 

class PayrollCommandTest extends \PHPUnit_Framework_TestCase{

    public function testPayroll(){

        $application = new Application();
        $application->add(new PayrollCommand());

        $command = $application->find('Payroll:Payroll');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'      => $command->getName(),
            'Year'         => '2017'
        ));    

        $this->assertRegExp('/The pay dates are:
        +------------+------------------+------------------+------------+
        | Month Name | 1st Expenses Day | 2nd Expenses Day | Salary Day |
        +------------+------------------+------------------+------------+
        | January    | 2017-01-02       | 2017-01-16       | 2017-01-31 |
        | February   | 2017-02-01       | 2017-02-15       | 2017-02-28 |
        | March      | 2017-03-01       | 2017-03-15       | 2017-03-31 |
        | April      | 2017-04-03       | 2017-04-15       | 2017-04-28 |
        | May        | 2017-05-01       | 2017-05-15       | 2017-05-31 |
        | June       | 2017-06-01       | 2017-06-15       | 2017-06-30 |
        | July       | 2017-07-03       | 2017-07-15       | 2017-07-31 |
        | August     | 2017-08-01       | 2017-08-15       | 2017-08-31 |
        | September  | 2017-09-01       | 2017-09-15       | 2017-09-29 |
        | October    | 2017-10-02       | 2017-10-16       | 2017-10-31 |
        | November   | 2017-11-01       | 2017-11-15       | 2017-11-30 |
        | December   | 2017-12-01       | 2017-12-15       | 2017-12-29 |
        +------------+------------------+------------------+------------+/', $commandTester->getDisplay());

    }

}