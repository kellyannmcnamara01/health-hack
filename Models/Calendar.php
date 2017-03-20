<?php
class Calendar {
    private $month;
    private $year;
    private $headings = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    private $db;

    public function setDb($db) {
        $this->db = $db;
    }

    function __construct($month, $year, $events = array()) {
        $this->month = $month;
        $this->year = $year;
        $this->events = $events;
    }

    public function getControls() {
        // date settings
        $this->month = isset($_GET['month']) ? $_GET['month'] : date('m');
        $this->year = isset($_GET['year']) ? $_GET['year'] : date('Y');

        // select month control
        $select_month_control = '<div class="form-group"><select name="month" id="month" class="form-control">';
        for($x = 1; $x <= 12; $x++) :
            $select_month_control .= '<option value="'.$x.'"'.($x != $this->month ? '' : ' selected="selected"').'>'.date('F', mktime(0, 0, 0, $x, 1, $this->year)).'</oprion>';
        endfor;
        $select_month_control .= '</select></div>';

        // select year control 
        $year_range = 7;
        $select_year_control = '<div class="form-group"><select name="year" id="year" class="form-control">';
        for($x = $this->year - floor($year_range/2); $x <= ($this->year + floor($year_range/2)); $x++) :
            $select_year_control .= '<option value="'.$x.'"'.($x != $this->year ? '' : ' selected="selected"').'>'.$x.'</option>';
        endfor;
        $select_year_control .= '</select></div>';

        // "next month" control
        $next_month_link = '<div class="form-group"><a href="?month='.($this->month != 12 ? $this->month + 1 : 1).'&year='.($this->month != 12 ? $this->year : $this->year + 1).'" class="control">Next Month</a></div>';

        // "previous month" control
        $previous_month_link = '<div class="form-group"><a href="?month='.($this->month != 1 ? $this->month - 1 : 12).'&year='.($this->month != 1 ? $this->year : $this->year - 1).'" class="control">Previous Month</a></div>';

        // bridging the controls together
        $controls = '<form method="get" class="form-inline">'.$select_month_control.$select_year_control.'<div class="form-group"><input type="submit" value="Go" class="btn btn-success" /></div>'.$previous_month_link.$next_month_link.'</form>';

        return $controls;
    }

    public function getRoutines() {
        $query = "select routine_id, name, monday_strength, tuesday_strength, wednesday_strength, thursday_strength, friday_strength, saturday_strength, sunday_strength from routines";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $strength_routines = $statement->fetchAll();
        return $strength_routines;
    }

    public function getEvents() {
        //require_once('database_events.php');
        $query = "select name, DATE_FORMAT(start_date, '%Y-%m-%d') as start_date from events where start_date LIKE :date";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':date', $this->year.'-'.$this->month.'%');
        $statement->execute();
        $events = $statement->fetchAll();
        $statement->closeCursor();
        foreach($events as $event):
            $this->events[$event['start_date']][] = $event;
        endforeach;
    }

    public function createCalendarEvent($day) {
        $output = "";
        $strength_routines = $this->getRoutines();
        foreach($strength_routines as $strength_routine)
        {
            $output .= "<div>";
            if (isset($strength_routine[$day])) 
            {
                $output .= $strength_routine['name'] . " / " . $strength_routine[$day];
            }
           $output .= "</div>";
        }
        return $output;
    }

    public function draw() {
        echo '<div class="calendar-feature col-md-9 col-sm-9">';
        echo $this->getControls();
        $strength_routines = $this->getRoutines();
        //var_dump($strength_routines);
        // draw table
        $calendar = '<table class="calendar">';

        // table row with headings
        $calendar .= '<tr class="calendar-row">';
        foreach($this->headings as $heading) :
            $calendar .= '<td class="calendar-day-head">'.$heading.'</td>';
        endforeach;
        $calendar .= '</tr>';

        // days and weeks vars now ...
        $running_day = date('w', mktime(0, 0, 0, $this->month, 1, $this->year));
        $days_in_month = date('t', mktime(0, 0, 0, $this->month, 1, $this->year));
        $days_in_this_week = 1;
        $day_counter = 0;

        // row for week one
        $calendar .= '<tr class="calendar-row">';

        // print "blank" days until first of the current week
        for($x = 0; $x < $running_day; ++$x) :
            $calendar .= '<td class="calendar-day-np">&nbsp;</td>';
            $days_in_this_week++;
        endfor;

        //keep going with days....
        for($list_day = 1; $list_day <= $days_in_month; $list_day++) :
            $calendar .= '<td class="calendar-day"><div>';
            
            // add in the day number
            $calendar .= '<div class="day-number">'.$list_day.'</div>';

            // add events for the day
            $event_day = $this->year.'-'.$this->month.'-'.$list_day;

            $calendar .= '<div class="event">';
            switch (date('w', mktime(0, 0, 0, $this->month, $list_day, $this->year))) 
            {
                case 0 :
                    $calendar .= $this->createCalendarEvent('sunday_strength');
                    break;
                case 1:
                    $calendar .= $this->createCalendarEvent('monday_strength');
                    break;
                case 2:
                    $calendar .= $this->createCalendarEvent('tuesday_strength');
                    break;
                case 3:
                    $calendar .= $this->createCalendarEvent('wednesday_strength');
                    break;
                case 4:
                    $calendar .= $this->createCalendarEvent('thursday_strength');
                    break;
                case 5:
                    $calendar .= $this->createCalendarEvent('friday_strength');
                    break;
                case 6:
                    $calendar .= $this->createCalendarEvent('saturday_strength');
                    break;
                default :
                    echo "Not Sunday";
                    break;
            }
            $calendar .= '</div>';
            //echo $this->events[$event_day];
            /*
            if (isset($this->events[$event_day])) {
                foreach($this->events[$event_day] as $event) :
                    $calendar .= '<div class="event">'.$event['name'].'</div>';
                endforeach;
            } else {
                $calendar .= str_repeat('<p>&nbsp;</p>', 2);
            }
            */
            $calendar .= '</div></td>';

            if ($running_day == 6) :
                $calendar .= '</tr>';
                if (($day_counter + 1) != $days_in_month):
                    $calendar .= '<tr class="calendar-row">';
                endif;
                $running_day = -1;
                $days_in_this_week = 0;
            endif;
            $days_in_this_week++;
            $running_day++;
            $day_counter++;
        endfor;

        // finish the rest of the days in the week
        if ($days_in_this_week != 1) :
            for($x = 1; $x <= 8 - $days_in_this_week; $x++):
                $calendar .= '<td class="calendar-day-np"></td>';
            endfor;
        endif;

        // final row
        $calendar .= '</tr>';

        // end the table
        $calendar .= '</table></div></main>';
        return $calendar;
    }
}
?>