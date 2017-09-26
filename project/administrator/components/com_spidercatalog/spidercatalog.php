<?php
/**
 * @package Spider Catalog
 * @author Web-Dorado
 * @copyright (C) 2012 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 

 
 
 defined('_JEXEC') or die('Restricted access');
 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
//print_r($db);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
 ///////////////////////////////////////////////Desighn Update/////////////////////////////////////////////////////////////////


$resultp = "Select value FROM #__spidercatalog_params WHERE name='params_background_color1' ";
$db->setQuery($resultp);
$colsp=$db->loadObject();

if($colsp->value=="c9effe"){

$query="UPDATE `#__spidercatalog_params` SET  `value` =  '290' WHERE `name` ='product_cell_width'";
$db->setQuery($query);
$db->Query();
$query="UPDATE `#__spidercatalog_params` SET  `value` =  '650' WHERE `name` ='product_cell_height'";
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
$query="UPDATE `#__spidercatalog_params` SET  `value` =  '250' WHERE `name` ='large_picture_width'";
$db->setQuery($query);
$db->Query();
$query="UPDATE `#__spidercatalog_params` SET  `value` =  '180' WHERE `name` ='large_picture_height'";
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
(108, 'cell_new_big_title_size', 'Cell New Big Title Size', 'Cell New Big Title Size', '24'),
(109, 'cell_new_title_size', 'Cell New Title Size', 'Cell New Title Size', '12'),
(110, 'cell_new_price_size', 'Cell New Price Size', 'Cell New Price Size', '20'),
(111, 'cell_new_market_price_size', 'Cell New Market Price Size', 'Cell New Market Price Size', '12'),
(112, 'cell_new_picture_width', 'Cell New Picture Width', 'Cell New Picture Width', '110'),
(113, 'cell_new_picture_height', 'Cell New Picture Height', 'Cell New Picture Height', '95'),
(114, 'cell_new_title_color', 'Cell New Title Color', 'Cell New Title Color', '004372'),
(115, 'new_cell_all_width', 'New Cell Width', 'New Cell Width', '320'),
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
(132, 'cell_tumble_all_width', 'All Width', 'All Width', '320'),
(133, 'cell_tumble_all_height', 'All Height', 'All Height', '225'),
(134, 'all_cell_title_size', 'Title Size', 'Title Sizes', '12'),
(135, 'all_cell_title_color', 'Title Color', 'Title Color', '004372'),
(136, 'all_cell_price_size', 'Price Size', 'Price Size', '13'),
(137, 'all_cell_price_text_color', 'Price Text Color', 'Price Text Color', 'FFFFFF'),
(138, 'all_cell_picture_width', 'Picture Width', 'Picture Width', '285'),
(139, 'all_cell_picture_height', 'Picture Height', 'Picture Height', '200'),
(140, 'all_cell_text_size', 'Text Size', 'Text Size', '10'),
(141, 'all_cell_text_color', 'Text Color', 'Text Color', '434242'),
(142, 'all_cell_all_width', 'All Width', 'All Width', '320'),
(143, 'all_cell_all_height', 'All Height', 'All Height', '400'),
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

 
require_once JPATH_COMPONENT . '/admin.spidercatalog.html.php';
require_once JPATH_COMPONENT . '/toolbar.spidercatalog.html.php';
$input=JFactory::getApplication()->input;
$task=$input->get('task');
$option=$input->get('option', '');
$controller = $input->get('controller','show_links');
$op_type  =$input->get('op_type', '');
 
 if(!defined('DS')){
   define('DS',DIRECTORY_SEPARATOR);
}
JTable::addIncludePath( JPATH_COMPONENT.'/tables' );

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

switch ($task)
{
    case 'edit':
    case 'add':
        TOOLBAR_spidercatalog::_NEW($controller, $op_type);
        break;
    default:
        TOOLBAR_spidercatalog::_DEFAULT($controller, $op_type);
        break;
}
if ($controller == 'products')
$menu_products=true;
else
$menu_products=false;
if ($controller == 'options')
$menu_options=true;
else
$menu_options=false;
if ($controller == 'category')
$menu_category=true;
else
$menu_category=false;

switch ($task)
{
    case 'edit':
    case 'add':
        if ($controller == 'products')
            editProduct($option);
        if ($controller == 'category')
            editCategory($option);
        if ($controller == 'product_rating')
            editProductRating($option);
        if ($controller == 'product_reviews')
            editProductReviews($option);
        break;
    case 'apply':
    case 'save':
        if ($controller == 'category')
            saveCategory($option, $task);
        if ($controller == 'products')
            saveProduct($option, $task);
        if ($controller == 'product_rating')
            saveProductRating($option, $task);
        if ($controller == 'options')
          {
            if ($op_type == "global")
                saveGlobal($option, $task);
            if ($op_type == "styles")
                saveStyles($option, $task);
          }
    case 'saveorder':
        if ($controller == 'product_rating')
            saveProductRating($option, $task);
        if ($controller == 'products')
            saveOrderProduct($cid);
        if ($controller == 'category')
            saveOrderCategories($cid);
        break;
    case 'cancel':
        cancel($option, $controller);
        break;
    case 'remove':
        if ($controller == 'products')
            removeProduct($option);
        if ($controller == 'category')
            removeCategory($option, $task);
        if ($controller == 'order')
            removeOrder($option, $task);
        if ($controller == 'product_rating')
            removeProductRating($option, $task);
        if ($controller == 'product_reviews')
            removeProductReviews($option, $task);
    case 'publish':
        if ($controller == 'products')
            publishProducts($option);
        if ($controller == 'category')
            publishCategory($option, $task);
        break;
    case 'unpublish':
        if ($controller == 'products')
            unpublishProducts($option);
        if ($controller == 'category')
            unpublishCategory($option, $task);
        break;
	case 'product_rating':
         editProductRatingRedirect($option);
        break;
	case 'product_reviews':
         editProductReviewsRedirect($option);
         break;
   default:
   	JSubMenuHelper::addEntry(JText::_('Categories'), 'index.php?option=com_spidercatalog&controller=category',$menu_category);
	JSubMenuHelper::addEntry(JText::_('Products'), 'index.php?option=com_spidercatalog&controller=products',$menu_products);
	JSubMenuHelper::addEntry(JText::_('Options'), 'index.php?option=com_spidercatalog&controller=options',$menu_options);
	
	if ($controller == 'products')
            {
	JSubMenuHelper::addEntry(('<form action="" method="post" enctype="multipart/form-data">
Import CSV:

<span style="position:relative;height:25px;width:auto;cursor:pointer;">
<input type="button" style="cursor:pointer;" value="Choose file" />
<input style="width:100%;height:100%;position:absolute;top:0px;left:0px;opacity:0;cursor:pointer;height:25px;display:block;" type="file" id="csv_file" value="brrr" name="filename" size="20" />
</span>
<input type="hidden" name="update" value="ok" />
<input type="submit" onclick="if(document.getElementById(\'csv_file\').value==\'\') {alert(\'choose CSV\') ;return false;}" value="Upload" />
</form>

<input type="button" style="margin-bottom:9px" class = "btn tip hasTooltip"value="Export as CSV" onclick="window.location=\'components/com_spidercatalog/exportcsv.php\'" /><script>



</script>
<br>
<a style="text-decoration:none;" target="_blank" href="http://web-dorado.com/products/joomla-catalog.html"><img style="width: 145px;" src="components/com_spidercatalog/images/buyme.png"></a>
'));
}
if ($controller != 'products')
            {
	JSubMenuHelper::addEntry(( '<br>
<a style="text-decoration:none;" target="_blank" href="http://web-dorado.com/products/joomla-catalog.html"><img style="width: 145px;"  src="components/com_spidercatalog/images/buyme.png"></a>'));	
			}
	
		if ($controller == 'products')
            showProducts($option, $controller);
			
        if ($controller == 'options')
          {
            showOptions($option, $controller, $op_type);
            if ($op_type == 'global')
                showglobal($option, $controller, $op_type);
            if ($op_type == 'styles')
                showStyles($option, $controller, $op_type);
          }
        if ($controller == 'category')
            showCategory($option, $controller);
        if ($controller == 'show_links')
          {
            showLinks($option, $controller);
          }
        break;
			case 'media_manager_image':
		media_manager_image();
		break;
}

function showLinks($option, $controller)
  {$input=JFactory::getApplication()->input;
    HTML_spidercatalog::showLinks($option, $controller);
  }
  
  
    
    
function open_cat_in_tree( $catt, $tree_problem='', $hihiih=1){
  $input=JFactory::getApplication()->input;
  $mainframe = JFactory::getApplication();
  $option=$input->get('option', '');
  $db =JFactory::getDBO();
$filter           = "";
    $filter_order_Dir = $mainframe->getUserStateFromRequest($option . '.filter_order_Dir', 'filter_order_Dir', '', 'word');
    $filter_order     = $mainframe->getUserStateFromRequest($option . '.filter_order', 'filter_order', 'ordering', 'cmd');
    $filter_state     = $mainframe->getUserStateFromRequest($option . '.filter_state', 'filter_state', '', 'word');
    //echo $filter_order_Dir;
    //echo $filter_state;
    $limit            = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
    $limitstart       = $mainframe->getUserStateFromRequest($option . '.limitstart', 'limitstart', 0, 'int');
    $ord              = $input->get('ord', 1);
    if ($ord and ($filter_order == "name" or $filter_order == "description" or $filter_order == "ordering" or $filter_order == "published"))
        $order = ' ORDER BY ' . $filter_order . ' ' . $filter_order_Dir . ', ordering';
    else
        $order = "";
   
static $trr_cat=array();
if($hihiih)
$trr_cat=array();
if (is_array($catt))
foreach($catt as $dog){
	$dog->name=$tree_problem.$dog->name;
	array_push($trr_cat,$dog);
	$new_cat_query=	"SELECT  a.* ,  COUNT(b.id) AS count, g.par_name AS par_name FROM #__spidercatalog_product_categories  AS a LEFT JOIN #__spidercatalog_product_categories AS b ON a.id = b.parent LEFT JOIN (SELECT  #__spidercatalog_product_categories.`ordering` as `ordering`, #__spidercatalog_product_categories.id AS id, COUNT( #__spidercatalog_products.category_id ) AS prod_count
FROM #__spidercatalog_products, #__spidercatalog_product_categories
WHERE (#__spidercatalog_products.category_id like concat(#__spidercatalog_product_categories.id,',%') or #__spidercatalog_products.category_id like concat('%,',#__spidercatalog_product_categories.id,',%'))
GROUP BY #__spidercatalog_products.category_id) AS c ON c.id = a.id LEFT JOIN
(SELECT #__spidercatalog_product_categories.name AS par_name,#__spidercatalog_product_categories.id FROM #__spidercatalog_product_categories) AS g
 ON a.parent=g.id WHERE a.parent=".$db->escape($dog->id)." group by a.id".$db->escape($order); 
 
 	$db->setQuery($new_cat_query);
	$new_cat = $db->loadObjectList();
 
 open_cat_in_tree($new_cat,$tree_problem. "— ",0);
}
return $trr_cat;
}

 
////////edit product
function editProduct($option)
  {$input=JFactory::getApplication()->input;
    JRequest::setVar('hidemainmenu', 1);
    $params =new jsshparams;
    
    $doc =JFactory::getDocument();
    $plugin_js_path = JURI::root(true) . '/administrator/components/com_spidercatalog/js';
    $doc->addScript($plugin_js_path . "/param_block.js");
    $row =JTable::getInstance('products', 'Table');
    $cid = $input->get('cid', array(
        0
    ), '', 'array');
    $id  = $cid[0];
    $row->load($id);
    $lists            = array();
    $category_id['0'] = array(
        'value' => '0',
        'text' => 'Uncategorised'
    );
    $db =JFactory::getDBO();
    $query = "SELECT * FROM #__spidercatalog_product_categories where published=1 AND parent=0";
    $db->setQuery($query);
    $rows1 = $db->loadObjectList();
    if ($db->getErrorNum())
      {
        echo $db->stderr();
        return false;
      }
   $rows2=open_cat_in_tree($rows1);

    for ($i = 0, $n = count($rows2); $i < $n; $i++)
      {
	  
        $row1 = $rows2[$i];
        $id1               = $row1->id;
		
		
        $category_id[$id1] = array(
            'value' => $row1->id,
            'text' =>$row1->name
        );
	
      }
    $ordering['0'] = array(
        'value' => '0',
        'text' => '0 First'
    );
    $db =JFactory::getDBO();
    $query = "SELECT ordering,name FROM #__spidercatalog_products order by ordering";
    $db->setQuery($query);
    $rows1 = $db->loadObjectList();
    if ($db->getErrorNum())
      {
        echo $db->stderr();
        return false;
      }
    for ($i = 0, $n = count($rows1); $i < $n; $i++)
      {
        $row1 =& $rows1[$i];
        $ordering1            = $row1->ordering;
        $ordering[$ordering1] = array(
            'value' => $row1->ordering,
            'text' => ($row1->ordering . "(" . $row1->name . ")")
        );
      }
    $ordering[(count($rows1) + 1)] = array(
        'value' => (count($rows1) + 1),
        'text' => (count($rows1) + 1) . ' Last'
    );
    $lists['ordering']             = JHTML::_('select.genericList', $ordering, 'ordering', 'class="inputbox" ' . '', 'value', 'text', $row->ordering);
    $lists['category_id']          = JHTML::_('select.genericList', $category_id, 'category_id', 'class="inputbox"  onchange="Joomla.submitbutton(\'apply\');"', 'value', 'text', $row->category_id);
	
	if (!$row->id)
        $show = 0;
    else
        $show = $row->published_in_parent;
	$lists['published_in_parent'] = JHTML::_('select.booleanlist', 'published_in_parent', 'class="inputbox"', $show);

    if (!$row->id)
        $pub = 1;
    else
        $pub = $row->published;
    $lists['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $pub);

    $query              = "SELECT * FROM #__spidercatalog_product_votes  WHERE product_id = '".$db->escape($id )."' ";
    $db->setQuery($query);
    $votes = $db->loadObjectList();
	
	$db =JFactory::getDBO();
	$query ="SELECT param FROM #__spidercatalog_product_categories where id='".$db->escape($row->category_id )."'";
	$db->setQuery( $query );
	$rows1 = $db->loadObjectList();
	if ($db->getErrorNum()) 
		{
			echo $db->stderr();
			return false;
		}
		
		$query = "select * FROM #__spidercatalog_product_categories ";
 $db->setQuery($query);  
 $rows =  $db->loadObjectList(); 
 
 $rowsparams='';
 if($row->category_id){
 $catids=substr($row->category_id,0,strlen($row->category_id)-1);
 
  $query = "select * FROM #__spidercatalog_product_categories where id in ($catids)";
$db->setQuery($query);  
 $rowsparams =  $db->loadObjectList(); 
	}
    HTML_spidercatalog::editProduct($row, $lists, $votes, $option, $params, $rows1, $rows, $rowsparams);
  }
////////edit product
function editCategory($option)
  {
  
  $input=JFactory::getApplication()->input;
    JRequest::setVar('hidemainmenu', 1);
	
    $doc =JFactory::getDocument();
    $plugin_js_path = JURI::root(true) . '/administrator/components/com_spidercatalog/js';
    $doc->addScript($plugin_js_path . "/param_block.js");
    $row =JTable::getInstance('categories', 'Table');
    $cid = $input->get('cid', array(
        0
    ), '', 'array');
    $id  = $cid[0];
    $row->load($id);
  $lists            = array();
    $category_id['0'] = array(
        'value' => '0',
        'text' => 'Uncategorised'
    );
    $db = JFactory::getDBO();
    $query = "SELECT * FROM #__spidercatalog_product_categories where published=1 and parent=0 and id!=" .$db->escape($id)."";
    $db->setQuery($query);
    $rows1 = $db->loadObjectList();
    if ($db->getErrorNum())
      {
        echo $db->stderr();
        return false;
      }
	  

	  $parent['0'] = array(
        'value' => '0',
        'text' => 'Main Category'
    );
	$rows2=open_cat_in_tree($rows1);
	 $rows3=array();
   $count_of_cat=count( $rows2);
   $ii=0;
   for($k=0;$k<$count_of_cat;$k++){
		if($rows2[$k]->published){
		$rows3[$ii]=$rows2[$k];
		$ii++;
		}
   }
   $rows2= $rows3;
    for ($i = 0, $n = count($rows2); $i < $n; $i++)
      {
        $row1 =& $rows2[$i];
        $id1          = $row1->id;
		if($id!=$row1->id){
        $parent[$id1] = array(
            'value' => $row1->id,
            'text' => $row1->name
        );
		}
      }
    $ordering['0'] = array(
        'value' => '0',
        'text' => '0 First'
    );
    $db = JFactory::getDBO();
    $query = "SELECT ordering,name FROM #__spidercatalog_product_categories order by ordering";
    $db->setQuery($query);
    $rows1 = $db->loadObjectList();
    if ($db->getErrorNum())
      {
        echo $db->stderr();
        return false;
      }
    for ($i = 0, $n = count($rows1); $i < $n; $i++)
      {
        $row1 =& $rows1[$i];
        $ordering1            = $row1->ordering;
        $ordering[$ordering1] = array(
            'value' => $row1->ordering,
            'text' => ($row1->ordering . "(" . $row1->name . ")")
        );
      }
    $ordering[(count($rows1) + 1)] = array(
        'value' => (count($rows1) + 1),
        'text' => (count($rows1) + 1) . ' Last'
    );
    $lists['ordering']             = JHTML::_('select.genericList', $ordering, 'ordering', 'class="inputbox" ' . '', 'value', 'text', $row->ordering);
	$lists['parent']          = JHTML::_('select.genericList', $parent, 'parent', 'class="inputbox"  onchange="paramj();Joomla.submitbutton(\'apply\');"', 'value', 'text', $row->parent);
    //
    if (!$row->id)
        $pub = 1;
    else
        $pub = $row->published;
		
		
   $lists['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $pub);
   //echo $row->parent;
   /*
		if($row->parent){
		
	$query = "SELECT param FROM #__spidercatalog_product_categories where parent=$row->parent ";
		$db->setQuery($query);
		$rowsparent = $db->loadResult();
		echo $rowsparent;
		$query = "SELECT parent FROM #__spidercatalog_product_categories where parent=$row->parent ";
		$db->setQuery($query);
		$rowsparentid = $db->loadResult();
		echo $rowsparentid;
		if($row->parent != $rowsparentid){
		$query = "UPDATE #__spidercatalog_product_categories SET param='$rowsparent' WHERE  id=$row->id ";
		$db->setQuery($query);
		//echo $row->id;
		$db->Query();
		}
		
		}
		*/
		//  echo JRequest::getVar('par');
		$rowsparent='';
    HTML_spidercatalog::editCategory($row, $lists, $option, $rowsparent);
  }

