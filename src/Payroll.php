<?php

namespace Payroll;

class Payroll{

	/**
	 * Receives a year and outputs the pay dates for that year.
	 *
	 * @param string $password
	 * @return string $hash
	 */
	public static function payDates( $year ){

		$months = range(1,12);
		$rows = [];
        foreach ($months as $month)
        {
			$dateObj   = \DateTime::createFromFormat('!m', $month);
			$monthName = $dateObj->format('F');
			$salaryDay = date("Y-m-t", strtotime($year . '-' . $month . '-' . '15'));
			$weekday = intval(date("N", strtotime($salaryDay)));
			$salaryDay = $weekday == 6 ? date('Y-m-d', strtotime('-1 day', strtotime($salaryDay))) : $salaryDay;
			$salaryDay = $weekday == 7 ? date('Y-m-d', strtotime('-2 day', strtotime($salaryDay))) : $salaryDay;	
			$rows[] = [ $monthName, $salaryDay ];
        }

		return $rows;
	}
}
