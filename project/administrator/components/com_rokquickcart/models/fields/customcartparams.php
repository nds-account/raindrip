<?php
/**
 * @version   $Id: customcartparams.php 6852 2013-01-28 18:51:50Z btowles $
 * @author    RocketTheme, LLC http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2013 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

// Check to ensure this file is within the rest of the framework
defined('_JEXEC') or die('Restricted access');
jimport('joomla.html.html');
jimport('joomla.form.formfield');

/**
 * Renders a file list from a directory in the current templates directory
 */

/**
 * @package     RocketTheme
 * @subpackage  rokquickcart.libs.elements
 */
class JFormFieldCustomCartParams extends JFormField
{

	/**
	 * Element name
	 *
	 * @access    protected
	 * @var        string
	 */
	var $_name = 'CustomCartParams';

	function getInput()
	{
		$doc  = JFactory::getDocument();
		$name = $this->element['name'];

		$html = '<button id="add_more-' . $name . '">Add</button><div class="clr"></div>' . '<div id="div-' . $name . '">';
		if (!empty($this->value) && is_array($this->value)) {
			foreach ($this->value as $valid => $valdata) {
				$html .= '<div id="' . $this->id . '_' . $valid . '" class="roknavmenu-extendedlink" style="margin: 5px 0pt;">' . '<input type="text" name="' . $this->name . '[' . $valid . ']" value="' . $valdata . '" size="22" />' . '<div class="clr"></div>' . '</div>';
			}
		}
		$html .= '</div>';

		$plugin_js_path = JURI::root(true) . '/administrator/components/com_rokquickcart/libs/js';
		$doc->addScript($plugin_js_path . "/dynamic-params.js");
		$doc->addScriptDeclaration("window.addEvent('domready', function() { new dynamicParams({ addButton: 'add_more-" . $name . "', moreField: 'div-" . $name . "', basename: '" . $name . "', params: 'jform[params]', paramsid: 'jform_params_', fields: 1})});");
		return $html;
	}
}