/////////////save
function saveProduct($option, $task)
  {$input=JFactory::getApplication()->input;
    $mainframe = JFactory::getApplication();
    $db = JFactory::getDBO();
    $row = JTable::getInstance('products', 'Table');
    $name = JRequest::getVar('name', '', 'post', 'string', JREQUEST_ALLOWRAW);
	$categoryselect=JRequest::getVar('categoryselect', '', 'post', 'string', JREQUEST_ALLOWRAW);
    if ($name == "")
      {
        echo "<script> alert('Name is required'); window.history.go(-1); </script>\n";
        exit();
      }
	if ($categoryselect == "")
      {
        echo "<script> alert('Category is required'); window.history.go(-1); </script>\n";
        exit();
      }
    if (!$row->bind(JRequest::get('post')))
      {
        echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
        exit();
      }
    $row->description = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);

	
	
	
	
    if (!$row->store())
      {
        echo "<script> alert('" . $row->getError() . "');



	window.history.go(-1); </script>\n";
        exit();
      }
    $table =& JTable::getInstance('products', 'Table');
    $table->reorder();
    $id = $input->get('id', '', 'post');
	
		$tver=explode(',',$row->category_id);
	array_pop($tver);
//print_r($tver);
foreach($tver as $tiv){

//exit;
$query= "DELETE FROM #__spidercatalog_id
 WHERE proid=".$db->escape($row->id)."  ";	

	$db->setQuery($query);	
//echo $query;
//exit;
if (!$db->query())
          {
            echo "<script> alert('" . $db->getErrorMsg() . "');



window.history.go(-1); </script>\n";
          }

}
   foreach ($tver as $addtiv){
$query=" INSERT INTO   #__spidercatalog_id (proid,cateid) VALUES ('".$db->escape($row->id)."','".$db->escape($addtiv)."') ";
	
		$db->setQuery($query);	

if (!$db->query())
          {
            echo "<script> alert('" . $db->getErrorMsg() . "');



window.history.go(-1); </script>\n";
          }
	
	}
	
	
	
    switch ($task)
    {
        case 'apply':
            $msg  = 'Changes to Products saved';
            $link = 'index.php?option=' . $option . '&task=edit&controller=products&cid[]=' . $row->id;
            break;
        case 'save':
        default:
            $msg  = 'Product Saved';
            $link = 'index.php?option=' . $option . '&controller=products';
            break;
    }
	if($task!='none')
		$mainframe->redirect($link, $msg, 'message');
  }
