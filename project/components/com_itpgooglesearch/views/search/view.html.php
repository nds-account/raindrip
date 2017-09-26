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

jimport('joomla.application.component.view');

class ITPGoogleSearchViewSearch extends JViewLegacy {

    /**
     * @var JRegistry
     */
    protected $state;

    /**
     * @var JRegistry
     */
    protected $params;

    protected $phrase = "";

    public function display($tpl = null) {
        
        $app = JFactory::getApplication();
        /** @var $app JApplicationSite **/
        
        $state          = $this->get('State');
        $this->params   = $state->get("params");

        $this->phrase   = $app->getUserStateFromRequest("com_itpgooglesearch.query", "gsquery");

        parent::display($tpl);
        
    }
}
