<?php
 /**
 * @package Spider Catalog
 * @author Web-Dorado
 * @copyright (C) 2012 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined( '_JEXEC' ) or die( 'Restricted access' );
$document =JFactory::getDocument();
$input=JFactory::getApplication()->input;
$document->addStyleSheet(JURI::root(true).'/components/com_spidercatalog/css/spidercatalog_main.css');
$document->addScript(JURI::root(true).'/components/com_spidercatalog/js/common.js');
$document->addScript('components/com_spidercatalog/spiderBox/spiderBox.js.php?delay=3000&allImagesQ=0&slideShowQ=0&darkBG=1&juriroot='.urlencode(JURI::root(false)).'&spiderShop=1');



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$db =JFactory::getDBO();
////////////////////////////////////////////update mysql///////////////////////////////////////////////////////////////


$query="CREATE TABLE IF NOT EXISTS `#__spidercatalog_id` (
  `id1` int(11)  NOT NULL AUTO_INCREMENT,
  `proid` int(11) NOT NULL,
   `cateid` int(11) NOT NULL,
  
  PRIMARY KEY (`id1`)

) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3";


$db->setQuery($query);
$db->Query();


$result = "SHOW columns FROM #__spidercatalog_products";
$db->setQuery($result);
$cols=$db->loadObjectList();
//print_r($cols[0]);
$type=$cols[2]->Type;
//echo $type;

///////////////////////////////////////////////Desighn Update/////////////////////////////////////////////////////////////////


$resultp = "Select value FROM #__spidercatalog_params WHERE name='params_background_color1' ";
$db->setQuery($resultp);
$colsp=$db->loadObject();
//print_r($colsp->value);
if($type=="int(11) unsigned"){

$query="UPDATE `#__spidercatalog_params` SET  `value` =  '290' WHERE `name` ='product_cell_width'";
$db->setQuery($query);
$db->Query();
$query="UPDATE `#__spidercatalog_params` SET  `value` =  '665' WHERE `name` ='product_cell_height'";
$db->setQuery($query);
$db->Query();
$query="UPDATE `#__spidercatalog_params` SET  `value` =  'F4F2F2' WHERE `name` ='params_background_color1'";
$db->setQuery($query);
$db->Query();
$query="UPDATE `#__spidercatalog_params` SET  `value` =  'F4F2F2' WHERE `name` ='params_background_color2'";
$db->setQuery($query);
$db->Query();
$query="UPDATE `#__spidercatalog_params` SET  `value` =  'FFFFFF' WHERE `name` ='background_color'";
$db->setQuery($query);
$db->Query();
$query="UPDATE `#__spidercatalog_params` SET  `value` =  'ridge' WHERE `name` ='border_style'";
$db->setQuery($query);
$db->Query();
$query="UPDATE `#__spidercatalog_params` SET  `value` =  '0' WHERE `name` ='border_width'";
$db->setQuery($query);
$db->Query();
$query="UPDATE `#__spidercatalog_params` SET  `value` =  '636363' WHERE `name` ='text_color'";
$db->setQuery($query);
$db->Query();
$query="UPDATE `#__spidercatalog_params` SET  `value` =  'FFFFFF' WHERE `name` ='price_color'";
$db->setQuery($query);
$db->Query();
$query="UPDATE `#__spidercatalog_params` SET  `value` =  'FFFFFF' WHERE `name` ='title_background_color'";
$db->setQuery($query);
$db->Query();
$query="UPDATE `#__spidercatalog_params` SET  `value` =  '210' WHERE `name` ='small_picture_width'";
$db->setQuery($query);
$db->Query();
$query="UPDATE `#__spidercatalog_params` SET  `value` =  '140' WHERE `name` ='small_picture_height'";
$db->setQuery($query);
$db->Query();
$query="UPDATE `#__spidercatalog_params` SET  `value` =  '300' WHERE `name` ='large_picture_width'";
$db->setQuery($query);
$db->Query();
$query="UPDATE `#__spidercatalog_params` SET  `value` =  '200' WHERE `name` ='large_picture_height'";
$db->setQuery($query);
$db->Query();
$query="UPDATE `#__spidercatalog_params` SET  `value` =  'F4F4F4' WHERE `name` ='review_background_color'";
$db->setQuery($query);
$db->Query();
$query="UPDATE `#__spidercatalog_params` SET  `value` =  '200' WHERE `name` ='category_picture_height'";
$db->setQuery($query);
$db->Query();
$query="UPDATE `#__spidercatalog_params` SET  `value` =  '300' WHERE `name` ='category_picture_width'";
$db->setQuery($query);
$db->Query();
$query="UPDATE `#__spidercatalog_params` SET  `value` =  '004372' WHERE `name` ='title_color'";
$db->setQuery($query);
$db->Query();




$db->setQuery($query);
$db->Query();
$query="INSERT INTO `#__spidercatalog_params` (`id`, `name`, `title`, `description`, `value`) VALUES
(97, 'cell_big_title_size', 'Cell Big Title Size', 'Cell Big Title Size', '24'),
(98, 'cell_price_background_color', 'Cell Price Background Color', 'Cell Price Background Color', '004372'),
(99, 'cell_small_image_backround_color', 'Cell Small Image Backround Color', 'Cell Small Image Backround Color', 'DDDBDB'),
(100, 'cell_parameters_left_size', 'Cell Parameters Left Size', 'Cell Parameters Left Size', '13'),
(101, 'cell_more_font_size', 'Cell More Font size', 'Cell More Font size', '15'),
(102, 'cell_more_font_color', 'Cell More Font Color', 'Cell More Font Color', 'FFFFFF'),
(103, 'cell_more_background_color', 'Cell More Background Color', 'Cell More Background Color', '004372'),
(104, 'cell_params_text_color', 'Cell Params Text Color', 'Cell Params Text Color', '3E3E3E'),
(105, 'product_back_add_your_review_here', 'Product back Add your review here', 'Product back Add your review here', '004372'),
(106, 'product_big_title_size', 'Product Big Title Size', 'Product Big Title Size', '28'),
(107, 'product_price_background_color', 'Product Price Background color', 'Product Price Background color', '004372'),
(108, 'cell_new_big_title_size', 'Cell New Big Title Size', 'Cell New Big Title Size', '20'),
(109, 'cell_new_title_size', 'Cell New Title Size', 'Cell New Title Size', '10'),
(110, 'cell_new_price_size', 'Cell New Price Size', 'Cell New Price Size', '20'),
(111, 'cell_new_market_price_size', 'Cell New Market Price Size', 'Cell New Market Price Size', '12'),
(112, 'cell_new_picture_width', 'Cell New Picture Width', 'Cell New Picture Width', '110'),
(113, 'cell_new_picture_height', 'Cell New Picture Height', 'Cell New Picture Height', '95'),
(114, 'cell_new_title_color', 'Cell New Title Color', 'Cell New Title Color', '004372'),
(115, 'new_cell_all_width', 'New Cell Width', 'New Cell Width', '290'),
(116, 'new_cell_all_height', 'New Cell All Height', 'New Cell All Height', '550'),
(117, 'cell_new_text_size', 'Cell New Text Size', 'Cell New Text Size', '12'),
(118, 'cell_new_text_back_color_1', 'Cell New Text Background Color 1', 'Cell New Text Background Color 1', 'F6F6F6'),
(119, 'cell_new_text_back_color_2', 'Cell New Text Background Color 2', 'Cell New Text Background Color 2', 'F0EDED'),
(120, 'cell_new_text_color', 'Cell New Text Color', 'Cell New Text Color', '3D3D3D'),
(121, 'new_cell_more_font_size', 'New Cell More Font Size', 'New Cell More Font Size', '17'),
(122, 'cell_new_more_font_color', 'More Font Color', 'More Font Color', 'FFFFFF'),
(123, 'cell_new_more_background_color', 'More Background Color', 'More Background Color', '004372'),
(124, 'cell_tumble_title_size', 'Title Size', 'Title Size', '10'),
(125, 'cell_tumble_title_font_color', 'Title Font Color', 'Title Font Color', '004372'),
(126, 'cell_tumble_price_size', 'Price Size', 'Price Size', '14'),
(127, 'cell_tumble_price_text_color', 'Price Text Color', 'Price Text Color', 'FFFFFF'),
(128, 'cell_tumble_picture_width', 'Picture Width', 'Picture Width', '120'),
(129, 'cell_tumble_picture_height', 'Picture Height', 'Picture Height', '120'),
(130, 'cell_tumble_text_size', 'Text Size', 'Text Size', '10'),
(131, 'cell_tumble_text_color', 'Text Color', 'Text Color', '434242'),
(132, 'cell_tumble_all_width', 'All Width', 'All Width', '290'),
(133, 'cell_tumble_all_height', 'All Height', 'All Height', '225'),
(134, 'all_cell_title_size', 'Title Size', 'Title Sizes', '12'),
(135, 'all_cell_title_color', 'Title Color', 'Title Color', '004372'),
(136, 'all_cell_price_size', 'Price Size', 'Price Size', '13'),
(137, 'all_cell_price_text_color', 'Price Text Color', 'Price Text Color', 'FFFFFF'),
(138, 'all_cell_picture_width', 'Picture Width', 'Picture Width', '285'),
(139, 'all_cell_picture_height', 'Picture Height', 'Picture Height', '200'),
(140, 'all_cell_text_size', 'Text Size', 'Text Size', '10'),
(141, 'all_cell_text_color', 'Text Color', 'Text Color', '434242'),
(142, 'all_cell_all_width', 'All Width', 'All Width', '290'),
(143, 'all_cell_all_height', 'All Height', 'All Height', '420'),
(144, 'single_cell_title_size', 'Title Size', 'Title Size', '16'),
(145, 'single_cell_title_color', 'Title Color', 'Title Color', '004372'),
(146, 'single_cell_font_1_size', 'Font 1 Size', 'Font 1 Size', '10'),
(147, 'single_cell_font_2_size', 'Font 2 Size', 'Font 2 Size', '10'),
(148, 'single_cell_background_color_1', 'Background Color 1', 'Background Color 1', 'F5F4F4'),
(149, 'single_cell_background_color_2', 'Background Color 2', 'Background Color 2', 'FFFFFF'),
(150, 'single_cell_text_color_1', 'Text Color 1', 'Text Color 1', '004372'),
(151, 'single_cell_text_color_2', 'Text Color 2', 'Text Color 2', '636363'),
(152, 'single_cell_picture_width', 'Picture Width', 'Picture Width', '215'),
(153, 'single_cell_picture_height', 'Picture Height', 'Picture Height', '200'),
(154, 'list_page_up_names_text_color', 'List Page Up Names Text Color', 'List Page Up Names Text Color', '3D3D3D'),
(155, 'list_page_up_names_background_color', 'List Page Up names Background Color', 'List Page Up names Background Color', 'E2E2E2'),
(156, 'list_page_background_color_1', 'List Page Background Color 1', 'List Page Background Color 1', 'F6F6F6'),
(157, 'list_page_background_color_2', 'List Page Background Color 2', 'List Page Background Color 2', 'FFFFFF'),
(158, 'list_cell_price_color', 'List Cell Price Color', 'List Cell Price Color', 'B02E2E'),
(159, 'list_cell_market_price_color', 'List Cell Market Price Color', 'List Cell Market Price Color', '3C6680'),
(160, 'list_page_text_color_1', 'Text Color 1', 'Text Color 1', '3E3E3E'),
(161, 'list_page_text_color_2', 'Text Color 2', 'Text Color 2', '235775'),
(162, 'search_icon_color', 'Search Icon Color', 'Search Icon Color', '004372'),
(163, 'reset_icon_color', 'Reset Icon Color', 'Reset Icon Color', '004372'),
(164, 'select_icon_color', 'Select icon color', 'Select icon color', '004372'),
(165, 'global_revers', 'Global Revers', 'Global Revers', '0')";
$db->setQuery($query);
$db->Query();

}




///////////////////////////////////////////////Desighn Update/////////////////////////////////////////////////////////////////

if($type=="int(11) unsigned"){
$query="ALTER TABLE `#__spidercatalog_products` modify category_id  varchar(200) binary";
$db->setQuery($query);
$db->Query();
$query="INSERT INTO `#__spidercatalog_id` (`proid`, `cateid`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1)";
$db->setQuery($query);
$db->Query();
$query1="select * from #__spidercatalog_products";
$db->setQuery($query1);
$products = $db->loadObjectList();
//print_r($products);
	foreach ($products as $categor)
	{
	$cat=$categor->category_id.',';

	$query="update #__spidercatalog_products set category_id='".$db->escape($cat)."'
	WHERE id=$categor->id ";
	$db->setQuery($query);
	$db->Query();
	}
}





//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(!defined('DS')){
   define('DS',DIRECTORY_SEPARATOR);
}
require_once( JPATH_COMPONENT.DS.'controller.php' );
$controller = $input->get( 'controller' );

global $param_values;
$db =JFactory::getDBO();
$query ="SELECT *  from #__spidercatalog_params ";

$db->setQuery($query);
$rows = $db->loadObjectList();
if ($db->getErrorNum()) {
	echo $db->stderr();
	return false;
}


$param_values=array();

foreach($rows as $row){
$key=$row->name;
$value=$row->value;
$param_values[$key]=$value;
}



class jsshparams{
    
    function get($key) {
		global $param_values;	
        return $param_values[$key];
    }
}



	$exist="0";
	$db =JFactory::getDBO();
	$query = "SHOW columns FROM #__spidercatalog_product_categories";
	$db->setQuery($query);
	$fields = $db->loadObjectList();
	for($i=0; $i<count($fields); $i++){
	if($fields[$i]->Field=="parent"){
	$exist="1";
	}
	}
	
	
	if($exist!="1"){
$query ="ALTER TABLE `#__spidercatalog_product_categories`
ADD `parent` int(11) unsigned DEFAULT 0";
$db->setQuery($query);
$db->Query($query);
}



	$exist1="0";
	$db =JFactory::getDBO();
	$query1 = "SHOW columns FROM #__spidercatalog_products";
	$db->setQuery($query1);
	$fields1 = $db->loadObjectList();
	for($i=0; $i<count($fields1); $i++){
	if($fields1[$i]->Field=="published_in_parent"){
	$exist1="1";
	}
	}
	
	
	if($exist1!="1"){
$query1 ="ALTER TABLE `#__spidercatalog_products`
ADD `published_in_parent` tinyint(4) unsigned DEFAULT 0";
$db->setQuery($query1);
$db->Query($query1);
}


$query2 ="INSERT IGNORE INTO `#__spidercatalog_params` (`id`, `name`, `title`, `description`, `value`) VALUES
(89, 'width_spider_main_table_lists', 'Product List  Width', 'Product List  Width', '620'),
(90, 'category_details_width', 'Category Details Width', 'Category Details Width', '600'),
(91, 'spider_catalog_product_page_width', 'Product Page Width', 'Product Page Width', '600'),
(92, 'description_size_list', 'Description Text Size', 'Description Text Size', '12'),
(93, 'name_price_size_list', 'Name Price List Text Size', 'Name Price List Text Size', '12'),
(94, 'Parameters_size_list', 'Parameters List Text Size', 'Parameters List Text Size', '12'),
(95, 'cell_crop_image', 'Save proportions', 'Save proportions', '0'),
(96, 'list_crop_image', 'Save proportions', 'Save proportions', '0')";
$db->setQuery($query2);
$db->Query($query2);

$classname    = 'spidercatalogController'.$controller;

$controller   = new $classname( );



$controller->execute( $input->get( 'task' ) );



$controller->redirect();

?>