<?php
/*======================================================================*\
|| #################################################################### ||
|| # Multi Media Box - 3.0                                            # ||	
|| # Copyright ©2006-2011 Youjoomla.com. All Rights Reserved.         # ||
|| # ----------------     JOOMLA TEMPLATES CLUB      -----------      # ||
|| # ----------------       www.youjoomla.com	     -----------      # ||
|| # @license http://www.gnu.org/copyleft/gpl.html GNU/GPL            # ||
|| #################################################################### ||
\*======================================================================*/

/// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once (dirname(__FILE__).DIRECTORY_SEPARATOR.'helper.php');

$list = modMultimediaBoxHelper::getList($params);

if (!count($list)) {
	return;
}
$row = new stdClass();
$row->text = htmlspecialchars($params->get( 'code', '' ));
require(JModuleHelper::getLayoutPath('mod_yj_multimediabox'));