/////////////save
function saveCategory($option, $task)
  {	

	
  
  $db = JFactory::getDBO();
  $input=JFactory::getApplication()->input;
     $mainframe = JFactory::getApplication();
    $row = JTable::getInstance('categories', 'Table');
    $name = $input->get('name', '', 'post', 'string', JREQUEST_ALLOWRAW);
	  $cid = $input->get('id', 0);

	$param='';
	if($cid==0 and $input->get('parent',0)>0)
	{
		$query="SELECT param FROM #__spidercatalog_product_categories where id='".$input->get('parent')."'";
		$db->setQuery($query);
		$param=	$db->loadResult($query);
	}
	
	
    if ($name == "")
      {
        echo "<script> alert('Name is required');

		window.history.go(-1); </script>\n";
        exit();
      }
    if (!$row->bind(JRequest::get('post')))
      {
        echo "<script> alert('" . $row->getError() . "');



	window.history.go(-1); </script>\n";
        exit();
      }
	  
	  $row->description =JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);
	  if($param) $row->param = $param;
    if (!$row->store())
      {
        echo "<script> alert('" . $row->getError() . "');



	window.history.go(-1); </script>\n";
        exit();
      }
	  
	
	
	
    $table = JTable::getInstance('categories', 'Table');
    $table->reorder();
    switch ($task)
    {
        case 'apply':
            $msg  = 'Changes to Category saved';
            $link = 'index.php?option=' . $option . '&controller=category&task=edit&cid[]=' . $row->id.'&par='. $row->parent;
            break;
        case 'save':
        default:
            $msg  = 'Category Saved';
            $link = 'index.php?option=' . $option . '&controller=category';
            break;
    }
	
	
	
	
	$query = "SELECT * FROM #__spidercatalog_product_categories where id=36 ";
    $db->setQuery($query);
	
	if($row->parent){
		
	$query = "SELECT param FROM #__spidercatalog_product_categories where parent=$row->parent ";
		$db->setQuery($query);
		$rowsparent = $db->loadResult();
		
		$query = "SELECT parent FROM #__spidercatalog_product_categories where parent=$row->parent ";
		$db->setQuery($query);
		$rowsparentid = $db->loadResult();
		//if($param){
		if($par == 1){
		$query = "UPDATE #__spidercatalog_product_categories SET param='$rowsparent' WHERE  id=$row->id ";
		$db->setQuery($query);
		
		$db->Query();
		}
	//}
		}
	
    $mainframe->redirect($link, $msg, 'message');
  }

