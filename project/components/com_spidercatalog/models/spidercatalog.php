<?php
/**
 * @package Spider Catalog
 * @author Web-Dorado
 * @copyright (C) 2012 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined ('_JEXEC')  or  die();
jimport( 'joomla.application.component.model' );
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

class spidercatalogModelspidercatalog extends JModelLegacy
{

function open_cat_in_tree($catt,$tree_problem='',$hihiih=1){

$db =JFactory::getDBO();
static $trr_cat=array();
if($hihiih)
$trr_cat=array();
foreach($catt as $dog){
	$dog->name=$tree_problem.$dog->name;
	array_push($trr_cat,$dog);
	$new_cat_query=	"SELECT  a.* ,  COUNT(b.id) AS count, g.par_name AS par_name FROM #__spidercatalog_product_categories  AS a LEFT JOIN #__spidercatalog_product_categories AS b ON a.id = b.parent LEFT JOIN (SELECT  #__spidercatalog_product_categories.`ordering` as `ordering`, #__spidercatalog_product_categories.id AS id, COUNT( #__spidercatalog_products.category_id ) AS prod_count
FROM #__spidercatalog_products, #__spidercatalog_product_categories
WHERE (#__spidercatalog_products.category_id like concat(#__spidercatalog_product_categories.id,',%') or #__spidercatalog_products.category_id like concat('%,',#__spidercatalog_product_categories.id,',%'))
GROUP BY #__spidercatalog_products.category_id) AS c ON c.id = a.id LEFT JOIN
(SELECT #__spidercatalog_product_categories.name AS par_name,#__spidercatalog_product_categories.id FROM #__spidercatalog_product_categories) AS g
 ON a.parent=g.id WHERE a.parent=".$db->escape($dog->id)." group by a.id"; 
 
 	$db->setQuery($new_cat_query);
	$new_cat = $db->loadObjectList();
 
 $this->open_cat_in_tree($new_cat,$tree_problem. "— ",0);
}
return $trr_cat;

}
function get_cat_childs_ids($cat_id=0){

$db = JFactory::getDBO();

$cat_ids='';
if(!$cat_id){

return $cat_ids;
}
else
{

	$loc_ids = "SELECT id FROM #__spidercatalog_product_categories WHERE parent like '%".$db->escape($cat_id)."%'";
	$db->setQuery($loc_ids);
	$loc_ids = $db->loadObjectList();
	
$count_cat=count($loc_ids);
if($count_cat){
for($i=0;$i<$count_cat;$i++){
if($cat_ids)
	$cat_ids=$cat_ids.','.$loc_ids[$i]->id.','.$this->get_cat_childs_ids($loc_ids[$i]->id);
	else
	$cat_ids=$loc_ids[$i]->id.','.$this->get_cat_childs_ids($loc_ids[$i]->id);
}
return str_replace(',,',',',$cat_ids);
}
else
return '';

}
}
function remov_last_storaket($str='')
{
if($str){
$last = $str[strlen($str)-1];
if($last==',')
{
$str=substr_replace($str ,"",-1);
}
if(!$str)
$str='0';
}
return  $str;
}



function showPublishedProducts()
{

$session = JFactory::getSession();
$sel_cat = JRequest::getVar('select_categories', 0);
$session->set( 'sel_categories', $sel_cat );
	$input=JFactory::getApplication()->input;
	$option=JRequest::getVar('option');	
	//echo "*".JRequest::getVar('page_num')."*".JRequest::getVar('workses');
//echo JRequest::getVar('select_categories', 0);
	if(JRequest::getVar('workses',0) == 1 ){
//if(true){
//echo '-1a-';
$select_categories=$session->get( 'select_categories', 0 );
//$select_categories=JRequest::getVar('select_categories', 0);
$show_category_details=$session->get( 'show_category_details', 0 );
$display_type=$session->get( 'display_type', 0 );
$show_subcategories=JRequest::getVar('show_subcategories', -1);
$show_subcategories_products=JRequest::getVar('show_subcategories_products', 2);
$show_products=$session->get( 'show_products', 1 );
}
else
{
//echo '-2a-';
$session->set( 'prod_name', '');
$select_categories=JRequest::getVar('select_categories', 0);
//$select_categories=$session->get( 'select_categories', 0);
$show_category_details=JRequest::getVar('show_category_details', 0);
$display_type=JRequest::getVar('display_type', 0);
$show_subcategories=JRequest::getVar('show_subcategories', -1);
$show_subcategories_products=JRequest::getVar('show_subcategories_products', 2);
$show_products=JRequest::getVar('show_products', 1);
$select_categories=JRequest::getVar('select_categories', 0);
//$session->set( 'prod_name', '' );
}
if($show_subcategories==-1){
$select_categories=JRequest::getVar('categories', 0);
}

	if(JRequest::getVar('prod_name', '') != ''){
	$session->set( 'prod_name', JRequest::getVar('prod_name', '') );
	}

$prod_name = JRequest::getVar( 'prod_name', '' );
//echo JRequest::getVar('tiko',0);

if(JRequest::getVar('tiko',0) == 1){
$select_categories='0';
$prod_name='';
$session->set( 'prod_name', '');
}

//echo JRequest::getVar('page_num', 1);

if(JRequest::getVar('page_num', 0) > 0){
	$session->set( 'page_num', JRequest::getVar('page_num', 1) );
	}

	$page_num = JRequest::getVar('page_num', 1);
/*
	if($page_num > 1)
{
$page_num = $session->get( 'page_num', 1 );
}
*/
if(JRequest::getVar('cat_id',0) == 0){
$session->set( 'select_categories', '0' );
}

