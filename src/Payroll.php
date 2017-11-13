<?php

namespace Payroll;

/**
 * Payroll Class
 * 
 */
class Payroll
{
	private $salaryDate;
	private $firstExpensesDate;
	private $secondExpensesDate;

	/**
	 * Receives a year and outputs the pay dates for that year.
	 *
	 * @param string $year
	 * @return array $rows
	 */
	public function payDates( $year )
	{
		$months = range(1,12);
		$rows = [];
        foreach ($months as $month)
        {
			$dateTime = \DateTime::createFromFormat('!m', $month);
			$monthName = $dateTime->format('F');
			$this->figureOutTheSalaryDate($year, $month)
					->figureOutTheFirstExpensesDate($year, $month)
					->figureOutTheSecondExpensesDate($year, $month);			
			$rows[] = [ $monthName, $this->firstExpensesDate, $this->secondExpensesDate, $this->salaryDate ];
		}
		
		return $rows;
	}

	/**
	 * Figure out the Salary Date for a given month.
	 *
	 * @param string $year
	 * @param string $month
	 * @return $this
	 */
	private function figureOutTheSalaryDate($year, $month)
	{
		$this->salaryDate = date("Y-m-t", strtotime($year . '-' . $month . '-' . '15'));
		$weekday = intval(date("N", strtotime($this->salaryDate)));
		$salaryDate = $weekday == 6 ? date('Y-m-d', strtotime('-1 day', strtotime($this->salaryDate))) : $this->salaryDate;
		$salaryDate = $weekday == 7 ? date('Y-m-d', strtotime('-2 day', strtotime($this->salaryDate))) : $this->salaryDate;
		$this->salaryDate;

		return $this;
	}

	/**
	 * Figure out the First Expenses Date for a given month.
	 *
	 * @param string $year
	 * @param string $month
	 * @return $this
	 */
	private function figureOutTheFirstExpensesDate($year, $month)
	{
		$this->firstExpensesDate = date("Y-m-d", strtotime($year .'-' . $month . '-' . 1));
		$weekday = intval(date("N", strtotime($this->firstExpensesDate)));
		$this->firstExpensesDate = $weekday == 6 ? date('Y-m-d', strtotime('+2 day', strtotime($this->firstExpensesDate))) : $this->firstExpensesDate;
		$this->firstExpensesDate = $weekday == 7 ? date('Y-m-d', strtotime('+1 day', strtotime($this->firstExpensesDate))) : $this->firstExpensesDate; 
		$this->firstExpensesDate;

		return $this;
	}

	/**
	 * Figure out the Second Expenses Date for a given month.
	 *
	 * @param string $year
	 * @param string $month
	 * @return $this
	 */
	private function figureOutTheSecondExpensesDate($year, $month)
	{
		$this->secondExpensesDate = date("Y-m-d", strtotime($year .'-' . $month . '-' . 15));
		$weekday = intval(date("N", strtotime($this->secondExpensesDate)));
		$this->firstExpensesDate = $weekday == 6 ? date('Y-m-d', strtotime('+2 day', strtotime($this->secondExpensesDate))) : $this->secondExpensesDate;
		$this->secondExpensesDate = $weekday == 7 ? date('Y-m-d', strtotime('+1 day', strtotime($this->secondExpensesDate))) : $this->secondExpensesDate; 
		$this->secondExpensesDate;

		return $this;
	}
}