////////////Show
function showProducts($option, $controller)
  {
  $input=JFactory::getApplication()->input;
     $mainframe = JFactory::getApplication();
    $db =JFactory::getDBO();
    $table =JTable::getInstance('products', 'Table');
    $table->reorder();
    $filter       = "";
    $ord          = $input->get('ord', 1);
    $filter_state = $mainframe->getUserStateFromRequest($option . '.filter_state', 'filter_state', '', 'word');
    if ($ord)
      {
        $filter_order_Dir = $mainframe->getUserStateFromRequest($option . '.filter_order_Dir', 'filter_order_Dir', '', 'word');
        $filter_order     = $mainframe->getUserStateFromRequest($option . '.filter_order', 'filter_order', 'ordering', 'cmd');
      }
    else
      {
        $filter_order_Dir = "asc";
        $filter_order     = "ordering";
      }
    //echo $filter_order_Dir;
    //echo $filter_state;
    $limit      = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
    $limitstart = $mainframe->getUserStateFromRequest($option . '.limitstart', 'limitstart', 0, 'int');
    $ord        = $input->get('ord', 1);
    if ($ord and ($filter_order == "name" or $filter_order == "categories.name" or $filter_order == "cost" or $filter_order == "ordering" or $filter_order == "published"))
        $order = ' ORDER BY ' . $filter_order . ' ' . $filter_order_Dir . ', ordering';
    else
        $order = "";
    $lists            = array();
    $category_id['0'] = array(
        'value' => '0',
        'text' => '- Select a Category -'
    );
    $db =JFactory::getDBO();
  $query = "SELECT * FROM #__spidercatalog_product_categories where published=1 AND parent=0";
    $db->setQuery($query);
	
    $rows1 = $db->loadObjectList();
	
    if ($db->getErrorNum())
      {
        echo $db->stderr();
        return false;
      }
    $search     = $mainframe->getUserStateFromRequest($option . '.search', 'search', '', 'string');
    $search     = JString::strtolower($search);
    $cat_search = $mainframe->getUserStateFromRequest($option . '.cat_search', 'cat_search', '', 'string');
    $cat_search = JString::strtolower($cat_search);
  $rows2=open_cat_in_tree($rows1);

    for ($i = 0, $n = count($rows2); $i < $n; $i++)
      {
	  
        $row1 = $rows2[$i];
        $id1               = $row1->id;
		
		
        $category_id[$id1] = array(
            'value' => $row1->id,
            'text' =>$row1->name
        );
	
      }

    $lists['category_id'] = JHTML::_('select.genericList', $category_id, 'cat_search', 'class="inputbox" onchange="this.form.submit();"' . '', 'value', 'text', $cat_search);

    //echo  $lists['category_id'];
    //echo $search;
    if ($cat_search)
      {
       $filter .= ' where  #__spidercatalog_products.category_id like ' . $db->Quote('' . $db->escape($cat_search, true) . ',%', false).' or #__spidercatalog_products.category_id like '. $db->Quote('%,' . $db->escape($cat_search, true) . ',%', false) ;
      }
    if ($search)
      {
        if ($cat_search)
            $filter .= ' and ';
        else
            $filter .= ' where ';
        $filter .= ' LOWER(#__spidercatalog_products.name) LIKE ' . $db->Quote('%' . $db->escape($search, true) . '%', false);
      }
    $query = 'SELECT COUNT(*)' . ' FROM #__spidercatalog_products ' . $filter;
	//print_r($query);
    //echo		$query;]
    $db->setQuery($query);
    $total = $db->loadResult();
    ///////////Paging//////////////////
    jimport('joomla.html.pagination');
    $pageNav = new JPagination($total, $limitstart, $limit);
    ///////////Paging//////////////////
    $query   = "SELECT #__spidercatalog_products.*,categories.name as category FROM #__spidercatalog_products left join #__spidercatalog_product_categories  as categories on  #__spidercatalog_products.category_id=categories.id " . $filter . " $order";
    //echo $query;
    $db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
	//print_r($pageNav->limitstart);
    $rows = $db->loadObjectList();
    if ($db->getErrorNum())
      {
        echo $db->stderr();
        return false;
      }
    $lists['order_Dir'] = $filter_order_Dir;
    $lists['order']     = $filter_order;
    $lists['search']    = $search;
		///////////////////////////////
	$db =JFactory::getDBO();
$query="SELECT * FROM #__spidercatalog_products WHERE published=1 ";

$db->setQuery($query);
$rows2 = $db->loadObjectList();




	///////////////////////////////
	$db =JFactory::getDBO();


$query   = "SELECT #__spidercatalog_product_categories.id  as category_id,#__spidercatalog_product_categories.name  as category_id FROM #__spidercatalog_product_categories left join #__spidercatalog_id on  #__spidercatalog_product_categories.id=#__spidercatalog_id.cateid ";

$db->setQuery($query);
$rows3 = $db->loadObjectList();


for ($i = 0, $n = count($rows); $i < $n; $i++)
          {
            $row =& $rows[$i];
			$arr=explode(",",$row->category_id);
array_pop($arr);
//print_r($arr);

$ids = join(',',$arr);  
//var_dump($ids);

	///////////////////////////////
	$db =JFactory::getDBO();
$query="SELECT * FROM #__spidercatalog_product_categories WHERE id IN (".$db->escape($ids).") AND published=1  order by ordering ";

$db->setQuery($query);
$rows3 = $db->loadObjectList();


$rows[$i]->gago=$rows3;



}

$max_file_size = 5; 
if(JRequest::getVar('update')=='ok')
{
   
    if($_FILES["filename"]["size"] > $max_file_size*1024*1024)
    {
        echo 'The SIZE of File is more than '.$max_file_size.' Mb!';
     
        exit;
    }
    if(copy($_FILES["filename"]["tmp_name"],$_FILES["filename"]["name"]))
	
    {
        echo("The file "."<b>".$_FILES["filename"]["name"]."</b>"." was downloaded successfully!");
		echo '<script>window.location.href = "index.php?option=com_spidercatalog&controller=products";</script>';
    }
    else
    {
        echo 'Error of Uploading';
     //   include('file_upload.php');
  // exit;
    }
    setlocale(LC_ALL, 'en_US.utf8'); 
    if(setlocale(LC_ALL, 0) == 'C') die('Your server does not suport LOCALS');

    $file = fopen('php://memory', 'w+');
    fwrite($file, iconv('CP1251', 'UTF-8', file_get_contents($_FILES["filename"]["name"])));
    rewind($file);


    $r = 0; 
	
	
    while (($row = fgetcsv($file, 1000, ",")) != FALSE) 
    {
        $r++;
        
		if($row[0]!='Name' and $row[0]!='Category id' )
		{
        $ins="INSERT INTO `#__spidercatalog_products` (`name`,`category_id`,`description`, `image_url`, `cost`, `market_cost`, `param`, `ordering`, `published`, `published_in_parent`) VALUES ('$row[0]', '$row[1]', '$row[2]', '$row[3]', '$row[4]', '$row[5]', '$row[6]', '$row[7]', '$row[8]', '$row[9]')";
        $db->setQuery($ins);
		$db->Query();
        
    }
	
	}
	
	
	
    fclose($file);
	
}

else
{
  
}

//print_r(count($rows3));

////////////////
    HTML_spidercatalog::showProducts($option, $rows, $rows2, $rows3, $controller, $lists, $pageNav);
  }
  
  function recursive_ordering($id)
{
    $mainframe = JFactory::getApplication();
	$db =JFactory::getDBO();
    $table =JTable::getInstance('categories', 'Table');
    $table->reorder("parent=$id");
	$query="SELECT id FROM #__spidercatalog_product_categories where published=1 AND parent='$id'";
				$db->setQuery($query);

	$column=$db->loadResultArray();
	
	if(count($column))
		foreach($column as $child_id)
			recursive_ordering($child_id);
} 

