<?php 


namespace Mapes\CMSBundle\Utils;

class dateUtils {
    
        public static $_ServerTimeZone = 'Australia/Canberra';

        public static function getPrettyDate( $date )

        {

		$phpdate = strtotime( $date );

		return date("jS M Y", $phpdate);

        }



        public static function getPointsExpiredDate()

        {

                $valid_days = formUtils::getDaysOfPointsBeValid() + 0;

                $expired_dt = date('y-m-d', time() + $valid_days * 86400);  

                return $expired_dt;

        }



        public static function convertJQueryDate($dateArray)

        {

                $year = $dateArray['year'] == '' ? date('Y') : $dateArray['year'];

                if ($dateArray['month'] == '')

                {

                    $month = date('m');

                }

                else

                {

                    $month = strlen($dateArray['month']) == 1 ? '0'.$dateArray['month'] : $dateArray['month'];

                }

                if ($dateArray['day'] == '')

                {

                    $day = date('d');

                }

                else

                {

                    $day = strlen($dateArray['day']) == 1 ? '0'.$dateArray['day'] : $dateArray['day'];

                }

                return $year."-".$month."-".$day;

        }



        public static function add_year($orgDate,$yr){

          $cd = strtotime($orgDate);

          $retDAY = date('Y-m-d H:i:s', mktime(date("H",$cd), date("i",$cd), date("s",$cd),date('m',$cd),date('d',$cd),date('Y',$cd)+$yr));

          return $retDAY;

        }



        public static function add_month($orgDate,$mth){

          $cd = strtotime($orgDate);

          $retDAY = date('Y-m-d H:i:s', mktime(date("H",$cd), date("i",$cd), date("s",$cd),date('m',$cd)+$mth,date('d',$cd),date('Y',$cd)));

          return $retDAY;

        }



        public static function add_date($orgDate,$day){

          $cd = strtotime($orgDate);

          $retDAY = date('Y-m-d H:i:s', mktime(date("H",$cd), date("i",$cd), date("s",$cd),date('m',$cd),date('d',$cd)+$day,date('Y',$cd)));

          return $retDAY;

        }

        public static function add_hour($orgTime, $hour){

          $cd = strtotime($orgTime);

          $retTime = date('Y-m-d H:i:s', mktime(date("H",$cd)+$hour, date("i",$cd), date("s",$cd),date('m',$cd),date('d',$cd),date('Y',$cd)));
          
          return $retTime;

        }
        
        public static function add_minute($orgTime, $minute){

          $cd = strtotime($orgTime);

          $retTime = date('Y-m-d H:i:s', mktime(date("H",$cd), date("i",$cd)+$minute, date("s",$cd),date('m',$cd),date('d',$cd),date('Y',$cd)));
          
          return $retTime;

        }

        public static function date_diff($date, $date2 = 0)
        {
            if(!$date2)
                $date2 = time();

            $date_diff = array('seconds'  => '',
                               'minutes'  => '',
                               'hours'    => '',
                               'days'     => '',
                               'weeks'    => '',

                               'tseconds' => '',
                               'tminutes' => '',
                               'thours'   => '',
                               'tdays'    => '',
                               'tdays'    => '');


            if($date2 > $date)
                $tmp = $date2 - $date;
            else
                $tmp = $date - $date2;

            $seconds = $tmp;

            // Relative ////////
            $date_diff['weeks'] = floor($tmp/604800);
            $tmp -= $date_diff['weeks'] * 604800;

            $date_diff['days'] = floor($tmp/86400);
            $tmp -= $date_diff['days'] * 86400;

            $date_diff['hours'] = floor($tmp/3600);
            $tmp -= $date_diff['hours'] * 3600;

            $date_diff['minutes'] = floor($tmp/60);
            $tmp -= $date_diff['minutes'] * 60;

            $date_diff['seconds'] = $tmp;

            // Total ///////////
            $date_diff['tweeks'] = floor($seconds/604800);
            $date_diff['tdays'] = floor($seconds/86400);
            $date_diff['thours'] = floor($seconds/3600);
            $date_diff['tminutes'] = floor($seconds/60);
            $date_diff['tseconds'] = $seconds;

            return $date_diff;
        }
        
        public static function convertServerTimeToLocalTime($datetime_string, $timezone)
        {
            $datetime = new DateTime($datetime_string, new DateTimeZone(self::$_ServerTimeZone));

            $datetime->setTimezone(new DateTimeZone($timezone));
            
            return $datetime->format('Y-m-d H:i:s');
            
        }
        
        public static function convertLocalTimeToServerTime($datetime_string, $timezone)
        {
            $datetime = new DateTime($datetime_string, new DateTimeZone($timezone));

            $datetime->setTimezone(new DateTimeZone(self::$_ServerTimeZone));
            
            return $datetime->format('Y-m-d H:i:s');
            
        }
        
