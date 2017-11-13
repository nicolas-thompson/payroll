<?php

namespace Payroll;

class Payroll{

	/**
	 * Receives a year and outputs the pay dates for that year.
	 *
	 * @param string $year
	 * @return string $rows
	 */
	public function payDates( $year ){

		$months = range(1,12);
		$rows = [];
        foreach ($months as $month)
        {
			$dateObj   = \DateTime::createFromFormat('!m', $month);
			$monthName = $dateObj->format('F');
			$salaryDate = $this->figureOutTheSalaryDate($year, $month);
			$firstExpensesDate = $this->figureOutTheFirstExpensesDate($year, $month);
			$rows[] = [ $monthName, $firstExpensesDate, $salaryDate ];
        }

		return $rows;
	}

	private function figureOutTheSalaryDate($year, $month)
	{
		$salaryDate = date("Y-m-t", strtotime($year . '-' . $month . '-' . '15'));
		$weekday = intval(date("N", strtotime($salaryDate)));
		$salaryDate = $weekday == 6 ? date('Y-m-d', strtotime('-1 day', strtotime($salaryDate))) : $salaryDate;
		$salaryDate = $weekday == 7 ? date('Y-m-d', strtotime('-2 day', strtotime($salaryDate))) : $salaryDate;
		
		return $salaryDate;
	}

	private function figureOutTheFirstExpensesDate($year, $month)
	{
		$firstExpensesDate =  date("Y-m-d", strtotime($year .'-' . $month . '-' . 1));
		$weekday = intval(date("N", strtotime($firstExpensesDate)));
		$firstExpensesDate = $weekday == 6 ? date('Y-m-d', strtotime('+2 day', strtotime($firstExpensesDate))) : $firstExpensesDate;
		$firstExpensesDate = $weekday == 7 ? date('Y-m-d', strtotime('+1 day', strtotime($firstExpensesDate))) : $firstExpensesDate; 
	
		return $firstExpensesDate;
	}
}
