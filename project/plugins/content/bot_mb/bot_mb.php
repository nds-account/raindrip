<?php
/*======================================================================*\
|| #################################################################### ||
|| # Multi Media Box - 3.0                                            # ||	
|| # Copyright (C) 2010  Youjoomla.com. All Rights Reserved.            ||
|| # license - PHP files are licensed under  GNU/GPL V2                 ||
|| # license - CSS  - JS - IMAGE files  are Copyrighted material        ||
|| # bound by Proprietary License of Youjoomla.com                      ||
|| # for more information visit http://www.youjoomla.com/license.html   ||
|| # Redistribution and  modification of this software                  ||
|| # is bounded by its licenses                                         ||
|| # websites - http://www.youjoomla.com | http://www.yjsimplegrid.com  ||
|| #################################################################### ||
\*======================================================================*/
if( ! defined( '_JEXEC' ) ) {
	die( 'Direct Access to ' . basename( __FILE__ ) . ' is not allowed.' ) ;
}

jimport("joomla.application.application");
$app = JFactory::getApplication();
$app->registerEvent( 'onContentAfterDisplay', 'pop_box_media');
global $app;
$mosConfig_absolute_path	= JPATH_ROOT;
$mosConfig_live_site 		= JURI :: base();
function find_part($a,$s) {
	for ($i=0;$i<count($a);$i++) {
		if (substr_count($a[$i],$s)>0) {
			return($i);
		}
	}
	return(-1);
}

