<?php
/**
 * @package Spider Catalog
 * @author Web-Dorado
 * @copyright (C) 2012 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
class spidercatalogViewshowproduct extends JViewLegacy

{

    function display($tpl = null)

    {
		$model = $this->getModel();
		$result = $model->showProduct();
        $this->assignRef( 'rows',	$result[0] );
		$this->assignRef( 'reviews_rows',	$result[1] );
        $this->assignRef( 'option',	$result[2] );
        $this->assignRef( 'params',	$result[3] );
		$this->assignRef( 'category_name',	$result[4] );
		 $this->assignRef( 'rev_page',	$result[5] );
		 $this->assignRef( 'reviews_count',	$result[6] );
    	$this->assignRef( 'rating',	$result[7] );
		$this->assignRef( 'voted',	$result[8] );
		
        parent::display($tpl);
    }
}
?>