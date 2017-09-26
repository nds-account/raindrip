<?php
/**
 * @package Spider portfolio
 * @author Web-Dorado
 * @copyright (C) 2012 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');

class spidercatalogController extends JControllerLegacy
{
	 function display($cachable = false, $urlparams = false)
	{
		

		$modelName=JRequest::getVar( 'view'  );
			parent::display();
	}

}

?>