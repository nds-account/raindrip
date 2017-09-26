<?php

 /**
 * @package Spider Catalog
 * @author Web-Dorado
 * @copyright (C) 2012 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted access');
class HTML_spidercatalog
{
static public function showLinks($option, $controller)
{
	?>
	<div style="background-color:#f6f6f6"> 
	<table>
	<tr>
	<td  ALIGN="center">
	<a href="index.php?option=com_spidercatalog&amp;controller=category"><img src="components/com_spidercatalog/images/Categories.png"  ALT="Categories"  style="padding:12px;"   width=100><br>Categories</a>
	</td>
	<td  ALIGN="center">
	<a href="index.php?option=com_spidercatalog&amp;controller=products"><img src="components/com_spidercatalog/images/products.png"  ALT="Products"  style="padding:12px;"  width=100><br>Products</a>
	</td>
	<td  ALIGN="center">
	<a href="index.php?option=com_spidercatalog&amp;controller=options"><img src="components/com_spidercatalog/images/options.png"  ALT="Options"  style="padding:12px;"   width=100><br>Options</a>
	</td>
	</tr>
	</table>
	</div >
	<?php
}

public static function editProduct( $row, $lists, $votes, $option , $params, $rows1, $rows, $rowsparams)
{
$editor =JFactory::getEditor('tinymce');
JHTML::_('behavior.calendar');
JHTML::_('behavior.modal'); 

?>
<script type="text/javascript">
Joomla.submitbutton=function(pressbutton) 
{
	if(document.adminForm.name.value=='' && pressbutton!='cancel')
	{
		alert('Name is required.');
		document.adminForm.name.focus();
	}
	else
		submitform(pressbutton);
}
</script>
<style>
.admintable input
{
float:none;
margin:0px;
}
.admintable .admPublished input
{
float:left;
}
.admintable tr td label
{
clear: none;
min-width: 50px;
margin:5px;
margin-top:0px;
}
</style>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<fieldset class="adminform">
<legend>Edit Product parameters</legend>

<table class="admintable" cellspacing="15">
<tr>
<td width="100" align="right" class="key">
Name:
</td>
	

<td>
<input class="text_area" type="text" name="name" 
id="name" size="50" maxlength="250"
value="<?php echo $row->name;?>" />
</td>
</tr>
<tr>
<td align="right" class="key">Category:</td>
<td>
<?php
//echo '<select multiple >';
    
    
      
           // echo '<option  '.$lists['category_id'].'</option>';
        
    
        
  //  echo '</select>';

	
//echo $row->category_id;

//echo $lists['category_id'];
?>

<?php


			$value=$row->id;
			
		//print_r($rows);

 $people = explode(',',$row->category_id);

array_pop($people);
 

 
?>

<script>

function getvalues()
{

option_length=document.getElementById('getvalue').options.length;
values_inline='';

for(i=0;i<option_length;i++)
{
if(document.getElementById('getvalue').options[i].selected)
values_inline=values_inline+document.getElementById('getvalue').options[i].value+',';
}

document.getElementById('select_id').value=values_inline;

}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>


    <input  type="button" value="Select all" class="selectAll"/>

	<select name="categoryselect" onchange="getvalues()" multiple id="getvalue" >




<?php 

foreach ($rows as $row_cat){


if (in_array($row_cat->id,$people))

  {
echo '<option selected="selected" value="'.$row_cat->id.'">'.$row_cat->name.'</option>';

  }
else

  {
echo '<option value="'.$row_cat->id.'">'.$row_cat->name.'</option>';
  }



}
?>
</select>

<script>
    $(".selectAll").click(function () {
      $(this).parent().find('option').attr('selected','selected');
	  getvalues();
    });
  </script>
<input type="hidden" id="select_id" name="category_id" value="<?php echo $row->category_id ?>" />


<input id="apply_cat" type="button" onclick="Joomla.submitbutton('apply')" value="Apply Categories" />

<?php
//echo $row->id;
   

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////sssssssssssssssssssssssss////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
</td>
</tr>
<?php
if($params->get( 'price' )){
?>
<tr>
<td width="100" align="right" class="key">
Price:
</td>
<td>
<input class="cost" type="text" name="cost" id="cost" size="50" maxlength="250"
value="<?php echo $row->cost;?>" />
</td>
</tr>

<?php
}
if($params->get( 'market_price' )){
	?>
	<tr>
<td width="100" align="right" class="key">
Market Price:
</td>
<td>
<input class="market_cost" type="text" name="market_cost" id="market_cost" size="50" maxlength="250"
value="<?php echo $row->market_cost; ?>" />
</td>
</tr>

<?php

}

?>
<tr>
<td width="100" align="right" class="key">
Images
</td>
<td>
<div style=" position:absolute; width:1px; height:1px; top:0px; overflow:hidden">
<textarea id="tempimage" name="tempimage" class="mce_editable"></textarea><br />
</div>

<input class="text_area" type="hidden" name="image_url"
id="image_url" size="50" maxlength="250"
value="<?php echo $row->image_url;?>" />
<!------------------------------------------------------------------------------------->
<div id='sel_img'>
<?php
	$param_string="";

	$par_values=explode(";",$row->image_url);
	$t=0;
?>
<script type="text/javascript">
	par_images=new Array(<?php
	for($j=0;$j<count($par_values);$j++) 
		{
			if($par_values[$j]!="")
				{
					echo "'".addslashes(htmlspecialchars($par_values[$j]))."',";
				}
		}
	
	?>'');
</script>
<?php
end($par_values);        
$key = key($par_values);
	$image_url_list='';
	
	for($j=0;$j<count($par_values);$j++) 
		{

			if($par_values[$j]!="")
				{
				
				if(strpos($par_values[$j],'http://')===0 or strpos($par_values[$j],'https://')===0)
				$fullhref=$par_values[$j];
				else
				$fullhref=JURI::root().$par_values[$j];
				
				$image_url_list.='<a href="'.$fullhref.'" target="_blank"><img src="../index.php?option=com_spidercatalog&view=picture&format=raw&tmpl=component&id='.$row->id.'&picnum='.$j.'&height=50" style="margin:8px;"/></a>';
				
					echo '<input style="width:200px;" id="sel_img_'.$j.'" onChange="Add(\'sel_img\')" value="'.$par_values[$j].'" />
					<input type="button" value="X" onClick="Remove('.$j.',\'sel_img\');Joomla.submitbutton(\'apply\');" /><br />';
					

				}
			else
				{
					if($t==0)
						{
					$srt_images='';

					echo '<input style="width:200px;" id="sel_img_'.$j.'" onChange="Add(\'sel_img\')" value="" />
					<input type="button" value="X" onClick="Remove('.$j.',\'sel_img\');Joomla.submitbutton(\'apply\');" /><br />';
	
							$t++;
						}
				}
				
		}
?>
</div><input type="hidden" name="param1" id="hid_sel_img" value="<?php echo $param_string; ?>" />

<a class="modal-button" title="Image" href="index.php?option=com_spidercatalog&task=media_manager_image&type=thumb&sel_img=<?php echo $key-1; ?>&tmpl=component" rel="{handler: 'iframe', size: {x: 550, y: 550}}">Select Image</a><br />

<script type="text/javascript">
srt_images="<?php echo $srt_images ?>"; 
setTimeout("getImage('<?php echo $_SERVER['HTTP_HOST'].JURI::root(true).DS ?>')",500);
</script>

</td>
</tr>
<tr><td colspan="2" style="width:500px;">
<?php echo $image_url_list; ?>
</td></tr>


<!---------------------------------------------------------------------------------------->
<?php 







$catids=substr($row->category_id,0,strlen($row->category_id)-1);


if($catids){

//print_r($rows);
		 


$array=explode(",",$row->category_id);
foreach($array as $arra){}
$paramsedit=array();

//print_r($rows5->param);
//echo $rows5->param;
foreach ($rowsparams as $rowz){
//echo $rowz->param.'<br>';


$paramsedit=array_merge($paramsedit,explode("	",$rowz->param));

}
$result = array_unique($paramsedit);
//print_r($result);

$zozo=implode("	",$result);
//print_r($zozo);



}

for ($i=0, $n=count( $rows1 ); $i < $n; $i++)
{

$row1 = &$rows1[$i];
$par=explode("	",$zozo);

for($k=0;$k<count($par);$k++)
{

if(isset($par[$k]) and $par[$k]!='')
{
echo "<tr>

<td width=\"100\" align=\"right\" class=\"key\">".htmlspecialchars($par[$k])."</td>";
?>
<td>

<div id='<?php echo "par_".htmlspecialchars($par[$k]); ?>'>
<?php
$param_string="";
$par_data=explode("par_",$row->param);

for($j=0;$j<count($par_data);$j++) 
{
$par1_data=explode("@@:@@",$par_data[$j]);
if($par1_data[0]==$par[$k])
$param_string=$par1_data[1];
}

	$par_values=explode("	",$param_string);
	$t=0;
	?>
<script type="text/javascript">
parameters0['<?php echo "par_".addslashes(htmlspecialchars($par[$k])); ?>']=new Array(<?php
for($j=0;$j<count($par_values);$j++) 
	{
		if($par_values[$j]!="")
			{
				echo "'".addslashes(htmlspecialchars($par_values[$j]))."',";
			}
	}
?>'');
</script>
<?php
	for($j=0;$j<count($par_values);$j++) 
		{
			if($par_values[$j]!="")
				{
					echo '<input type="text" style="width:200px;" id="inp_par_'.htmlspecialchars($par[$k])."_".$j.'" value="'.htmlspecialchars($par_values[$j]).'" onChange="Add(\'par_'.addslashes(htmlspecialchars($par[$k])).'\')" /><input type="button" value="X" onClick="Remove('.$j.',\''."par_".addslashes(htmlspecialchars($par[$k])).'\');" /><br />';
				}
			else
				{
					if($t==0)
						{
					echo '<input type="text" style="width:200px;" id="inp_par_'.htmlspecialchars($par[$k])."_".$j.'" value="" 					onChange="Add(\'par_'.addslashes(htmlspecialchars($par[$k])).'\')" /><input type="button" value="X" onClick="Remove('.$j.',\''."par_".addslashes(htmlspecialchars($par[$k])).'\');" /><br />';
							$t++;
						}
				}

		}

?>
</div><input type="hidden" name="param1" id="hid_<?php echo "par_".htmlspecialchars($par[$k]); ?>" />

</td>
</tr>
<?php
}
}
}

?>


<tr>
<td width="100" align="right" class="key">
Description:<input type="hidden" name="param" id="all_par_hid" />

<script type="text/javascript">
loadHids();
</script>

</td>
<td>
<?php
echo $editor->display('description', $row->description ,
'200%', '30', '40', '5' );
?>
</td>
</tr>
<tr>
<td width="100" align="right" class="key">
Order:
</td>
<td>
<?php
echo $lists['ordering'];
?>
</td>
</tr>
<tr>
<td width="100" align="right" class="key">
Show in parents:
</td>
<td class="admPublished">
<fieldset id="published_in_parent	" class="radio btn-group">
<?php
echo $lists['published_in_parent'];
?>
</fieldset>
</td>
</tr>

<tr>
<td width="100" align="right" class="key">
Published:
</td>
<td class="admPublished">
<fieldset id="published	" class="radio btn-group">
<?php
echo $lists['published'];
?>
</fieldset>
</td>
</tr>
</table>

</fieldset>
<input type="hidden" name="id"
value="<?php echo $row->id; ?>" />
<input type="hidden" name="option"
value="<?php echo $option;?>" />


<input type="hidden" name="controller" value="products" />

<input type="hidden" name="task"
value="" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
<?php
}
 public static function editCategory( $row, $lists, $option, $rowsparent )

{
$editor = JFactory::getEditor('tinymce');
JHTML::_('behavior.calendar');
?>
<script type="text/javascript">
function paramj(){
document.getElementById('idparam').value=1;

}
Joomla.submitbutton=function(pressbutton) 
{
	if(document.adminForm.name.value=='' && pressbutton!='cancel')
	{
		alert('Name is required.');
		document.adminForm.name.focus();
	}
	else
		submitform(pressbutton);
}
</script>
<style>
.admintable input
{
float:none;
margin:0px;
}
.admintable .admPublished input
{
float:left;
}
.admintable tr td label
{
clear: none;
min-width: 50px;
margin:5px;
margin-top:0px;
}
</style>
<form action="index.php?" method="post"
name="adminForm" id="adminForm">
<fieldset class="adminform">
<input type="hidden" name="idparam"
id="idparam" value="0" />
<legend>Edit Category</legend>
<table class="admintable" cellspacing="15">
<tr>
<td width="100" align="right" class="key">
Name:
</td>
<td>
<input class="text_area" type="text" name="name"
id="name" size="50" maxlength="250"
value="<?php echo $row->name;?>" />
</td>
</tr>
<tr>
<td width="100" align="right" class="key">
Parent Category:
</td>
<td>
<?php
echo $lists['parent'];
?>
</td>
</tr>




<tr>
<td width="100" align="right" class="key">
Images
</td>
<td>
<div style=" position:absolute; width:1px; height:1px; top:0px; overflow:hidden">
<textarea id="tempimage" name="tempimage" class="mce_editable"></textarea><br />
</div>

<input class="text_area" type="hidden" name="category_image_url"
id="image_url" size="50" maxlength="250"
value="<?php echo $row->category_image_url;?>" />
<!------------------------------------------------------------------------------------->
<div id='sel_img'>
<?php
	$param_string="";

	$par_values=explode(";",$row->category_image_url);;
	$t=0;
?>
<script type="text/javascript">
	par_images=new Array(<?php
	for($j=0;$j<count($par_values);$j++) 
		{
			if($par_values[$j]!="")
				{
					echo "'".addslashes(htmlspecialchars($par_values[$j]))."',";
				}
		}
	
	?>'');
</script>
<?php
end($par_values);        
$key = key($par_values);
	$image_url_list='';
	
	for($j=0;$j<count($par_values);$j++) 
		{

			if($par_values[$j]!="")
				{
				if(strpos($par_values[$j],'http://')===0 or strpos($par_values[$j],'https://')===0)
				$fullhref=$par_values[$j];
				else
				$fullhref=JURI::root().$par_values[$j];
				
				$image_url_list.='<a href="'.$fullhref.'" target="_blank"><img src="../index.php?option=com_spidercatalog&view=picturecat&format=raw&tmpl=component&id='.$row->id.'&picnum='.$j.'&height=50" style="margin:8px;"/></a>';
				
					echo '<input style="width:200px;" id="sel_img_'.$j.'" onChange="Add(\'sel_img\')" value="'.$par_values[$j].'" />
					<input type="button" value="X" onClick="Remove('.$j.',\'sel_img\');Joomla.submitbutton(\'apply\');" /><br />';
					

				}
			else
				{
					if($t==0)
						{
					$srt_images='';

					echo '<input style="width:200px;" id="sel_img_'.$j.'" onChange="Add(\'sel_img\')" value="" />
					<input type="button" value="X" onClick="Remove('.$j.',\'sel_img\');Joomla.submitbutton(\'apply\');" /><br />';
	
							$t++;
						}
				}
				
		}
?>
</div><input type="hidden" name="param1" id="hid_sel_img" value="<?php echo $param_string; ?>" />

<input type="hidden" id="apply_cat" type="button" onclick="Joomla.submitbutton('apply')" value="Apply Categories">

<a class="modal-button" title="Image" href="index.php?option=com_spidercatalog&task=media_manager_image&type=thumb&sel_img=<?php echo $key-1; ?>&tmpl=component" rel="{handler: 'iframe', size: {x: 550, y: 550}}">Select Image</a><br />

<script type="text/javascript">
srt_images="<?php echo $srt_images ?>"; 
setTimeout("getImage('<?php echo $_SERVER['HTTP_HOST'].JURI::root(true).DS ?>')",500);
</script>

</td>
</tr>
<tr><td colspan="2" style="width:500px;">
<?php echo $image_url_list; ?>
</td></tr>






<tr>
<td width="100" align="right" class="key">
Description:
</td>
<td>
<?php
echo $editor->display('description', $row->description ,
'100%', '150', '40', '5' ) ;
?>
</td>
</tr>
<tr>
<tr>
<td width="100" align="right" class="key">
Parameters</td>
<td>
<?php
?>

<script type="text/javascript">

parameters0['sel1']=new Array(<?php

$par=explode("	",$row->param);

for($k=0;$k<=count($par);$k++)
{
if(isset($par[$k]) and $par[$k]!='')
echo "'".addslashes(htmlspecialchars($par[$k]))."',";
}

?>'');

</script>

<div id="sel1">
<?php
$k=0;
while($k<1000)
{
if(isset($par[$k]) and $par[$k]!=''){
echo '<input type="text" style="width:200px;" id="inp_sel1_'.$k.'" value="'.htmlspecialchars($par[$k]).'" onChange="Add(\'sel1\')" /><input type="button" value="X" onClick="Remove('.$k.',\'sel1\');" /><br />';
$k++;
}
else{
echo '<input type="text" style="width:200px;" id="inp_sel1_'.$k.'" value="" onChange="Add(\'sel1\')" /><input type="button" value="X" onClick="Remove('.$k.',\'sel1\');" /><br />';
$k=1000;
}
}

	//if(trim($rows55->param)==trim($row->param)){
//	print_r($rowsparent->param);
	//echo $rowsparent;
?>
</div><input type="hidden" name="param" id="hid_sel1" value="<?php echo $row->param; ?>	" />
<?php //} ?>
</td>
</tr>

<tr>
<td width="100" align="right" class="key">
Order:
</td>
<td>
<?php
echo $lists['ordering'];
?>
</td>
</tr>
<tr>
<td width="100" align="right" class="key">
Published:
</td>
<td class="admPublished">
<fieldset id="published	" class="radio btn-group">
<?php
echo $lists['published'];
?>
</fieldset>
</td>
</tr>
</table>
</fieldset>
<input type="hidden" name="id"
value="<?php echo $row->id; ?>" />
<input type="hidden" name="controller"
value="category" />
<input type="hidden" name="option"
value="<?php echo $option;?>" />
<input type="hidden" name="task"
value="" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
<?php
}

    
    
 public static   function showProducts($option, &$rows, $rows2, $rows3, $controller, $lists, $pageNav)
      {

?>
<style>
.icon-menu-2::before {
content: ">" !important;
color: #51A351;
}
</style>
<table><tr><td>
</td></tr></table>

<form action="index.php?option=com_spidercatalog&controller=products" method="post"  id="adminForm" name="adminForm">
<table>
            <tr>
            <td align="left" width="50%">
                    <?php
        echo JText::_('Filter');
?>:
                    <input type="text" name="search" id="search" value="<?php
        echo $lists['search'];
?>" class="text_area" onchange="document.adminForm.submit();" />
                    <button style="margin-bottom:9px;" class="btn tip hasTooltip" data-original-title="Search" onclick="this.form.submit();"><?php
        echo JText::_('Go');
?></button>
                    <button style="margin-bottom:9px;" class="btn tip hasTooltip" data-original-title="Clear" onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='';this.form.submit();"><?php
        echo JText::_('Reset');
?></button>
                </td>
				
                <td align="right" width="50%">
				
	
			


                    
                    <?php
        echo $lists['category_id'];
?>
                    
                </td>
                <td nowrap="nowrap">
                </td>
            </tr>
        </table>
		
<table class="adminlist table table-striped">
<thead>
<tr>
    

<tr>
<th width="1%">
#
</th>
<th width="1%">
<input type="checkbox" name="toggle"
value="" onclick="Joomla.checkAll(this);" />
</th>
<th class="title"><?php
        echo JHTML::_('grid.sort', 'Name', 'name', $lists['order_Dir'], $lists['order']);
?></th>
<th width="12%"><?php
        echo JHTML::_('grid.sort', 'Category', 'categories.name', @$lists['order_Dir'], @$lists['order']);
?></th>
<th width="12%"><?php
        echo JHTML::_('grid.sort', 'Price', 'cost', @$lists['order_Dir'], @$lists['order']);
?></th>
<th width="8%"><?php
        echo JHTML::_('grid.sort', 'Order', 'ordering', @$lists['order_Dir'], @$lists['order']);
?>&nbsp;<?php
        echo JHTML::_('grid.order', $rows);
?></a></th>
<th width="5%" nowrap="nowrap"><?php
        echo JHTML::_('grid.sort', 'Published', 'published', @$lists['order_Dir'], @$lists['order']);
?></th>
</tr>
</thead>
 <?php
        $k = 0;
        for ($i = 0, $n = count($rows); $i < $n; $i++)
          {
            $row =& $rows[$i];
            $checked   = JHTML::_('grid.id', $i, $row->id);
            $published = JHTML::_('grid.published', $row, $i);
            $link      = 'index.php?option=' . $option . '&task=edit&controller=products&cid[]=' . $row->id;
?>
<tr class="<?php
            echo "row$k";
?>">
<td>
<?php
            echo $pageNav->getRowOffset($i);
?>
</td>
<td>
<?php
            echo $checked;
?>
</td>
<td>
<a href="<?php
            echo $link;
?>">
<?php
            echo $row->name;
?></a>
</td>
<td>
<?php


foreach ($rows[$i]->gago as $categoryname)
{
echo $categoryname->name;
echo '<br>';
}






////////////////




?>
</td>
<td>
<?php
            echo $row->cost;
?>
</td>
<td class="order">
<input type="text" name="order[]" size="5" value="<?php
            echo $row->ordering;
?>" class="text_area" style="text-align: center" />
            </td>
<td style="text-align: center">
<?php
            echo $published;
?>
</td>
</tr>

<?php
            $k = 1 - $k;
          }
?>
<tfoot><tr>
                            <td colspan="8">
                                <?php
        echo $pageNav->getListFooter();
?>
                            </td>
                            </tr></tfoot>
</table>
<input type="hidden" name="option"
value="<?php
        echo $option;
?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />

<input type="hidden" name="controller" value="products" />

<input type="hidden" name="filter_order" value="<?php
        echo $lists['order'];
?>" />
<input type="hidden" name="filter_order_Dir" value="<?php
        echo $lists['order_Dir'];
?>" />
<?php
        echo JHTML::_('form.token');
?>
</form>
<?php
      }
  public static  function showcategories($option, $rows, $controller, $lists, $pageNav, $cat_rows, $plusnum)
      {
?>

<style>
.icon-menu-2::before {
content: ">" !important;
color: #51A351;
}
</style>

<form action="index.php?option=com_spidercatalog&controller=category" method="post" id="adminForm" name="adminForm">

<table>
    <tr>
                <td align="left" width="100%">
                    <?php
        echo JText::_('Filter');
?>:
                    <input type="text" name="search" id="search" value="<?php
        echo $lists['search'];
?>" class="text_area" onchange="document.adminForm.submit();" />
                    <button style="margin-bottom:9px;" class="btn tip hasTooltip" data-original-title="Search" onclick="this.form.submit();"><?php
        echo JText::_('Go');
?></button>
                    <button style="margin-bottom:9px;" class="btn tip hasTooltip" data-original-title="Clear"  onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='';this.form.submit();"><?php
        echo JText::_('Reset');
?></button>
                </td>
				
					<td align="right" width="50%">
             <?php
        echo $lists['category_id'];
?>
                </td>
				
                <td nowrap="nowrap">
                    

                </td>
            </tr></table>
            <table class="adminlist table table-striped">
<thead>
<tr>
<th width="1%">
#
</th>
<th width="1%">
<input type="checkbox" name="toggle"
value="" onclick="Joomla.checkAll(this);" />
</th>
<th class="title"><?php
        echo JHTML::_('grid.sort', 'Name', 'name', $lists['order_Dir'], $lists['order']);
?></th>
<th width="35%"><?php
        echo JHTML::_('grid.sort', 'Description', 'description', $lists['order_Dir'], $lists['order']);
?></th>
<th width="5%" nowrap="nowrap"><?php
        echo JHTML::_('grid.sort', 'Subcategories', 'subcategories', $lists['order_Dir'], $lists['order']);
?></th>
<th width="5%" nowrap="nowrap"><?php
        echo JHTML::_('grid.sort', 'Parent', 'parent', $lists['order_Dir'], $lists['order']);
?></th>
<th width="5%" nowrap="nowrap"><?php
        echo JHTML::_('grid.sort', 'Products', 'products', $lists['order_Dir'], $lists['order']);
?></th>
<th width="10%"><?php
        echo JHTML::_('grid.sort', 'Order', 'ordering', @$lists['order_Dir'], @$lists['order']);
?>&nbsp;<?php
        echo JHTML::_('grid.order', $rows);
?></a></th>
<th width="5%" nowrap="nowrap"><?php
        echo JHTML::_('grid.sort', 'Published', 'published', $lists['order_Dir'], $lists['order']);
?></th>

</tr>
</thead>
<?php
//$rows=open_cat_in_tree($rows);
        $k = 0;
        for ($i = 0, $n = count($rows); $i < $n; $i++)
          {
            $row =$rows[$i];
            $checked   = JHTML::_('grid.id', $i, $row->id);
            $published = JHTML::_('grid.published', $row, $i);
            $link      = 'index.php?option=' . $option . '&task=edit&controller=category&cid[]=' . $row->id;
?>
<tr class="<?php
            echo "row$k";
?>">
<td>
<?php

//print_r($pageNav->limitstart);
if($pageNav->limitstart=='0'){
            echo $pageNav->getRowOffset($i);
			}
			else
			{
			echo $pageNav->getRowOffset($i)+count($plusnum);
			}
			
?>
</td>
<td>
<?php
            echo $checked;
?>
</td>
<td>
<a href="<?php
            echo $link;
?>">
<?php
            echo $row->name;
?></a>
</td>

<td>
<?php
            echo $row->description;
?>
</td>


<td style="text-align: center">
<a href="index.php?option=com_spidercatalog&controller=category&cat_search=<?php echo $row->id; ?>"> <?php echo $row->count1;
?> </a>
</td>

<td>
<?php 
if(!($rows[$i]->par_name))
echo "Uncategorized";
else
echo $row->par_name;
?>
</td>

<td style="text-align: center">
<a href="index.php?option=com_spidercatalog&controller=products&cat_search=<?php echo $row->id; ?>"> <?php echo $row->prod_count;
?> </a>
</td>

<td class="order">
<input type="text" name="order[]" size="5" value="<?php
            echo $row->ordering;
?>" class="text_area" style="text-align: center" />
            </td>
<td style="text-align: center">
<?php
            echo $published;
?>
</td>
</tr>
<?php
            $k = 1 - $k;
          }
?><tfoot><tr><td colspan="9">
                                <?php
								
							//	print_r($limitstart);
					//	echo	JRequest::getVar(page_num)	;
        echo $pageNav->getListFooter();
?>
                            </td>
                            </tr></tfoot>
</table>
<input type="hidden" name="option" value="<?php
        echo $option;
?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="category" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php
        echo $lists['order'];
?>" />
<input type="hidden" name="filter_order_Dir" value="<?php
        echo $lists['order_Dir'];
?>" />
<?php
        echo JHTML::_('form.token');
?>
</form>



<?php
      }
  
  public static  function editProductRating($option, $rows, $pageNav, $product_id, $lists)
      {
?>

<form action="index.php?option=com_spidercatalog&task=edit&controller=product_rating&product_id=<?php
        echo $product_id;
?>" method="post"  id="adminForm" name="adminForm">
<table>
    <tr>
                <td align="left" width="100%">
               
            <table class="adminlist">
<thead>
<tr>
<th width="1%">
#
</th>
<th width="1%">
<input type="checkbox" name="toggle"
value="" onclick="checkAll(<?php
        echo count($rows);
?>);" />
</th>
<th class="title"><?php
        echo JHTML::_('grid.sort', 'Remote Ip', 'remote_ip', $lists['order_Dir'], $lists['order']);
?></th>
<th class="title"><?php
        echo JHTML::_('grid.sort', 'Vote Value', 'vote_value', $lists['order_Dir'], $lists['order']);
?></th>
</tr>
</thead>
<?php
for ($j = 1; $j < 6; $j++)
              {
                $vote_select[] = array(
                    'value' => $j,
                    'text' => $j
                );
              }
        $k = 0;
        for ($i = 0, $n = count($rows); $i < $n; $i++)
          {
            $row =& $rows[$i];
            $checked = JHTML::_('grid.id', $i, $row->id);
            
            $lists['vote_select'] = JHTML::_('select.genericList', $vote_select, 'vote_' . $row->id, 'class="inputbox" ' . '', 'value', 'text', $row->vote_value);

			?>
<tr  class="<?php
            echo "row$k";
?>" >
<td>
<?php
            echo $pageNav->getRowOffset($i);
?>
</td>
<td>
<?php
            echo $checked;
?>
<input type="hidden" name="rating_id[]" value="<?php
            echo $row->id;
?>" />
</td>

<td>


<?php
            echo $row->remote_ip;
?>



</td>
<td>
<?php
            echo $lists['vote_select'];
?>
</td>

</tr>
<?php
            $k = 1 - $k;
          }
?><tfoot><tr><td colspan="8">
                                <?php
        echo $pageNav->getListFooter();
?>
                            </td>
                            </tr></tfoot>
</table>

<input type="hidden" name="option" value="<?php
        echo $option;
?>" />
<input type="hidden" name="task" value="edit" />
<input type="hidden" name="controller" value="product_rating" />
<input type="hidden" name="product_id" value="<?php
        echo $product_id;
?>" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php
        echo $lists['order'];
?>" />
<input type="hidden" name="filter_order_Dir" value="<?php
        echo $lists['order_Dir'];
?>" />
<?php
        echo JHTML::_('form.token');
?>
</form>
</table>


<?php
      }
    function editProductReviews($option, $rows, $pageNav, $product_id, $lists)
      {
?>


<form action="index.php?option=com_spidercatalog&task=edit&controller=product_reviews&product_id=<?php
        echo $product_id;
?>" method="post"  id="adminForm" name="adminForm">
<table>
    <tr>
                <td align="left" width="100%">
               
            <table class="adminlist">
<thead>
<tr>
<th width="1%">
#
</th>
<th width="1%">
<input type="checkbox" name="toggle"
value="" onclick="checkAll(<?php
        echo count($rows);
?>);" />
</th>
<th class="title"><?php
        echo JHTML::_('grid.sort', 'Remote Ip', 'remote_ip', $lists['order_Dir'], $lists['order']);
?></th>
<th class="title"><?php
        echo JHTML::_('grid.sort', 'Name', 'name', $lists['order_Dir'], $lists['order']);
?>&nbsp;</th>

<th class="title"><?php
        echo JHTML::_('grid.sort', 'Message', 'content', $lists['order_Dir'], $lists['order']);
?>&nbsp;</th>
</tr>
</thead>
<?php

        $k = 0;
        for ($i = 0, $n = count($rows); $i < $n; $i++)
          {
            $row =& $rows[$i];
            $checked = JHTML::_('grid.id', $i, $row->id);
?>
<tr  class="<?php
            echo "row$k";
?>" >
<td>
<?php
            echo $pageNav->getRowOffset($i);
?>
</td>
<td>
<?php
            echo $checked;
?>
<input type="hidden" name="review_id[]" value="<?php
            echo $row->id;
?>" />
</td>

<td>


<?php
            echo $row->remote_ip;
?>


</td>
<td>


<?php
            echo $row->name;
?>


</td>

<td>


<?php
            echo $row->content;
?>


</td>

</tr>
<?php
            $k = 1 - $k;
          }
?><tfoot><tr><td colspan="8">
                                <?php
        echo $pageNav->getListFooter();
?>
                            </td>
                            </tr></tfoot>
</table>

<input type="hidden" name="option" value="<?php
        echo $option;
?>" />
<input type="hidden" name="task" value="edit" />
<input type="hidden" name="controller" value="product_reviews" />
<input type="hidden" name="product_id" value="<?php
        echo $product_id;
?>" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php
        echo $lists['order'];
?>" />
<input type="hidden" name="filter_order_Dir" value="<?php
        echo $lists['order_Dir'];
?>" />
<?php
        echo JHTML::_('form.token');
?>
</form>


</table>



<?php
      }
    
 public static   function showOptions($op_type)
      {
?>
<div style="background-color:#f6f6f6"> 
<table cellpadding="20">
<tr><td  ALIGN="center">

<?php
        if ($op_type == "")
            $width = 100;
        else
            $width = 50;
?>
<a href="index.php?option=com_spidercatalog&amp;controller=options&op_type=global"><img src="components/com_spidercatalog/images/GlobalOptions.png"  ALT="Global Options"  style="padding:12px;"  width=<?php
        echo $width;
?> ><br>Global Options</a>
</td>
<td  ALIGN="center">
<a href="index.php?option=com_spidercatalog&amp;controller=options&op_type=styles"><img src="components/com_spidercatalog/images/StylesAndColors.png"  ALT="Styles and Colors"  style="padding:12px;"  width=<?php
        echo $width;
?> ><br>Styles and Colors</a>
</td>

</tr>
</table>

</div>

  
<?php
      }
   
 public static   function showGlobal($option, $param_values, $controller, $op_type)
      {
?>
<br />
<style>
.admintable tr td label
{
clear: none;
min-width: 50px;
}
</style>
<form action="index.php?option=com_spidercatalog&controller=options&op_type=global" method="post"  id="adminForm" name="adminForm">
<div class="width-50">
<fieldset class="adminform">
<legend>Global Options</legend>

<table width="100%" class="paramlist admintable" cellspacing="1">

<tr>

<td width="40%" class="paramlist_key"><span class="editlinktip"><label id="paramsprice-lbl" for="paramsprice" class="hasTip" title="Show or hide Price">Price</label></span></td>
<td class="paramlist_value">
<?php
        $check0 = "";
        $check1 = "";
        if ($param_values['price'] == 1)
            $check1 = ' checked="checked" ';
        else
            $check0 = ' checked="checked" ';
			
?><fieldset id="price" class="radio btn-group">
     <input type="radio" name="params[price]" id="paramsprice0" class="btn" value="0" <?php
        echo $check0;
?>  /><label for="paramsprice0">Disable</label>
    <input type="radio" name="params[price]" id="paramsprice1" class="btn" value="1" <?php
        echo $check1;
?>  /><label for="paramsprice1">Enable</label>
</fieldset>
    
    </td>
</tr>
<tr>
<td width="40%" class="paramlist_key"><span class="editlinktip"><label id="jform_params_market_price-lbl" for="jform_params_market_pricemarket_price" class="hasTip" title="Show or hide market Price">Market Price</label></span></td>
<td class="paramlist_value">
<?php
        $check0 = "";
        $check1 = "";
        if ($param_values['market_price'] == 1)
            $check1 = ' checked="checked" ';
        else
            $check0 = ' checked="checked" ';
?>    <fieldset id="price" class="radio btn-group">
<input type="radio" name="params[market_price]" id="paramsmarket_price0" class="btn" value="0" <?php
        echo $check0;
?>  />
    <label for="paramsmarket_price0">Disable</label>
    <input type="radio" name="params[market_price]" id="paramsmarket_price1" class="btn" value="1" <?php
        echo $check1;
?>  />
    <label for="paramsmarket_price1">Enable</label>
    </fieldset>

    
    </td>
</tr>

<tr>
<td width="40%" class="paramlist_key"><span class="editlinktip"><label id="paramscurrency_symbol-lbl" for="paramscurrency_symbol" class="hasTip" title="Currency Symbol">Currency Symbol</label></span></td>
<td class="paramlist_value"><input type="text" name="params[currency_symbol]" id="paramscurrency_symbol" value="<?php
        echo $param_values['currency_symbol'];
?>" class="text_area" size="3" /></td>
</tr>
<tr>
<td width="40%" class="paramlist_key"><span class="editlinktip"><label id="paramscurrency_symbol_position-lbl" for="paramscurrency_symbol_position" class="hasTip" title="Currency Symbol Position (after or before number )">Currency Symbol Position</label></span></td>
<td class="paramlist_value">

<?php
        $check0 = "";
        $check1 = "";
        if ($param_values['currency_symbol_position'] == 0)
            $check0 = ' checked="checked" ';
        if ($param_values['currency_symbol_position'] == 1)
            $check1 = ' checked="checked" ';
?>
<fieldset id="currency_symbol_position" class="radio btn-group">
    <input type="radio" name="params[currency_symbol_position]" id="paramscurrency_symbol_position0" class="btn" value="0" <?php
        echo $check0;
?>   />
    <label for="paramscurrency_symbol_position0">Before</label>
    <input type="radio" name="params[currency_symbol_position]" id="paramscurrency_symbol_position1" class="btn" value="1"  <?php
        echo $check1;
?>  />
    <label for="paramscurrency_symbol_position1">After</label>
    </fieldset>
</td>
</tr>


<?php
        $check0 = "";
        $check1 = "";
        if ($param_values['enable_rating'] == 0)
            $check0 = ' checked="checked" ';
        if ($param_values['enable_rating'] == 1)
            $check1 = ' checked="checked" ';
?>
<tr>
<td width="40%" class="paramlist_key"><span class="editlinktip"><label id="paramsenable_rating-lbl" for="paramsenable_rating">Product Ratings</label></span></td>
<td class="paramlist_value">
    <fieldset id="enable_rating" class="radio btn-group">
    <input type="radio" name="params[enable_rating]" id="paramsenable_rating0" class="btn" value="0" <?php
        echo $check0;
?>  />
    <label for="paramsenable_rating0">Disable</label>
    <input type="radio" name="params[enable_rating]" id="paramsenable_rating1" class="btn" value="1" <?php
        echo $check1;
?>  />
    <label for="paramsenable_rating1">Enable</label>
    </fieldset>
</td>
</tr>


<tr>
<?php
        $check0 = "";
        $check1 = "";
        if ($param_values['enable_review'] == 0)
            $check0 = ' checked="checked" ';
        if ($param_values['enable_review'] == 1)
            $check1 = ' checked="checked" ';
?>
<td width="40%" class="paramlist_key"><span class="editlinktip"><label id="paramsenable_review-lbl" for="paramsenable_review">Customer Reviews</label></span></td>
<td class="paramlist_value">
    <fieldset id="enable_review" class="radio btn-group">
    <input type="radio" name="params[enable_review]" id="paramsenable_review0" class="btn" value="0"  <?php
        echo $check0;
?> />
    <label for="paramsenable_review0">Disable</label>
    <input type="radio" name="params[enable_review]" id="paramsenable_review1" class="btn" value="1" <?php
        echo $check1;
?>   />
    <label for="paramsenable_review1">Enable</label>
    </fieldset>
</td>
</tr>
<tr>
<?php
        $check0 = "";
        $check1 = "";
        if ($param_values['choose_category'] == 0)
            $check0 = ' checked="checked" ';
        if ($param_values['choose_category'] == 1)
            $check1 = ' checked="checked" ';
?>
<td width="40%" class="paramlist_key"><span class="editlinktip"><label id="paramschoose_category-lbl" for="paramschoose_category">Search by Category</label></span></td>
<td class="paramlist_value">
     <fieldset id="choose_category" class="radio btn-group">
    <input type="radio" name="params[choose_category]" id="paramschoose_category0" class="btn" value="0"  <?php
        echo $check0;
?> />
    <label for="paramschoose_category0">Disable</label>
    <input type="radio" name="params[choose_category]" id="paramschoose_category1" class="btn" value="1" <?php
        echo $check1;
?>   />
    <label for="paramschoose_category1">Enable</label>
    </fieldset>
</td>
</tr>

<tr>
<?php
        $check0 = "";
        $check1 = "";
        if ($param_values['search_by_name'] == 0)
            $check0 = ' checked="checked" ';
        if ($param_values['search_by_name'] == 1)
            $check1 = ' checked="checked" ';
?>
<td width="40%" class="paramlist_key"><span class="editlinktip"><label id="paramssearch_by_name-lbl" for="paramssearch_by_name">Search by Name</label></span></td>
<td class="paramlist_value">
 <fieldset id="choose_category" class="radio btn-group">
    <input type="radio" name="params[search_by_name]" id="paramssearch_by_name0" class="btn" value="0"  <?php
        echo $check0;
?> />
    <label for="paramssearch_by_name0">Disable</label>
    <input type="radio" name="params[search_by_name]" id="paramssearch_by_name1" class="btn" value="1" <?php
        echo $check1;
?>   />
    <label for="paramssearch_by_name1">Enable</label>
    </fieldset>
</td>
</tr>




</table>
<input type="hidden" name="option" value="<?php
        echo $option;
?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="options" />
<input type="hidden" name="op_type" value="global" />
<input type="hidden" name="boxchecked" value="0" />



<?php
        echo JHTML::_('form.token');
?>
</fieldset>
</div>
</form>


<?php
      }
 public static    function showStyles($option, $param_values, $controller, $op_type)
      {
?>

<br />
<style>
.admintable tr td label
{
clear: none;
min-width: 50px;
}
.admintable #ratingStars tr td img
{
float:none;
}
.admintable #ratingStars tr td input
{
margin-left:5px;
}
</style>
<?php
        $path_admin = JURI::root(true) . DS . 'administrator' . DS . 'components' . DS . 'com_spidercatalog';
        $path_site  = JURI::root(true) . DS . 'components' . DS . 'com_spidercatalog';
?>

 <script type="text/javascript" src="<?php
        echo $path_admin;
?>/elements/jscolor/jscolor.js"></script>
<form action="#" method="post" name="adminForm">
<fieldset class="adminform">
<div class="updated" style="font-size: 14px; color:red !important"><p><strong>Style Options is disabled in free version. If you need this functionality, you need to buy the commercial version.</strong></p></div>
<table width="80%">
  <tbody>
                <tr>   
<td width="50%" style="font-size:14px; font-weight:bold"><a href="http://web-dorado.com/spider-catalog-guide-step-1.html" target="_blank" style="color:blue; text-decoration:none;">User Manual</a><br>
This section allows you to configure the Style options. <a href="http://web-dorado.com/4-catalog-options/spider-catalog-guide-step-4-2.html" target="_blank" style="color:blue; text-decoration:none;">More...</a><br>
If you want to customize the style options of your website,than you need to buy a license</td>   
<td colspan="7" align="right" style="font-size:16px;">
  <a href="http://www.web-dorado.com/files/fromSpiderCatalogJoomla.php" target="_blank" style="color:red; text-decoration:none;">
<img src="components/com_spidercatalog/images/header.png" border="0" alt="http://web-dorado.com/files/fromSpiderCatalogJoomla.php" width="215"><br>
Get the full version&nbsp;&nbsp;&nbsp;&nbsp;
</a>
  </td>
        </tr>


  </tbody></table>
  <img src="components/com_spidercatalog/images/styles.png">

</fieldset>
</form>

<?php
      }
   
   

function media_manager_image(){
	?>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>


<script type="text/javascript">

function set_value()
{
	var image= document.getElementById('image').value;
	if(image=="") 
	{
		alert('Image is empty'); 
		return;
	}
	if(<?php echo JRequest::getVar('sel_img'); ?> == -1)
	{
	window.parent.document.getElementById('sel_img_0').value=image;

	window.parent.document.getElementById('sel_img_0').onchange();
	}
	else
	{
	window.parent.document.getElementById('sel_img_<?php echo JRequest::getVar('sel_img'); ?>').value=image;

	window.parent.document.getElementById('sel_img_<?php echo JRequest::getVar('sel_img'); ?>').onchange();
}

	window.parent.document.getElementById('apply_cat').click();
	
	window.parent.document.getElementById('sbox-btn-close').click();


	window.parent.document.getElementById('imagebox').style.display="block";
	window.parent.document.getElementById('<?php echo JRequest::getVar('type'); ?>').value=image;
	window.parent.SqueezeBox.close();

}

function set_selected_image(path)
{
	document.getElementById('image').value=path.replace(/\\/g,'/').replace(/\/\//g,'/');

}
</script>
<style>
button   { padding: 3px; border: 1px solid #CCCCCC; color: #0B55C4; background-color: white; }
</style>
<?php   $folder=JRequest::getVar('folder','');
  
  
  $dir = '../media/com_spidercatalog/upload/'.$folder;
  $dir2 = 'media/com_spidercatalog/upload/'.$folder;
  
function delfiles($del_file)
{	
	if(is_dir($del_file))
		{
		$del_folder = scandir($del_file);
		foreach($del_folder as $file)
			if($file!='.' and $file!='..')
				delfiles($del_file.'/'.$file);
			
		rmdir($del_file);
		}
	else
	print_r($del_file);
		unlink($del_file);
		
}
  
if(JRequest::getVar('del_file','')!='')
delfiles(JRequest::getVar('del_file'));

  
if(JRequest::getVar('foldername','')!='')
mkdir($dir.'/'.JRequest::getVar('foldername'));

$files = JRequest::getVar('file', null, 'files', 'array');
$allowedExtensions = array("jpg","png","gif"); 

if (isset($files["type"]))
  {
  if ($files["error"] > 0)
	{
	echo '<span style="color:red;">Error Code: <b>' . $files["error"] . '</b></span><br />';
	}
  else
	{

	if (file_exists($dir.'/'. $files["name"]))
	  {
	  echo '<span style="color:red;"><b>'.$files["name"] . '</b> already exists.</span><br />';
	  }
	else
		{
			$extension= end(explode(".", strtolower($files['name'])));
			if (!in_array($extension,$allowedExtensions))
			{
			  echo '<span style="color:red;"><b>'.$files["name"].'</b> invalid file format</span><br />';
			}
			else
			  {
			  move_uploaded_file($files["tmp_name"],
			  $dir.'/'. $files["name"]);
			  echo "<span style='color:blue;'>Stored in: <b>" . $folder.'/'. $files["name"].'</b></span><br />';
			  }
		}
	}
  }
  else
  {
  echo 'Allowed file extensions - jpg, png, gif';
  }
  
  
 
echo "<br />Directory: <b>".$folder.'/</b><div style="float: right">';
?>
			<button id="insertimagei" type="button" onclick="set_value();">Insert</button>
		<?php	
	echo		'<button type="button" onclick="window.parent.SqueezeBox.close();">Cancel</button>
		</div>';


echo "<br /><br />";
  
$files1 = scandir($dir);
$nofiles=true;
?>
<hr />
<table cellpadding="5" cellspacing="0" border="1" width="500">
<tr><td>Name</td><td>Size</td><td>Delete</td></tr>
<?php
if($folder!='')
echo '<tr><td colspan="3"><a href="index.php?option=com_spidercatalog&task=media_manager_image&type='.JRequest::getVar('type').'&tmpl=component&sel_img='.JRequest::getVar('sel_img').'&folder='.substr($folder,0,strrpos($folder,'/')).'" title="Directory Up" style="text-decoration:none; margin:5px;"><button type="button" onclick=""><img src="components/com_spidercatalog/images/arrow_up.png" alt="" />Folder Up</button></a></td></tr>';

foreach($files1 as $file)
if($file!='.' and $file!='..' and is_dir($dir.'/'.$file))
{
	echo '<tr><td><a href="index.php?option=com_spidercatalog&task=media_manager_image&type='.JRequest::getVar('type').'&tmpl=component&sel_img='.JRequest::getVar('sel_img').'&folder='.$folder.'/'.$file.'" style="color:#333399"><img src="components/com_spidercatalog/images/folder_sm.png" alt="" />&nbsp;'. $file .'</a></td><td>&nbsp;</td><td><a  style="color:#333399" href="javascript:if(confirm(\'Are you sure you want to delete the directory and all its contents?\'))document.forms.delfileform.del_file.value=\''.addslashes($dir.'/'.$file).'\';document.forms.delfileform.submit();">Delete</a></td></tr>';
	$nofiles=false;
}

foreach($files1 as $file)
if(!(is_dir($dir.'/'.$file)))
if (in_array(end(explode(".", strtolower($file))),$allowedExtensions))
{
	echo '<tr><td><a href="javascript:set_selected_image(\''.addslashes($dir2.'/'.$file).'\')" style="color:#333399">'. $file .'</a></td><td>'.round(filesize($dir.'/'.$file)/1024).' Kb </td><td><a style="color:#333399" href="javascript:if(confirm(\'Are you sure you want to delete?\'))
	document.forms.delfileform.del_file.value=\''.addslashes($dir.'/'.$file).'\';document.forms.delfileform.submit();">Delete</a></td></tr>';
	$nofiles=false;
}

if($nofiles)
echo '<tr><td colspan="3">No Files</td></tr>';

  ?>
  </table>
  <br />
  <table cellpadding="5" cellspacing="0" border="1" width="500">
<tr><td>Create a New Folder</td></tr>
	<tr><td>
	<form action="index.php?option=com_spidercatalog&task=media_manager_image&type=<?php echo JRequest::getVar('type'); ?>&tmpl=component&sel_img=<?php echo JRequest::getVar('sel_img'); ?>&folder=<?php echo $folder; ?>" method="post" style="margin:5px;">
			<label for="file">Folder Name</label>
			<input type="text" name="foldername" id="foldername" /> 
			<input type="submit" name="submit" value="Create" />
	</form>
	</td></tr>
  </table>
  
  <br />
  <table cellpadding="5" cellspacing="0" border="1" width="500">
<tr><td>Upload a File</td></tr>
	<tr><td>
	<form action="index.php?option=com_spidercatalog
	&task=media_manager_image&type=<?php echo JRequest::getVar('type'); ?>&tmpl=component&sel_img=<?php echo JRequest::getVar('sel_img'); ?>&folder=<?php echo $folder ?>" method="post"	enctype="multipart/form-data" style="margin:5px;">
			<label for="file">Select a file:</label>
			<input type="file" name="file" id="file" /> 
			<input type="submit" name="submit" value="Upload" />
		</form>
	</td></tr>
  </table>
		
		<br /><br />
  <label for="file">Image URL:</label>
			<input type="text" name="image" id="image" size="50" /> 
  <br /><br /><br />
  
		
 
 <form action="index.php?option=com_spidercatalog&task=media_manager_image&type=<?php echo JRequest::getVar('type'); ?>&tmpl=component&sel_img=<?php echo JRequest::getVar('sel_img'); ?>&folder=<?php echo $folder ?>" method="post" name="delfileform">
			<input type="hidden" name="del_file" /> 
		</form>
 
 
	<?php
}



   
  }
?>