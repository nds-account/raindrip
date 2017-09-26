<?php
/**
 * @package      ITPGoogleSearch
 * @subpackage   Components
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2014 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

if(!defined("ITPGOOGLESEARCH_COMPONENT_ADMINISTRATOR")) {
    define("ITPGOOGLESEARCH_COMPONENT_ADMINISTRATOR", JPATH_ADMINISTRATOR .DIRECTORY_SEPARATOR. "components" .DIRECTORY_SEPARATOR. "com_itpgooglesearch");
}

// Register Component libraries
JLoader::register("ItpGoogleSearchVersion", ITPGOOGLESEARCH_COMPONENT_ADMINISTRATOR .DIRECTORY_SEPARATOR. "libraries" .DIRECTORY_SEPARATOR. "version.php");
