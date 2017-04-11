<?php
class Calendar {
    public $month;
    public $year;
    public $day;
    private $headings = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    private $headingsm = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    private $db;
    private $user;

    public function setDb($db) {
        $this->db = $db;
    }

    function __construct($month, $year, $userId) {
        $this->month = $month;
        $this->year = $year;
        $this->day = date("d");
        $this->user = $userId;
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
        $controls = '<form method="get">'.$select_month_control.$select_year_control.'<div class="form-group"><input type="submit" value="Go" class="btn btn-success" /></div>'.$previous_month_link.$next_month_link.'</form>';

        return $controls;
    }
/*
    public function getRoutines() {
        $query = "select * from ROUTINES";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $routines = $statement->fetchAll();
        return $routines;
    }*/

    public function getRoutinesByDay($day) {
        $workouts = array($day."_strength", $day."_cardio");
        $query = "select routine_id, name, $workouts[0], $workouts[1] from ROUTINES
                  where ($workouts[0] IS NOT NULL OR $workouts[1] IS NOT NULL)
                        AND user_id = :userID AND active = 'Yes'";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':userID', $this->user);
        $statement->execute();
        $routines = $statement->fetchAll();
        return $routines;
    }

    public function getWorkoutById($type, $id)
    {
        $workout_name = "";
        if ($type == "cardio") {
            $query = "select name from CARDIO_WORKOUTS where cardio_id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindValue(":id", $id);
            $statement->execute();
            $workout = $statement->fetch();
            $workout_name = $workout['name'];
        } else {
            $query = "select strength_workout_name from STRENGTH_WORKOUTS where strength_id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindValue(":id", $id);
            $statement->execute();
            $workout = $statement->fetch();
            $workout_name = $workout['strength_workout_name'];
        }
        return $workout_name;
    }

    public function createCalendarEvent($day) {
        $output = "";
        $type = "";
        $workouts = array($day."_strength", $day."_cardio");

        $routines = $this->getRoutinesByDay($day);
        foreach($routines as $routine)
        {
            $output .= "<div class='routine'><div><strong>Routine: ".$routine['name']."</strong></div>";
            for ($i = 0; $i < count($workouts); ++$i)
            {
                $type = ($i == 0) ? "strength" : "cardio";
                if (isset($routine[$workouts[$i]])) 
                {
                    $output .= "<div><span>".$this->getWorkoutById($type, $routine[$workouts[$i]])."</span></div>";
                }
            }
            $output .= "</div>";
        }
        return $output;
    }

    public function drawMobile()
    {
        $curDay = date('d', strtotime($this->year.'-'.$this->month.'-'.$this->day));
        $curMonday = date('d', strtotime('Monday this week', strtotime($this->year.'-'.$this->month.'-'.$this->day)));
        $dayCounter = $curMonday;
        
        $calendar = "<div class='calendar'>";

        foreach($this->headingsm as $heading) :
            if ($dayCounter == $curDay) {
                $calendar .= "<div class='day-of-week current-day'>";
            } else {
                $calendar .= "<div class='day-of-week'>";
            }
            $calendar .= "<div><span>".$dayCounter."</span></div>";
            $calendar .= "<div><strong>".$heading."</strong></div>";

            $calendar .= '<div class="routines">';
            switch (date('w', mktime(0, 0, 0, $this->month, $dayCounter, $this->year))) 
            {
                case 0 :
                    $calendar .= $this->createCalendarEvent('sunday');
                    //$calendar .= $this->createCalendarEvent('sunday_cardio');
                    break;
                case 1:
                    $calendar .= $this->createCalendarEvent('monday');
                    //$calendar .= $this->createCalendarEvent('monday_cardio');
                    break;
                case 2:
                    $calendar .= $this->createCalendarEvent('tuesday');
                    //$calendar .= $this->createCalendarEvent('tuesday_cardio');
                    break;
                case 3:
                    $calendar .= $this->createCalendarEvent('wednesday');
                    //$calendar .= $this->createCalendarEvent('wednesday_cardio');
                    break;
                case 4:
                    $calendar .= $this->createCalendarEvent('thursday');
                    //$calendar .= $this->createCalendarEvent('thursday_cardio');
                    break;
                case 5:
                    $calendar .= $this->createCalendarEvent('friday');
                    //$calendar .= $this->createCalendarEvent('friday_cardio');
                    break;
                case 6:
                    $calendar .= $this->createCalendarEvent('saturday');
                    //$calendar .= $this->createCalendarEvent('saturday_cardio');
                    break;
                default :
                    break;
            }
            $calendar .= '</div>';

            $calendar .= "</div>";
            ++$dayCounter;
        endforeach;

        $dayCounter = $curMonday;

        $calendar .= "</div>";

        return $calendar;
    }

    public function draw() {
        //echo $this->user;
        echo '<div class="calendar-feature col-md-9 col-sm-9">';
        echo $this->getControls();
        //$strength_routines = $this->getRoutines();
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
            if (date("d") == $list_day && date("m") == $this->month && date('Y') == $this->year) {
                $calendar .= '<td class="calendar-day today"><div>';
            } else {
                $calendar .= '<td class="calendar-day"><div>';
            }
            
            // add in the day number
            $calendar .= '<div class="day-number">'.$list_day.'</div>';

            // add events for the day
            $event_day = $this->year.'-'.$this->month.'-'.$list_day;

            $calendar .= '<div class="event">';
            switch (date('w', mktime(0, 0, 0, $this->month, $list_day, $this->year))) 
            {
                case 0 :
                    $calendar .= $this->createCalendarEvent('sunday');
                    //$calendar .= $this->createCalendarEvent('sunday_cardio');
                    break;
                case 1:
                    $calendar .= $this->createCalendarEvent('monday');
                    //$calendar .= $this->createCalendarEvent('monday_cardio');
                    break;
                case 2:
                    $calendar .= $this->createCalendarEvent('tuesday');
                    //$calendar .= $this->createCalendarEvent('tuesday_cardio');
                    break;
                case 3:
                    $calendar .= $this->createCalendarEvent('wednesday');
                    //$calendar .= $this->createCalendarEvent('wednesday_cardio');
                    break;
                case 4:
                    $calendar .= $this->createCalendarEvent('thursday');
                    //$calendar .= $this->createCalendarEvent('thursday_cardio');
                    break;
                case 5:
                    $calendar .= $this->createCalendarEvent('friday');
                    //$calendar .= $this->createCalendarEvent('friday_cardio');
                    break;
                case 6:
                    $calendar .= $this->createCalendarEvent('saturday');
                    //$calendar .= $this->createCalendarEvent('saturday_cardio');
                    break;
                default :
                    break;
            }
            $calendar .= '</div>';

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