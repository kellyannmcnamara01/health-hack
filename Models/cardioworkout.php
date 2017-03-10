<?php

/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-09
 * Time: 6:04 PM
 */
class cardioworkout
{
    private $user_id, $name, $goal_distance, $goal_time;

    /**
     * @return mixed
     */


    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getGoalDistance()
    {
        return $this->goal_distance;
    }

    /**
     * @param mixed $goal_distance
     */
    public function setGoalDistance($goal_distance)
    {
        $this->goal_distance = $goal_distance;
    }

    /**
     * @return mixed
     */
    public function getGoalTime()
    {
        return $this->goal_time;
    }

    /**
     * @param mixed $goal_time
     */
    public function setGoalTime($goal_time)
    {
        $this->goal_time = $goal_time;
    }



}