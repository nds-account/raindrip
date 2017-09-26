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

class ItpGoogleSearchViewCpanel extends JViewLegacy {

    /**
     * @var JDocumentHtml
     */
    public $document;

    protected $version;

    public function display($tpl = null){
        
        $this->version = new ItpGoogleSearchVersion();
        
        $this->addToolbar();
        parent::display($tpl);
    }
    
    /**
     * Add the page title and toolbar.
     *
     * @since   1.6
     */
    protected function addToolbar(){
        
        JToolBarHelper::title(JText::_("COM_ITPGOOGLESEARCH_CPANEL_TITLE"));
        
        JToolBarHelper::preferences('com_itpgooglesearch');
    }

	/**
	 * Method to set up the document properties
	 * @return void
	 */
	protected function setDocument() {
	    $this->document->setTitle(JText::_('COM_ITPGOOGLESEARCH_CPANEL_TITLE'));
	}
	
}