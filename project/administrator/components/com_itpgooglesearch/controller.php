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

jimport('joomla.application.component.controller');

/**
 * Control Panel Controller
 *
 * @package     ITPGoogleSearch
 * @subpackage  Components
  */
class ITPGoogleSearchController extends JControllerLegacy {
    
    public function display($cachable = false, $urlparams = array()) {

        $app = JFactory::getApplication();
        /** @var $app JApplicationAdministrator */
        
        $viewName      = $app->input->getCmd('view', 'cpanel');
        $app->input->set("view", $viewName);

        parent::display();
        return $this;
    }

}