function pop_box_media($context,&$row, &$params) {
	global $app;

	if($app->isSite()){
		$mosConfig_absolute_path	= JPATH_ROOT;
		$mosConfig_live_site 		= JURI :: base();
		$database					= JFactory::getDBO();
		$plugin 					= JPluginHelper::getPlugin('content', 'bot_mb');
		
		// PARAMS
		$params_all = new JRegistry();
	
		if(intval(JVERSION) >= 3 ){	
			$params_all->loadString( $plugin->params  );
		}else{
			$params_all->loadJSON( $plugin->params  );
		}	  
		if($params_all->get('image_folder')){
			$image_folder= 'images/'.$params_all->get('image_folder');
		}else{
			$image_folder= 'images';
		}

		//get the text where to search for the plugin code
		$class_name="popbox";
		$regex = '/\{mbox:(.*?)}/i';
				
		$text_array = array();
		if(isset($row->text)){
			$text_array['text'] = $row->text;
		}
		if(isset($row->introtext)){		
			$text_array['introtext'] = $row->introtext;	
		}	
	
		if(!empty($text_array)){
			foreach($text_array as $text_type => $text_to_search){
				if(preg_match_all($regex,$text_to_search,$matches)){
					// load plugin script
					$document = JFactory::getDocument();
					
					if(intval(JVERSION) >= 3){
						JHtml::_('behavior.framework',true);
					}else{
						JHTML::_('behavior.mootools');
					}
					
					$document->addStyleSheet(JURI::base() . 'plugins/content/bot_mb/bot_mb/css/mediaboxAdv-'.$params_all->get('mbox_theme','Dark').'.css');
					//$document->addScript(JURI::base() . 'plugins/content/bot_mb/bot_mb/js/Quickie.js');	
					// $document->addScript(JURI::base() . 'plugins/content/bot_mb/bot_mb/js/yjmmbox.js');
					$document->addScript(JURI::base() . 'plugins/content/bot_mb/bot_mb/js/yjmmbox.min.js');
					
					$document->addScriptDeclaration("
					var plugin_path ='".JURI::base()."';
					var over_opacity = ".$params_all->get('over_opacity',0.7).";
					");
				}
		
				preg_match_all($regex,$text_to_search,$matches);
				for ($x=0; $x<count($matches[0]); $x++) {
		
					$parts = explode("|",$matches[1][$x]);
					$href=$parts[0];
				
					if (find_part($parts,"title=")!=-1) {
						$t=explode("title=",$parts[find_part($parts,"title=")]);
						$title=$t[1];
					} else {
						$title="Empty title";
					}
					
					if (find_part($parts,"group=")!=-1) {
						$t=explode("group=",$parts[find_part($parts,"group=")]);
						$group='['.$t[1].']';
						$groupv= ''.$t[1].' ';
					} else {
						$group='';
						$groupv='';
					}
					
					// ADD width 
					if (find_part($parts,"width=")!=-1) {
						$t=explode("width=",$parts[find_part($parts,"width=")]);
						$img_width=$t[1];
					} else {
						$img_width="";
					}
					
					// ADD height 
					if (find_part($parts,"height=")!=-1) {
						$t=explode("height=",$parts[find_part($parts,"height=")]);
						$img_height=$t[1];
					} else {
						$img_height="";
					}
					
					// ADD CAPTION 
					if (find_part($parts,"caption=")!=-1) {
						$t=explode("caption=",$parts[find_part($parts,"caption=")]);
						$caption=$t[1];
						$show_caption="<span class=\"bot_caption\" style=\"width:".$img_width."px;height:20px;\" >".$caption."</span>";
					} else {
						$caption="";
						$show_caption="";
					}
					
					// ADD THUMB 
					if (find_part($parts,"thumb=")!=-1) {
						$t=explode("thumb=",$parts[find_part($parts,"thumb=")]);
						$thumb=$t[1];
					} else {
						$thumb="".$href."";
					}
					
					if (find_part($parts,"txt=")!=-1) {
						$t=explode("txt=",$parts[find_part($parts,"txt=")]);
						$txt=$t[1];
					} else {
						$txt="Link";
					}
		
					// ADD THUMB FOR VIDEO
					if (find_part($parts,"vthumb=")!=-1) {
						$t=explode("vthumb=",$parts[find_part($parts,"vthumb=")]);
						$vthumb="<img class=\"bot_thumbv\" src=\"".$mosConfig_live_site."".$image_folder."/".$thumb."\"  style=\"width:".$img_width."px;height:".$img_height."px;\" alt=\"".$title."\"/>\n";
						$vclass_name="class=\"popboxv yjmboxes\"";
					} else {
						$vthumb="Missing Image";
					}
					
					if (find_part($parts,"vthumb=")!=-1) {
						$linkis=$vthumb;
					} else if (find_part($parts,"txt=")!=-1) {
						$linkis=$txt;
						$vclass_name="class=\"yjmboxes\"";
					} else {
						$linkis='';
					}
					
					// GET THE MBOX
					$fp=explode('.',$href);
					if (isset($fp[1])&&(($fp[1]=="jpg")||($fp[1]=="gif")||($fp[1]=="png")||($fp[1]=="jpeg") ||($fp[1]=="JPG"))) {
						$rel_data ='<span class="Mbox_reldata">lightbox'.$group.'</span><span class="Mbox_titles">'.$title.'</span>';
						$replace="<a href=\"".$mosConfig_live_site."".$image_folder."/".$href."\" title=\"".$title."\" class=\"".$class_name." yjmboxes\" >";
					
						if (find_part($parts,"thumbnone=")!=-1) {
							$t=explode("thumbnone=",$parts[find_part($parts,"thumbnone=")]);
							$replace.="";
							$show_caption="";
						} else {
							$replace.="<img class=\"bot_thumb\" src=\"".$mosConfig_live_site."".$image_folder."/".$thumb."\" style=\"width:".$img_width."px;height:".$img_height."px;\"  alt=\"".$title."\"/>\n";
						}
						$replace.="".$linkis."".$show_caption.$rel_data."</a>\n";
					} else {
					
						if (find_part($parts,"thumbnone=")!=-1) {
							$t=explode("thumbnone=",$parts[find_part($parts,"thumbnone=")]);
							$replace.="";
							$show_caption="";
						}
	
						$rel_data ='<span class="Mbox_reldata">lightbox['.$groupv.''.$parts[1].' '.$parts[2].']</span><span class="Mbox_titles">'.$title.'</span>';
						$replace="<a href=\"".$href."\" title=\"".$title."\"  ".$vclass_name.">".$linkis."".$show_caption.$rel_data."</a>\n";
					}
		
					$row->$text_type = str_replace($matches[0][$x],$replace,$row->$text_type);

				}
			}//end foreach
		}//emd if !empty
	}//end if site
}