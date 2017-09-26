<?php  
/**
 * @package Spider Catalog
 * @author Web-Dorado
 * @copyright (C) 2012 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
 
defined('_JEXEC') or die('Restricted access'); 
	$rows=$this->rows;
	$reviews_rows=$this->reviews_rows;
	$option=$this->option;
	$params=$this->params;
	$category_name=$this->category_name;	
	$rev_page=$this->rev_page;
	$reviews_count=$this->reviews_count;
	$rating=$this->rating;
	$voted=$this->voted;
	//$categories=$this->categories;
$input=JFactory::getApplication()->input;

?>
<div>
<?php if($params->get( 'enable_rating' )): ?>
<style type="text/css">
.star-rating 					{ background: url(<?php echo JURI::root().'/components/'.$option.'/images/star'.$params->get( 'rating_star' ).'.png'; ?>) top left repeat-x !important; margin-top:0px;}
.star-rating li a:hover			{ background: url(<?php echo JURI::root().'/components/'.$option.'/images/star'.$params->get( 'rating_star' ).'.png'; ?>) left bottom !important; }
.star-rating li.current-rating 	{ background: url(<?php echo JURI::root().'/components/'.$option.'/images/star'.$params->get( 'rating_star' ).'.png'; ?>) left center !important; }
.star-rating1 					{ background: url(<?php echo JURI::root().'/components/'.$option.'/images/star'.$params->get( 'rating_star' ).'.png'; ?>) top left repeat-x !important;  margin-top:0px;}
.star-rating1 li.current-rating	{ background: url(<?php echo JURI::root().'/components/'.$option.'/images/star'.$params->get( 'rating_star' ).'.png'; ?>) left center !important; }
</style>
<?php
endif;


if ($params->get('rounded_corners')):
?>
<style type="text/css">
#productMainDiv, .spidercatalogbutton, .spidercataloginput
{
-webkit-border-radius: 8px;
-moz-border-radius: 8px;
border-radius: 8px;
}

#productMainDiv #prodTitle
{
-webkit-border-top-right-radius: 8px;
-webkit-border-top-left-radius: 8px;
-moz-border-radius-topright: 8px;
-moz-border-radius-topleft: 8px;
border-top-right-radius: 8px;
border-top-left-radius: 8px;
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
$backview=JRequest::getVar('display_type','');
$session = JFactory::getSession();
$session->set( 'select_categories', JRequest::getVar('select_categories') );


foreach($rows as $key=>$row)
{
$document = JFactory::getDocument();
$session = JFactory::getSession();
//echo $session->get( 'Itemid', 0 );
//echo JRequest::getVar('Itemid');

//$session->set( 'page_num','1' );

if($session->get( 'Itemid', 0 ) == JRequest::getVar('Itemid')){
$document->setTitle($row->name);
}
//echo $session->get( 'page_num' );
if($session->get( 'Itemid', 0 ) == JRequest::getVar('Itemid')){
if($session->get( 'back', 'empty' )){
//echo '<span id="back_to_spidercatalog_button"><a href="#" onclick="this.form.submit();" >'.JText::_('SH_BACK_TO_SHOPPING').'</a></span>';
if($session->get( 'page_num' ) > '1'){
if(JRequest::getVar('rev_page'))
{
$linkback = ''.JRoute::_('index.php?' .str_replace('showproduct','spidercatalog',$_SERVER['QUERY_STRING'])).'?page_num='.$session->get( 'page_num','1' ).'';
//echo $linkback;
$pos=strpos($linkback,'?rev_page=');
//echo $pos;
$po=substr_replace($linkback,'',$pos+1);
//echo $po;
$backcatlink=$po.'page_num='.$session->get( 'page_num','1' );
//$session->set( 'page_num', '' );
	//echo $session->get( 'prod_name', 'tiko' );
	//echo $backcatlink;
echo '<form action="'.$backcatlink.'" method="post" name="cat_form" id="cat_form_page_nav" style="display:block;">';
}
else
{
	echo '<form action="'.JRoute::_('index.php?' .str_replace('showproduct','spidercatalog',$_SERVER['QUERY_STRING'])).'?page_num='.$session->get( 'page_num','1' ).'" method="post" name="cat_form" id="cat_form_page_nav" style="display:block;">';
	}
}
else
{
	echo '<form action="'.JRoute::_('index.php?' .str_replace('showproduct','spidercatalog',$_SERVER['QUERY_STRING'])).'" method="post" name="cat_form" id="cat_form_page_nav" style="display:block;">';
	//echo JRequest::getVar('select_categories');
	}
}

?>
<input  type="submit" value="<?php echo JText::_('SH_BACK_TO_SHOPPING'); ?>" />
<?php
}
?>
<input type="hidden" name="select_categories" id="select_categories" value="<?php echo $session->get( 'select_categories', 0 ); ?>" />
<input type="hidden" name="workses" id="workses" value="1" />
<input type="hidden" name="prod_name" id="prod_name" value="<?php echo $session->get( 'prod_name', '' ); ?>" />

<?php

//echo '<span id="back_to_spidercatalog_button"><a href="'.JRoute::_('index.php?' .str_replace('showproduct','spidercatalog',$_SERVER['QUERY_STRING'])).'" >'.JText::_('SH_BACK_TO_SHOPPING').'</a></span>';


echo '</form><div id="productMainDiv" style="border-width:'.$params->get( 'border_width' ).'px;border-color:#'.$params->get( 'border_color' ).';border-style:'.$params->get( 'border_style' ).';'.(($params->get( 'text_size_big' )!='')?('font-size:'.$params->get( 'text_size_big' ).'px;'):'').(($params->get( 'text_color' )!='')?('color:#'.$params->get( 'text_color' ).';'):'').(($params->get( 'background_color' )!='')?('background-color:#'.$params->get( 'background_color' ).';'):'').'">';


$imgurl=explode(";",$row->image_url);
$array=explode(" ",$row->name);
$array2=str_replace("$array[0]","",$row->name);


echo '<div id="prodTitle" style="'.(($params->get( 'title_color' )!='')?('color:#'.$params->get( 'title_color' ).';'):'').(($params->get( 'title_background_color' )!='')?('background-color:#'.$params->get( 'title_background_color' ).';'):'').'padding:0px;"><table style="background-color:#'.$params->get( 'review_background_color' ).';" border="0" cellspacing="0" cellpadding="0" width="100%"><tr><td  style="padding:10px;font-size:'.$params->get( 'title_size_big' ).'px;"><font size="7" style="margin-left: 10px !important;font-size: '.$params->get( 'product_big_title_size' ).'pt;">' . $array[0].'</font><br><span style="margin-left: 10px !important;line-height: 27px;">'.$array2.'</span></td>';
if($params->get('price') and $row->cost != 0 and $row->cost != '')
{
echo '<td style="padding-right:40px;background:#'.$params->get( 'product_price_background_color' ).';width:170px;background-repeat: no-repeat !important;background-position: 95% 0%;">';
}
else
{
echo '<td style="padding-right:40px;width:170px;background-repeat: no-repeat !important;background-position: 95% 0%;">';
}

if ($params->get('price') and $row->cost != 0 and $row->cost != '')
echo '<div id="prodCost" style="font-size:'.$params->get( 'price_size_big' ).'px;color:#'.$params->get( 'price_color' ).';">' .(($params->get( 'currency_symbol_position' )==0)?($params->get( 'currency_symbol' )):'').' '.$row->cost .' '.(($params->get( 'currency_symbol_position' )==1)?$params->get( 'currency_symbol'):'') . '</div>';


if( $params->get( 'market_price' ) and $row->market_cost!=0 and $row->market_cost!='' )
echo '<div id="prodCost" style="font-size:'.($params->get( 'price_size_big' )/1.7).'px;"><span style="color:#'.$params->get( 'price_color' ).';">'.JText::_('SH_MARKET_PRICE').' </span><span style=" text-decoration:line-through;color:#'.$params->get( 'price_color' ).';"> ' .(($params->get( 'currency_symbol_position' )==0)?($params->get( 'currency_symbol' )):'').' '.$row->market_cost .' '.(($params->get( 'currency_symbol_position' )==1)?$params->get( 'currency_symbol'):'') . '</span></div>';

if($params->get( 'enable_rating' ))
{

echo '</td></tr><tr><td style="padding-right:10px;"><div style="overflow:hidden; vertical-align:top; height:25px;">
<div id="voting'.$row->id.'" style="width:130px;">';

if($voted==0)
		{
		if($rating==0)
			$title=JText::_('SH_NOT_RATED');
		else 
			$title=$rating;

			echo "
			<ul class='star-rating' style='margin-left: 20px !important;'>	
				<li class='current-rating' id='current-rating' style=\"width:".($rating*25)."px\"></li>
				<li><a href=\"#\" onclick=\"vote(1,".$row->id.",'voting".$row->id."','".JText::_('SH_RATED')."'); return false;\"
						title='".$title."' class='one-star'>1</a></li>
				<li><a href=\"#\" onclick=\"vote(2,".$row->id.",'voting".$row->id."','".JText::_('SH_RATED')."'); return false;\"     
						title='".$title."' class='two-stars'>2</a></li>	
				<li><a href=\"#\" onclick=\"vote(3,".$row->id.",'voting".$row->id."','".JText::_('SH_RATED')."'); return false;\"           
				 title='".$title."' class='three-stars'>3</a></li>
				<li><a href=\"#\" onclick=\"vote(4,".$row->id.",'voting".$row->id."','".JText::_('SH_RATED')."'); return false;\"     
						title='".$title."' class='four-stars'>4</a></li>
				<li><a href=\"#\" onclick=\"vote(5,".$row->id.",'voting".$row->id."','".JText::_('SH_RATED')."'); return false;\"
						title='".$title."' class='five-stars'>5</a></li>
			</ul>";
		}
else
		{
		if($rating==0)
			$title=JText::_('SH_NOT_RATED');
		else 
			$title=JText::_('SH_RATING').' '.$rating.'&nbsp;&nbsp;&nbsp;&nbsp;&#013;'.JText::_('SH_ALREADY_RATED');
			
			
			echo "
			<ul class='star-rating1' style='margin-left: 20px !important;'>	
			<li class='current-rating' id='current-rating' style=\"width:".($rating*25)."px\"></li>
			<li><a  title='".$title."' class='one-star'>1</a></li>
			<li><a  title='".$title."' class='two-stars'>2</a></li>
			<li><a title='".$title."' class='three-stars'>3</a></li>
			<li><a title='".$title."' class='four-stars'>4</a></li>
			<li><a title='".$title."' class='five-stars'>5</a></li>
			</ul>";
		}
		
echo '</div></div></td>';

} 

echo '</tr></table></div>

<table id="prodMiddle" border="0" cellspacing="0" cellpadding="0"><tr>
<tr><td valign="top" width="280">
<table cellpadding="0" cellspacing="5" border="0" style="margin:0px;">';

if(!($row->image_url!="" and $row->image_url!=";"))
{
	$imgurl[0]=JURI::root()."components/com_spidercatalog/images/noimage.jpg";

	echo '<tr><td colspan="2" id="prod_main_picture_container" valign="top"><div style="border: #CCCCCC solid 2px;padding:5px;background-color:#white;"><div id="prod_main_picture" style="width:'.($params->get( 'large_picture_width' )).'px;height:'.($params->get( 'large_picture_height' )).'px; background:url('.JURI::root().'/components/com_spidercatalog/images/noimage.jpg) center no-repeat;background-size: '.($params->get( 'large_picture_width' )-30).'px '.($params->get( 'large_picture_height' )-20).'px;">&nbsp;</div></div></td></tr>';
}
else
{
				if(strpos($imgurl[0],'http://')===0 or strpos($imgurl[0],'https://')===0)
				$fullhref=$imgurl[0];
				else
				$fullhref=JURI::root().$imgurl[0];
				//'.$row->id.'&picnum='.$key.'
				//$full=JURI::root().$row->id.".&picnum=.".$key;
	echo '<tr><td colspan="2" id="prod_main_picture_container" valign="top">
<div style="width:'.($params->get( 'large_picture_width' )+40).'px;height:'.($params->get( 'large_picture_height' )+15).'px;background-image:url(components/com_spidercatalog/images/prodimgb.png);background-repeat: no-repeat;padding:width:'.($params->get( 'large_picture_height' )+5).'px;background-color:#white;background-size:'.($params->get( 'large_picture_width' )+45).'px '.($params->get( 'large_picture_height' )+10).'px;">
<a href="'.$imgurl[0].'" target="_blank" id="prod_main_picture_a" style="text-decoration:none; "><center>
<div id="prod_main_picture" style=" background-position: 50% 50% !important; width:'.($params->get( 'large_picture_width' )).'px;height:'.($params->get( 'large_picture_height' )).'px; background:url(index.php?option=com_spidercatalog&view=picture&format=raw&tmpl=component&id='.$row->id.'&picnum='.$key.'&height='.($params->get( 'large_picture_height' )*0.85).'&width='.($params->get( 'large_picture_width' )*0.85).'&reverse='.$params->get( 'global_revers' ).') center no-repeat;">&nbsp;</div></center></a></div>
</td></tr>';

    }

echo'
<tr><td style="text-align:center;">';

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
				
$small_images_str.='<a href="'.$img.'" target="_blank"><img style="border:solid 1px #e5e5e5;padding:2px;" src="index.php?option=com_spidercatalog&view=picture&format=raw&tmpl=component&id='.$row->id.'&picnum='.$key.'&height=50" vspace="0" hspace="0" onMouseOver="prod_change_picture(\''.$row->id.'&picnum='.$key.'\',this,'.($params->get( 'large_picture_width' )*0.85).','.($params->get( 'large_picture_height' )*0.85).');" /></a>
';
$small_images_count++;
}
}
if($small_images_count>1)
echo $small_images_str;
else
echo '&nbsp;';

echo '</td></tr>
</table></td>
<td valign="top" align="right">';



	echo '<table border="0" cellspacing="0" cellpadding="5" style="width:270px;margin:10px;border-width:'.$params->get( 'border_width' ).'px;border-color:#'.$params->get( 'border_color' ).';border-style:'.$params->get( 'border_style' ).';'.(($params->get( 'review_background_color' )!='')?('background-color:#'.$params->get( 'review_background_color' ).';'):'').'">';


echo '<tr style="border-bottom:solid 2px #e5e5e5;'.(($params->get( 'params_background_color1' )!='')?('background-color:#'.$params->get( 'params_background_color1' ).';'):'').' vertical-align:middle;"><td><b>'.JText::_('SH_CATEGORY').'</b></td><td style="'.(($params->get( 'params_color' )!='')?('color:#'.$params->get( 'params_color' ).';'):'').'"><span id="cat_' . $row->id . '">';


//	print_r($rows->category_id);
jimport( 'joomla.application.component.model' );
	$input=JFactory::getApplication()->input;
$db = JFactory::getDBO();
		
 
   foreach($rows as $categ)
	{
	$pieces = explode(",",$categ->category_id);
	array_pop($pieces);
	foreach ($pieces as $catnames){
	
	$query= "SELECT * FROM #__spidercatalog_product_categories WHERE id = '".$catnames."' ";

		$db->setQuery($query);

		$row1 = $db->loadObject();
		
		echo $row1->name.'<br>';
	
	
	}
	}
	
	
	
	

echo '</span></td></tr>';
//print_r($rows);

		
			



//--------------------------------------------------------------------------

$par_data=explode("par_",$row->param);

for($j=0;$j<count($par_data);$j++)

	if($par_data[$j]!='')
	{

		$par1_data=explode("@@:@@",$par_data[$j]);

		$par_values=explode("	",$par1_data[1]);

				$countOfPar=0;
					for($k=0;$k<count($par_values);$k++)
						if($par_values[$k]!="")
						$countOfPar++;
		$bgcolor=(($j%2)?(($params->get( 'params_background_color2' )!='')?('background-color:#'.$params->get( 'params_background_color2' ).';'):''):(($params->get( 'params_background_color1' )!='')?('background-color:#'.$params->get( 'params_background_color1' ).';'):''));	


		if($countOfPar!=0)
		{
		
                echo '<tr style="border-bottom:solid 2px #e5e5e5;' . $bgcolor . 'text-align:left"><td><b>' . $par1_data[0] . ':</b></td>';
                

                    echo '<td style="' . (($params->get('text_size_list') != '') ? ('font-size:' . $params->get('text_size_list') . 'px;') : '') . $bgcolor . (($params->get('params_color') != '') ? ('color:#' . $params->get('params_color') . ';') : '') . 'width:' . $params->get('parameters_select_box_width') . 'px;"><ul class="spidercatalogparamslist">';
                    
                    for ($k = 0; $k < count($par_values); $k++)
                        if ($par_values[$k] != "")
                            echo '<li>' . $par_values[$k] . '</li>';
                    
                    echo '</ul></td></tr>';

		}
	}	
	if(isset($bgcolor))
	{
	echo '';
	}
	else
	{
	$bgcolor='';
	}
	
//--------------------------------------------------------------------------
echo '<table><tr style="text-align:left;vertical-align:middle;"><td style="width:275px;" ><div style="margin-right: 5px;padding:4px;' . $bgcolor . '">' . $row->description . '</div></td></tr></table>';
echo '<br/>';

echo '</table>';

echo '</table><br />';






if($params->get( 'enable_review' ))
{

echo '<center><div style="background-color:#'.$params->get( 'product_back_add_your_review_here' ).';width:240px;padding:7px;"><a name="rev" style="color:#ffffff;text-decoration:inherit;font-size:150%">'.JText::_('SH_ADD_REVIEW').'</a></div></center>';


$pos=strpos($_SERVER['QUERY_STRING'], "rev_page")-1;
$reviews_perpage=$params->get( 'reviews_perpage' );
if($pos>0)
$url=substr($_SERVER['QUERY_STRING'],0,$pos);
else
$url=$_SERVER['QUERY_STRING'];


echo '
<div style="margin:3px; padding:10px; border-width:'.$params->get( 'border_width' ).'px;border-color:#'.$params->get( 'border_color' ).';border-style:'.$params->get( 'border_style' ).';'.(($params->get( 'review_background_color' )!='')?('background-color:#'.$params->get( 'review_background_color' ).';'):'').'">

<form  action="'.$_SERVER["REQUEST_URI"].'#rev"  name="review" method="post" >

				
<br />
				';
				?>
				
				
				
				<input type="text" name="full_name" id="full_name" style="webkit-border-radius: 0px !important;-moz-border-radius: 0px !important;border-radius: 0px !important;border:none !important;width:98%; margin:0px;" value="Name"
       onfocus="(this.value == 'Name') && (this.value = '')"
       onblur="(this.value == '') && (this.value = 'Name')" />
<?php 

	 
echo '<br />
<br />';

		?>		
				<textarea rows="4" 
				name="message_text" id="message_text" style="webkit-border-radius: 0px !important;-moz-border-radius: 0px !important;border-radius: 0px !important;border:none !important;width:98%; margin:0px;"  onfocus="(this.innerHTML  == 'Message') && (this.innerHTML  = '')"
				onblur="(this.innerHTML  == '') && (this.innerHTML  = 'Message')" >Message</textarea>
				
				
				
<?php
echo
	'<input type="hidden" name="product_id" value="'.$row->id.'" />
	<input type="hidden" name="view" value="showproduct" />
	<input type="hidden" name="review" value="1" />
	<input type="hidden" name="option" value="'.$option.'" />';

	?><br />
<br />

    <table cellpadding="0" cellspacing="0" border="0" valign="middle" width="100%"> <tr><td style="width: 26%;">
    <font size="3" style="font-size: 12pt;"><?php echo JText::_('SH_ENTER_THE_CODE') ?></font>
    </td><td style="width: 20%;">
   <span id="wd_captcha"><img src="index.php?option=com_spidercatalog&view=wdcaptcha&format=raw&tmpl=component" id="wd_captcha_img" height="24" width="80" /></span><a href="javascript:refreshCaptcha();" style="text-decoration:none">&nbsp;<img src="components/<?php echo $option ?>/images/refresh.png" border="0" style="border:none" /></a>&nbsp;</td><td style="width:28%"><input style="margin-top: 10px;
height: 27px;webkit-border-radius: 0px !important;-moz-border-radius: 0px !important;border-radius: 0px !important;border:none !important;width: 150px !important;" type="text" name="code" id="review_capcode"  width="85%" size="6" /><span id="caphid"></span>
   </td>
     
   
	<td>
 <input type="button" class="spidercatalogbutton" style="<?php echo 'background-color:#'.$params->get( 'product_back_add_your_review_here' ).'; color:#'.$params->get( 'button_color' ) ?>; width:" value="<?php echo JTEXT::_('SH_SEND') ?>" onclick='dontinput()' />
 </td></tr></table>
	</form>
	</div>	
	
	
<script>

function formAddToOnload()

{ 

	if(formOldFunctionOnLoad){ formOldFunctionOnLoad(); }

	refreshCaptcha();

}



function formLoadBody()

{

	formOldFunctionOnLoad = window.onload;

	window.onload = formAddToOnload;

}



var formOldFunctionOnLoad = null;

formLoadBody();

function dontinput()
{
if(jQuery("#full_name").val()=="Name"){alert("Write Name");
 return false;
}


if(jQuery("#full_name").val()!="Name"){
if(jQuery("#message_text").val()=="Message"){alert("Write Message");
return false;
}
else
{
 submit_reveiw("<?php echo JText::_('SH_NAME_REQUIRED'); ?>","<?php echo JText::_('SH_MESSAGE_REQUIRED'); ?>","<?php echo JText::_('SH_REVIEW_ERROR'); ?>");
}
}

}

</script>
 <?php
    $session =JFactory::getSession();
	
  
  

   $code=JRequest::getVar('code','');
   $review=JRequest::getVar('review',0);
   
   if($review)
  	if($code!='' and $code==$session->get( 'captcha_code', '' )   )
   		{
    	echo '<br /><center style="font-weight:bold">'.JText::_('SH_REVIEW_SUCCESS').'</center><br />';
  		} 
  	else
   		{   
     	echo '<br /><center style="font-weight:bold">'.JText::_('SH_REVIEW_ERROR').'</center><br />';
  		}


	 foreach($reviews_rows as $reviews_row)
 	{
	echo '<br /><br />
	<div style="padding:3px;'.(($params->get( 'review_author_background_color' )!='')?('background-color:#'.$params->get( 'review_author_background_color' ).';'):'').'">'.JText::_('SH_AUTHOR').' <b>'.$reviews_row->name.'</b></div>

	 <div style="'.(($params->get( 'review_text_background_color' )!='')?('background-color:#'.$params->get( 'review_text_background_color' ).';'):'').(($params->get( 'review_color' )!='')?('color:#'.$params->get( 'review_color' ).';'):'').' padding:8px;">'.str_replace('
','<br>', $reviews_row->content).'</div>
	 ';
	}
	
	
	
	if($reviews_count>$reviews_perpage)
	{
 ?>
<div id="spidercatalognavigation" style="text-align:center;">
    <?php
	
	$r=ceil($reviews_count/$reviews_perpage);
	
	 $navstyle=(($params->get( 'text_size_small' )!='')?('font-size:'.$params->get( 'text_size_small' ).'px;'):'').(($params->get( 'text_color' )!='')?('color:#'.$params->get( 'text_color' ).';'):'');
			$linkback = JRoute::_($_SERVER["PHP_SELF"].'?'. $url . '');
//echo $linkback;
$pos=strpos($linkback,'?rev_page=');
//echo $pos;
$po=substr_replace($linkback,'',$pos);
//echo $po;
//$link = JRoute::_($_SERVER["PHP_SELF"].'?' .$url . '&rev_page= ');
	if($rev_page>5){
	$link = JRoute::_($_SERVER["PHP_SELF"].'?'.$url . 'rev_page=1#rev');
echo "
&nbsp;&nbsp;<a href=\"$link\" style=\"$navstyle\">first</a>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;...&nbsp";
}
	
	 if($rev_page>1)
		{


		if(JRequest::getVar('rev_page'))
		{
			//$link = JRoute::_($_SERVER["PHP_SELF"].'?'. $url . '&rev_page='.($rev_page-1).'#rev');
			$link = $po.'?rev_page='.($rev_page-1).'#rev';
		}
		else
		{
		$link = JRoute::_($_SERVER["PHP_SELF"].'?'. $url . 'rev_page='.($rev_page-1).'#rev');
		}
		//	echo $link;
			echo "&nbsp;&nbsp;<a href=\"$link\" style=\"$navstyle\">prev</a>&nbsp;&nbsp;";
		}
	
	for ($i=$rev_page-4; $i<($rev_page+5); $i++)
	{
		 if($i<=$r and $i>=1)
		 {
		 if(JRequest::getVar('rev_page'))
		 {
			//$link = JRoute::_($_SERVER["PHP_SELF"].'?'. $url . '&rev_page='.$i.'#rev');
			$link = $po.'?rev_page='.$i.'#rev';
			}
			else
			{
			$link = JRoute::_($_SERVER["PHP_SELF"].'?'. $url . 'rev_page='.$i.'#rev');
			}
			
			if($i==$rev_page)
				echo "<span style='font-weight:bold;color:##000000'>&nbsp;$i&nbsp;</span>";
			else
				echo "<a href=\"$link\" style=\"$navstyle\">&nbsp;$i&nbsp;</a>";
		 }
	 }
	 
	 
	if($rev_page<$r)
		{
				 if(JRequest::getVar('rev_page'))
				 {
				  if(JRequest::getVar('rev_page')){
			//$link = JRoute::_($_SERVER["PHP_SELF"].'?'. $url . '&rev_page='.($rev_page+1).'#rev');
			$link = $po.'?rev_page='.($rev_page+1).'#rev';
			}
			else
			{
			$link = JRoute::_($_SERVER["PHP_SELF"].'?'. $url . 'rev_page='.($rev_page+1).'#rev');
			}
			}
			else
			{
			$link = JRoute::_($_SERVER["PHP_SELF"].'?'. $url . 'rev_page='.($rev_page+1).'#rev');
			}
			echo "&nbsp;&nbsp;<a href=\"$link\" style=\"$navstyle\">next</a>&nbsp;&nbsp;";
		}
if(($r-$rev_page)>4)
{
  if(JRequest::getVar('rev_page'))
  {
//$link = JRoute::_($_SERVER["PHP_SELF"].'?'.$url . '&rev_page='.$r.'#rev');
$link = $po.'?rev_page='.$r.'#rev';
}
else
{
$link = JRoute::_($_SERVER["PHP_SELF"].'?'.$url . 'rev_page='.$r.'#rev');
}
echo "&nbsp;...&nbsp;&nbsp;&nbsp;<a href=\"$link\" style=\"$navstyle\">last</a>";
}

	echo '</div>';
	}
	}
	echo '</div>';
}
?>
	</div><br /><br /><script type="text/javascript">
var SpiderCatOFOnLoad = window.onload;
window.onload = SpiderCatAddToOnload;

function prod_change_picture(id,obj,width,height)
{
		
	phpurl=document.getElementById("prod_main_picture").style.backgroundImage.substr(0,document.getElementById("prod_main_picture").style.backgroundImage.indexOf("&id"));
	document.getElementById("prod_main_picture_a").href=obj.parentNode.href;
	
	document.getElementById("prod_main_picture").style.backgroundImage=phpurl+'&id='+id+'&width='+width+'&height='+height+'&reverse=<?php echo $params->get( 'global_revers' ); ?>)';
	
}
</script>