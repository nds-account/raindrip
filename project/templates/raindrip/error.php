<?php

/**
 * @package     Joomla.Site
 * @subpackage  Template.system
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

if (($this->error->getCode()) == '404') {
    //header('Location: /index.php?option=com_content&view=article&id=92');
    header("HTTP/1.0 404 Not Found");
    echo file_get_contents(JURI::root() . '/index.php?option=com_content&view=article&id=92');
    exit;
}
?>
