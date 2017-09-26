<?php
/**
 * @package Spider Catalog
 * @author Web-Dorado
 * @copyright (C) 2012 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/ 
 
 
defined('_JEXEC') or die('Restricted access');

$rows = $this->rows;
$option = $this->option;
$params = $this->params;
$page_num = $this->page_num;
$prod_count = $this->prod_count;
$prod_in_page = $this->prod_in_page;
$ratings = $this->ratings;
$voted = $this->voted;
$categories = $this->categories;
$category_list = $this->category_list;
$params1 = $this->params1;
$cat_rows=$this->cat_rows;
$cat_id=$this->cat_id;
$child_ids=$this->child_ids;
$categor=$this->categor;
$par=$this->par;
$subcat_id=$this->subcat_id;
$prod_name=$this->prod_name;
$input=JFactory::getApplication()->input;
?>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<?php
if ($params->get('enable_rating')):
?>
<style type="text/css">
.star-rating {
background: url(<?php  echo JURI::root() . '/components/' . $option . '/images/star' . $params->get('rating_star') . '.png';
?>) top left repeat-x !important;
}
.star-rating li a:hover {
background: url(<?php  echo JURI::root() . '/components/' . $option . '/images/star' . $params->get('rating_star') . '.png';
?>) left bottom !important;
}
.star-rating li.current-rating {
background: url(<?php  echo JURI::root() . '/components/' . $option . '/images/star' . $params->get('rating_star') . '.png';
?>) left center !important;
}
.star-rating1 {
background: url(<?php  echo JURI::root() . '/components/' . $option . '/images/star' . $params->get('rating_star') . '.png';
?>) top left repeat-x !important;
}
.star-rating1 li.current-rating {
background: url(<?php  echo JURI::root() . '/components/' . $option . '/images/star' . $params->get('rating_star') . '.png';
?>) left center !important;
}
</style>
<?php
endif;

if ($params->get('rounded_corners')):
?>
<style type="text/css">
#productCartFull tr:last-child td:first-child
{
-webkit-border-bottom-left-radius: 8px;
-moz-border-radius-bottomleft: 8px;
border-bottom-left-radius: 8px;
}

#productCartFull tr:last-child td:last-child
{
-webkit-border-bottom-right-radius: 8px;
-moz-border-radius-bottomright: 8px;
border-bottom-right-radius: 8px;
}

#productCartFull td table td
{
-webkit-border-radius: 0px !important;
-moz-border-radius: 0px !important;
border-radius: 0px !important;
}

</style>
<?php
endif;

$menu = JFactory::getApplication()->getMenu();
$active = $menu->getActive();  
   if($active){
$meta_description = $active->params->get('menu-meta_description');
$meta_keywords = $active->params->get('menu-meta_keywords');

$doc = JFactory::getDocument();
if($meta_description)
			$doc->setDescription($meta_description);
if($meta_keywords)
			$doc->setMetadata('keywords',$meta_keywords);
}

$menu = JFactory::getApplication()->getMenu();
$active = $menu->getActive();  
   if($active){
   $menuname = $active->params->get('page_heading');
   if($active->params->get('show_page_heading', 1)==1){      
      echo "<h1>".$menuname."</h1>";
   }
}


$session = JFactory::getSession();

$aa= JRequest::getVar('session_id');

$pagenumid= JRequest::getVar('page_num');

?>
<script>

function catt_idd(id)
{ 

	document.getElementById("subcat_id").value=id;
	
	document.cat_form.submit();
	}

</script>

<?php
$config = JFactory::getConfig();
//echo $config->get( 'sef' );
foreach($categor as $chidd){

if(($input->get('cat_id')>0 or $input->get('subcat_id')>0) and $input->get('cat_id')!=$params1['select_categories'] and $input->get('subcat_id')!=$params1['select_categories'] and $par!=0 and $params1['show_category_details']==1){

//echo '<a style="cursor:pointer;" onclick="catt_idd('.$chidd->parent.')" >'.('Back to Catalog').'</a>';
echo '<a style="cursor:pointer;" class="subthissubcatback'.$chidd->parent.'" >'.('Back to Catalog').'</a>';
?>
	<script>
	$("a.subthissubcatback<?php echo $chidd->parent; ?> ").click(function(){

 
 $('select[name="cat_id"]').val("<?php echo $chidd->parent; ?>");
	 $("#cat_form_page_nav").submit();
	  return false;
	 
});
</script>
<?php
}
}
if(($params1['select_categories'] > 0 or $cat_id!=0) and $params1['show_category_details']==1 )
{


echo '<div id="productMainDiv" style="border-width:'.$params->get( 'border_width' ).'px;border-color:#'.$params->get( 'border_color' ).';border-style:'.$params->get( 'border_style' ).';'.(($params->get( 'text_size_big' )!='')?('font-size:'.$params->get( 'text_size_big' ).'px;'):'').(($params->get( 'text_color' )!='')?('color:#'.$params->get( 'text_color' ).';'):'').'">';


echo '<div id="prodTitle" style="background-repeat: no-repeat !important;background-position: 3% 0%;text-align: right;width:370px;background-color:#004372 !important;'.(($params->get( 'title_color' )!='')?('color:#ffffff;'):'').(($params->get( 'title_background_color' )!='')?('background-color:#'.$params->get( 'title_background_color' ).';'):'').'padding:20px;font-size:25px;">' .$cat_rows[0]->cat_name.'</div>';


$imgurl=explode(";",$cat_rows[0]->cat_image_url);
echo '<table id="category" border="0" cellspacing="10" cellpadding="10">
<tr>';

if($cat_rows[0]->cat_image_url!="" and $cat_rows[0]->cat_image_url!=";")
{
				if(strpos($imgurl[0],'http://')===0 or strpos($imgurl[0],'https://')===0)
				$fullhref=$imgurl[0];
				else
				$fullhref=JURI::root().$imgurl[0];

	echo '<td valign="top">
			<table cellpadding="0" cellspacing="5" border="0" style="margin:0px;">
			<tr><td colspan="2" id="prod_main_picture_container" valign="top">
			<div style="border: #CCCCCC solid 2px;padding:5px;background-color:#white;">
			<a href="'.$imgurl[0].'" target="_blank" id="prod_main_picture_a" style="text-decoration:none;">
			<div id="prod_main_picture" style="width:'.($params->get( 'category_picture_width' )).'px;height:'.($params->get( 'category_picture_height' )).'px; background:url(index.php?option=com_spidercatalog&view=picturecat&format=raw&tmpl=component&id='.$chidd->id.'&picnum=0&height='.$params->get( 'category_picture_height' ).'&width='.$params->get( 'category_picture_width' ).'&reverse='.$params->get( 'global_revers' ).') center no-repeat;">&nbsp;</div></a></div>
			</td></tr>';

	echo'<tr><td style="text-align:justify;">';

$small_images_str='';
$small_images_count=0;

foreach($imgurl as $key=>$img)
{
if($img!=='')
{
				if(strpos($img,'http://')===0 or strpos($img,'https://')===0)
				$fullhref=$img;
				else
				$fullhref=JURI::root().$img;


$small_images_str.='<a href="'.$img.'" target="_blank"><img src="index.php?option=com_spidercatalog&view=picturecat&format=raw&tmpl=component&id='.$cat_rows[0]->cat_id.'&picnum='.$key.'&height=50" vspace="0" hspace="0" onMouseOver="prod_change_picture(\''.$cat_rows[0]->cat_id.'&picnum='.$key.'\',this,'.$params->get( 'category_picture_width' ).','.$params->get( 'category_picture_height' ).');" /></a>
';
$small_images_count++;
}
}
if($small_images_count>1)
echo $small_images_str;
else
echo '&nbsp;';

echo '</td></tr>
</table></td>';
}

echo'<td valign="top">
'.$cat_rows[0]->cat_description.'
</td>
</tr></table>';

echo '<table id="category" border="0" cellspacing="10" cellpadding="10">';
if( count($child_ids) and $params1['show_subcategories']==1)
{

echo '<center><div><div id="prodTitle" style="width:190px;background-color:#004372 !important;'.(($params->get('title_color')!='')?('color:#ffffff;'):'').(($params->get( 'title_background_color')!='')?('background-color:#'.$params->get( 'title_background_color').';'):'').'padding:10px;font-size:'.$params->get( 'category_title_size').'px;">Subcategories</div></center>';


?>
<script>
function change_subcat(id)
{
	document.getElementById("subcat_id").value=id;
	
	document.cat_form.submit();
	}
</script>
<?php
echo '<tr>
<td style="padding:10px;width:130px;background-color:#f4f4f4;border-right: solid 1px #ffffff !important;"><center>Image</center></td>
<td style="width:150px;background-color:#f4f4f4;border-right: solid 1px #ffffff !important;"><center>Name</center></td>
<td style="width:350px;background-color:#f4f4f4;border-right: solid 1px #ffffff !important;"><center>Description</center></td></tr>';


foreach ($child_ids as $key=>$chid)
{
$imgurl=explode(";",$chid->category_image_url);

if($key%2==0){
$backgurl=''.JURI::root().'components/com_spidercatalog/images/stverlist.png';
$backgurl2='';
$backcolor='f6f6f6';
$backcolor2='';
}
if($key%2!=0){
$backgurl='';
$backgurl2=''.JURI::root().'components/com_spidercatalog/images/stverlist2.png';
$backcolor2='f6f6f6';
}
	
$uri2	= JFactory::getURI();		
			$url2=$uri2->toString();
	
	
		echo '<tr style="background-color:#'.$backcolor2.';"><td style="width:150px; background-repeat: no-repeat;background-image: url('.$backgurl.'); background-size: 100% 5%;" vertical-align: middle;background-color:#'.$backcolor.'"><br>';
if(!($chid->category_image_url!="" and $chid->category_image_url!=";"))
{
$imgurl[0]="components/com_spidercatalog/images/noimage.jpg";
echo '<img src="' .$imgurl[0]. '" vspace="0" hspace="0" style="max-width:'. $params->get('small_picture_width') . 'px; max-height:' . $params->get('small_picture_height') . 'px" />';
}else{
				if(strpos($imgurl[0],'http://')===0 or strpos($imgurl[0],'https://')===0)
				$fullhref=$imgurl[0];
				else
				$fullhref=JURI::root().$imgurl[0];

				
	echo ' <a href="' . $imgurl[0] . '" target="_blank" ><img src="' .$fullhref. '" vspace="0" hspace="0" style="max-width:'. $params->get('small_picture_width') . 'px; max-height:' . $params->get('small_picture_height') . 'px" /></a>';
}
	echo '</td>';
	echo '<td style="width:160px;vertical-align: middle;">';
    echo  ''.'<a class="subthissubcat'.$chid->id.'" style="'.(($params->get('text_size_small') != '') ? ('font-size:' . $params->get('text_size_small') . 'px !important;') : '').';cursor:pointer; '.(($params->get( 'hyperlink_color')!='')?('color:#'.$params->get( 'hyperlink_color').';'):'').'; font-size:inherit;"  >'.$chid->name.'</a>';
	
	?>
	
	<script>
	$("a.subthissubcat<?php echo $chid->id; ?>").click(function(){

 
 $('select[name="cat_id"]').val("<?php echo $chid->id; ?>");
  $('input[name="prod_name"]').val("");
	 $("#cat_form_page_nav").submit();
	  return false;
	 
});
</script>
	
	<?php
	

echo'</td><td style="width:355px;background-repeat: no-repeat;background-image: url('.$backgurl2.'); background-size: 100% 5%;">
'.$chid->description.'
</td>';

}
echo '</tr></table>';
}

echo '</div>';
}

?>
<div id="productMainDiv" style="text-align:center">
<?php
if ((!$params->get("choose_category") and ($params1['select_categories'] > 0)) or !$params->get("search_by_name"))
 {
  echo '<script>
  if(document.getElementById("cat_form_page_nav"))
  document.getElementById("cat_form_page_nav").style.display = "none";
  </script>'; 
  }

  $uri2	= JFactory::getURI();		
			$url2=$uri2->toString();


	echo '<table><table><form action="" method="post" name="cat_form" id="cat_form_page_nav" style="display:block;">
<input type="hidden" name="page_num"	value="1">
<input type="hidden" name="subcat_id" id="subcat_id" value="">
<input type="hidden" name="tiko" id="tiko" value="0">
<input type="hidden" name="workses" id="workses" value="1" />
<input type="hidden" name="select_categories" id="select_categories" value="'.$cat_id.'" />
<input type="hidden" name="allcatselect" id="allcatselect" value="0">
<div class="CatalogSearchBox">';




?>

<script>
function valuenone()
{
<?php
if ( $params->get("search_by_name") and $params1['show_products']==1)
{
?>
document.getElementById("prod_name").value="";
<!-- form.allcatselect.value='1'; -->
<?php
}
?>

}
</script>


<?php


if ($params->get("choose_category") and !($params1['select_categories'] > 0)) 
{

?>

<div style="display: block;">
<div style="position:relative;">


<div style="bottom: -40px;margin-right: -55px;height: 30px;width: 192px !important;border: none;display: block;background-color: #ececec;position: absolute;right: 12%;webkit-border-radius: 0px !important;-moz-border-radius: 0px !important;border-radius: 0px !important;"></div>
<?php

foreach ($category_list as $category){
if($category->id == $cat_id){
?>
<div style="text-align: left !important;
bottom: -35px;
border: none;
display: block;
position: absolute;
left: 69%;"><?php echo $category->name ; ?></div>

<?php
}}
if($cat_id == '0'){
?>
<div style="text-align: left !important;
bottom: -35px;
border: none;
display: block;
position: absolute;
left: 69%;"><?php echo JText::_('SH_ALL') ; ?></div>
<?php
}
?>
<div  style="background-color:#<?php echo $params->get('select_icon_color'); ?> ;right: 20px !important;position:absolute;bottom: -40px;width:30px;height:30px;background-repeat: no-repeat;background-image: url('components/com_spidercatalog/images/selectcat.png');background-size: 100% 100%; border: 0px;cursor: pointer;"></div>
<?php


	echo JText::_('SH_CHOOSE_CATEGORY') . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		
		
		<select style="opacity:0;margin-right: -61px;height: 30px;width: 197px !important;border: none;display: block;background-color: #ececec;position: absolute;right: 12%;webkit-border-radius: 0px !important;-moz-border-radius: 0px !important;border-radius: 0px !important;" id="cat_id" name="cat_id" class="spidercataloginput" size="1" onChange="if(this.value!=0){valuenone();this.form.submit();}else{cat_form_allcateg(form);}"> 
		<option value="0">' . JText::_('SH_ALL') . '</option> ';
    
   
    foreach ($category_list as $category)
	
    {   if($input->get('subcat_id')){echo $input->get('subcat_id');
	
        if ($input->get('subcat_id')==$category->id){
            echo '<option value="' . $category->id . '"  selected="selected">' . $category->name . '</option>';
			}
			else
            echo '<option value="' . $category->id . '" >' . $category->name . '</option>';
			}
			else 
			if($category->id == $cat_id){
				echo '<option value="' . $category->id . '"  selected="selected">' . $category->name . '</option>';
			}else{
				echo '<option value="' . $category->id . '" >' . $category->name . '</option>';
			}
    }
        
    echo '</select>';
	?>
	</div></div>
	<?php
}
if ($params1['select_categories'] > 0) 
{

?>

<div style="display: block;">
<div style="position:relative;">


<div style="bottom: -40px;margin-right: -55px;height: 30px;width: 192px !important;border: none;display: block;background-color: #ececec;position: absolute;right: 12%;webkit-border-radius: 0px !important;-moz-border-radius: 0px !important;border-radius: 0px !important;"></div>
<?php

foreach ($category_list as $category){
if($category->id == $cat_id){
?>
<div style="text-align: left !important;
bottom: -35px;
border: none;
display: block;
position: absolute;
left: 69%;"><?php echo $category->name ; ?></div>

<?php
}
if($cat_id == '0'){
?>
<div style="text-align: left !important;
bottom: -35px;
border: none;
display: block;
position: absolute;
left: 69%;"><?php echo JText::_('SH_ALL') ; ?></div>
<?php
}}
?>
<div  style="background-color:#<?php echo $params->get('select_icon_color'); ?> ;right: 20px !important;position:absolute;bottom: -40px;width:30px;height:30px;background-repeat: no-repeat;background-image: url('components/com_spidercatalog/images/selectcat.png');background-size: 100% 100%; border: 0px;cursor: pointer;"></div>

<?php

echo JText::_('SH_CHOOSE_CATEGORY') . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		
		
		
		<select style="opacity:0;margin-right: -61px;height: 30px;width: 197px !important;border: none;display: block;background-color: #ececec;position: absolute;right: 12%;webkit-border-radius: 0px !important;-moz-border-radius: 0px !important;border-radius: 0px !important;" id="cat_id" name="cat_id" class="spidercataloginput" size="1" onChange="if(this.value!=0){valuenone();this.form.submit();}else{cat_form_allcateg(form);}"> 
		<option value="0">' . JText::_('SH_ALL') . '</option> ';
    
   
    foreach ($category_list as $category)
	
    {   if($input->get('subcat_id')){echo $input->get('subcat_id');
	
        if ($input->get('subcat_id')==$category->id){
            echo '<option value="' . $category->id . '"  selected="selected">' . $category->name . '</option>';
			}
			else
            echo '<option value="' . $category->id . '" >' . $category->name . '</option>';
			}
			else 
			if($category->id == $cat_id){
				echo '<option value="' . $category->id . '"  selected="selected">' . $category->name . '</option>';
			}else{
				echo '<option value="' . $category->id . '" >' . $category->name . '</option>';
			}
    }
        
    echo '</select>';
	?>
	</div></div>
	<?php
}

?>

<br>
<?php
if ( $params->get("search_by_name") and $params1['show_products']==1)
{
	if(JRequest::getVar( 'prod_name', '' ))
$prod_name=JRequest::getVar( 'prod_name', '' );
else
$prod_name='';


echo '<br />';
if($prod_name){
?>
<div style="display: block;">
<div style="position:relative;">
<input id="prod_name" name="prod_name" style="height: 22px;width:135px !important;border: none;display: block;background-color:#ececec;position:absolute;right:11%;" class="spidercataloginput" name="prod_name" id="prod_name"  value="<?php echo $prod_name; ?>"
       onfocus="(this.value == 'Search...') && (this.value = '')"
       onblur="(this.value == '') && (this.value = 'Search...')" />
	   
	   
	   <input  type="submit" id="prod_namesubmit" name="prod_namesubmit" value=""  style="background-color:#<?php echo $params->get('search_icon_color'); ?>;bottom: 32px;background-image:url('components/com_spidercatalog/images/search-icon.png');width: 30px !important;height: 30px !important;right: 50px !important;background-size: 100% 100%;
	position:absolute;background-repeat: no-repeat; border: 0px;cursor: pointer;">
	
	<input  type="submit" value="" onClick="cat_form_resettiko(this.form);"  style="background-color:#<?php echo $params->get('reset_icon_color'); ?>;right: 20px !important;position:absolute;bottom: 32px;width:30px;height:30px;background-repeat: no-repeat;background-image:url('components/com_spidercatalog/images/search-reset.png'); background-size: 100% 100%; border: 0px;cursor: pointer;">
	<input type="hidden" name="workses" id="workses" value="1" />
	<br><br><br><br>
	<?php
	echo '</div></div>';
	   
	  
}
if($prod_name==""){
?>	   
<div style="display: block;">
<div style="position:relative;">
<input id="prod_name" name="prod_name" style="height: 22px;width:135px !important;border: none;display: block;background-color:#ececec;position:absolute;right:11%;" class="spidercataloginput" name="prod_name" id="prod_name"  value="Search..."
       onfocus="(this.value == 'Search...') && (this.value = '')"
       onblur="(this.value == '') && (this.value = 'Search...')" />
	   

	<input  type="submit" value="" id="prod_namesubmit" name="prod_namesubmit"  style="background-color:#<?php echo $params->get('search_icon_color'); ?>;bottom: 32px;background-image:url('components/com_spidercatalog/images/search-icon.png');width: 30px !important;height: 30px !important;right: 50px !important;background-size: 100% 100%;
	position:absolute;background-repeat: no-repeat; border: 0px;cursor: pointer;">
	
	<input  type="submit" value="" onClick="cat_form_resettiko(this.form);"  style="background-color:#<?php echo $params->get('reset_icon_color'); ?>;right: 20px !important;position:absolute;bottom: 32px;width:30px;height:30px;background-repeat: no-repeat;background-image:url('components/com_spidercatalog/images/search-reset.png');background-size: 100% 100%; border: 0px;cursor: pointer;">
	<br><br><br><br>
	<?php
	echo '</div></div>';
	
	}
}


if(!($params->get("search_by_name")))
{
echo '<br><br><br>';
}
echo '</form></div>';

if($params1['show_products']==1){
if(count($rows))
{
echo '<table border="0" cellspacing="0" cellpadding="0" id="productCartFull" style="border-width:'.$params->get( 'border_width' ).'px;border-color:#'.$params->get( 'border_color' ).';border-style:'.$params->get( 'border_style' ).';border-bottom:none; border-right:none;'.(($params->get( 'text_color' )!='')?('color:#'.$params->get( 'text_color' ).';'):'').(($params->get( 'background_color' )!='')?('background-color:#'.$params->get( 'background_color' ).';'):'').'">'
.'<tr style="'.(($params->get( 'title_color' )!='')?('color:#'.$params->get( 'title_color' ).';'):'').'">';

$parameters_exist=0;
foreach($rows as $row)
{
if($row->param!="")
$parameters_exist++;
}

echo '<TD style="font-size:12pt;border-right:solid 1px #ffffff !important;color:#'.$params->get( 'list_page_up_names_text_color' ).';background-color:#'.$params->get( 'list_page_up_names_background_color' ).' !important;">'.JTEXT::_('SH_PRODUCT').'</TD>';

	echo '<TD style="font-size:12pt;border-right:solid 1px #ffffff !important;color:#'.$params->get( 'list_page_up_names_text_color' ).';background-color:#'.$params->get( 'list_page_up_names_background_color' ).' !important;">'.JTEXT::_('SH_NAME');

if ($params->get('enable_rating'))	
	echo ' / '.JTEXT::_('SH_RATING');
	
echo '</TD>';


	
if($parameters_exist and $params->get( 'list_show_parameters' ))
echo '<TD style="font-size:12pt;border-right:solid 1px #ffffff !important;color:#'.$params->get( 'list_page_up_names_text_color' ).';padding:13px;background-color:#'.$params->get( 'list_page_up_names_background_color' ).' !important;">'.JTEXT::_('SH_PARAMETERS').'</TD>';

if($params->get( 'list_show_description' ))
echo '<TD style="font-size:12pt;border-right:solid 1px #ffffff !important;color:#'.$params->get( 'list_page_up_names_text_color' ).';background-color:#'.$params->get( 'list_page_up_names_background_color' ).' !important;">'.JTEXT::_('SH_DESCRIPTION').'</TD>';


if($params->get('price') or $params->get('market_price'))
echo '<TD style="font-size:12pt;color:#'.$params->get( 'list_page_up_names_text_color' ).';background-color:#'.$params->get( 'list_page_up_names_background_color' ).' !important;">'.JTEXT::_('SH_PRICE').'</TD>';

echo '</tr>';
}

foreach ($rows as $key=>$row)
{
$imgurl=explode(";",$row->image_url);

if(!($row->image_url!="" and $row->image_url!=";"))
$imgurl[0]="components/com_spidercatalog/images/noimage.jpg";

if($key%2==0){

echo'<tr style="background-color:#'.$params->get( 'list_page_background_color_1' ).';">';
}
if($key%2!=0){

echo'<tr style="background-color:#'.$params->get( 'list_page_background_color_2' ).';">';
}
if($key==0){

echo'<tr style="background-color:#'.$params->get( 'list_page_background_color_1' ).';">';
}



    $imgurl = explode(";", $row->image_url);
   
if (!($row->image_url != "" and $row->image_url != ";"))
       echo '<td style="width:' . ($params->get('list_picture_width')+20). 'px;border-right: solid 1px #e8e8e8 !important;border-width:'.$params->get( 'border_width' ).'px;border-color:#'.$params->get( 'border_color' ).';border-style:'.$params->get( 'border_style' ).';border-top:none; border-left:none;"><img src="'.JURI::root().'/components/com_spidercatalog/images/noimage.jpg" />
</td>';
else
{
				if(strpos($imgurl[0],'http://')===0 or strpos($imgurl[0],'https://')===0)
				$fullhref=$imgurl[0];
				else
				$fullhref=JURI::root().$imgurl[0];
				
				if($params->get('list_crop_image')==1){	
					
				if($params->get('list_picture_height')=='')
				$listheight=100;
	else
	
				$listheight=$params->get('list_picture_height');
				
	if($params->get('list_picture_width')=='')
				$listwidth=100;
	else
	
				$listwidth=$params->get('list_picture_width');
				
				  echo '<td style="width:' . ($params->get('list_picture_width')+20). 'px;border-right: solid 1px #e8e8e8 !important;border-width:'.$params->get( 'border_width' ).'px;border-color:#'.$params->get( 'border_color' ).';border-style:'.$params->get( 'border_style' ).';border-top:none; border-left:none; "><a href="' . $imgurl[0] . '" target="_blank"><img style=" margin:10px; width:' . $listwidth . 'px; height:' . $listheight . 'px;" src="index.php?option=com_spidercatalog&view=picture&format=raw&tmpl=component&id=' . $row->id . '&picnum=0&width=' . $listwidth . '&height=' . $listheight . '" /></a></td>';
				
		} else{
	if($params->get('list_picture_width')>=$params->get('list_picture_height'))
	
	 echo '<td style="width:' . ($params->get('list_picture_width')+20). 'px;border-right: solid 1px #e8e8e8 !important;border-width:'.$params->get( 'border_width' ).'px;border-color:#'.$params->get( 'border_color' ).';border-style:'.$params->get( 'border_style' ).';border-top:none; border-left:none;"><a href="' . $imgurl[0] . '" target="_blank"><img style=" margin:10px" src="index.php?option=com_spidercatalog&view=picture&format=raw&tmpl=component&id=' . $row->id . '&picnum=0&width=' . $params->get('list_picture_width'). '" /></a></td>';
	 else{
	   echo '<td style="width:' . ($params->get('list_picture_width')+20). 'px;border-right: solid 1px #e8e8e8 !important;border-width:'.$params->get( 'border_width' ).'px;border-color:#'.$params->get( 'border_color' ).';border-style:'.$params->get( 'border_style' ).';border-top:none; border-left:none;"><a href="' . $imgurl[0] . '" target="_blank"><img style=" margin:10px" src="index.php?option=com_spidercatalog&view=picture&format=raw&tmpl=component&url=id=' . $row->id . '&picnum=0&height=' . $params->get('list_picture_height'). '" /></a></td>';
	}
    }
      
}


echo '<td style="text-align: left !important;border-right: solid 1px #e8e8e8 !important;border-width:'.$params->get( 'border_width' ).'px;border-color:#'.$params->get( 'border_color' ).';border-style:'.$params->get( 'border_style' ).';border-top:none; border-left:none;">';

  
    $config = JFactory::getConfig();
    if($config->get( 'sef' ) == 1){
    	$titlelink = str_replace(' ', '-', $row->name);
    $link = JRoute::_('index.php?option=' . $option . '&product_id=' . $row->id . '&view=showproduct&select_categories='.$cat_id.'&prname='.$titlelink.'');
	$link = str_replace('?Itemid='.JRequest::getVar('Itemid').'', '', $link);
}
	else
	{
	$link = JRoute::_('index.php?option=' . $option . '&product_id=' . $row->id . '&view=showproduct&page_num=' . $page_num . '&back=1&show_category_details='.$params1["show_category_details"].'&display_type='.$params1["display_type"].'&show_subcategories='.$params1["show_subcategories"].'&show_subcategories_products='.$params1["show_subcategories_products"].'&show_products='.$params1["show_products"].'&select_categories='.$cat_id);
	}
	$uri1	= JFactory::getURI();		
			$url2=$uri1->toString();
		if($uri1==$url2){
    			$linkback = $link;
$config = JFactory::getConfig();
if( $config->get( 'sef' )== 1){
$pos=strpos($linkback,'showproduct/');
//echo $pos;
$po=substr_replace($linkback,JRequest::getInt('Itemid').'/',$pos+12);
//echo $po;
$link=$po.$row->id.'/'.$cat_id.'/'.$titlelink;
}

}
	echo '<a href="'.$link.'" style="color:#' . $params->get('list_page_text_color_2') . ';">' . $row->name . '</a>';

$categories_id=explode(',',$row->category_id);
	if ($subcat_id > 0 and $params->get('list_show_category'))
	{
        echo '<br><div style="margin-left: 0px;margin-right: 10px;margin-bottom: 10px;margin-top: 10px;color:#' . $params->get('list_page_text_color_1') . ';"><b>' . JText::_('SH_CATEGORY') . '</b>&nbsp;&nbsp;&nbsp;<span style="color:#' . $params->get('list_page_text_color_2') . ';" id="cat_' . $row->id . '">';
		
		//print_r($categories);
		
	foreach($categories as $categ)
	{
	if(in_array($categ->id,$categories_id))
	echo $categ->name.'<br>';
	
	}
		
		
	echo	'</span></div>';
}

else
   {
        echo '<br><div style="margin-left: 0px;margin-right: 10px;margin-bottom: 10px;margin-top: 10px;color:#' . $params->get('list_page_text_color_1') . ';"><b>' . JText::_('SH_CATEGORY') . '</b>&nbsp;&nbsp;&nbsp;<span style="color:#' . $params->get('list_page_text_color_2') . ';" id="cat_' . $row->id . '"><br>';
		
		
		foreach($categories as $categ)
	{
	if(in_array($categ->id,$categories_id))
	echo $categ->name.'<br>';
	
	}
		
		
		
		
		echo  '</span></div>';
    
    }
	
	
	


    if ($params->get('enable_rating'))
      {
        $id = $row->id;
        
        $rating = $ratings[$id] * 25;
        
        if ($voted[$id] == 0)
          {
            if ($ratings[$id] == 0)
                $title = JText::_('SH_NOT_RATED');

            else
                $title = $ratings[$id];           
            
            
            echo "<div id='voting" . $row->id . "' style='height:50px; padding:10px;'>
			<ul class='star-rating' style='margin-left: -10px !important;'>	
				<li class='current-rating' id='current-rating' style=\"width:" . $rating . "px\"></li>
				<li><a href=\"#\" onclick=\"vote(1," . $row->id . ",'voting" . $row->id . "','" . JText::_('SH_RATED') . "'); return false;\"
						title='" . $title . "' class='one-star'>1</a></li>
				<li><a href=\"#\" onclick=\"vote(2," . $row->id . ",'voting" . $row->id . "','" . JText::_('SH_RATED') . "'); return false;\"     
						title='" . $title . "' class='two-stars'>2</a></li>	
				<li><a href=\"#\" onclick=\"vote(3," . $row->id . ",'voting" . $row->id . "','" . JText::_('SH_RATED') . "'); return false;\"           
				 title='" . $title . "' class='three-stars'>3</a></li>
				<li><a href=\"#\" onclick=\"vote(4," . $row->id . ",'voting" . $row->id . "','" . JText::_('SH_RATED') . "'); return false;\"     
						title='" . $title . "' class='four-stars'>4</a></li>
				<li><a href=\"#\" onclick=\"vote(5," . $row->id . ",'voting" . $row->id . "','" . JText::_('SH_RATED') . "'); return false;\"
						title='" . $title . "' class='five-stars'>5</a></li>
			</ul>
			</div>";
           
          }
        
        else
          {
            if ($ratings[$id] == 0)
                $title = JText::_('SH_NOT_RATED');
            
            else
                $title = JText::_('SH_RATING:') . '&nbsp;' . $ratings[$id] . '&nbsp;&nbsp;&nbsp;&nbsp;&#013;' . JText::_('SH_ALREADY_RATED');
            
            echo "<div id='voting" . $row->id . "' style='height:50px; padding:10px;'>
			<ul class='star-rating1' style='margin-left: -10px !important;'>	
			<li class='current-rating' id='current-rating' style=\"width:" . $rating . "px\"></li>
			<li><a  title='" . $title . "' class='one-star'>1</a></li>
			<li><a  title='" . $title . "' class='two-stars'>2</a></li>
			<li><a title='" . $title . "' class='three-stars'>3</a></li>
			<li><a title='" . $title . "' class='four-stars'>4</a></li>
			<li><a title='" . $title . "' class='five-stars'>5</a></li>
			</ul>
			</div>";
           
         }
       
      }
echo '</td>';

if($parameters_exist and $params->get( 'list_show_parameters' ))
{
    echo '<td style="border-right: solid 1px #e8e8e8 !important;padding:0px;border-width:'.$params->get( 'border_width' ).'px;border-color:#'.$params->get( 'border_color' ).';border-style:'.$params->get( 'border_style' ).';border-top:none; border-left:none;"><table border="0" cellspacing="0" cellpadding="0" width="100%">';
         
    
    $par_data = explode("par_", $row->param);
 
    for ($j = 0; $j < count($par_data); $j++)
        if ($par_data[$j] != '')
          {
            $par1_data = explode("@@:@@", $par_data[$j]);
            $par_values = explode("	", $par1_data[1]);

            $countOfPar = 0;
            
            for ($k = 0; $k < count($par_values); $k++)
                if ($par_values[$k] != "")
                    $countOfPar++;
            
           
            
            
            if ($countOfPar != 0)
              {
                echo '<tr style="text-align:left"><td style="color:#' . $params->get('list_page_text_color_1') . '"><b>' . $par1_data[0] . ':</b></td>';
                

                    echo '<td style="' . (($params->get('text_size_list') != '') ? ('font-size:' . $params->get('text_size_list') . 'px;') : '').'   width:' . $params->get('parameters_select_box_width') . 'px;color:#' . $params->get('list_page_text_color_2') . '"><ul class="spidercatalogparamslist">';
                    
                    for ($k = 0; $k < count($par_values); $k++)
                        if ($par_values[$k] != "")
                            echo '<li>' . $par_values[$k] . '</li>';
                    
                    echo '</ul></td></tr>';
                  
              }
          }
echo '</table></td>';
}


if($params->get( 'list_show_description' ))
{	
   $description = explode('<hr id="system-readmore" />', $row->description);
   echo '<td style="border-right: solid 1px #e8e8e8 !important;border-width:'.$params->get( 'border_width' ).'px;border-color:#'.$params->get( 'border_color' ).';border-style:'.$params->get( 'border_style' ).';border-top:none; border-left:none;padding:10px">
   <div id="prodDescription">' . $description[0] . ' </div>
   <div id="prodMore"><a href="'.$link.'">' . JText::_('SH_MORE_INFO') . '</a></div>
   </td>';
}


if($params->get('price') or $params->get('market_price'))
{
echo '<td style="border-width:'.$params->get( 'border_width' ).'px;border-color:#'.$params->get( 'border_color' ).';border-style:'.$params->get( 'border_style' ).';border-top:none; border-left:none;">';

	if ($params->get('price') and $row->cost != 0 and $row->cost != '')
	  echo '<div id="prodCost" style="font-size:' . $params->get('price_size_list') . 'px;color:#' . $params->get('list_cell_price_color') . ';">' . (($params->get('currency_symbol_position') == 0) ? ($params->get('currency_symbol')) : '') . '&nbsp;' . $row->cost . '&nbsp;' . (($params->get('currency_symbol_position') == 1) ? $params->get('currency_symbol') : '') . '</div>';
		
	if ($params->get('market_price') and $row->market_cost != 0 and $row->market_cost != '')
	   echo '<div id="prodCost" style="color:#' . $params->get('list_cell_market_price_color') . ';font-size:' . ($params->get('price_size_list') / 1.7) . 'px;">' . JText::_('SH_MARKET_PRICE') . ' <span style=" text-decoration:line-through;color:#' . $params->get('list_cell_market_price_color') . ';"> ' . (($params->get('currency_symbol_position') == 0) ? ($params->get('currency_symbol')) : '') . '&nbsp;' . $row->market_cost . '&nbsp;' . (($params->get('currency_symbol_position') == 1) ? $params->get('currency_symbol') : '') . '</span></div>';
	   
	echo '</td>';   
}

echo '</tr>';   
    
}

if(count($rows))
echo '</table>';
?>

<div id="spidercatalognavigation" style="text-align:center;">
  <?php
$pos = strpos($_SERVER['QUERY_STRING'], "page_num") - 1;
if ($pos > 0)
    $url = substr($_SERVER['QUERY_STRING'], 0, $pos);
else
    $url = $_SERVER['QUERY_STRING'];

$pos = strpos($_SERVER['QUERY_STRING'], "cat_id") - 1;

if ($pos > 0)
    $url = substr($url, 0, $pos);

$pos = strpos($_SERVER['QUERY_STRING'], "prod_name") - 1;

if ($pos > 0)
    $url = substr($url, 0, $pos);

if ($input->get('cat_id') != 0)
    $url .= "&cat_id=" . $input->get('cat_id');
else if ($input->get('subcat_id') != 0)
		$url .= "&cat_id=" . $input->get('subcat_id');

if ($prod_name != ""){
if ($input->get('cat_id') != 0)
    $url .= "&cat_id=" . $input->get('cat_id')."&prod_name=" . $prod_name;
else if ($input->get('subcat_id') != 0)
		$url .= "&cat_id=" . $input->get('subcat_id')."&prod_name=" . $prod_name;
  
}

if($subcat_id)
{
$subcat_id=$subcat_id;
}
else
{
$subcat_id='0';
}

$uri	= JFactory::getURI();		
			$url2=$uri->toString();

if ($prod_count > $prod_in_page and $prod_in_page > 0)
  {
    $r = ceil($prod_count / $prod_in_page);
    ?>
	
	
	 <form action="" method="post" id="page_num_post" name="page_num_post">
	<div style="width:100%;margin: 0px auto;position: relative;">
			<input type="hidden" name="select_categories" id="select_categories" value="<?php echo $cat_id; ?>" />
		<input type="hidden" name="prod_name" id="prod_name" value="<?php echo JRequest::getVar('prod_name'); ?>" />
    <?php
    
    $navstyle = (($params->get('text_size_small') != '') ? ('font-size:' . $params->get('text_size_small') . 'px;') : '') . (($params->get('text_color') != '') ? ('color:#' . $params->get('text_color') . ';') : '');
    
    
    
     $link = JRoute::_('index.php?' . $url . '&page_num= ');
    
    if ($page_num > 5)
      {
        $link = JRoute::_('index.php?' . $url . '&page_num=1' );
        
        echo "

&nbsp;&nbsp;<a class=\"subthisaction\" href=\"$link\" style=\"$navstyle\">".JText::_('SH_FIRST')."</a>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;...&nbsp";
        
      }
    
   
    if(JRequest::getVar('back'))
	{
    if ($page_num > 1)
      {
        $link = JRoute::_('index.php?' . $url . '&page_num=' . ($page_num - 1));
       
        echo "&nbsp;&nbsp;<a class=\"subthisaction\" href=\"$link\" style=\"$navstyle\">".JText::_('SH_PREV')."</a>&nbsp;&nbsp;";
        
      }
	}  
	
	else
	{
    if ($page_num > 1)
      {
         $link = JRoute::_('index.php?' . $url . '&page_num=' . ($page_num - 1));
        
        echo "&nbsp;&nbsp;<a class=\"subthisaction\" href=\"$link\" style=\"$navstyle\">".JText::_('SH_PREV')."</a>&nbsp;&nbsp;";
        
      }
	} 
    
    
    if(JRequest::getVar('back'))
	{
    for ($i = $page_num - 4; $i < ($page_num + 5); $i++)
      {
        if ($i <= $r and $i >= 1)
          {
            $link = '' . $url2 . '&page_num=' . $i .'';
            
            if ($i == $page_num)
                echo "<span style='font-weight:bold;color:##000000'>&nbsp;$i&nbsp;</span>";
            
            else
                echo "<a class=\"subthisaction\" href=\"$link\" style=\"$navstyle\">&nbsp;$i&nbsp;</a>";
            
          }
        
      }
    }
	
	
	 else
	 {
    for ($i = $page_num - 4; $i < ($page_num + 5); $i++)
      {
        if ($i <= $r and $i >= 1)
          {
            $link = JRoute::_('index.php?' . $url . '&page_num=' . $i );
            
            if ($i == $page_num)
                echo "<span style='font-weight:bold;color:##000000'>&nbsp;$i&nbsp;</span>";
            
            else
                echo "<a class=\"subthisaction\" href=\"$link\" style=\"$navstyle\">&nbsp;$i&nbsp;</a>";
            
          }
        
      }
    }
    
    
    
if(JRequest::getVar('back')){
//	echo $url2;

	$link = ''.$url2.'&page_num=' . ($page_num + 1) .'';
	
        
    echo "&nbsp;&nbsp;<a href=\"$link\" style=\"$navstyle\">".JText::_('SH_NEXT')."</a>&nbsp;&nbsp;";
	}
	else
{
    if ($page_num < $r)
      {
        $link = JRoute::_('index.php?' . $url . '&page_num=' . ($page_num + 1));
        
        echo "&nbsp;&nbsp;<a class=\"subthisaction\" href=\"$link\" style=\"$navstyle\">".JText::_('SH_NEXT')."</a>&nbsp;&nbsp;";
        
      }
 }   
	
	
	
    if (($r - $page_num) > 4)
      {
        $link = JRoute::_('index.php?' . $url . '&page_num=' . $r);
        
        echo "&nbsp;...&nbsp;&nbsp;&nbsp;<a class=\"subthisaction\" href=\"$link\" style=\"$navstyle\">".JText::_('SH_LAST')."</a>";
        }
	
		?>

		
		<script>

$("a.subthisaction").click(function(){

      $("#page_num_post").attr("action", $(this).attr("href"));
//alert("form submited form action="+$("#page_num_post").attr("action")); 
	 $("#page_num_post").submit();
	  return false;
	 
});

</script>
</div>
		</form>
		<?php
    }

}
if(count($rows==0)){
echo '</table>';
}	
?>

</div>
<?php
if(count($rows)){
echo '</div></table>';
}
?>
<script type="text/javascript">
var SpiderCatOFOnLoad = window.onload;
window.onload = SpiderCatAddToOnload;

function prod_change_picture(id,obj,width,height)
{
		
	phpurl=document.getElementById("prod_main_picture").style.backgroundImage.substr(0,document.getElementById("prod_main_picture").style.backgroundImage.indexOf("&id"));
	document.getElementById("prod_main_picture_a").href=obj.parentNode.href;
	
	document.getElementById("prod_main_picture").style.backgroundImage=phpurl+'&id='+id+'&width='+width+'&height='+height+'&reverse=<?php echo $params->get( 'global_revers' ); ?>)';
	
}
</script>
