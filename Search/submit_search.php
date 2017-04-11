<?php
/*Created By Rahul Malik*/
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
$user_id = 1;  //get it from session
$ModuleID=1;//get it from feature which is integrating this feature this system
if (isset($_POST['txtSearch']))
{
    //save the values

    $txtSearch = filter_input(INPUT_POST, 'txtSearch');
   

    require_once '../Models/Search.php';
    $SearchObj = new Search();
    $Result=$SearchObj->Search($txtSearch);
	
}
?>
<div id="main-content" class="col-md-9 col-sm-12 col-12 row" >
  
 
        
		 <div id="SearchTitle">Search Results</div>
          <div id="ResultContainer">
			
            <?php 
				if(count($Result)>0)
				{
					for($i=0;$i<count($Result);$i++) {
		    ?>
					  <div class="ResultTitleDiv">
						<a href="search-details.php?id=<?php echo($Result[$i]['id']);?>&tab=<?php echo($Result[$i]['table']);?>"><?php echo($Result[$i]['title']);?> </a>
					  </div>
             
             <?php  } ?>
			 <div class="Spacer"></div><div id="TotalResultDiv">Total Results Found: <?php echo(count($Result));?></div>
			 <?php
				}
				else
				{
			?>
			    <div id="NoResultDiv">No Result Found.</div>
		    <?php
			    
				}
				
			 ?>
          </div>
        

</div>
<?php
require_once '../Common Views/Footer.php';
?>