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
			$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);			
			$rows[] = [ $monthName, $numberOfDays ];
        }

		return $rows;
	}
}
