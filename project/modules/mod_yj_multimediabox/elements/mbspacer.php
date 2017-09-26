<?php
/*======================================================================*\
|| #################################################################### ||
|| # Package - Joomla Template based on YJSimpleGrid Framework          ||
|| # Copyright (C) 2010  Youjoomla.com. All Rights Reserved.            ||
|| # Authors - Dragan Todorovic and Constantin Boiangiu                 ||
|| # license - PHP files are licensed under  GNU/GPL V2                 ||
|| # license - CSS  - JS - IMAGE files  are Copyrighted material        ||
|| # bound by Proprietary License of Youjoomla.com                      ||
|| # for more information visit http://www.youjoomla.com/license.html   ||
|| # Redistribution and  modification of this software                  ||
|| # is bounded by its licenses                                         ||
|| # websites - http://www.youjoomla.com | http://www.yjsimplegrid.com  ||
|| #################################################################### ||
\*======================================================================*/

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Renders a text element
 *
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */
$document =JFactory::getDocument();	
$document->addCustomTag('
	
	<style type="text/css">
	div.mbox_spacer{
		font-size:18px;
		font-weight:bold;
		margin:15px 0 15px 0;
		color:#146295;
	}
	</style>
	
');
class JFormFieldmbspacer extends JFormField
{
	
	
	public $type = 'mbspacer'; 

	public function getInput(){
		// Output		
		return '
		
		<div class="mbox_spacer">
			'.JText::_($this->value).'
		</div>';
	}

	public function getLabel() {
		return false;
	}
}

?>