function showCategory($option, $controller)
  {$input=JFactory::getApplication()->input;
     $mainframe = JFactory::getApplication();
    $db =JFactory::getDBO();
    $table =JTable::getInstance('categories', 'Table');
	recursive_ordering(0);
    $filter           = "";
    $filter_order_Dir = $mainframe->getUserStateFromRequest($option . '.filter_order_Dir', 'filter_order_Dir', '', 'word');
    $filter_order     = $mainframe->getUserStateFromRequest($option . '.filter_order', 'filter_order', 'ordering', 'cmd');
    $filter_state     = $mainframe->getUserStateFromRequest($option . '.filter_state', 'filter_state', '', 'word');
    //echo $filter_order_Dir;
    //echo $filter_state;
    $limit            = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
    $limitstart       = $mainframe->getUserStateFromRequest($option . '.limitstart', 'limitstart', 0, 'int');
    $ord              = $input->get('ord', 1);
    if ($ord and ($filter_order == "name" or $filter_order == "description" or $filter_order == "ordering" or $filter_order == "published"))
        $order = ' ORDER BY ' . $filter_order . ' ' . $filter_order_Dir . ', ordering';
    else
        $order = "";
 
     $lists            = array();
    $category_id['0'] = array(
        'value' => '0',
        'text' => '- Select Parent -'
    );
    $db =JFactory::getDBO();
    $query = "SELECT * FROM #__spidercatalog_product_categories where published=1 AND parent=0";
    $db->setQuery($query);
	
    $rows1 = $db->loadObjectList();
	
    if ($db->getErrorNum())
      {
        echo $db->stderr();
        return false;
      }
    $search = $mainframe->getUserStateFromRequest($option . '.search', 'search', '', 'string');
    $search = JString::strtolower($search);
    $cat_search = $mainframe->getUserStateFromRequest($option . '.cat_search', 'cat_search', '', 'string');
    $cat_search = JString::strtolower($cat_search);
	$rows2=open_cat_in_tree($rows1);

    for ($i = 0, $n = count($rows2); $i < $n; $i++)
      {
	  
        $row1 = $rows2[$i];
        $id1=$row1->id;
		
		
        $category_id[$id1] = array(
            'value' => $row1->id,
            'text' =>$row1->name
        );
	
      }

    $lists['category_id'] = JHTML::_('select.genericList', $category_id, 'cat_search', 'class="inputbox" onchange="this.form.submit();"' . '', 'value', 'text', $cat_search);
	
    //echo  $lists['category_id'];
    //echo $search;
   
   
   
    $search = $mainframe->getUserStateFromRequest($option . '.search', 'search', '', 'string');
    $search = JString::strtolower($search);
    //if ($search)
     // {
        $filter .= $db->Quote('%' . $db->escape($search, true) . '%', false);
     // }
    $query = 'SELECT COUNT(*)' . ' FROM #__spidercatalog_product_categories where LOWER(name) LIKE ' . $filter;
    $db->setQuery($query);
    $total = $db->loadResult();
    //$total=6;
    ///////////Paging//////////////////
    jimport('joomla.html.pagination');
	$queryplus="select * FROM #__spidercatalog_product_categories where parent !='0' ";

$db->setQuery($queryplus);
$plusnum=$db->loadObjectList();
	$total=$total-(count($plusnum));
	//print_r($limitstart);
    $pageNav = new JPagination($total, $limitstart, $limit);
    ///////////Paging//////////////////
    $db =JFactory::getDBO();
	
		 $cat_rows_query="SELECT id,name FROM #__spidercatalog_product_categories WHERE parent=0";
		 $db->setQuery($cat_rows_query);
	     $cat_rows=$db->loadResult();
	
	
	if($cat_search){
	$query ="SELECT  a.* ,  COUNT(b.id) AS count, g.par_name AS par_name FROM #__spidercatalog_product_categories  AS a LEFT JOIN  #__spidercatalog_product_categories AS b ON a.id = b.parent LEFT JOIN (SELECT  #__spidercatalog_product_categories.ordering as ordering, #__spidercatalog_product_categories.id AS id, COUNT( #__spidercatalog_products.category_id ) AS prod_count
FROM #__spidercatalog_products, #__spidercatalog_product_categories
WHERE (#__spidercatalog_products.category_id like concat(#__spidercatalog_product_categories.id,',%') or #__spidercatalog_products.category_id like concat('%,',#__spidercatalog_product_categories.id,',%'))
GROUP BY #__spidercatalog_products.category_id) AS c ON c.id = a.id LEFT JOIN
(SELECT #__spidercatalog_product_categories.name AS par_name, #__spidercatalog_product_categories.id FROM #__spidercatalog_product_categories) AS g
 ON a.parent=g.id WHERE a.parent=$cat_search AND a.name LIKE ".$filter." group by a.id ". $order ." " ; 

	 }
	 else{
	$query ="SELECT  a.* ,  COUNT(b.id) AS count, g.par_name AS par_name FROM #__spidercatalog_product_categories  AS a LEFT JOIN #__spidercatalog_product_categories AS b ON a.id = b.parent LEFT JOIN (SELECT  #__spidercatalog_product_categories.ordering as ordering, #__spidercatalog_product_categories.id AS id, COUNT( #__spidercatalog_products.category_id ) AS prod_count
FROM #__spidercatalog_products, #__spidercatalog_product_categories
WHERE (#__spidercatalog_products.category_id like concat(#__spidercatalog_product_categories.id,',%') or #__spidercatalog_products.category_id like concat('%,',#__spidercatalog_product_categories.id,',%'))
GROUP BY #__spidercatalog_products.category_id) AS c ON c.id = a.id LEFT JOIN
(SELECT #__spidercatalog_product_categories.name AS par_name, #__spidercatalog_product_categories.id FROM #__spidercatalog_product_categories) AS g
 ON a.parent=g.id WHERE a.parent=0 group by a.id ". $order ." " ; 
}



//$pageNav->limit=$pageNav->limit-count($plusnum);
//print_r($pageNav->limit);
	 $db->setQuery($query, $pageNav->limitstart, $pageNav->limit);

	$rows = $db->loadObjectList();
	
	$rows=open_cat_in_tree($rows);
//	print_r(count($rows));

	$query ="SELECT  #__spidercatalog_product_categories.ordering, #__spidercatalog_product_categories.id, COUNT( #__spidercatalog_id.cateid ) AS prod_count
FROM #__spidercatalog_id, #__spidercatalog_product_categories
WHERE #__spidercatalog_id.cateid = #__spidercatalog_product_categories.id
GROUP BY #__spidercatalog_id.cateid " ;
     $db->setQuery($query);
	$prod_rows = $db->loadObjectList();

	
foreach($rows as $row)
{
$row->prod_count=0;
	foreach($prod_rows as $row_1)
	{
		if ($row->id == $row_1->id)
		{
			$row->ordering = $row_1->ordering;
		$row->prod_count = $row_1->prod_count;
	}
		}
		$query = "SELECT * FROM #__spidercatalog_product_categories where parent=$row->id ";
		    $db->setQuery($query);
	$prod5555 = $db->loadObjectList();
//	print_r(count($prod5555));
//	$gago=count($prod5555);
	$row->count1=count($prod5555);
	}
			$cat_rows=open_cat_in_tree($cat_rows);

	
    if ($db->getErrorNum())
      {
        echo $db->stderr();
        return false;
      }
	
	 
	  //print_r($cat_rows);
    $lists['order_Dir'] = $filter_order_Dir;
    $lists['order']     = $filter_order;
    $lists['search']    = $search;
    HTML_spidercatalog::showcategories($option, $rows, $controller, $lists, $pageNav, $cat_rows, $plusnum );
  }
  
/////////Remove
function removeProduct($option)
  {$input=JFactory::getApplication()->input;
     $mainframe = JFactory::getApplication();
    JRequest::checkToken() or jexit('Invalid Token');
    $cid = $input->get('cid', array(), '', 'array');
    $db =& JFactory::getDBO();
    if (count($cid))
      {
        $cids  = implode(',', $cid);
        $query = "DELETE FROM #__spidercatalog_products WHERE id IN (".$db->escape($cids )." )";
        $db->setQuery($query);
        if (!$db->query())
          {
            echo "<script> alert('" . $db->getErrorMsg() . "');



	window.history.go(-1); </script>\n";
          }
      }
    $mainframe->redirect('index.php?option=' . $option . '&controller=products');
  }
function removeCategory($option)
  {$input=JFactory::getApplication()->input;
     $mainframe = JFactory::getApplication();
    JRequest::checkToken() or jexit('Invalid Token');
    $cid = $input->get('cid', array(), '', 'array');
    $db =& JFactory::getDBO();
    if (count($cid))
      {
        $cids  = implode(',', $cid);
        $query = "DELETE FROM #__spidercatalog_product_categories WHERE id IN ( ".$db->escape($cids )." )";
        $db->setQuery($query);
        if (!$db->query())
          {
            echo "<script> alert('" . $db->getErrorMsg() . "');



	window.history.go(-1); </script>\n";
          }
      }
    $mainframe->redirect('index.php?option=' . $option . '&controller=category');
  }
/////publish
function publishProducts($option)
  {$input=JFactory::getApplication()->input;
     $mainframe = JFactory::getApplication();
    JRequest::checkToken() or jexit('Invalid Token');
    $cid = $input->get('cid', array(), '', 'array');
    $db =& JFactory::getDBO();
    if (count($cid))
      {
        $cids  = implode(',', $cid);
        $query = "update   #__spidercatalog_products set published=1 WHERE id IN ( ".$db->escape($cids )." )";
        $db->setQuery($query);
        if (!$db->query())
          {
            echo "<script> alert('" . $db->getErrorMsg() . "');



	window.history.go(-1); </script>\n";
          }
      }
    $mainframe->redirect('index.php?option=' . $option . '&controller=products');
  }
function publishCategory($option)
  {$input=JFactory::getApplication()->input;
     $mainframe = JFactory::getApplication();
    JRequest::checkToken() or jexit('Invalid Token');
    $cid = $input->get('cid', array(), '', 'array');
    $db =& JFactory::getDBO();
    if (count($cid))
      {
        $cids  = implode(',', $cid);
        $query = "update   #__spidercatalog_product_categories set published=1 WHERE id IN ( ".$db->escape($cids )." )";
        $db->setQuery($query);
        if (!$db->query())
          {
            echo "<script> alert('" . $db->getErrorMsg() . "');



	window.history.go(-1); </script>\n";
          }
      }
    $mainframe->redirect('index.php?option=' . $option . '&controller=category');
  }

/////unpublish
function unpublishProducts($option)
  {$input=JFactory::getApplication()->input;
     $mainframe = JFactory::getApplication();
    JRequest::checkToken() or jexit('Invalid Token');
    $cid = $input->get('cid', array(), '', 'array');
    $db =& JFactory::getDBO();
    if (count($cid))
      {
        $cids  = implode(',', $cid);
        $query = "update   #__spidercatalog_products set published=0 WHERE id IN ( ".$db->escape($cids )." )";
        $db->setQuery($query);
        if (!$db->query())
          {
            echo "<script> alert('" . $db->getErrorMsg() . "');



window.history.go(-1); </script>\n";
          }
      }
    $mainframe->redirect('index.php?option=' . $option . '&controller=products');
  }
function unpublishCategory($option)
  {$input=JFactory::getApplication()->input;
     $mainframe = JFactory::getApplication();
    JRequest::checkToken() or jexit('Invalid Token');
    $cid = $input->get('cid', array(), '', 'array');
    $db =& JFactory::getDBO();
    if (count($cid))
      {
        $cids  = implode(',', $cid);
        $query = "update   #__spidercatalog_product_categories set published=0 WHERE id IN ( ".$db->escape($cids )." )";
        $db->setQuery($query);
        if (!$db->query())
          {
            echo "<script> alert('" . $db->getErrorMsg() . "');



window.history.go(-1); </script>\n";
          }
      }
    $mainframe->redirect('index.php?option=' . $option . '&controller=category');
  }
function saveOrderProduct(&$cid)
  {$input=JFactory::getApplication()->input;
     $mainframe = JFactory::getApplication();
    // Check for request forgeries
    JRequest::checkToken() or jexit('Invalid Token');
    // Initialize variables
    $db =& JFactory::getDBO();
    $cid   = $input->get('cid', array(), '', 'array');
    $total = count($cid);
    $order = $input->get('order', array(
        0
    ), 'post', 'array');
    JArrayHelper::toInteger($order, array(
        0
    ));
    $row =& JTable::getInstance('products', 'Table');
    $groupings = array();
    // update ordering values
    for ($i = 0; $i < $total; $i++)
      {
        $row->load((int) $cid[$i]);
        // track sections
        //echo $row->ordering;
        if ($row->ordering != $order[$i])
          {
            $row->ordering = $order[$i];
            if (!$row->store())
              {
                JError::raiseError(500, $db->getErrorMsg());
              }
          }
      }
    $msg = JText::_('New ordering saved');
    $mainframe->redirect('index.php?option=com_spidercatalog&controller=products', $msg);
  }
function saveOrderCategories(&$cid)
  {$input=JFactory::getApplication()->input;
     $mainframe = JFactory::getApplication();
    // Check for request forgeries
    JRequest::checkToken() or jexit('Invalid Token');
    // Initialize variables
    $db =& JFactory::getDBO();
    $cid   = $input->get('cid', array(), '', 'array');
    $total = count($cid);
    $order = $input->get('order', array(
        0
    ), 'post', 'array');
    JArrayHelper::toInteger($order, array(
        0
    ));
    $row =& JTable::getInstance('categories', 'Table');
    $groupings = array();
    // update ordering values
    for ($i = 0; $i < $total; $i++)
      {
        $row->load((int) $cid[$i]);
        // track sections
        //echo $row->ordering;
        if ($row->ordering != $order[$i])
          {
            $row->ordering = $order[$i];
            if (!$row->store())
              {
                JError::raiseError(500, $db->getErrorMsg());
              }
          }
      }
    $msg = JText::_('New ordering saved');
    $mainframe->redirect('index.php?option=com_spidercatalog&controller=category', $msg);
  }

function cancel($option, $controller)
  {
 $input=JFactory::getApplication()->input;
     $mainframe = JFactory::getApplication();
    if ($controller == 'product_rating' or $controller == 'product_reviews')
      {
        $product_id = $input->get('product_id', 0);
        $mainframe->redirect('index.php?option=' . $option . '&task=edit&controller=products&cid[]=' . $product_id);
      }
    else
      {
        $mainframe->redirect('index.php?option=' . $option . '&controller=' . $controller);
      }
  }
  
function editProductRatingRedirect($option)
{$input=JFactory::getApplication()->input;
	saveProduct($option, 'none');
	 $mainframe = JFactory::getApplication();
	
	$product_id = $input->get('id', "");
    $mainframe->redirect('index.php?option=' . $option . '&task=edit&controller=product_rating&product_id=' . $product_id);

}
  
function editProductReviewsRedirect($option)
{$input=JFactory::getApplication()->input;
	saveProduct($option, 'none');
     $mainframe = JFactory::getApplication();
	
	$product_id = $input->get('id', "");
    $mainframe->redirect('index.php?option=' . $option . '&task=edit&controller=product_reviews&product_id=' . $product_id);

}

function editProductRating($option)
  {$input=JFactory::getApplication()->input;
     $mainframe = JFactory::getApplication();
    $params =new jsshparams;
    $db = JFactory::getDBO();
    $product_id = $input->get('product_id', "");

    if ($product_id != '')
      {
        $filter_order_Dir = $mainframe->getUserStateFromRequest($option . '.filter_order_Dir', 'filter_order_Dir', '', 'word');
        $filter_order     = $mainframe->getUserStateFromRequest($option . '.filter_order', 'filter_order', 'order_id', 'cmd');
        $filter_state     = $mainframe->getUserStateFromRequest($option . '.filter_state', 'filter_state', '', 'word');
        //echo $filter_order_Dir;
        //echo $filter_state;
        $limit            = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
        $limitstart       = $mainframe->getUserStateFromRequest($option . '.limitstart', 'limitstart', 0, 'int');
        $ord              = $input->get('ord', 1);
        $query            = "SELECT * FROM #__spidercatalog_product_votes  WHERE product_id = '" . $db->escape($product_id) . "' ";
        $db->setQuery($query);
        $db->query();
        $total           = $db->getNumRows();
        $lists           = array();
        $lists['search'] = "";
        if ($ord and ($filter_order == "remote_ip" or $filter_order == "vote_value"))
            $order = ' ORDER BY ' . $filter_order . ' ' . $filter_order_Dir . ' ';
        else
            $order = " ORDER BY id desc";
        $query = "SELECT * FROM #__spidercatalog_product_votes  WHERE product_id = '".$db->escape($product_id )."'  $order";
        //exit;
        jimport('joomla.html.pagination');
        $pageNav = new JPagination($total, $limitstart, $limit);
        ///////////Paging//////////////////
        //echo $order;
        //exit;
        $db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum())
          {
            echo $db->stderr();
            return false;
          }
        $lists['order_Dir'] = $filter_order_Dir;
        $lists['order']     = $filter_order;
        HTML_spidercatalog::editProductRating($option, $rows, $pageNav, $product_id, $lists);
      }
  }
function saveProductRating($option, $task)
  {$input=JFactory::getApplication()->input;
     $mainframe = JFactory::getApplication();
    $db =& JFactory::getDBO();
    $rating_id  = $input->get('rating_id', array(
        0
    ), '', 'array');
    $product_id = $input->get('product_id', 0);
    foreach ($rating_id as $id)
      {
        $vote_row =& JTable::getInstance('votes', 'Table');
        $vote_value           = $input->get('vote_' . $id, '', 'post');
        $vote_row->id         = $id;
        $vote_row->vote_value = $vote_value;
        if (!$vote_row->store())
          {
            echo "<script> alert('" . $row->getError() . "');



	window.history.go(-1); </script>\n";
            exit();
          }
      }
    switch ($task)
    {
        case 'apply':
            $msg  = 'Changes to Ratings saved';
            $link = 'index.php?option=' . $option . '&task=edit&controller=product_rating&product_id=' . $product_id;
            break;
        case 'save':
        default:
            $msg  = 'Changes to Ratings saved';
            $link = 'index.php?option=' . $option . '&task=edit&controller=products&cid[]=' . $product_id;
            break;
    }
    $mainframe->redirect($link, $msg, 'message');
  }
function removeProductRating($option, $task)
  {$input=JFactory::getApplication()->input;
     $mainframe = JFactory::getApplication();
    JRequest::checkToken() or jexit('Invalid Token');
    $cid = $input->get('cid', array(), '', 'array');
    $db =& JFactory::getDBO();
    $product_id = $input->get('product_id', 0);
    if (count($cid))
      {
        $cids  = implode(',', $cid);
        $query = "DELETE FROM #__spidercatalog_product_votes WHERE id IN (".$db->escape($cids )." )";
        $db->setQuery($query);
        if (!$db->query())
          {
            echo "<script> alert('" . $db->getErrorMsg() . "');



window.history.go(-1); </script>\n";
          }
      }
    $mainframe->redirect('index.php?option=' . $option . '&controller=product_rating&task=edit&product_id=' . $product_id);
  }
/// Reviews
function editProductReviews($option)
  {$input=JFactory::getApplication()->input;
     $mainframe = JFactory::getApplication();
    $params =new jsshparams;
    $db =& JFactory::getDBO();
    $product_id = $input->get('product_id', "");
    if ($product_id != '')
      {
        $filter_order_Dir = $mainframe->getUserStateFromRequest($option . '.filter_order_Dir', 'filter_order_Dir', '', 'word');
        $filter_order     = $mainframe->getUserStateFromRequest($option . '.filter_order', 'filter_order', 'order_id', 'cmd');
        $filter_state     = $mainframe->getUserStateFromRequest($option . '.filter_state', 'filter_state', '', 'word');
        //echo $filter_order_Dir;
        //echo $filter_state;
        $limit            = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
        $limitstart       = $mainframe->getUserStateFromRequest($option . '.limitstart', 'limitstart', 0, 'int');
        $ord              = $input->get('ord', 1);
        $query            = "SELECT * FROM #__spidercatalog_product_reviews  WHERE product_id = '" . $db->escape($product_id) . "' ";
        $db->setQuery($query);
        $db->query();
        $total           = $db->getNumRows();
        $lists           = array();
        $lists['search'] = "";
        if ($ord and ($filter_order == "name" or $filter_order == "content" or $filter_order == "remote_ip"))
            $order = ' ORDER BY ' . $filter_order . ' ' . $filter_order_Dir . ' ';
        else
            $order = " ORDER BY id desc";
        $query = "SELECT * FROM #__spidercatalog_product_reviews  WHERE product_id = '" . $db->escape($product_id) . "'  $order";
        //exit;
        jimport('joomla.html.pagination');
        $pageNav = new JPagination($total, $limitstart, $limit);
        ///////////Paging//////////////////
        //echo $order;
        //exit;
        $db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum())
          {
            echo $db->stderr();
            return false;
          }
        $lists['order_Dir'] = $filter_order_Dir;
        $lists['order']     = $filter_order;
        HTML_spidercatalog::editProductReviews($option, $rows, $pageNav, $product_id, $lists);
      }
  }
function removeProductReviews($option, $task)
  {$input=JFactory::getApplication()->input;
     $mainframe = JFactory::getApplication();
    JRequest::checkToken() or jexit('Invalid Token');
    $cid = $input->get('cid', array(), '', 'array');
    $db =& JFactory::getDBO();
    $product_id = $input->get('product_id', 0);
    if (count($cid))
      {
        $cids  = implode(',', $cid);
        $query = "DELETE FROM #__spidercatalog_product_reviews WHERE id IN ( ".$db->escape($cids )." )";
        $db->setQuery($query);
        if (!$db->query())
          {
            echo "<script> alert('" . $db->getErrorMsg() . "');



window.history.go(-1); </script>\n";
          }
      }
    $mainframe->redirect('index.php?option=' . $option . '&controller=product_reviews&task=add&product_id=' . $product_id);
  }
  
  
function showOptions($option, $controller, $op_type)
  {$input=JFactory::getApplication()->input;
    HTML_spidercatalog::showOptions($op_type);
  }
  
  //show global
function showGlobal($option, $controller, $op_type)
  {$input=JFactory::getApplication()->input;
     $mainframe = JFactory::getApplication();
    $db = JFactory::getDBO();
    $table = JTable::getInstance('params ', 'Table');
    $lists = array();
    $db = JFactory::getDBO();
    $query = "SELECT *  from #__spidercatalog_params ";
    $db->setQuery($query);
    $rows = $db->loadObjectList();
    if ($db->getErrorNum())
      {
        echo $db->stderr();
        return false;
      }
    $param_values = array();
    foreach ($rows as $row)
      {
        $key                = $row->name;
        $value              = $row->value;
        $param_values[$key] = $value;
      }
  
    HTML_spidercatalog::showGlobal($option, $param_values, $controller, $op_type);
  }
//show styles
function showStyles($option, $controller, $op_type)
  {$input=JFactory::getApplication()->input;
     $mainframe = JFactory::getApplication();
    $db =JFactory::getDBO();
    $table =JTable::getInstance('params ', 'Table');
    $lists = array();
    $db = JFactory::getDBO();
    $query = "SELECT *  from #__spidercatalog_params ";
    $db->setQuery($query);
    $rows = $db->loadObjectList();
    if ($db->getErrorNum())
      {
        echo $db->stderr();
        return false;
      }
    $param_values = array();
    foreach ($rows as $row)
      {
        $key                = $row->name;
        $value              = $row->value;
        $param_values[$key] = $value;
      }
    HTML_spidercatalog::showStyles($option, $param_values, $controller, $op_type);
  }

function saveGlobal($option, $task)
  {$input=JFactory::getApplication()->input;
     $mainframe = JFactory::getApplication();
    $db =& JFactory::getDBO();
    $params = $input->get('params', array(
        0
    ), '', 'array');
    $db =& JFactory::getDBO();
    foreach ($params as $key => $value)
      {
        $query = "update  #__spidercatalog_params set value='".$db->escape($value )."' where name='".$db->escape($key )."' ";
        $db->setQuery($query);
        if (!$db->query())
          {
            echo "<script> alert('" . $db->getErrorMsg() . "');
window.history.go(-1); </script>\n";
          }
      }
    switch ($task)
    {
        case 'apply':
            $msg  = 'Changes to global options saved';
            $link = 'index.php?option=' . $option . '&controller=options&op_type=global';
            break;
        case 'save':
        default:
            $msg  = 'Changes to global options  saved';
            $link = 'index.php?option=' . $option . '&controller=options';
            break;
    }
    $mainframe->redirect($link, $msg, 'message');
  }
function saveStyles($option, $task)
  {$input=JFactory::getApplication()->input;
     $mainframe = JFactory::getApplication();
    $db =& JFactory::getDBO();
    $params = $input->get('params', array(
        0
    ), '', 'array');
    $db =& JFactory::getDBO();
    foreach ($params as $key => $value)
      {
        $query = "update  #__spidercatalog_params set value='".$db->escape($value )."' where name='".$db->escape($key )."' ";
        $db->setQuery($query);
        if (!$db->query())
          {
            echo "<script> alert('" . $db->getErrorMsg() . "');
window.history.go(-1); </script>\n";
          }
      }
    switch ($task)
    {
        case 'apply':
            $msg  = 'Changes to Styles saved';
            $link = 'index.php?option=' . $option . '&controller=options&op_type=styles';
            break;
        case 'save':
        default:
            $msg  = 'Changes to Styles  saved';
            $link = 'index.php?option=' . $option . '&controller=options';
            break;
    }
    $mainframe->redirect($link, $msg, 'message');
  }
    function media_manager_image()
{
	HTML_spidercatalog::media_manager_image();
}


?>