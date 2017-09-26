<?php
/**
 * ------------------------------------------------------------------------
 * JU Tabs module for Joomla 2.5
 * ------------------------------------------------------------------------
 * Copyright (C) 2010-2013 JoomUltra. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: JoomUltra Co., Ltd
 * Websites: http://www.joomultra.com
 * ------------------------------------------------------------------------
 */

// no direct access
defined('_JEXEC') or die;

$ModJUTabsHelper = new ModJUTabsHelper($params);

$tabcode = $ModJUTabsHelper->generateTabCode();

if(trim($params->get('introtext', '')) != '') {
	echo '<div class="ju-tabs-introtext">'.$params->get('introtext', '').'</div>';
}

echo $tabcode;

if(trim($params->get('posttext', '')) != '') {
	echo '<div class="ju-tabs-posttext">'.$params->get('posttext', '').'</div>';
}
?>