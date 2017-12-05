<?php


trait  DateComparator
{

    /**
     * @param array $date1 ['start_date', 'end_date']
     * @param array $date2 ['start_date', 'end_date']
     * @return boolean
     */
    public function dateBetween(array $date1, array $date2)
    {
        $date2StartDate = strtotime($date2['start_date']);
        $date2SEndDate = strtotime($date2['end_date']);
        $between1 = strtotime($date1['start_date']);
        $between2 = strtotime($date1['end_date']);
        // date2 -> start_date is between $date1
        if (($between1 <= $date2StartDate) && ($between2 >= $date2StartDate)) {
            return true;
        } elseif (($between1 <= $date2SEndDate) && ($between2 >= $date2SEndDate)) {
            return true;
        } else {
            return false;
        }
    }
}