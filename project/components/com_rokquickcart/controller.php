<?php
/**
 * @version   $Id: controller.php 6852 2013-01-28 18:51:50Z btowles $
 * @author    RocketTheme, LLC http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2013 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
// Check to ensure this file is included in Joomla!

// No direct access
defined('_JEXEC') or die;
include_once(JPATH_COMPONENT_ADMINISTRATOR . '/helpers/legacy_class.php');
jimport('joomla.application.component.controller');

/**
 * RokQuickCart Component Controller
 *
 * @package        RokQuickCart
 * @subpackage     com_rokquickcart
 * @since          1.5
 */
class RokQuickCartController extends RokQuickCartLegacyJController
{
	/**
	 * Method to display a view.
	 *
	 * @param    boolean            If true, the view output will be cached
	 * @param    array              An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return    JController        This object to support chaining.
	 * @since    1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$cachable = true;

		// Set the default view name and format from the Request.
		$vName = JFactory::getApplication()->input->get('view', 'rokquickcart');
		JFactory::getApplication()->input->set('view', $vName);


		$safeurlparams = array(
			'catid'            => 'INT',
			'id'               => 'INT',
			'cid'              => 'ARRAY',
			'year'             => 'INT',
			'month'            => 'INT',
			'limit'            => 'INT',
			'limitstart'       => 'INT',
			'showall'          => 'INT',
			'return'           => 'BASE64',
			'filter'           => 'STRING',
			'filter_order'     => 'CMD',
			'filter_order_Dir' => 'CMD',
			'filter-search'    => 'STRING',
			'print'            => 'BOOLEAN',
			'lang'             => 'CMD'
		);

		parent::display($cachable, $safeurlparams);

		return $this;
	}
}
