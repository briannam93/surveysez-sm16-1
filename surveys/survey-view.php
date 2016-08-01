<?php
/**
 *survey-view.php along with index.php creates a list/view application  
 *
 * @package SurveySez
 * @author Brianna Mori <brianna.mori@gmail.com>
 * @version 0.1 2016/07/25
 * @link http://www.briannamori.com/
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @see index.php
 * @see Pager.php 
 * @todo none
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
 
# check variable of item passed in - if invalid data, forcibly redirect back to ice-cream-list.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "surveys/index.php");
}

//sql statement to select individual item
//$sql = "select * from sm16_IceCream where IceCreamID = " . $myID;
//$sql = "select * from sm16_surveys where SurveyID = " . $myID;
//---end config area --------------------------------------------------

#$foundRecord = FALSE; # Will change to true, if record found!
   
$mySurvey= new Survey($myID);
    if($mySurvey->isValid)
    {//loads survey title in title tag
    $config->titleTag =$mySurvey->Title;  

    }else{
        $config->titleTag = 'Sorry, no such Survey!';

    }
        
//dumpDie($mySurvey); 
# connection comes first in mysqli (improved) function


# END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php
?>
<h3 align="center"><?=$config->titleTag?></h3>



<?php
get_footer(); #defaults to theme footer or footer_inc.php


class Survey
{
    
    public $Title='';
    public $Description=''; 
    public $SurveyID=0; 
    public $isValid=false; 
    
    public function __construct($id)
    {//forcibly cast to an integer 
        $id=(int)$id; 
        $sql = "select * from sm16_surveys where SurveyID = " . $id;
        
        
        $result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()),                        E_USER_ERROR));

                if(mysqli_num_rows($result) > 0)
                    {#records exist - process
	                $this->SurveyID= $id;   
                    $isValid = true;	
	                   while ($row = mysqli_fetch_assoc($result))
	           {
                   $this->Title = dbOut($row['Title']);
                    $this->Description = dbOut($row['Description']);
                  
        
			     
	   }
}

            @mysqli_free_result($result); # We're done with the data!

        
        
        
        
        
    
    }#end Survey constructor
    
    
    
}#end Survey Class 