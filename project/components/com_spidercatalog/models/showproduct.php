<?php
/**
 * @package Spider Catalog
 * @author Web-Dorado
 * @copyright (C) 2012 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined ('_JEXEC')  or  die();
jimport( 'joomla.application.component.model' );

class spidercatalogModelshowproduct extends JModelLegacy
{
	function showProduct()
	{
	$mainframe = JFactory::getApplication();
	$input=JFactory::getApplication()->input;
	$option=JRequest::getVar('option');
	
	$params = new jsshparams;

	$rev_page=JRequest::getVar('rev_page', 1);

	$product_id= JRequest::getVar('product_id', 0);
	$db = JFactory::getDBO();

	
	
	


	$query = "SELECT #__spidercatalog_products.*, #__spidercatalog_product_categories.name as cat_name FROM #__spidercatalog_products left join #__spidercatalog_product_categories on  #__spidercatalog_products.category_id=#__spidercatalog_product_categories.id where
	#__spidercatalog_products.id='".$db->escape($product_id)."' and #__spidercatalog_products.published = '1' ";

	$db->setQuery( $query );

	$rows = $db->loadObjectList();

	if ($db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}

	foreach($rows as $row)
		{
			$category_id=$row->category_id;
		}

		$query= "SELECT * FROM #__spidercatalog_product_categories WHERE id = '".$db->escape(@$category_id )."' ";

		$db->setQuery($query);

		$row1 = $db->loadAssoc();
		$category_name=$row1['name'];
		$full_name=JRequest::getVar('full_name','');
		$message_text=JRequest::getVar('message_text','');

		$row = JTable::getInstance('reviews', 'Table');
		$row->name=$full_name;
		$row->content=$message_text;
		$row->product_id=$product_id;
		$row->remote_ip =$_SERVER['REMOTE_ADDR'];



		$session = JFactory::getSession();

		$code=JRequest::getVar('code','');



				if($code!='' and $full_name!='' and $code==$session->get( 'captcha_code', '' ) )
					{
						if (!$row->store())
							{
								echo "<script> alert('".$row->getError()."');
								window.history.go(-1); </script>\n";
								exit();
							}
						else
							{
								$mainframe->redirect($_SERVER["REQUEST_URI"]);
							}
					}

				
	$reviews_perpage=$params->get( 'reviews_perpage' );
					$query = "SELECT name,content FROM #__spidercatalog_product_reviews where product_id='".$db->escape($product_id )."' order by id desc  limit ".(($rev_page-1)*$reviews_perpage).",$reviews_perpage ";

					$db->setQuery( $query );
					$reviews_rows = $db->loadObjectList();
					if ($db->getErrorNum())
						{
							echo $db->stderr();
							return false;
						}

	$query_count = "SELECT count(#__spidercatalog_product_reviews.id) as reviews_count FROM #__spidercatalog_product_reviews  WHERE product_id='".$db->escape($product_id )."' ";

	$db->setQuery($query_count);
	$row = $db->loadAssoc();
	$reviews_count=$row['reviews_count'];



	$query= "SELECT AVG(vote_value) as rating FROM #__spidercatalog_product_votes  WHERE product_id = '".$db->escape($product_id )."' ";

		$db->setQuery($query);

		$row1 = $db->loadAssoc();

		$rating=substr($row1['rating'],0,3);

		$query= "SELECT vote_value FROM #__spidercatalog_product_votes  WHERE product_id = '".$db->escape($product_id )."' and remote_ip='".$_SERVER['REMOTE_ADDR']."' ";

		$db->setQuery($query);
		$db->execute();
		$voted=$db->getNumRows();

		return array($rows,$reviews_rows, $option, $params,$category_name,$rev_page,$reviews_count,$rating,$voted);

	}
}
?>