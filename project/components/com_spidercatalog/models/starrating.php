<?php
/**
 * @package Spider Catalog
 * @author Web-Dorado
 * @copyright (C) 2012 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined ('_JEXEC')  or  die();

jimport( 'joomla.application.component.model' );

class spidercatalogModelstarrating extends JModelLegacy
{
	function starrating()
		{
			$input=JFactory::getApplication()->input;
			$db=&JFactory::getDBO();

			$option=$input->get('option');

			$product_id = $input->get('product_id', 0);

			$vote_value=$input->get('vote_value',0);

			$row =& JTable::getInstance('votes', 'Table');

			$row->product_id=$product_id;

			$row->vote_value=$vote_value;

			$row->remote_ip =$_SERVER['REMOTE_ADDR'];

			if (!$row->store())
				{
					echo "<script> alert('".$row->getError()."');
					window.history.go(-1); </script>\n";
					exit();
				}

	$query= "SELECT AVG(vote_value) as rating FROM #__spidercatalog_product_votes  WHERE product_id = '".$db->escape($product_id )."' ";

	$db->setQuery($query);

	$row1 = $db->loadAssoc();

	$rating=substr($row1['rating'],0,3);

			return array($product_id,$rating);

		}

}
?>