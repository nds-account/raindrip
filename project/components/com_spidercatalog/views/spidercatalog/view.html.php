<?php
/**
 * @package Spider Catalog
 * @author Web-Dorado
 * @copyright (C) 2012 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class spidercatalogViewspidercatalog extends JViewLegacy{    function display($tpl = null)    {
		$model = $this->getModel();
		$result = $model->showPublishedProducts();
		
        $this->assignRef( 'rows',	$result[0] );
        $this->assignRef( 'option',	$result[1] );
       	$this->assignRef( 'params',	$result[2] );
        $this->assignRef( 'page_num',	$result[3] );
        $this->assignRef( 'prod_count',	$result[4] );
        $this->assignRef( 'prod_in_page',	$result[5] );
		$this->assignRef( 'ratings',	$result[6] );
		$this->assignRef( 'voted',	$result[7] );
		$this->assignRef( 'categories',	$result[8] );
		$this->assignRef( 'category_list',	$result[9] );
		$this->assignRef( 'params1',	$result[10] );
		$this->assignRef( 'cat_rows',	$result[11] );
		$this->assignRef( 'cat_id',	$result[12] );
		$this->assignRef( 'child_ids',	$result[13] );
		$this->assignRef( 'categor',	$result[14] );
		$this->assignRef( 'par',	$result[15] );
		$this->assignRef( 'subcat_id',	$result[16] );	
        $this->assignRef( 'prod_name',	$result[17] );
		$display_type=JRequest::getVar('display_type',0);

		if($display_type=="cell"){
		$tpl=$display_type;
		
		}
		
		if($display_type=="list"){
		$tpl=$display_type;
		
		}
		
		if($display_type=="thumb"){
		$tpl=$display_type;
		
		}
		
		if($display_type=="cube"){
		$tpl=$display_type;
		
		}
		
		if($display_type=="cube2"){
		$tpl=$display_type;
		
		}
		
		if($display_type=="cube3"){
		$tpl=$display_type;
		
		}
		
        parent::display($tpl);
    }
}
?>