$allcatselect=JRequest::getVar('allcatselect');
if($allcatselect == 1){
$session->set( 'select_categories', '0' );
//print_r($session);
}
if($show_subcategories==-1)
$select_categories=JRequest::getVar('categories', 0);


$params1=array('select_categories' => $select_categories,'show_category_details' => $show_category_details, 'display_type' => $display_type, 'show_subcategories' => $show_subcategories, 'show_subcategories_products' => $show_subcategories_products, 'show_products' => $show_products);

$menu_id = $params1['select_categories'];

$params = new jsshparams;
$doc =JFactory::getDocument();
if($params1['display_type']=="list" or $params1['display_type']=="cube")
$prod_in_page=$params->get( 'count_of_products_in_the_page' );
else
$prod_in_page=$params->get( 'count_of_product_in_the_row' )*$params->get( 'count_of_rows_in_the_page' );

//$page_num=JRequest::getVar('page_num', 1);
$cat_id=JRequest::getVar('cat_id', 0);




$db =JFactory::getDBO();

if($cat_id=="")
$cat_id = $menu_id;
			
$subcat_id=JRequest::getVar('subcat_id',$cat_id);

if(!$subcat_id)
{
$subcat_id=$cat_id;
}
			$categ_query = "SELECT * FROM #__spidercatalog_product_categories WHERE parent='".$db->escape($subcat_id)."' AND `published`=1 ORDER BY `ordering` ASC ";
			$db->setQuery($categ_query);
			$child_ids = $db->loadObjectList();

