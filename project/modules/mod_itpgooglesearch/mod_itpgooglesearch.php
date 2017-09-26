<?php
/**
 * @package      ITPGoogleSearch
 * @subpackage   Modules
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2014 Todor Iliev <todor.iliev@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_QUOTES, "utf-8");

$app = JFactory::getApplication();
/** @var $app JApplicationSite */

$phrase = htmlentities($app->getUserStateFromRequest("com_itpgooglesearch.query", "gsquery"), ENT_QUOTES, "UTF-8");

require JModuleHelper::getLayoutPath('mod_itpgooglesearch', $params->get('layout', 'default'));