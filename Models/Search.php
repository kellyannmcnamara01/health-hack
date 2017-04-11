<?php

/*Created By Rahul Malik*/

require_once 'Database.php';

class Search
{
    private $Connection;
	
    public function __construct() {		
		$db = new Database();
        $this->Connection = $db->getDbFromAWS();	
		$this->Connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
	}	
    public function Search($SearchTxt)
	{

        $Criteria= "%".$SearchTxt."%";
		$ResultSet=array();
		
		$select = "SELECT name as title,marker_id as id FROM GYMS WHERE name LIKE :Criteria";
        //prepare query
        $SearchQry = $this->Connection->prepare($select);
        //bind values
        $SearchQry->bindValue(":Criteria", $Criteria);	
     
        $SearchQry->execute();
		
        $Result = $SearchQry->fetchAll();
		
		foreach($Result as $Item)
		{
			$Item['table']="GYM";
			$ResultSet[]=$Item;
		}
		
		$select = "SELECT list_name as title,list_id as id FROM GROCERY_LISTS WHERE list_name LIKE :Criteria or list_details like :Criteria";
        //prepare query
        $SearchQry = $this->Connection->prepare($select);
        //bind values
        $SearchQry->bindValue(":Criteria", $Criteria);	
     
        $SearchQry->execute();
		
        $Result = $SearchQry->fetchAll();
		
		foreach($Result as $Item)
		{
			$Item['table']="GROCERY";
			$ResultSet[]=$Item;
		}
		return $ResultSet;
	}
	public function SearchDetail($SearchID,$SearchTable)
	{
		
		if($SearchTable=="GYM")
		{
			$select = "SELECT name as title, address as details FROM GYMS WHERE marker_id=:Criteria";
			
		}
		else if($SearchTable=="GROCERY")
		{
			$select = "SELECT list_name as title,list_details as details FROM GROCERY_LISTS WHERE list_id=:Criteria";
		}
		
		//prepare query
		$SearchQry = $this->Connection->prepare($select);
		//bind values
		$SearchQry->bindValue(":Criteria", $SearchID);	
		$SearchQry->execute();
		
		$Result = $SearchQry->fetch();
		return $Result;
	}

}