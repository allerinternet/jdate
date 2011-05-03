<?php

/**
 * A class for handling dates
 *
 * @author Jonas Bjork <jonas.bjork@aller.se>
 * @author Kristian Erendi <kristian.erendi@aller.se>
 * 
 * @copyright Aller media AB - 2011
 * @license GNU General Public License, GPLv3
 * @version 1.0
 *
 */
class JDate {

	private $unixtime = 0;
	private $orig_unixtime = 0;
	
	// If we don't specify a date we use systems local time
	function __construct($date = false) {
		if (($date != false) && (!is_int($date))) {
				$set_date = strtotime($date);
		} else if (($date != false)) {
			$set_date = $date;
		} else {
			$set_date = time();
		}		
		$this->unixtime = $set_date;
		$this->orig_unixtime = $set_date;
	}
		
	/**
	 * Get object date in YYYY-MM-DD or UNIXTIME format
	 * 
	 * @param boolean $unix sets the return format in unixtime
	 * @return string|int with date in format YYYY-MM-DD or UNIXTIME
	 */
	public function getDate($unix = FALSE) {
		if ($unix) {
			return $this->unixtime;
		} else {
			return date("Y-m-d", $this->unixtime);
		}
	}
	
	/**
	 * Get object original date, useful after we have used add/sub methods
	 * for days and weeks
	 * 
	 * @param boolean $unix sets the return format in unixtime
	 * @return string|int with date in format YYYY-MM-DD or UNIXTIME
	 */
	public function getOrigDate($unix = FALSE) {
		if ($unix) {
			return $this->orig_unixtime;
		} else {
			return date("Y-m-d", $this->orig_unixtime);
		}
	}
	
	/**
	 * Get the year from the date
	 * @return int with the year
	 */
	public function getYear() {
		return date("Y", $this->unixtime);
	}
	
	/**
	 * Get the month from the date.
	 * 
	 * @param boolean $zeropad switches leading zero on/off
	 * @return int with the month number
	 */
	public function getMonth($zeropad = FALSE) {
		$pad = ($zeropad) ? "n" : "m"; 
		return date($pad, $this->unixtime);
	}
	
	/**
	 * Get the day from the date.
	 * 
	 * @param boolean $zeropad switches leading zero on/off
	 * @return int with the day number
	 */
	public function getDay($zeropad = FALSE) {
		$pad = ($zeropad) ? "j" : "d";
		return date($pad, $this->unixtime);
	}
	
	/**
	 * Get the week from the date.
	 * 
	 * @param boolean $zeropad switches leading zero on/off
	 * @return int with the week number
	 */
	public function getWeek($zeropad = FALSE) {
		$week = date("W", $this->unixtime);
		if ($zeropad) {
			$week = ltrim($week, "0");
		}
		return $week;
	}
	
	/**
	 * Reset the date to what we initialised the object with
	 */
	public function reset() {
		$this->unixtime = $this->orig_unixtime;
	}


  /**
   * Returns the weekday name of the current date
   * @return string weekday name
   */
  public function getWeekday() {
    $wd = getdate($this->unixtime);
    return $wd['weekday'];
  }


	/**
	 * Private helper method for getMonday, getTuesday..
	 * 
	 * @param int $day is the day number in week (1=monday)
	 * @param boolean $unix decides if we want the return in unixtime format or not
	 * @return string|int with date in YYYY-MM-DD or UNIXTIME format
	 */
	private function _getWeekday($day, $unix = FALSE) {
		$day = $day - 1;
		if (date("w", $this->unixtime)==1) {
			$monday = $this->unixtime;		
		} else {
			$monday = strtotime("last Monday", $this->unixtime);
		}
		$time = strtotime(date("Y-m-d", $monday) . "+$day day");
		if ($unix) {
			return $time;
		} else {
			return date("Y-m-d", $time);
		}
	}
	