        public static function convertLocalTimeToUTCTime($datetime_string, $timezone)
        {
            $datetime = new DateTime($datetime_string, new DateTimeZone($timezone));
            $datetime->setTimezone(new DateTimeZone('UTC'));

            return $datetime->format('Ymd\THis\Z');            
        }
        
        public static function convertServerTimeToUTCTime($datetime_string)
        {
            $datetime = new DateTime($datetime_string, new DateTimeZone(self::$_ServerTimeZone));
            $datetime->setTimezone(new DateTimeZone('UTC'));

            return $datetime->format('Ymd\THis\Z');            
        }
        
        public static function add_date_exclude_weekend($orgDate, $day)
        {
            
            $d = $orgDate;
            for($i=0; $i < $day; $i++){

                // get what day it is next day
                $nextDay = date('w', strtotime(self::add_date($d, 1)));

                // if it's Saturday or Sunday get $i-1
                if($nextDay == 0 || $nextDay == 6) {
                    $i--;
                }

                $d = self::add_date($d, 1);
            }
            
            return date("Y-m-d", strtotime($d));
        }
        
        public static function add_hour_exclude_weekend($orgDate, $hour)
        {
            $day = floor($hour / 24);
            
            $leftHour = $hour % 24;
            
            $d = $orgDate;
            for($i=0; $i < $day; $i++){

                // get what day it is next day
                $nextDay = date('w', strtotime(self::add_date($d, 1)));

                // if it's Saturday or Sunday get $i-1
                if($nextDay == 0 || $nextDay == 6) {
                    $i--;
                }

                $d = self::add_date($d, 1);
            }
            
            if($leftHour != 0)
                $d = self::add_hour($d, $leftHour);
            
            return date("Y-m-d H:i:s", strtotime($d));
        }
        
        public static function getWorkingDate($orgDate)
        {
            $rtnDate = $orgDate;
            
            $day = date('w', strtotime($orgDate));
            
            if($day == 0) {
                $rtnDate = self::add_date($orgDate, 1);
            }elseif($day == 6){
                $rtnDate = self::add_date($orgDate, 2);
            }
            
            return $rtnDate;
        }

        /**
         * Returns the amount of weeks into the month a date is
         * @param $date a YYYY-MM-DD formatted date
         * @param $rollover The day on which the week rolls over
         * example : getWeeks("2011-06-11", "sunday");
         */        
        public static function getTotalWeeks($date, $rollover = 'sunday')
        {
            $cut = substr($date, 0, 8);
            $daylen = 86400;

            $timestamp = strtotime($date);
            $first = strtotime($cut . "00");
            $elapsed = ($timestamp - $first) / $daylen;

            $i = 1;
            $weeks = 1;

            for($i; $i<=$elapsed; $i++)
            {
                $dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
                $daytimestamp = strtotime($dayfind);

                $day = strtolower(date("l", $daytimestamp));

                if($day == strtolower($rollover))  $weeks ++;
            }

            return $weeks;
        }        
        
        /*
         * Return example : first Monday, second Friday, last Sunday
         */
        public static function getNthWeekday($date){
            
            $weekdays = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
            $prefixes = array('first', 'second', 'third', 'fourth', 'last');
            
            $day = date('j', strtotime($date));
            $week = floor(($day - 1)/7) + 1;

            if(self::getWeekOfTheMonth($date) >= 5){
                return 'last ' + $weekdays[date('w', strtotime($date))];
            }else{
                return $prefixes[$week - 1] + ' ' + $weekdays[date('w', strtotime($date))];
            }
            
        }
        
        public static function getDateForGivenRelativeDay($the_week, $the_day, $year, $month)
        {
            $firstDayInMonth = $year."-".$month."-01";
            $lastDayInMonth = dateUtils::add_date(dateUtils::add_month($firstDayInMonth, 1), -1);
            
            
            $rtnDate = "";
            $date = $firstDayInMonth;
            while ($date <= $lastDayInMonth){
                
                //echo $date." - ". self::getTheWeek($date)." - ".date('N', strtotime($date))."<br/>";
                if(self::getTheWeek($date) == $the_week && date('N', strtotime($date)) == $the_day){
                    $rtnDate = $date;
                    break;
                }
                $date = dateUtils::add_date($date, 1);
            }
            
            //die($rtnDate);
            
            
            return $rtnDate;
        }
        
        public static function getTheWeek($date) {
            
            $day = date("j", strtotime($date));
            
            $the_week = floor(($day - 1) / 7) + 1;
            
            if(self::getWeekOfTheMonth($date) >= 5){
                return 'LAST';
            }else{
                return $the_week;
            }
        }
        
        public static function getWeekOfTheMonth($date){
            
            $firstDateInMonth = date("Y-m-01", strtotime($date));
            
            $weekDayOfFirstDay = date("w", strtotime($firstDateInMonth));
            $day = date("j", strtotime($date));
            
            return ceil(($day + $weekDayOfFirstDay)/7);   
    
        }         
        
        
}

?>