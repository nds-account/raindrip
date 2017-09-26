<?php
/**
 * ------------------------------------------------------------------------
 * JU Backend Toolkit for Joomla 2.5/3.x
 * ------------------------------------------------------------------------
 * Copyright (C) 2010-2013 JoomUltra. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: JoomUltra Co., Ltd
 * Websites: http://www.joomultra.com
 * ------------------------------------------------------------------------
 */

// no direct access
defined('_JEXEC') or die ;
require_once dirname(__FILE__). '/juelementhelper.php';
jimport('joomla.form.formfield');

class JFormFieldJUTabsTheme extends JFormField {
		
	public $type = 'JUTabsTheme';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput() {
		$layouts_in_template_ori = $layouts_in_template_ext = $layouts_in_module_ori = $merged_layouts = array();
		
        $template = JUElementHelper::getActiveTemplate();
		
		$themes = array();
		
		//Get all themes in module
		$theme_path = JPATH_SITE . DS . 'plugins' . DS . 'system' . DS . 'jutabs' . DS . 'tabs' . DS . 'themes';
		$folders = glob($theme_path.DS.'*', GLOB_ONLYDIR);
		if(count($folders)) {
			foreach ($folders AS $key=>$folder){
				$theme =  basename($folder);
				$themes[$theme] = $theme;
			}
		}
		
		//Get all themes in template, themes in template has higher priority, so it will overwrite theme in module if they have the same folder name
        $theme_path = JPATH_SITE . DS . 'templates' . DS . $template . DS . 'html' . DS . 'plg_jutabs' . DS . 'themes';
		$folders = glob($theme_path.DS.'*', GLOB_ONLYDIR);
		if(count($folders)) {
			foreach ($folders AS $key=>$folder){
				$theme =  basename($folder);
				$themes[$theme] = $theme ." [".JText::_("Template")."]";
			}
		}
		
		//Sort themes by alphabet
		asort($themes);
				
		$html = JHTML::_('select.genericlist', $themes, $this->name, 'class="'.$this->element['class'].'"', 'id', 'title', $this->value, $this->id);
		return $html;
	}

}
?>