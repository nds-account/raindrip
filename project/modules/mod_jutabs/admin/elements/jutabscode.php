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

defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.form.formfield');
require_once dirname(dirname(dirname(__FILE__))).'/helper.php';

class JFormFieldJUTabsCode extends JFormField {
    protected $type = 'JUTabsCode';
	
	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 * @since	1.6
	 */
	protected function getLabel() {
		return '<div id="'.$this->id.'" style="display: none;"></div>';
	}
	
	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
    protected function getInput() {
		$params = new JRegistry($this->form->getValue('params'));
		
		$ModJUTabsHelper = new ModJUTabsHelper($params);

		$tabcode = $ModJUTabsHelper->generateTabCode();
		
		$html = "";
		$html .= '<textarea name="'.$this->name.'" rows="'.$this->element['rows'].'" cols="'.$this->element['cols'].'" class="jutabscode '.$this->element['class'].'">';
		$html .= $tabcode;
		$html .= '</textarea>';
		
		return $html;
    }
}