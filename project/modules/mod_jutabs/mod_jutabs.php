<?php
/**
 * ------------------------------------------------------------------------
 * JU Tabs module for Joomla 2.5
 * ------------------------------------------------------------------------
 * Copyright (C) 2010-2012 JoomUltra. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: JoomUltra Co., Ltd
 * Websites: http://www.joomultra.com
 * ------------------------------------------------------------------------
 */

// no direct access
defined('_JEXEC') or die;

require_once dirname(__FILE__).'/helper.php';

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$document = JFactory::getDocument();

//Load main module styles
$document->addStyleSheet(JURI::base(true) . "/modules/" . $module->module . "/assets/css/style.css");

//Load Google fonts
$googlefonts = $params->get('googlefonts','');
$googlefont_arr = explode("\n", $googlefonts);
if(count($googlefont_arr)) {
	foreach($googlefont_arr AS $googlefont) {
		$googlefont = str_replace(' ', '+', trim($googlefont));
		if($googlefont) {
			JHTML::stylesheet('http://fonts.googleapis.com/css?family=' . $googlefont);
		}
	}
}

require JModuleHelper::getLayoutPath($module->module, $params->get('layout', 'default'));
?>
