<?php
 /**
 * @package Spider Contacts
 * @author Web-Dorado
 * @copyright (C) 2012 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
 // This php file generates CSV therefore direct access must be allowed
 
 
define( '_JEXEC', 1 );
define( 'JPATH_BASE', realpath(dirname(__FILE__).'/../..' ));
define( 'DS', DIRECTORY_SEPARATOR );

require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
$mainframe =& JFactory::getApplication('administrator');

$mainframe->initialise();
$user =& JFactory::getUser();
if ($user->guest)
{
	echo 'You have no permissions to download csv';
	return;
}
	
if(!(in_array(7,$user->groups) || in_array(8,$user->groups)))
{ 
	echo 'You have no permissions to download csv';
	return;
}
$dbo =& JFactory::getDBO();
function echocsv( $fields )
  {
	  $pattern = "/par_([a-zA-Z0-9\-]*)@asd@:@asd@(([a-zA-Z0-9\-(),.\+_]|\x20)*)/";
	

    $separator = '';
    foreach ( $fields as $field )
    {
		if ( substr_count($field, '@asd@:@asd@'))
		{
			$string = '';
			///////////////////////	
$par_data=explode("par_",$field);

for($j=0;$j<count($par_data);$j++)
	if($par_data[$j]!='')
	{

		$par1_data=explode("@@:@@",$par_data[$j]);

		$par_values=explode("	",$par1_data[1]);

				$countOfPar=0;
					for($k=0;$k<count($par_values);$k++)
						if($par_values[$k]!="")
						$countOfPar++;
	


		if($countOfPar!=0)
		{
		
               $string .= $par1_data[0].':'; 
                
							 for ($k = 0; $k < count($par_values); $k++)
                        if ($par_values[$k] != "")
                            $string.= $par_values[$k].', ' ;
							$string .= "\n";
                    
                   

		}
	}	
	
	////////////////////////
	$field = $string;
	}
		$field1 = $field;
	
		if ( preg_match_all(  $pattern ,$field, $res))
		{ 	$field1 ='';	  
		//print_r($res);
		   for ($i=0;$i<count($res[0]);$i++)
		   
		   {
			   $field1.=$res[1][$i].':'.$res[2][$i].' ';
						
	   }
		 }
		
		
      if ( preg_match( '/\\r|\\n|,|"/', $field1 ) )
      {
        $field1 = '"' . str_replace( '"', '""', $field1 ) . '"';
		
      }
      echo $separator . $field1;
      $separator = ',';
    }
    echo "\r\n";
  }
  $filename = 'export_'.date("d-m-y") . '.csv';
  
	JRequest::setVar('format','raw');
@ob_end_clean();  							 
@clearstatcache();
		header('Content-Description: File Transfer');							
		header( 'Content-Type: text/csv' );
		header( 'Content-Disposition: attachment;filename='.$filename.'' );
	
   
        
        $query = "SELECT #__spidercatalog_products.name AS 'Name',#__spidercatalog_products.category_id AS 'Category id',#__spidercatalog_products.description AS 'Description', #__spidercatalog_products.image_url AS 'Picture Url',#__spidercatalog_products.cost AS 'Cost',#__spidercatalog_products.market_cost AS 'Market Cost',#__spidercatalog_products.param AS 'Parameters',#__spidercatalog_products.ordering AS 'Ordering',#__spidercatalog_products.published AS 'Published',#__spidercatalog_products.published_in_parent AS 'Show in Parent',categories.name AS 'Category' FROM #__spidercatalog_products LEFT JOIN #__spidercatalog_product_categories  AS categories ON  #__spidercatalog_products.category_id=categories.id";
        $dbo->setQuery($query);
		if (!$dbo->query($query))
          {
			  echo 'aaaaaaaaa';
            echo $dbo->getErrorMsg();
          }
		  $result = $dbo->loadAssocList();
		  
		
//
// output header row (if atleast one row exists)
//

$row = $dbo->loadAssoc();


if ( $row )
{echocsv( array_keys( $row ) );}

//
// output data rows (if atleast one row exists)
//
 
foreach ($result as $row1)
{echocsv( $row1 );

}
  
 
  