<?php
/**
 * @package Spider Catalog
 * @author Web-Dorado
 * @copyright (C) 2012 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined( '_JEXEC' ) or die( 'Restricted access' );



class JFormFieldsqlmultilistx extends JFormField
{
	protected $type = 'sqlmultilistx';

public function getInput() 
{
        ob_start();
        static $embedded;
                if(!$embedded)
        {

            $embedded=true;

        }
			$value=$this->value;
			
	
			
			 //print_r($this->element['sql']);
			 //exit;
			 $db =  JFactory::getDBO();
 $db->setQuery($this->element['sql']);   
 $key = ($this->element['key_field']? $this->element['key_field'] : 'value'); 
 $val = ($this->element['value_field'] ?$this->element['value_field'] : 'name');
 $options = array();    
 //foreach ($node->children() as $option)				{  
// $options[]= array($key=> $option->attributes('value'),$val => $option->data());
 //}              
 $rows = $db->loadAssocList(); 

 if($key=='id')

$key='id';
$val='name';

$options[]=array($key=>0,$val=>$this->element['default']); 
 foreach ($rows as $row)				{   
 
 // echo $row[$key1];
  //var_dump($rows) ;
$options[]=array($key=>$row[$key],$val=>$row[$val]);          
 }     

 if($options)
 {                        return JHTML::_('select.genericlist',$options, $this->name,'', $key, $val, $value, $this->name);                
           
}	
}}	   
/*
?>

<input type="text" name="<?php echo $this->name;?>" id="<?php echo  $this->id; ?>" value="<?php echo $value; ?>">
        <?php

        $content=ob_get_contents();

        ob_end_clean();
        return $content;

    }
	}
	*/
	?>