	/**
	 * Get the monday in dateobject week
	 * 
	 * @param boolean $unix decides if we want the return in unixtime format or not
	 * @return string|int with date in YYYY-MM-DD or UNIXTIME format
	 */	
	public function getMonday($unix = FALSE) {
		return $this->_getWeekday(1, $unix);
	}
	
	/**
	 * Get the tuesday in dateobject week
	 * 
	 * @param boolean $unix decides if we want the return in unixtime format or not
	 * @return string|int with date in YYYY-MM-DD or UNIXTIME format
	 */
	public function getTuesday($unix = FALSE) {
		return $this->_getWeekday(2, $unix);
	}
	
	/**
	 * Get the wednesday in dateobject week
	 * 
	 * @param boolean $unix decides if we want the return in unixtime format or not
	 * @return string|int with date in YYYY-MM-DD or UNIXTIME format
	 */
	public function getWednesday($unix = FALSE) {
		return $this->_getWeekday(3, $unix);
	}
	
	/**
	 * Get the thursday in dateobject week
	 * 
	 * @param boolean $unix decides if we want the return in unixtime format or not
	 * @return string|int with date in YYYY-MM-DD or UNIXTIME format
	 */
	public function getThursday($unix = FALSE) {
		return $this->_getWeekday(4, $unix);
	}
	
	/**
	 * Get the friday in dateobject week
	 * 
	 * @param boolean $unix decides if we want the return in unixtime format or not
	 * @return string|int with date in YYYY-MM-DD or UNIXTIME format
	 */
	public function getFriday($unix = FALSE) {
		return $this->_getWeekday(5, $unix);
	}
	
	/**
	 * Get the saturday in dateobject week
	 * 
	 * @param boolean $unix decides if we want the return in unixtime format or not
	 * @return string|int with date in YYYY-MM-DD or UNIXTIME format
	 */
	public function getSaturday($unix = FALSE) {
		return $this->_getWeekday(6, $unix);
	}
	
	/**
	 * Get the sunday in dateobject week
	 * 
	 * @param boolean $unix decides if we want the return in unixtime format or not
	 * @return string|int with date in YYYY-MM-DD or UNIXTIME format
	 */
	public function getSunday($unix = FALSE) {
		return $this->_getWeekday(7, $unix);
	}
	
	/**
	 * Add day or days to the date
	 * 
	 * @param int $days adds specified days to the date
	 */
	public function addDays($days) {
		if (!is_int($days)) return FALSE;
		
		if ($days > 0) {
			$this->unixtime = strtotime(date("Y-m-d", $this->unixtime) . "+$days day");
		}
	}
	
	/**
	 * Subtract day or days from the date
	 * 
	 * @param int $days subtracts specified days from the date
	 */
	public function subDays($days) {
		if (!is_int($days)) return FALSE;
		
		if ($days > 0) {
			$this->unixtime = strtotime(date("Y-m-d", $this->unixtime) . "-$days day");
		}
	}
	
	/**
	 * Add week or weeks to the date
	 * 
	 * @param int $weeks adds specified weeks to the date
	 */
	public function addWeeks($weeks) {
		if (!is_int($weeks)) return FALSE;
		
		if ($weeks > 0) {
			$this->unixtime = strtotime(date("Y-m-d", $this->unixtime) . "+$weeks week");
		}
	}
	
	/**
	 * Subtract week or weeks from the date
	 *
	 * @param int $weeks subtracts specified weeks from the date
	 */
	public function subWeeks($weeks) {
		if (!is_int($weeks)) return FALSE;
		
		if ($weeks > 0) {
			$this->unixtime = strtotime(date("Y-m-d", $this->unixtime) . "-$weeks week");
		}
	}
	
	/**
	 * Set the date from specified year and week number. Always is a monday.
	 *
	 * @param int $year is the year
	 * @param int $week is the week number
	 */
	public function setDateFromWeek($year, $week) {
		$this->unixtime = strtotime("01 January $year + $week weeks");
		$this->unixtime = $this->getMonday(true);
	}
  
}
