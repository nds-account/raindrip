<?php
 /**
 * ------------------------------------------------------------------------
 * JU Slideshow Module for Joomla 2.5/3.x
 * ------------------------------------------------------------------------
 * Copyright (C) 2010-2013 JoomUltra. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: JoomUltra Co., Ltd
 * Websites: http://www.joomultra.com
 * ------------------------------------------------------------------------
 */

defined('_JEXEC') or die;

class ModJUTabsHelper
{
	public $params;
	
	function __construct($params){
		$this->params = $params;
	}
	
	function generateTabCode(){
		$tabparams = array();
		
		//Tab name
		$tabparams['name'] = $this->params->get('tabname', '');

		//Load content
		$loadcontent_type = $this->params->get('loadcontent_type', '');
		if($loadcontent_type != 'custom' && $this->params->get('loadcontent_value', '') != '') {
			$tabparams['loadcontent'] = $loadcontent_type.":".$this->params->get('loadcontent_value', '');
		}

		$tab_type = $this->params->get('type', '');
		
		//Basic settings
		$tabparams['theme'] 		= $this->params->get('theme', '');
		$tabparams['width'] 		= $this->params->get('width', '');
		$tabparams['minwidth'] 		= $this->params->get('minwidth', '');
		$tabparams['maxwidth'] 		= $this->params->get('maxwidth', '');
		$tabparams['height'] 		= $this->params->get('height', '');
		//Only use widthtabs for Tab left/right
		if($tab_type == 'accordion' || $tab_type == 'slideshow' || ($tab_type == 'tab' && ($this->params->get('position', '') == 'top' || $this->params->get('position', '') == 'bottom'))) {
			$this->params->set('widthtabs', '');
		}
		$tabparams['widthtabs'] 	= $this->params->get('widthtabs', '');
		//Don't use heighttabs for Tab left/right
		if($tab_type == 'tab' && ($this->params->get('position', '') == 'left' || $this->params->get('position', '') == 'right')) {
			$this->params->set('heighttabs', '');
		}
		$tabparams['heighttabs'] 	= $this->params->get('heighttabs', '');
		$tabparams['defaultitem'] 	= $this->params->get('defaultitem', '');
		$tabparams['maxitems'] 		= $this->params->get('maxitems', '');
		$tabparams['skipemptyitems']= $this->params->get('skipemptyitems', '');
		$tabparams['history'] 		= $this->params->get('history', '');
		$tabparams['changetab'] 	= $this->params->get('changetab', '');
		$tabparams['initialeffect'] = $this->params->get('initialeffect', '');
		$tabparams['ajax'] 			= $this->params->get('ajax', '');
		$tabparams['duration'] 		= $this->params->get('duration', '');

		//Tab effect
		if ($tab_type == 'accordion' || $tab_type == '') {
			$tabparams['accordioneffect'] = $this->params->get('accordioneffect', '');
		}
		if ($tab_type != 'accordion' || $tab_type == '') {
			$tabparams['tabeffect'] = $this->params->get('tabeffect', '');
		}
		
		$tabparams['currentitemeasing'] 	= $this->params->get('currentitemeasing', '');
		$tabparams['nextitemeasing'] 		= $this->params->get('nextitemeasing', '');
		$tabparams['swipetouch'] 			= $this->params->get('swipetouch', '');
		$tabparams['triggerwindowresize'] 	= $this->params->get('triggerwindowresize', '');
		$tabparams['tabclass'] 				= $this->params->get('tabclass', '');
		$tabparams['slidetotab'] 			= $this->params->get('slidetotab', '');
		$tabparams['view'] 					= $this->params->get('view', '');
		$tabparams['parseplugin'] 			= $this->params->get('parseplugin', '');
		$tabparams['type'] 					= $tab_type;
		$tabparams['password'] 				= $this->params->get('password', '');

		//Tab
		if($tab_type == "tab" || $tab_type == "") {
			$tabparams['position'] 			= $this->params->get('position', '');
			//Don't use tabalign/tabscroll for Tab left/right
			if($tabparams['position'] == 'left' || $tabparams['position'] == 'right') {
				$this->params->set('tabalign', '');
				$this->params->set('tabscroll', '');
			}
			$tabparams['tabalign'] 			= $this->params->get('tabalign', '');
			$tabparams['tabscroll'] 		= $this->params->get('tabscroll', '');
		}
		
		//Accordion
		if($tab_type == "accordion" || $tab_type == "") {
			$tabparams['accordionmode'] 	= $this->params->get('accordionmode', '');
			//Responsive only supported in horizontal accordion
			if($tabparams['accordionmode'] != 'horizontal') {
				$this->params->set('responsive', '');
			}
			$tabparams['responsive'] 		= $this->params->get('responsive', '');
			$tabparams['closetab'] 			= $this->params->get('closetab', '');
			//openmultitabs only supported in vertical accordion
			if($tabparams['accordionmode'] != 'vertical') {
				$this->params->set('openmultitabs', '');
			}
			$tabparams['openmultitabs'] 	= $this->params->get('openmultitabs', '');
		}
		
		//Slideshow
		if($tab_type == "slideshow" || $tab_type == "") {
			$tabparams['showtitle'] 		= $this->params->get('showtitle', '');
			$tabparams['nextprev'] 			= $this->params->get('nextprev', '');
			$tabparams['navigation'] 		= $this->params->get('navigation', '');
			
			if($tabparams['navigation'] != 'true') {
				$this->params->set('titleinnavigation', '');
			}
			$tabparams['titleinnavigation'] = $this->params->get('titleinnavigation', '');
			
			$tabparams['controlbuttons'] 	= $this->params->get('controlbuttons', '');
			$tabparams['autoplay'] 			= $this->params->get('autoplay', '');
			
			if($tabparams['autoplay'] != 'true') {
				$this->params->set('intervaltime', '');
				$this->params->set('autopause', '');
			}
			$tabparams['intervaltime'] 		= $this->params->get('intervaltime', '');
			$tabparams['autopause'] 		= $this->params->get('autopause', '');
			
			$tabparams['clickable'] 		= $this->params->get('clickable', '');
			$tabparams['rotate'] 			= $this->params->get('rotate', '');
		}

		//Tab params
		foreach($tabparams AS $param=>$value) {
			if(trim($value) != '') {
				$tabparams_arr[] = $param . '="'.$value.'"';
			}
		}
		$tabparams_str = implode(" ", $tabparams_arr);

		//Subtab content
		if ($loadcontent_type == 'custom') {
			$sub_tabs = $this->params->get('sub_tabs', '');
		} else {
			$sub_tabs = "";
		}

		//Complete JU Tabs code
		$tab_code  = "{jutabs " . $tabparams_str . "}";
		$tab_code .= trim($sub_tabs) != "" ? "\n".$sub_tabs."\n" : "";
		$tab_code .= "{/jutabs}";
		
		//Parse content plugin in module, it will help to load js/css of module if use {loadposition ...} or use addScript/addStylesheet command in content plugin
		$tab_code = JHtml::_('content.prepare', $tab_code);
		
		//Return tab code, plugin will parse it
		return $tab_code;
	}
}
?>