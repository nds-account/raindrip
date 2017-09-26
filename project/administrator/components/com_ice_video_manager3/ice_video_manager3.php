<?php
/**
 * @version     1.0.0
 * @package     com_ice_video_manager3
 * @copyright   Copyright (C) 2014 SDS International. All rights reserved worldwide.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      SDS International <info@sdsinternational.com> - http://www.sdsinternational.com
 */


// no direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_ice_video_manager3')) 
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

$controller	= JControllerLegacy::getInstance('Ice_video_manager3');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