//$prod_name=$session->get( 'prod_name', '' );
if($prod_name=='Search...'){
$prod_name='';
}
//$cat_id =	$menu_id;		
if($cat_id>0)
{
		if($params1['show_subcategories_products']==2){
		
	
		$query_count = "SELECT count(#__spidercatalog_products.id) as prod_count FROM #__spidercatalog_products 
		left join #__spidercatalog_product_categories  
		on 
		(#__spidercatalog_products.category_id like concat(#__spidercatalog_product_categories.id,',%') or #__spidercatalog_products.category_id like concat('%,',#__spidercatalog_product_categories.id,',%'))
		
		left join #__spidercatalog_id 
		on 
		#__spidercatalog_products.id=#__spidercatalog_id.proid
		WHERE	
		#__spidercatalog_products.published = '1'  and (#__spidercatalog_id.cateid = '".$db->escape($subcat_id)."'   ";
		
		$query = "SELECT #__spidercatalog_products.*, #__spidercatalog_product_categories.name as cat_name,

		#__spidercatalog_product_categories.category_image_url as cat_image_url, #__spidercatalog_product_categories.id as cat_id, #__spidercatalog_product_categories.description as cat_description, #__spidercatalog_product_categories.id as cat_id,
		#__spidercatalog_id.*
		FROM #__spidercatalog_products 
		left join #__spidercatalog_product_categories  
		on 
		(#__spidercatalog_products.category_id like concat(#__spidercatalog_product_categories.id,',%') or #__spidercatalog_products.category_id like concat('%,',#__spidercatalog_product_categories.id,',%'))
		
		left join #__spidercatalog_id 
		on 
		#__spidercatalog_products.id=#__spidercatalog_id.proid
		WHERE	
		#__spidercatalog_products.published = '1'  and (#__spidercatalog_id.cateid = '".$db->escape($subcat_id)."'   ";

			if($this->remov_last_storaket($this->get_cat_childs_ids($subcat_id))!=='')
			{
				$query .= "OR (#__spidercatalog_products.category_id IN (".$this->remov_last_storaket($this->get_cat_childs_ids($subcat_id)).") AND #__spidercatalog_products.published_in_parent = '1') ";
				$query_count .= "OR (#__spidercatalog_products.category_id IN (".$this->remov_last_storaket($this->get_cat_childs_ids($subcat_id)).") AND #__spidercatalog_products.published_in_parent = '1') ";
			}
			$query .= ")";
			$query_count .= ")";
		
			
		
		}
		else if($params1['show_subcategories_products']==1)
		{
		
		$query_count = "SELECT count(#__spidercatalog_products.id) as prod_count FROM #__spidercatalog_products left join #__spidercatalog_product_categories on (#__spidercatalog_products.category_id like concat(#__spidercatalog_product_categories.id,',%') or #__spidercatalog_products.category_id like concat('%,',#__spidercatalog_product_categories.id,',%')) WHERE		
		#__spidercatalog_products.published = '1'  and (#__spidercatalog_products.category_id like '".$db->escape($subcat_id).",%' or #__spidercatalog_products.category_id like '%,".$db->escape($subcat_id).",%'  ";
		
		$query = "SELECT #__spidercatalog_products.*, #__spidercatalog_product_categories.name as cat_name, #__spidercatalog_product_categories.category_image_url as cat_image_url, #__spidercatalog_product_categories.id as cat_id, #__spidercatalog_product_categories.id as cat_id, #__spidercatalog_product_categories.description as cat_description FROM #__spidercatalog_products left join #__spidercatalog_product_categories on (#__spidercatalog_products.category_id like concat(#__spidercatalog_product_categories.id,',%') or #__spidercatalog_products.category_id like concat('%,',#__spidercatalog_product_categories.id,',%')) WHERE		
		#__spidercatalog_products.published = '1'  and (#__spidercatalog_products.category_id like '".$db->escape($subcat_id).",%' or #__spidercatalog_products.category_id like '%,".$db->escape($subcat_id).",%'  ";
		
		
		
		
if($this->remov_last_storaket($this->get_cat_childs_ids($subcat_id))!=='')
	{
		$query .= "OR (#__spidercatalog_products.category_id IN (".$this->remov_last_storaket($this->get_cat_childs_ids($db->escape($subcat_id))).")) ";
		$query_count .= "OR (#__spidercatalog_products.category_id IN (".$this->remov_last_storaket($this->get_cat_childs_ids($db->escape($subcat_id))).")) ";
	}
		$query .= ")";
		$query_count .= ")";
		
		}
		else{
	$query_count = "SELECT count(#__spidercatalog_products.id) as prod_count FROM #__spidercatalog_products left join #__spidercatalog_product_categories on (#__spidercatalog_products.category_id like concat(#__spidercatalog_product_categories.id,',%') or #__spidercatalog_products.category_id like concat('%,',#__spidercatalog_product_categories.id,',%')) WHERE		
		#__spidercatalog_products.published = '1'  and #__spidercatalog_products.category_id like '".$db->escape($subcat_id).",%' or #__spidercatalog_products.category_id like '%,".$db->escape($subcat_id).",%'  ";
		$query = "SELECT #__spidercatalog_products.*, #__spidercatalog_product_categories.name as cat_name, #__spidercatalog_product_categories.category_image_url as cat_image_url, #__spidercatalog_product_categories.id as cat_id, #__spidercatalog_product_categories.id as cat_id, #__spidercatalog_product_categories.description as cat_description FROM #__spidercatalog_products left join #__spidercatalog_product_categories on (#__spidercatalog_products.category_id like concat(#__spidercatalog_product_categories.id,',%') or #__spidercatalog_products.category_id like concat('%,',#__spidercatalog_product_categories.id,',%')) WHERE		
		#__spidercatalog_products.published = '1'  and #__spidercatalog_products.category_id like '".$db->escape($subcat_id).",%' or #__spidercatalog_products.category_id like '%,".$db->escape($subcat_id).",%'  ";
		}
			
		$cat_query= "SELECT #__spidercatalog_product_categories.name as cat_name,#__spidercatalog_product_categories.category_image_url as cat_image_url, #__spidercatalog_product_categories.id as cat_id, #__spidercatalog_product_categories.description as cat_description FROM #__spidercatalog_product_categories WHERE published = '1' and id= '".$db->escape($subcat_id)."' ";
		}
		else
		{
		$query_count = "SELECT count(#__spidercatalog_products.id) as prod_count FROM #__spidercatalog_products  WHERE 
		#__spidercatalog_products.published = '1' ";
		
		$query= "SELECT  #__spidercatalog_products.*, #__spidercatalog_product_categories.name as cat_name, #__spidercatalog_product_categories.category_image_url as cat_image_url,#__spidercatalog_product_categories.description as cat_description FROM #__spidercatalog_products left join #__spidercatalog_product_categories on (#__spidercatalog_products.category_id like concat(#__spidercatalog_product_categories.id,',%') or #__spidercatalog_products.category_id like concat('%,',#__spidercatalog_product_categories.id,',%'))
		WHERE 
		#__spidercatalog_products.published = '1'  ";
		$cat_query= "SELECT #__spidercatalog_product_categories.name as cat_name,#__spidercatalog_product_categories.category_image_url as cat_image_url, #__spidercatalog_product_categories.id as cat_id, #__spidercatalog_product_categories.description as cat_description FROM #__spidercatalog_product_categories WHERE published = '1'  ";


		
if($cat_id!=0)
{
	
	if(is_numeric($cat_id) and $params1['show_subcategories_products']==2){
			$query_count .= " and (#__spidercatalog_products.category_id like '%".$db->escape($cat_id)."%'  OR ( #__spidercatalog_products.category_id IN (".$this->remov_last_storaket($this->get_cat_childs_ids($db->escape($cat_id))).") AND #__spidercatalog_products.published_in_parent = '1'))";
			
			$query .= " and (#__spidercatalog_products.category_id='".$db->escape($cat_id)."'";  
			if($this->remov_last_storaket($this->get_cat_childs_ids($cat_id))!=='')
			$query .= " OR (#__spidercatalog_products.category_id IN (".$this->remov_last_storaket($this->get_cat_childs_ids($db->escape($cat_id))).") AND #__spidercatalog_products.published_in_parent = '1')";
			
			$query .= ")";
		
			}
			else if($params1['show_subcategories_products']==1)
			{
			$query_count .= " and (#__spidercatalog_products.category_id like '%".$db->escape($cat_id)."%'  OR ( #__spidercatalog_products.category_id IN (".$this->remov_last_storaket($this->get_cat_childs_ids($db->escape($cat_id))).")))";
			$query .= " and (#__spidercatalog_products.category_id like '%".$db->escape($cat_id)."%'  OR ( #__spidercatalog_products.category_id IN (".$this->remov_last_storaket($this->get_cat_childs_ids($cat_id)).")))";
			}
			else{
			$query_count .= " and (#__spidercatalog_products.category_id like '".$db->escape($cat_id).",%'  or #__spidercatalog_products.category_id like '%,".$db->escape($cat_id).",%')";
			$query .= " and (#__spidercatalog_products.category_id like '".$db->escape($cat_id).",%'  or #__spidercatalog_products.category_id like '%,".$db->escape($cat_id).",%')  ";
			}
		}
		}
	
if($prod_name!="")
{
$query_count .= " and (#__spidercatalog_products.name like '%".$db->escape($prod_name )."%' or #__spidercatalog_products.description like '%".$db->escape($prod_name )."%' or #__spidercatalog_products.param like '%".$db->escape($prod_name )."%' ) group by  #__spidercatalog_products.id ";
$query .= " and (#__spidercatalog_products.name like '%".$db->escape($prod_name )."%' or #__spidercatalog_products.description like '%".$db->escape($prod_name )."%' or #__spidercatalog_products.param like '%".$db->escape($prod_name )."%' )  ";
}

$query .= " group by  #__spidercatalog_products.id  order by #__spidercatalog_products.`ordering`  limit ".(($page_num-1)*$prod_in_page).",$prod_in_page  ";
if($prod_name=="")
{
$query_count .= "group by #__spidercatalog_products.id";
}
$db->setQuery($query_count);
$row = $db->loadAssocList();
$prod_count=count($row);
//echo $prod_count;

$db->setQuery($query);
$rows = $db->loadObjectList();

if ($db->getErrorNum())
{
echo $db->stderr();
return false;
}

$db->setQuery($cat_query);

$cat_rows = $db->	loadObjectList();

if ($db->getErrorNum())
{
echo $db->stderr();
return false;
}


if($params1['show_products']==1){


		foreach($rows as $row)
		{
			$id=$row->id;
	$query= "SELECT AVG(vote_value) as rating FROM #__spidercatalog_product_votes  WHERE product_id = '".$db->escape($id )."' ";

	$db->setQuery($query);
	$row1 = $db->loadAssoc();
	$ratings[$id]=substr($row1['rating'],0,3);
	$query= "SELECT vote_value FROM #__spidercatalog_product_votes  WHERE product_id = '".$db->escape($id )."'  and remote_ip='".$_SERVER['REMOTE_ADDR']."' ";
	$db->setQuery($query);
	$db->query();

	$num_rows = $db->getNumRows();
	$voted[$id]=$num_rows;

	$query= "SELECT * FROM #__spidercatalog_product_categories  ";	
	$db->setQuery($query);	
	$row2 = $db->loadAssoc();	
	$categories=$db->loadObjectList();			
	}
	
}
			$query= "SELECT * FROM #__spidercatalog_product_categories WHERE parent=0 AND `published`=1 ORDER BY `ordering` ASC ";	
			
			$db->setQuery($query);
			$category_list = $db->loadObjectList();

			if(!$subcat_id)
			$subcat_id=$cat_id;
			
			$cat_query = "SELECT * FROM #__spidercatalog_product_categories WHERE `published`=1 AND id=".$db->escape($subcat_id)."";
	
			
			$db->setQuery($cat_query);
			$categor = $db->loadObjectList();

			$par = JRequest::getVar('par');
			foreach($categor as $chid)
			{
            $par=$chid->parent;
            }
					
			if($params1['show_subcategories']==1){
			
			$category_list=$this->open_cat_in_tree($category_list);
			}
			 $rows3=array();
   $count_of_cat=count( $category_list);
   $ii=0;
   for($k=0;$k<$count_of_cat;$k++){
		if($category_list[$k]->published){
		$rows3[$ii]=$category_list[$k];
		$ii++;
		}
   }
   $category_list= $rows3;
   
   $session->set( 'view', 'showproduct' );
//$session->set( 'page_num', $page_num );
$session->set( 'back', '1' );
$session->set( 'show_category_details', $params1["show_category_details"] );

$session->set( 'display_type', $params1["display_type"] );

//$session->set( 'show_subcategories', $params1["show_subcategories"] );
//$session->set( 'show_subcategories_products', $params1["show_subcategories_products"] );
$session->set( 'show_products', $params1["show_products"] );
$session->set( 'select_categories', $cat_id );
$session->set( 'sel_categories', JRequest::getVar('cat_id') );
$session->set( 'Itemid', JRequest::getVar('Itemid') );


return array($rows, $option,$params,$page_num,$prod_count,$prod_in_page,@$ratings,@$voted,@$categories,$category_list,$params1,$cat_rows,$cat_id,$child_ids,$categor,$par,$subcat_id, $prod_name);



}

}

?>