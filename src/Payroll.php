<?php

namespace Payroll;

class Payroll{

	/**
	 * Receives a year and outputs the pay dates for that year.
	 *
	 * @param string $password
	 * @return string $hash
	 */
	public function payDates( $year ){

		$months = range(1,12);
		$rows = [];
        foreach ($months as $month)
        {
			$dateObj   = \DateTime::createFromFormat('!m', $month);
			$monthName = $dateObj->format('F');
			$salaryDate = $this->figureOutTheSalaryDate($year, $month);
			$firstExpensesDay =  date("Y-m-d", strtotime($year .'-' . $month . '-' . 1));
			$weekday = intval(date("N", strtotime($firstExpensesDay)));
			$firstExpensesDay = $weekday == 6 ? date('Y-m-d', strtotime('+2 day', strtotime($firstExpensesDay))) : $firstExpensesDay;
			$firstExpensesDay = $weekday == 7 ? date('Y-m-d', strtotime('+1 day', strtotime($firstExpensesDay))) : $firstExpensesDay; 
			$rows[] = [ $monthName, $firstExpensesDay, $salaryDate ];
        }

		return $rows;
	}

	private function figureOutTheSalaryDate($year, $month)
	{
		$salaryDay = date("Y-m-t", strtotime($year . '-' . $month . '-' . '15'));
		$weekday = intval(date("N", strtotime($salaryDay)));
		$salaryDay = $weekday == 6 ? date('Y-m-d', strtotime('-1 day', strtotime($salaryDay))) : $salaryDay;
		$salaryDay = $weekday == 7 ? date('Y-m-d', strtotime('-2 day', strtotime($salaryDay))) : $salaryDay;
		return $salaryDay;
	}
}
