<?php

/**
 * Created by PhpStorm.
 * User: kellyannmcnamara
 * Date: 2017-03-12
 * Time: 12:33 PM
 */
class GroceryList
{
    //properties
    private $list_id, $list_name;

    //get list_id
    public function getListId()
    {
        return $this->list_id;
    }

    //set list_id
    public function setListId($list_id)
    {
        $this->list_id = $list_id;
    }

    //get list_name
    public function getListName()
    {
        return $this->list_name;
    }

    //set list_name
    public function setListName($list_name)
    {
        $this->list_name = $list_name;
    }
}