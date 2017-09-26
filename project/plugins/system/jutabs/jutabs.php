<?php
/**
 * ------------------------------------------------------------------------
 * JU Tabs Plugin for Joomla 2.5, 3.x
 * ------------------------------------------------------------------------
 * Copyright (C) 2010-2014 JoomUltra. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: JoomUltra Co., Ltd
 * Website: http://www.joomultra.com
 * ------------------------------------------------------------------------
 */

// No direct access.
defined('_JEXEC') or die();

jimport('joomla.application.module.helper');

if (!defined('DS'))
{
	define('DS', DIRECTORY_SEPARATOR);
}

/**
 * JUTabs Plugin
 *
 * @package        Joomla
 * @subpackage     System
 * @since          2.5
 */
class plgSystemJUTabs extends JPlugin
{
	protected $_body = null;
	protected $_jutabs_open = "{";
	protected $_jutabs = "jutabs";
	protected $_jutabs_close = "}";
	protected $_jusubtab_open = "[";
	protected $_jusubtab = "tab";
	protected $_jusubtab_close = "]";
	protected $_jutabs_start_comment = "<!-- JUTABS START -->";
	protected $_jutabs_end_comment = "<!-- JUTABS END -->";

	/**
	 * Constructor
	 *
	 * @access      protected
	 *
	 * @param       object $subject The object to observe
	 * @param       array  $config  An array that holds the plugin configuration
	 *
	 * @since       1.5
	 */
	function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);
	}

	/*
	* Parse jutabs in content then return an array of all matched jutabs
	* If $capture_params_content == true => capture jutabs, all params and tab; else capture jutabs only
	*/
	protected function parseJUTabs($content, $tabopen, $tab, $tabclose, $capture_params_content = true)
	{
		//Escape tabopen/tabclose so regex_pattern will be true even with specical characters: '[', ']' ...
		$tabopen_escape  = "\\" . $tabopen;
		$tabclose_escape = "\\" . $tabclose;

		//Capture tab params and tab content ?
		if ($capture_params_content)
		{
			$capture_str = "";
		}
		else
		{
			$capture_str = "?:";
		}

		//#(?:\{jutabs(?:\s|&nbsp;)*?\}|\{jutabs(.*?(?:\"|'|&quot;|&\#039;|&apos;))(?:\s|&nbsp;)*?\})(.*?)\{\/jutabs\}#msi
		//#(?:\[tab(?:\s|&nbsp;)*?\]|\[tab(.*?(?:\"|'|&quot;|&\#039;|&apos;))(?:\s|&nbsp;)*?\])(.*?)\[\/tab\]#msi
		$regex_pattern = "#(?:" . $tabopen_escape . $tab . "(?:\s|&nbsp;)*?" . $tabclose_escape . "|" . $tabopen_escape . $tab . "(" . $capture_str . ".*?(?:\"|'|&quot;|&\#039;|&apos;))(?:\s|&nbsp;)*?" . $tabclose_escape . ")(" . $capture_str . ".*?)" . $tabopen_escape . "\/" . $tab . $tabclose_escape . "#msi";
		preg_match_all($regex_pattern, $content, $matches);

		return $matches;
	}

	/*
	* Return value of specified param from params string
	* Use for sub tab only
	*/
	protected function getParamValue($params_str, $keyword)
	{
		$params_str    = html_entity_decode($params_str, ENT_QUOTES, 'UTF-8');
		$regex_pattern = "#\s*" . $keyword . "\s*=\s*('([^']*)'|\"([^\"]*)\"|([^\s]*))#msi";
		preg_match_all($regex_pattern, $params_str, $matches);
		if (count($matches) >= 3)
		{
			$value = $matches[2][0] ? $matches[2][0] : ($matches[3][0] ? $matches[3][0] : $matches[4][0]);
		}

		return $value;
	}

	/*
	* Merge tab plugin params with tab code params
	* Return a JRegistry object
	*/
	protected function parseParams($jutabparams)
	{
		$jutabparams   = html_entity_decode($jutabparams, ENT_QUOTES, 'UTF-8');
		$regex_pattern = "#\s*([^=\s]+)\s*=\s*('([^']*)'|\"([^\"]*)\"|([^\s]*))#msi";
		preg_match_all($regex_pattern, $jutabparams, $matches);

		$paramarray = array();
		if (count($matches))
		{
			for ($i = 0; $i < count($matches[1]); $i++)
			{
				$key = $matches[1][$i];
				//Ignore "loadcontentsql" param, these params can not be overwrited
				if ($key == "loadcontentsql") continue;
				$val              = $matches[3][$i] ? $matches[3][$i] : ($matches[4][$i] ? $matches[4][$i] : $matches[5][$i]);
				$paramarray[$key] = $val;
			}
		}

		//Convert plugin params to array
		$plugin_params_arr = $this->params->toArray();

		//Unset "password" param of plugin, so we can compare it with "password" param of tab code
		unset($plugin_params_arr['password']);

		//Create new JRegistry with plugin params
		//We have to create new JRegistry instead use $this->params to avoid $this->params keep change when merge params from multi tab code
		$merged_params = new JRegistry($plugin_params_arr);

		//Overwrite jutabs plugin params by jutabs code params
		$merged_params->loadArray($paramarray);

		return $merged_params;
	}

	/*
	* Check if $query is SELECT query
	*/
	protected function is_ValidQuery($query)
	{
		$select_pos = strpos($query, "SELECT ");
		if ($select_pos === false || $select_pos > 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	/*
	* Return array of all tab items
	* $tabcontent_type: tab content type: moduleid/modulename/moduleposition/articleid/catid/k2itemid/content
	* $tabcontent_value: is ids of moduleid/modulename/moduleposition/articleid/catid/k2itemid
	* $subtabs_str: sub tabs string: [tab]...[/tab][tab]...[/tab]...
	* $_params: mergerd params of jutabs code params and jutabs plugin params
	* $jutabs_id: unique id of jutabs
	*/
	protected function generateJUTabsItems($tabcontent_type, $tabcontent_value, $subtabs_str, $_params, $jutabs_id)
	{
		$jutabs_id = "ju-tabs-" . $jutabs_id;

		//Remove all spaces if user enter it to get exactly values
		$tabcontent_value = trim($tabcontent_value);

		$ajax           = $_params->get('ajax', 'false');
		$maxitems       = $_params->get('maxitems', 0);
		$skipemptyitems = $_params->get('skipemptyitems', 'false');
		$class_param    = $_params->get('tabclass', '');
		$loadcontentsql = $_params->get('loadcontentsql', 0);
		$class          = array();

		if ($class_param != "")
		{
			$tabclass_arr = explode(",", $class_param);
			foreach ($tabclass_arr AS $class_str)
			{
				$class_arr                                  = explode(":", $class_str);
				$class[str_replace(" ", "", $class_arr[0])] = $class_arr[1];
			}
		}

		$tab_item  = array();
		$tab_items = array();
		//Depends on $tabcontent_type, $tabcontent_value will be proceeded in different way
		//If unknown content type => load content from sub_tabs
		switch (strtolower($tabcontent_type))
		{
			case "moduleid":
				$moduleid_array = explode(",", $tabcontent_value);
				$totalitems     = count($moduleid_array);

				if ($maxitems > 0 && $totalitems > $maxitems) $lastitem = $maxitems;
				else $lastitem = $totalitems;

				$i = 0;
				foreach ($moduleid_array AS $moduleid)
				{

					if ($maxitems > 0 && $i >= $maxitems) break;

					$i++;
					$tab_item = array();

					$tabtitle = self::getModuleTitleById($moduleid);
					if ($tabtitle != "")
					{
						$tab_item['title'] = self::getModuleTitleById($moduleid);
						if ($ajax == "true")
						{
							$tab_item['loadcontent'] = "moduleid:" . $moduleid;
							$tab_item['content']     = "";
						}
						else
						{
							$tab_item['loadcontent'] = $jutabs_id . "_" . $i;
							$tab_item['content']     = self::loadModuleById($moduleid);
							//Parse plugin
							if ($_params->get('parseplugin', 'true') == 'true')
							{
								$tab_item['content'] = JHtml::_('content.prepare', $tab_item['content']);
							}
						}

						if ($skipemptyitems == 'false' || !self::isEmptyTab($tab_item['content']) || $ajax == "true")
						{
							if ($i == 1)
							{
								$tab_item['class'] = "first " . $class[$i - 1];
							}
							elseif ($i == $lastitem)
							{
								$tab_item['class'] = "last " . $class[$i - 1];
							}
							else
							{
								if ($class[$i - 1] != "") $tab_item['class'] = $class[$i - 1];
								else $tab_item['class'] = "";
							}

							$tab_items[] = $tab_item;
						}
						else
						{
							$i--;
						}
					}
				}
				break;
			case "modulename":
				$modulename_array = explode(",", $tabcontent_value);
				$totalitems       = count($modulename_array);

				if ($maxitems > 0 && $totalitems > $maxitems) $lastitem = $maxitems;
				else $lastitem = $totalitems;

				$i = 0;
				foreach ($modulename_array AS $modulename)
				{

					if ($maxitems > 0 && $i >= $maxitems) break;

					$i++;
					$tab_item = array();

					$tabtitle = self::getModuleTitleByName($modulename);
					if ($tabtitle != "")
					{
						$tab_item['title'] = $tabtitle;
						if ($ajax == "true")
						{
							$tab_item['loadcontent'] = "modulename:" . $modulename;
							$tab_item['content']     = "";
						}
						else
						{
							$tab_item['loadcontent'] = $jutabs_id . "_" . $i;
							$tab_item['content']     = self::loadModuleByName($modulename);
							//Parse plugin
							if ($_params->get('parseplugin', 'true') == 'true')
							{
								$tab_item['content'] = JHtml::_('content.prepare', $tab_item['content']);
							}
						}

						if ($skipemptyitems == 'false' || !self::isEmptyTab($tab_item['content']) || $ajax == "true")
						{
							if ($i == 1)
							{
								$tab_item['class'] = "first " . $class[$i - 1];
							}
							elseif ($i == $lastitem)
							{
								$tab_item['class'] = "last " . $class[$i - 1];
							}
							else
							{
								if ($class[$i - 1] != "") $tab_item['class'] = $class[$i - 1];
								else $tab_item['class'] = "";
							}

							$tab_items[] = $tab_item;
						}
						else
						{
							$i--;
						}
					}
				}
				break;
			case "moduleposition":
				$moduleposition_array = explode(",", $tabcontent_value);

				$i = 0;
				foreach ($moduleposition_array AS $moduleposition)
				{

					if ($maxitems > 0 && $i >= $maxitems) break;

					$modules = self::loadModulesByPosition($moduleposition);
					foreach ($modules AS $module)
					{

						if ($maxitems > 0 && $i >= $maxitems) break;

						$i++;
						$tab_item = array();

						$tabtitle = $module['title'];
						if ($tabtitle != "")
						{
							$tab_item['title'] = $tabtitle;
							if ($ajax == "true")
							{
								$tab_item['loadcontent'] = "moduleid:" . $module['id'];
								$tab_item['content']     = "";
							}
							else
							{
								$tab_item['loadcontent'] = $jutabs_id . "_" . $i;
								$tab_item['content']     = $module['content'];
								//Parse plugin
								if ($_params->get('parseplugin', 'true') == 'true')
								{
									$tab_item['content'] = JHtml::_('content.prepare', $tab_item['content']);
								}
							}

							if ($skipemptyitems == 'false' || !self::isEmptyTab($tab_item['content']) || $ajax == "true")
							{
								if ($i == 1)
								{
									$tab_item['class'] = "first " . $class[$i - 1];
								}
								else
								{
									if ($class[$i - 1] != "") $tab_item['class'] = $class[$i - 1];
									else $tab_item['class'] = "";
								}

								$tab_items[] = $tab_item;
							}
							else
							{
								$i--;
							}
						}
					}
				}
				$tab_items[$i - 1]['class'] = "last " . $tab_items[$i - 1]['class'];
				break;
			case "articleid":
				$articleid_array = explode(",", $tabcontent_value);
				$totalitems      = count($articleid_array);
				$view            = $_params->get('view', 'introtext');

				if ($maxitems > 0 && $totalitems > $maxitems) $lastitem = $maxitems;
				else $lastitem = $totalitems;

				$i = 0;
				foreach ($articleid_array AS $articleid)
				{

					if ($maxitems > 0 && $i >= $maxitems) break;

					$i++;
					$tab_item = array();

					$tabtitle = self::getArticleTitle($articleid);
					if ($tabtitle != "")
					{
						$tab_item['title'] = $tabtitle;
						if ($ajax == "true")
						{
							$tab_item['loadcontent'] = "articleid:" . $articleid . "," . $view;
							$tab_item['content']     = "";
						}
						else
						{
							$tab_item['loadcontent'] = $jutabs_id . "_" . $i;
							$tab_item['content']     = self::loadArticle($articleid, $view);
							//Parse plugin
							if ($_params->get('parseplugin', 'true') == 'true')
							{
								$tab_item['content'] = JHtml::_('content.prepare', $tab_item['content']);
							}
						}

						if ($skipemptyitems == 'false' || !self::isEmptyTab($tab_item['content']) || $ajax == "true")
						{
							if ($i == 1)
							{
								$tab_item['class'] = "first " . $class[$i - 1];
							}
							elseif ($i == $lastitem)
							{
								$tab_item['class'] = "last " . $class[$i - 1];
							}
							else
							{
								if ($class[$i - 1] != "") $tab_item['class'] = $class[$i - 1];
								else $tab_item['class'] = "";
							}

							$tab_items[] = $tab_item;
						}
						else
						{
							$i--;
						}
					}
				}
				break;
			case "catid":
				$catid_array = explode(",", $tabcontent_value);
				$articles    = self::getArticlesByCatid($catid_array, $maxitems);
				$totalitems  = count($articles);
				$view        = $_params->get('view', 'introtext');

				if ($maxitems > 0 && $totalitems > $maxitems) $lastitem = $maxitems;
				else $lastitem = $totalitems;

				$i = 0;
				foreach ($articles AS $article)
				{

					if ($maxitems > 0 && $i >= $maxitems) break;

					$i++;
					$tab_item = array();

					$tabtitle = self::getArticleTitle($article->id);
					if ($tabtitle != "")
					{
						$tab_item['title'] = $tabtitle;
						if ($ajax == "true")
						{
							$tab_item['loadcontent'] = "articleid:" . $article->id . "," . $view;
							$tab_item['content']     = "";
						}
						else
						{
							$tab_item['loadcontent'] = $jutabs_id . "_" . $i;
							$tab_item['content']     = self::loadArticle($article->id, $view);
							//Parse plugin
							if ($_params->get('parseplugin', 'true') == 'true')
							{
								$tab_item['content'] = JHtml::_('content.prepare', $tab_item['content']);
							}
						}

						if ($skipemptyitems == 'false' || !self::isEmptyTab($tab_item['content']) || $ajax == "true")
						{
							if ($i == 1)
							{
								$tab_item['class'] = "first " . $class[$i - 1];
							}
							elseif ($i == $lastitem)
							{
								$tab_item['class'] = "last " . $class[$i - 1];
							}
							else
							{
								if ($class[$i - 1] != "") $tab_item['class'] = $class[$i - 1];
								else $tab_item['class'] = "";
							}

							$tab_items[] = $tab_item;
						}
						else
						{
							$i--;
						}
					}
				}
				break;
			case "k2itemid":
				$k2itemid_array = explode(",", $tabcontent_value);
				$totalitems     = count($k2itemid_array);
				$view           = $_params->get('view', 'introtext');

				if ($maxitems > 0 && $totalitems > $maxitems) $lastitem = $maxitems;
				else $lastitem = $totalitems;

				$i = 0;
				foreach ($k2itemid_array AS $k2itemid)
				{

					if ($maxitems > 0 && $i >= $maxitems) break;

					$i++;
					$tab_item = array();

					$tabtitle = self::getK2ItemTitle($k2itemid);
					if ($tabtitle != "")
					{
						$tab_item['title'] = $tabtitle;
						if ($ajax == "true")
						{
							$tab_item['loadcontent'] = "k2itemid:" . $k2itemid . "," . $view;
							$tab_item['content']     = "";
						}
						else
						{
							$tab_item['loadcontent'] = $jutabs_id . "_" . $i;
							$tab_item['content']     = self::loadK2Item($k2itemid, $view);
							//Parse plugin
							if ($_params->get('parseplugin', 'true') == 'true')
							{
								$tab_item['content'] = JHtml::_('content.prepare', $tab_item['content']);
							}
						}

						if ($skipemptyitems == 'false' || !self::isEmptyTab($tab_item['content']) || $ajax == "true")
						{
							if ($i == 1)
							{
								$tab_item['class'] = "first " . $class[$i - 1];
							}
							elseif ($i == $lastitem)
							{
								$tab_item['class'] = "last " . $class[$i - 1];
							}
							else
							{
								if ($class[$i - 1] != "") $tab_item['class'] = $class[$i - 1];
								else $tab_item['class'] = "";
							}

							$tab_items[] = $tab_item;
						}
						else
						{
							$i--;
						}
					}
				}
				break;
			case "k2catid":
				$k2catid_array = explode(",", $tabcontent_value);
				$k2items       = self::getK2itemsByCatid($k2catid_array, $maxitems);
				$totalitems    = count($k2items);
				$view          = $_params->get('view', 'introtext');

				if ($maxitems > 0 && $totalitems > $maxitems) $lastitem = $maxitems;
				else $lastitem = $totalitems;

				$i = 0;
				foreach ($k2items AS $k2item)
				{

					if ($maxitems > 0 && $i >= $maxitems) break;

					$i++;
					$tab_item = array();

					$tabtitle = self::getK2ItemTitle($k2item->id);
					if ($tabtitle != "")
					{
						$tab_item['title'] = $tabtitle;
						if ($ajax == "true")
						{
							$tab_item['loadcontent'] = "#k2itemid:" . $k2item->id . "," . $view;
							$tab_item['content']     = "";
						}
						else
						{
							$tab_item['loadcontent'] = "#" . $jutabs_id . "_" . $i;
							$tab_item['content']     = self::loadK2Item($k2item->id, $view);
							//Parse plugin
							if ($_params->get('parseplugin', 'true') == 'true')
							{
								$tab_item['content'] = JHtml::_('content.prepare', $tab_item['content']);
							}
						}

						if ($skipemptyitems == 'false' || !self::isEmptyTab($tab_item['content']) || $ajax == "true")
						{
							if ($i == 1)
							{
								$tab_item['class'] = "first " . $class[$i - 1];
							}
							elseif ($i == $lastitem)
							{
								$tab_item['class'] = "last " . $class[$i - 1];
							}
							else
							{
								if ($class[$i - 1] != "") $tab_item['class'] = $class[$i - 1];
								else $tab_item['class'] = "";
							}

							$tab_items[] = $tab_item;
						}
						else
						{
							$i--;
						}
					}
				}
				break;
			case "sql":
				$query = trim(html_entity_decode($tabcontent_value));

				//Only run if turn on Loadcontent SQL and is SELECT Query
				if (!$loadcontentsql || !self::is_ValidQuery($query)) break;

				//Load tab items from database
				$db = JFactory::getDbo();
				$db->setQuery($query);
				$items = $db->loadObjectList();

				$totalitems = count($items);

				if ($maxitems > 0 && $totalitems > $maxitems) $lastitem = $maxitems;
				else $lastitem = $totalitems;

				$i = 0;

				foreach ($items AS $item)
				{
					if ($maxitems > 0 && $i >= $maxitems) break;

					$i++;
					$tab_item = array();

					$tabtitle = $item->title;
					if ($tabtitle != "")
					{
						$tab_item['title'] = $tabtitle;

						$tab_item['loadcontent'] = "#" . $jutabs_id . "_" . $i;
						$tab_item['content']     = self::convertURL($item->content);
						//Parse plugin
						if ($_params->get('parseplugin', 'true') == 'true')
						{
							$tab_item['content'] = JHtml::_('content.prepare', $tab_item['content']);
						}

						if ($skipemptyitems == 'false' || !self::isEmptyTab($tab_item['content']) || $ajax == "true")
						{
							if ($i == 1)
							{
								$tab_item['class'] = "first " . $class[$i - 1];
							}
							elseif ($i == $lastitem)
							{
								$tab_item['class'] = "last " . $class[$i - 1];
							}
							else
							{
								if ($class[$i - 1] != "") $tab_item['class'] = $class[$i - 1];
								else $tab_item['class'] = "";
							}

							$tab_items[] = $tab_item;
						}
						else
						{
							$i--;
						}
					}
				}
				break;
			//Mixed content: load content depends on settings on each sub tab
			case "content":
			default:
				//Replace [tab title="..."  ]...</p> => [tab title="..."  ]<p>...</p> to make JU Tabs valid W3C
				$subtabopen_escape  = "\\" . $this->_jusubtab_open;
				$subtabclose_escape = "\\" . $this->_jusubtab_close;
				// /(\[tab(?:\s|&nbsp;)*?\]|\[tab.*?"(?:\s|&nbsp;)*?\])(.*?(?:\[\/tab\]|<\/p>))/
				$subtabs_str = preg_replace_callback("/(" . $subtabopen_escape . $this->_jusubtab . "(?:\s|&nbsp;)*?" . $subtabclose_escape . "|" . $subtabopen_escape . $this->_jusubtab . ".*?\"(?:\s|&nbsp;)*?" . $subtabclose_escape . ")(.*?(?:" . $subtabopen_escape . "\/" . $this->_jusubtab . "" . $subtabclose_escape . "|<\/p>))/", array($this, 'self::close_tag_after_subtab_callback'), $subtabs_str);

				//Explode [/tab] to get all subtabs
				$sub_tab_items = explode($this->_jusubtab_open . "/" . $this->_jusubtab . $this->_jusubtab_close, $subtabs_str, -1);
				$totalitems    = count($sub_tab_items);

				if ($maxitems > 0 && $totalitems > $maxitems) $lastitem = $maxitems;
				else $lastitem = $totalitems;

				$i = 0;
				foreach ($sub_tab_items AS $sub_tab_item)
				{

					if ($maxitems > 0 && $i >= $maxitems) break;

					$i++;
					$tab_item = array();
					//Add [/tab] to the end to return the right subtab code format
					$sub_tab_code = $sub_tab_item . $this->_jusubtab_open . "/" . $this->_jusubtab . $this->_jusubtab_close;

					$sub_tab_arr    = self::parseJUTabs($sub_tab_code, $this->_jusubtab_open, $this->_jusubtab, $this->_jusubtab_close, true);
					$sub_tab_params = $sub_tab_arr[1][0];
					//Replace class="..." or style="..." ... => class='...' or style='...' ... before parse tab param, so we can use title="<a class="myclass" style="mystyle" rel="rel...">"
					$pattern        = "#(class|style|rel|src|alt|href)=\"([^\"]*)\"#mis";
					$replacement    = "$1='$2'";
					$sub_tab_params = preg_replace($pattern, $replacement, $sub_tab_params);

					$tab_item['title'] = self::getParamValue($sub_tab_params, "title");

					$titleonly_param = self::getParamValue($sub_tab_params, "titleonly");

					$loadcontent_param = self::getParamValue($sub_tab_params, "loadcontent");

					$loadcontent_param_arr = explode(":", $loadcontent_param, 2);
					$contenttype           = $loadcontent_param_arr[0];
					$contentvalue          = $loadcontent_param_arr[1];

					//Only load tab title from DB or by manual, force load tab content manually in code
					if ($titleonly_param == "true")
					{
						$tab_item['loadcontent'] = "#" . $jutabs_id . "_" . $i;
						$tab_item['content']     = $sub_tab_arr[2][0];
						//Load tab content by Ajax
					}
					elseif ($ajax == "true")
					{
						//Ajax = true, but does not specify where to load content => return corresponding tab in sub_tab_arr, ajax will be disabled for this sub_tab
						if ($loadcontent_param == "")
						{
							$tab_item['loadcontent'] = "noajax:" . $i;
							$tab_item['content']     = $sub_tab_arr[2][0];
						}
						else
						{
							//Parse loadcontent="artilceid:15,introtext" for sub tab
							$contentvalue_arr = explode(",", $contentvalue);
							$view             = $contentvalue_arr[1];
							//Make sure we set view type for articleid/k2itemid
							if (($contenttype == "articleid" || $contenttype == "k2itemid") && $view == "")
							{
								$view              = $_params->get('view', 'introtext');
								$loadcontent_param = $loadcontent_param . "," . $view;
							}
							$tab_item['loadcontent'] = $loadcontent_param;
							$tab_item['content']     = "";
						}
						//Load tab content No Ajax, case by case
					}
					else
					{
						//Ajax = false, load content for each tab based on loadcontent param
						switch (strtolower($contenttype))
						{
							case "moduleid":
								$moduleid = (int) $contentvalue;
								if ($moduleid == 0)
								{
									$tab_item['content'] = "";
								}
								else
								{
									$tab_item['content'] = self::loadModuleById($moduleid);
								}
								break;
							case "modulename":
								$modulename = trim($contentvalue);
								if ($modulename == "")
								{
									$tab_item['content'] = "";
								}
								else
								{
									$tab_item['content'] = self::loadModuleByName($modulename);
								}
								break;
							case "articleid":
								$articleid = (int) $contentvalue;
								if (strpos($loadcontent_param, "introtext") !== false) $view = "introtext";
								elseif (strpos($loadcontent_param, "fulltext") !== false) $view = "fulltext";

								if ($articleid == 0)
								{
									$tab_item['content'] = "";
								}
								else
								{
									if ($view == "") $view = $_params->get('view', 'introtext');
									$tab_item['content'] = self::loadArticle($articleid, $view);
								}
								break;
							case "k2itemid":
								$k2itemid = (int) $contentvalue;
								if (strpos($loadcontent_param, "introtext") !== false) $view = "introtext";
								elseif (strpos($loadcontent_param, "fulltext") !== false) $view = "fulltext";

								if ($k2itemid == 0)
								{
									$tab_item['content'] = "";
								}
								else
								{
									if ($view == "") $view = $_params->get('view', 'introtext');
									$tab_item['content'] = self::loadK2Item($k2itemid, $view);
								}
								break;
							case "sql":
								$query = trim(html_entity_decode($contentvalue));

								//Only run if turn on Loadcontent SQL and is SELECT Query
								if (!$loadcontentsql || !self::is_ValidQuery($query)) break;

								//Load tab item from database
								$db = JFactory::getDbo();
								$db->setQuery($query);
								$object = $db->loadObject();

								if ($object)
								{
									$tab_item['content'] = $object->content;
								}
								break;
							case "url":
								//Load content from URL
								$url = trim($contentvalue);
								if ($url == "")
								{
									$tab_item['content'] = "";
								}
								else
								{
									$tab_item['content'] = self::loadUrl($url);
								}
								break;
							case "content":
							default:
								//Use sub_tab content
								$tab_item_content = $sub_tab_arr[2][0];

								//Remove unclosed empty p tag <p...> at the end of subtab if any
								$tab_item_content = preg_replace("/<p[^<]*?>$/", "", $tab_item_content);

								//Close tags for subtab content to make JU Tabs valid W3C
								$tab_item_content = self::closetags($tab_item_content);

								//Parse content plugin in tab content
								if ($_params->get('parseplugin', 'true') == 'true')
								{
									$tab_item_content = JHtml::_('content.prepare', $tab_item_content);
								}
								$tab_item['content'] = $tab_item_content;
								break;
						}

						//Set href="$tab_item['loadcontent']" for a tag
						$tab_item['loadcontent'] = $jutabs_id . "_" . $i;
					}

					//Auto get tab title if title param is empty
					if (!$tab_item['title'])
					{
						switch (strtolower($contenttype))
						{
							case "moduleid":
								$tab_item['title'] = self::getModuleTitleById((int) $contentvalue);
								break;
							case "modulename":
								$tab_item['title'] = self::getModuleTitleByName(trim($contentvalue));
								break;
							case "articleid":
								$tab_item['title'] = self::getArticleTitle((int) $contentvalue);
								break;
							case "k2itemid":
								$tab_item['title'] = self::getK2ItemTitle((int) $contentvalue);
								break;
							case "sql":
								$sql = trim($contentvalue);

								//Only run if turn on Loadcontent SQL and is SELECT Query
								if (!$loadcontentsql || !self::is_ValidQuery($sql)) break;

								$db = JFactory::getDbo();
								$db->setQuery($sql);
								$object = $db->loadObject();
								if ($object)
								{
									$tab_item['title'] = $object->title;
								}
								break;
							case "url":
							case "content":
							default:
								$tab_item['title'] = JText::_('No title');
								break;
						}
					}

					//Parse plugin, ignore url content type
					if ($_params->get('parseplugin', 'true') == 'true' && strtolower($contenttype) != 'url')
					{
						$tab_item['content'] = JHtml::_('content.prepare', $tab_item['content']);
					}

					if ($skipemptyitems == 'false' || !self::isEmptyTab($tab_item['content']) || $ajax == "true")
					{
						//Class for each sub tab
						if ($i == 1)
						{
							$tab_item['class'] = "first " . $class[$i - 1];
						}
						elseif ($i == $lastitem)
						{
							$tab_item['class'] = "last " . $class[$i - 1];
						}
						else
						{
							if ($class[$i - 1] != "") $tab_item['class'] = $class[$i - 1];
							else $tab_item['class'] = "";
						}

						//Include tab title in tab content
						//$tab_item['content'] = "<h3 class='ju-tabs-title-content'>" . $tab_item['title']."</h3>" . $tab_item['content'];
						$tab_items[] = $tab_item;
					}
					else
					{
						$i--;
					}
				}
				break;
		}

		return $tab_items;
	}

	//Callback function of preg_replace_callback to complete p tag
	protected function close_tag_after_subtab_callback($matches)
	{
		$subtab          = $matches[1];
		$content         = $matches[2];
		$subtabclose_pos = strpos($content, $this->_jusubtab_open . "/" . $this->_jusubtab . $this->_jusubtab_close);
		//If has NO [/tab] in content
		if ($subtabclose_pos === false)
		{
			$regex_pattern = "/<p[^<]*?>/";
			preg_match_all($regex_pattern, $content, $p_tag_open_matches);
			//If has <p> => Valid content, return itself
			if (count($p_tag_open_matches[0]))
			{
				return $subtab . $content;
			}
			//If has </p> but don't has open tag: <p> to the first
			else
			{
				if ($content == "</p>") $content = "";
				else $content = "<p>" . $content;

				return $subtab . $content;
			}
		}
		else
		{
			//If has [/tab] in content => closetags before [/tab]
			$content_before_subtabclose = substr($content, 0, $subtabclose_pos);
			$content_from_subtabclose   = substr($content, $subtabclose_pos);

			return $subtab . self::closetags($content_before_subtabclose) . $content_from_subtabclose;
		}
	}

	protected function isEmptyTab($content)
	{
		//Remove <br/>
		$content = preg_replace("#(?:<br\s*\/?>\s*)*#i", "", $content);
		//Remove empty <p> tags
		$content = preg_replace("#<p[^>]*><\/p[^>]*>#i", "", $content);
		//Remove <script>
		$content = preg_replace("#<script[^>]*>.*?</script>#i", "", $content);
		//Remove <link>
		$content = preg_replace("#<link[^>]*>.*?</link>#i", "", $content);
		//Trim
		$content = trim($content);
		if ($content == '')
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/*
	* Generate HTML for tabs from $jutabs_params and $tab_items
	* $jutabs_params: params of tab: param1="value1" param2="value2"...
	* $tab_items: an array of all tab item
	*/
	protected function generateJUTabsHtml($_params, $tab_items, $jutabs_id)
	{
		$theme             = $_params->get('theme', 'default');
		$type              = $_params->get('type', 'tab');
		$accordionmode     = $_params->get('accordionmode', 'vertical');
		$position          = $_params->get('position', 'top');
		$width             = $_params->get('width', '100%');
		$height            = $_params->get('height', 'auto');
		$widthtabs         = $_params->get('widthtabs', '150px');
		$heighttabs        = $_params->get('heighttabs', 'auto');
		$minwidth          = $_params->get('minwidth', '0');
		$maxwidth          = $_params->get('maxwidth', 'none');
		$ajax              = $_params->get('ajax', 'false');
		$showtitle         = $_params->get('showtitle', 'true');
		$nextprev          = $_params->get('nextprev', 'true');
		$navigation        = $_params->get('navigation', 'true');
		$titleinnavigation = $_params->get('titleinnavigation', 'false');
		$controlbuttons    = $_params->get('controlbuttons', 'true');
		$autoplay          = $_params->get('autoplay', 'false');

		if ($type == 'tab')
		{
			if ($position == 'top' || $position == 'bottom')
			{
				$widthtabs    = 'auto';
				$widthpanels  = 'auto';
				$heightpanels = 'auto';
			}
			elseif ($position == 'left' || $position == 'right')
			{
				$heighttabs   = 'auto';
				$widthpanels  = 'auto';
				$heightpanels = 'auto';
			}
		}
		//We must specify a value in px for horizontal accordion
		if ($type == 'accordion' && $accordionmode == 'horizontal' && ($height == '100%' || $height == 'auto'))
		{
			$height = '300px';
		}

		$tabclass_str = $_params->get('tabclass', '');
		if ($tabclass_str != "")
		{
			$tabclass_arr = explode(",", $tabclass_str);
			foreach ($tabclass_arr AS $class_str)
			{
				$class_arr                                  = explode(":", $class_str);
				$class[str_replace(" ", "", $class_arr[0])] = $class_arr[1];
			}
		}

		$tabscontainer_id = "ju-tabs-" . $jutabs_id;
		$tabtitle_id      = "ju-tabs-title-" . $jutabs_id;
		$tabcontent_id    = "ju-tabs-content-" . $jutabs_id;

		switch ($type)
		{
			//TAB
			case 'tab':
				$tab_content = array();
				if ($position == "top" || $position == "bottom")
				{
					$tab_align = " ju-tabs-align-" . $_params->get('tabalign', 'left');;
				}
				$tab_title = "<div class=\"ju-tabs-title-wrap ju-tabs-title-" . $position . $tab_align . "\" style=\"width:" . $widthtabs . "; height:" . $heighttabs . ";\">";
				if ($position == "top" || $position == "bottom")
				{
					$tab_title .= "<span class=\"tabscroll-prev\"></span>";
				}
				$tab_title .= "<ul class=\"ju-tabs-title " . $tabtitle_id . "\">";
				foreach ($tab_items AS $tab_item)
				{
					if ($tab_item['class'] != "")
					{
						$tab_class = " class=\"" . $tab_item['class'] . "\"";
					}
					else
					{
						$tab_class = "";
					}
					$tab_title .= "<li" . $tab_class . "><h3><span>" . $tab_item['title'] . "</span>";
					$tab_title .= "<span class=\"ju-tabs-arrow\"></span>";
					$tab_title .= "<a class=\"no-display\" href=\"#" . $tab_item['loadcontent'] . "\"></a>";
					$tab_title .= "</h3></li>";
				}
				$tab_title .= "</ul>";
				if ($position == "top" || $position == "bottom")
				{
					$tab_title .= "<span class=\"tabscroll-next\"></span>";
				}
				$tab_title .= "</div>";

				$tab_panels = "<div class=\"ju-tabs-panel ju-tabs-panel-" . $position . "\" style=\"width:" . $widthpanels . "; height: " . $heightpanels . ";\">";

				foreach ($tab_items AS $tab_item)
				{
					$tab_panels .= "<div class=\"ju-tabs-content " . $tabcontent_id . " " . $tab_item['class'] . "\"><div class=\"ju-tabs-subcontent\">" . $tab_item['content'] . "</div></div>";
				}
				$tab_panels .= "</div>";
				if ($position == "bottom") $html = $tab_panels . $tab_title;
				else $html = $tab_title . $tab_panels;
				break;
			//ACCORDION
			case 'accordion':
				if ($_params->get('accordionmode', 'vertical') == 'vertical')
				{
					$accordion_style = "ju-tabs-accordion-vertical";
				}
				else
				{
					$accordion_style = "ju-tabs-accordion-horizontal";
				}
				$heading_style = "style=\"height: " . $heighttabs . ";\"";

				$html = "<ul class=\"ju-tabs-accordion " . $accordion_style . " " . $tabtitle_id . "\">";
				foreach ($tab_items AS $tab_item)
				{
					if ($tab_item['class'] != "")
					{
						$tab_class = " class=\"jutabs-item " . $tab_item['class'] . "\"";
					}
					else
					{
						$tab_class = " class=\"jutabs-item\"";
					}
					$html .= "<li" . $tab_class . "><h3 class=\"ju-tabs-accordion-title\" " . $heading_style . " ><span>" . $tab_item['title'] . "</span>";
					$html .= "<span class=\"ju-tabs-accordion-arrow\"></span>";
					$html .= "<a class=\"no-display\" href=\"#" . $tab_item['loadcontent'] . "\"></a>";
					$html .= "</h3>";
					$html .= "<div class=\"ju-tabs-accordion-content " . $tabcontent_id . "\"><div class=\"ju-tabs-accordion-subcontent\">" . $tab_item['content'] . "</div></div></li>";
				}
				$html .= "</ul>";
				break;
			//SLIDESHOW
			case 'slideshow':
				//Navigation ([1], [2], [3]...)
				//Navigation must always be there, so js plugin can trigger it
				$navigation_style = ($navigation == "true") ? "" : " style=\"display: none;\"";
				$navigation_html  = "<div class=\"ju-tabs-slide-nav\"" . $navigation_style . "><div class=\"ju-tabs-slide-nav-inner " . $tabtitle_id . "\">";
				$i                = 1;
				foreach ($tab_items AS $tab_item)
				{
					if ($tab_item['class'] != "")
					{
						$tab_class = " class=\"" . $tab_item['class'] . "\"";
					}
					else
					{
						$tab_class = "";
					}

					if ($titleinnavigation == "true")
					{
						$navigation_html .= "<span" . $tab_class . ">" . $tab_item['title'] . "<a class=\"no-display\" href=\"#" . $tab_item['loadcontent'] . "\"></a></span>";
					}
					else
					{
						$navigation_html .= "<span" . $tab_class . ">" . $i . "<a class=\"no-display\" href=\"#" . $tab_item['loadcontent'] . "\"></a></span>";
					}
					$i++;
				}
				$navigation_html .= "</div></div>";

				//Slide panels
				$slide_panels_html = "<div class=\"ju-tabs-slide-panels\">";
				$slide_panels_html .= "<div class=\"ju-tabs-slide-content-wrapper\">";
				foreach ($tab_items AS $tab_item)
				{
					$slide_panels_html .= "<div class=\"ju-tabs-slide-content " . $tabcontent_id . " " . $tab_item['class'] . "\"><div class=\"ju-tabs-slide-inner\">";
					if ($showtitle == "true") $slide_panels_html .= "<h3 class=\"ju-tabs-slide-heading\" style=\"height: " . $heighttabs . "\"><span>" . $tab_item['title'] . "</span></h3>";
					$slide_panels_html .= "<div class=\"ju-tabs-slide-subcontent\">" . $tab_item['content'] . "</div></div></div>";
				}
				$slide_panels_html .= "</div>";

				//Next/Prev
				if ($nextprev == 'true')
				{
					$slide_panels_html .= "<div class = \"prev_btn\">&laquo;</div>";
					$slide_panels_html .= "<div class = \"next_btn\">&raquo;</div>";
				}
				$slide_panels_html .= "</div>";

				//Control buttons
				$control_bottons_html = "";
				if ($controlbuttons == 'true')
				{
					if ($autoplay == 'true')
					{
						$play_btn_style = 'style="display: none;"';
					}
					else
					{
						$stop_btn_style = 'style="display: none;"';
					}
					$control_bottons_html .= "<div class=\"ju-tabs-slide-buttons\"><div class=\"ju-tabs-slide-buttons-inner\">";
					$control_bottons_html .= "<span class=\"ju-tabs-slide-prev\">" . JText::_('Prev') . "</span>";
					$control_bottons_html .= "<span class=\"ju-tabs-slide-stop\" " . $stop_btn_style . ">Stop</span>";
					$control_bottons_html .= "<span class=\"ju-tabs-slide-play\" " . $play_btn_style . ">Play</span>";
					$control_bottons_html .= "<span class=\"ju-tabs-slide-next\">" . JText::_('Next') . "</span>";
					$control_bottons_html .= "</div></div>";
				}
				//Javascript event for Play/Stop button
				$slide_javascript .= '
						<script type="text/javascript">
						jQuery(document).ready(function($){
							$(function(){
								  $("#' . $tabscontainer_id . ' .ju-tabs-slide-buttons .ju-tabs-slide-play").click(function(){$("#' . $tabscontainer_id . ' .ju-tabs-slide-nav .ju-tabs-slide-nav-inner").data("jutabs_slideshow").play(); $(this).hide().parent().find(".ju-tabs-slide-stop").show();});
								  $("#' . $tabscontainer_id . ' .ju-tabs-slide-buttons .ju-tabs-slide-stop").click(function(){$("#' . $tabscontainer_id . ' .ju-tabs-slide-nav .ju-tabs-slide-nav-inner").data("jutabs_slideshow").stop(); $(this).hide().parent().find(".ju-tabs-slide-play").show();});
							});
						});
						</script>';

				$html = $slide_panels_html . $navigation_html . $control_bottons_html . $slide_javascript;
				break;
		}

		$jutabs_html = $this->_jutabs_start_comment . "\n";
		$jutabs_html .= "<div class=\"ju-tabs-wrap " . $theme . "-" . $type . "\" style=\"width:" . $width . "; height:" . $height . "; min-width:" . $minwidth . "; max-width:" . $maxwidth . ";\">"
			. "<div id=\"" . $tabscontainer_id . "\" class=\"ju-tabs-container\">" . $html . "</div>"
			. "</div>";
		$jutabs_html .= "\n" . $this->_jutabs_end_comment;

		return $jutabs_html;
	}

	/*
	* Return jQuery for Tabs
	*/
	protected function generateJavascript($jutabs_id, $jutabs_js_params, $jutabs_slide_js_params, $type)
	{
		$tabscontainer_id = "ju-tabs-" . $jutabs_id;
		$tabstitle_id     = "ju-tabs-title-" . $jutabs_id;
		$tabscontent_id   = "ju-tabs-content-" . $jutabs_id;

		if ($type == 'accordion')
		{
			$javascript = "jQuery(document).ready(function($){ $(function() { $(\"#" . $tabscontainer_id . " ." . $tabstitle_id . "\").jutabs(\"#" . $tabscontainer_id . " ." . $tabscontent_id . "\", {" . $jutabs_js_params . "})}); });";
		}
		elseif ($type == 'slideshow')
		{
			$javascript = "jQuery(document).ready(function($){ $(function() { $(\"#" . $tabscontainer_id . " ." . $tabstitle_id . "\").jutabs(\"#" . $tabscontainer_id . " ." . $tabscontent_id . "\", {" . $jutabs_js_params . "}).jutabs_slideshow({" . $jutabs_slide_js_params . "});}); });";
		}
		else
		{
			$javascript = "jQuery(document).ready(function($){ $(function() { $(\"#" . $tabscontainer_id . " ." . $tabstitle_id . "\").jutabs(\"#" . $tabscontainer_id . " ." . $tabscontent_id . "\", {" . $jutabs_js_params . "});}); });";
		}

		return $javascript;
	}

	/*
	* jQuery plugin params for slideshow
	*/
	protected function generateSlideJSParams($jutabs_id, $_params)
	{
		$jutabs_id = "ju-tabs-" . $jutabs_id;

		//Slideshow params
		$autoplay     = $_params->get('autoplay', 'false');
		$intervaltime = $_params->get('intervaltime', 3000);
		$autopause    = $_params->get('autopause', 'true');
		$clickable    = $_params->get('clickable', 'true');

		$slide_params[] = "next_btn: '#" . $jutabs_id . " .next_btn'";
		$slide_params[] = "prev_btn: '#" . $jutabs_id . " .prev_btn'";
		$slide_params[] = "next: '#" . $jutabs_id . " .ju-tabs-slide-buttons .ju-tabs-slide-next'";
		$slide_params[] = "prev: '#" . $jutabs_id . " .ju-tabs-slide-buttons .ju-tabs-slide-prev'";
		$slide_params[] = "autoplay: " . $autoplay;
		$slide_params[] = "interval: " . $intervaltime;
		$slide_params[] = "autopause: " . $autopause;
		$slide_params[] = "clickable: " . $clickable;

		return implode(", ", $slide_params);
	}

	/*
	* Add JS and CSS to header
	*/
	protected function addHeadTag($type, $data)
	{
		//Check data before addHeadTag
		if (!count($data)) return;

		$document          = JFactory::getDocument();
		$styles            = $document->_styleSheets;
		$scripts           = $document->_scripts;
		$style_arr         = array();
		$script_arr        = array();
		$data              = array_unique($data);
		$jutabs_jsfiles    = "<!-- JUTABS JS FILES -->";
		$jutabs_javascript = "<!-- JUTABS JAVASCRIPT CODE -->";
		$jutabs_cssfiles   = "<!-- JUTABS CSS FILES -->";

		//Build javascript file tags
		if (strtoupper($type) == strtoupper("addScript"))
		{
			foreach ($scripts AS $key => $value)
			{
				$script_arr[] = $key;
			}

			$headtag[] = $jutabs_jsfiles;
			foreach ($data AS $item)
			{
				if (!in_array($item, $script_arr))
				{
					$headtag_item = '<script src="' . $item . '" type="text/javascript"></script>';
					if (strpos($this->_body, $headtag_item) === false) $headtag[] = $headtag_item;
				}
			}
			$headtag[] = $jutabs_javascript;
		}

		//$styles_diff = array_diff_key($styles_1, $styles);
		//$scripts_diff = array_diff_key($scripts_1, $scripts);

		//Build javascript code tags
		if (strtoupper($type) == strtoupper("addScriptDeclaration"))
		{
			$headtag[]               = "<script type=\"text/javascript\">\n    " . implode("\n    ", $data) . "\n  </script>";
			$headtag_declaration_str = "\n  " . implode("\n  ", $data) . "\n";
		}

		//Build css file tags
		if (strtoupper($type) == strtoupper("addStyleSheet"))
		{
			foreach ($styles AS $key => $value)
			{
				$style_arr[] = $key;
			}
			$headtag[] = $jutabs_cssfiles;
			foreach ($data AS $item)
			{
				if (!in_array($item, $style_arr))
				{
					$headtag_item = '<link href="' . $item . '" type="text/css" rel="stylesheet"/>';
					if (strpos($this->_body, $headtag_item) === false) $headtag[] = $headtag_item;
				}
			}
		}

		//Build css code tags
		if (strtoupper($type) == strtoupper("addStyleDeclaration"))
		{
			$headtag[]               = "<style type=\"text/css\">\n    " . implode("\n    ", $data) . "\n  </style>";
			$headtag_declaration_str = "\n  " . implode("\n  ", $data) . "\n";
		}

		$headtag_str = "\n  " . implode("\n  ", $headtag) . "\n";

		//addScript
		if (strtoupper($type) == strtoupper("addScript"))
		{
			$regex = '#\<script.* src="(?:[\\\/a-zA-Z0-9_:\.-]*)jquery(?:[0-9\.-]|core|min|pack)*?.js".*\>\<\/script\>#m';
			preg_match_all($regex, $this->_body, $matches);
			$total_matches = count($matches[0]);
			if ($total_matches)
			{
				$latest_match = $matches[0][$total_matches - 1];
				//Add js files after last jQuery if possible
				$this->_body = str_replace($latest_match, $latest_match . $headtag_str, $this->_body);
				//Remove JUTabs addScript anchor
				$this->_body = preg_replace('#<script[^>]*JUTABS_ADD_SCRIPT_HERE[^>]*></script>#', '', $this->_body, 1);
			}
			else
			{
				$count = 0;
				//Replace JUTabs addScript anchor by js files
				$this->_body = preg_replace('#<script[^>]*JUTABS_ADD_SCRIPT_HERE[^>]*></script>#', $headtag_str, $this->_body, 1, $count);
				//Add js files before </head>
				if (!$count)
				{
					$this->_body = str_replace('</head>', $headtag_str . "</head>", $this->_body);
				}
			}
		}

		//addScriptDeclaration
		if (strtoupper($type) == strtoupper("addScriptDeclaration"))
		{
			if (strpos($this->_body, $jutabs_javascript) !== false)
			{
				//Add javascript code after JUTabs js files if possible, so we should add js files first
				$this->_body = self::str_replace_first($jutabs_javascript, $jutabs_javascript . $headtag_str, $this->_body);
				//Remove JUTabs addScriptDeclaration anchor
				$this->_body = preg_replace('#JUTABS_ADD_SCRIPT_DECLARATION_HERE#', '', $this->_body, 1, $count);
			}
			else
			{
				$count = 0;
				//Replace JUTabs addScriptDeclaration anchor by js code
				$this->_body = preg_replace('#JUTABS_ADD_SCRIPT_DECLARATION_HERE#', $headtag_declaration_str, $this->_body, 1, $count);
				//Add js files before </head>
				if (!$count)
				{
					$this->_body = str_replace('</head>', $headtag_str . "</head>", $this->_body);
				}
			}
		}

		//addStyleSheet
		if (strtoupper($type) == strtoupper("addStyleSheet"))
		{
			$count = 0;
			//Replace JUTabs addStyleSheet by css files
			$this->_body = preg_replace('#<link[^>]*JUTABS_ADD_STYLESHEET_HERE[^>]*/>#', $headtag_str, $this->_body, 1, $count);
			//Add css files before </head>
			if (!$count)
			{
				$this->_body = str_replace('</head>', $headtag_str . "</head>", $this->_body);
			}
		}

		//addStyleDeclaration
		if (strtoupper($type) == strtoupper("addStyleDeclaration"))
		{
			$count = 0;
			//Replace JUTabs addStyleDeclaration by css code
			$this->_body = preg_replace('#JUTABS_ADD_STYLESHEET_DECLARATION_HERE#', $headtag_declaration_str, $this->_body, 1, $count);
			//Add css code before </head>
			if (!$count)
			{
				$this->_body = str_replace('</head>', $headtag_str . "</head>", $this->_body);
			}
		}
	}

	/*
	* Check if jQurey is loaded or not
	*/
	protected function checkjQuery()
	{
		$body  = JResponse::getBody();
		$regex = '#\<script.* src="([\/\\a-zA-Z0-9_:\.-]*)jquery([0-9\.-]|core|min|pack)*?.js".*\>\<\/script\>#m';
		preg_match($regex, $body, $matches);
		if (empty($matches)) return false;
		else return true;
	}

	/*
	* Check if jQurey easing is loaded or not
	*/
	protected function checkjQueryEasing()
	{
		$body  = JResponse::getBody();
		$regex = '#\<script.* src="([\/\\a-zA-Z0-9_:\.-]*)jquery.easing([0-9\.-]|core|min|pack)*?.js".*\>\<\/script\>#m';
		preg_match($regex, $body, $matches);
		if (empty($matches)) return false;
		else return true;
	}

	/*
	* Remove all plugin tab code
	* This function only work properly without nested tab
	*/
	protected function removePlgCode($content)
	{
		$jutabs_code = '#{jutabs(?:.*?){/jutabs}#msi';

		return preg_replace($jutabs_code, '', $content);
	}

	/*
	* Replace only first found string if has more than one matched result
	*/
	protected function str_replace_first($search, $replace, $subject)
	{
		$pos = strpos($subject, $search);
		if ($pos !== false)
		{
			$subject = substr_replace($subject, $replace, $pos, strlen($search));
		}

		return $subject;
	}

	/*
	* Replace only last found string if has more than one matched result
	*/
	protected function str_replace_last($search, $replace, $subject)
	{
		$pos = strrpos($subject, $search);
		if ($pos !== false)
		{
			$subject = substr_replace($subject, $replace, $pos, strlen($search));
		}

		return $subject;
	}

	protected function removeTabAnchor()
	{
		$this->_body = preg_replace('#<script[^>]*JUTABS_ADD_SCRIPT_HERE[^>]*></script>#', '', $this->_body, 1);
		$this->_body = preg_replace('#JUTABS_ADD_SCRIPT_DECLARATION_HERE#', '', $this->_body, 1);
		$this->_body = preg_replace('#<link[^>]*JUTABS_ADD_STYLESHEET_HERE[^>]*/>#', '', $this->_body, 1);
		$this->_body = preg_replace('#JUTABS_ADD_STYLESHEET_DECLARATION_HERE#', '', $this->_body, 1);
	}

	/**
	 * @since    1.6
	 */
	public function onAfterRender()
	{
		$runplugin = true;

		//Don't run tab in backend
		$app = JFactory::getApplication();
		if ($app->isAdmin())
		{
			$runplugin = false;
		}

		//Make sure we don't run tab when call ajax
		if (JRequest::getCmd('jutabaction'))
		{
			$runplugin = false;
		}

		//Only run tab in html mode
		$document = JFactory::getDocument();
		if ($document->getType() !== 'html' && $document->getType() !== 'feed')
		{
			$runplugin = false;
		}

		//Don't run tab in front-end edit layout
		if (JRequest::getVar('option') == 'com_content' && JRequest::getVar('layout') == 'edit')
		{
			$runplugin = false;
		}

		$this->_body = JResponse::getBody();
		if ($this->_body == '')
		{
			$runplugin = false;
		}

		// enable plugin on the listed pages
		$enabledpage = false;
		$enablepaths = trim((string) $this->params->get('enablepaths'));
		if ($enablepaths)
		{
			$paths              = array_map('trim', (array) explode("\n", $enablepaths));
			$current_uri_string = JURI::getInstance()->toString();

			foreach ($paths as $regex_pattern)
			{
				//preg_quote and remove ending slash of JURI::root()
				$root_path     = preg_quote(preg_replace('#\/$#', '', JURI::root()), '/');
				$regex_pattern = "#" . str_replace("[root]", $root_path, $regex_pattern) . "#i";
				preg_match($regex_pattern, $current_uri_string, $matches);
				if (count($matches))
				{
					$enabledpage = true;
					break;
				}
			}
		}

		// disable plugin in the listed pages, if the page is not in list of enabled pages
		$disablepaths = trim((string) $this->params->get('disablepaths'));
		$disabledpage = false;
		if (!$enabledpage && $disablepaths)
		{
			$paths              = array_map('trim', (array) explode("\n", $disablepaths));
			$current_uri_string = JURI::getInstance()->toString();

			foreach ($paths as $regex_pattern)
			{
				//preg_quote and remove ending slash of JURI::root()
				$root_path     = preg_quote(preg_replace('#\/$#', '', JURI::root()), '/');
				$regex_pattern = "#" . str_replace("[root]", $root_path, $regex_pattern) . "#i";
				preg_match($regex_pattern, $current_uri_string, $matches);
				if (count($matches))
				{
					$disabledpage = true;
					break;
				}
			}
		}

		//Force run tab in enabled pages
		if (!$enabledpage && $disabledpage)
		{
			$tab_in_disabled_page = true;
		}
		else
		{
			$tab_in_disabled_page = false;
		}

		//Tab in disabled page
		if ($tab_in_disabled_page)
		{
			//Don't parse tab code => Stop the plugin
			if ($this->params->get('handletabindisabledpage', 1) == 1)
			{
				$runplugin = false;
				//Remove tab code => Force disable tab
			}
			else if ($this->params->get('handletabindisabledpage', 1) == 2)
			{
				$this->params->set('disable_tab', 1);
			}
		}

		//Don't run plugin, remove all tab anchor then return false;
		if (!$runplugin)
		{
			self::removeTabAnchor();
			//Set new body
			JResponse::setBody($this->_body);

			return false;
		}

		//Disable tab will remove all JUTabs code
		$disable_tab = $this->params->get('disable_tab', 0);

		//Load default tab style
		$css_files[] = JURI::root(true) . "/plugins/system/jutabs/tabs/jutabs.css";

		//Load jQuery
		if ($this->params->get('loadjquery', '2') == 1 || ($this->params->get('loadjquery', '2') == 2 && !self::checkjQuery()))
		{
			if ($this->params->get('loadjqueryfrom', '1') == 1)
			{
				$js_files[] = JURI::root(true) . "/plugins/system/jutabs/tabs/assets/js/jquery.min.js";
			}
			else if ($this->params->get('loadjqueryfrom', '1') == 2)
			{
				$js_files[] = "http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js";
			}
		}

		//Load JUTabs function
		$js_files[] = JURI::root(true) . "/plugins/system/jutabs/tabs/assets/js/jutabs.min.js";

		if (!self::checkjQueryEasing()) $js_files[] = JURI::root(true) . "/plugins/system/jutabs/tabs/assets/js/jquery.easing.1.3.min.js";

		if (JRequest::getCmd('format') != 'pdf' || !JRequest::getCmd('print'))
		{
			$total_working_tabs = 0;
			$total_tabs         = 0;
			$has_tab            = true;

			$addscript_ext            = array();
			$addscriptdeclaration_ext = array();
			$addstylesheet_ext        = array();
			$addstyledeclaration_ext  = array();

			$all_stripscripts     = array();
			$all_stripstylesheets = array();

			WHILE ($has_tab == true)
			{
				//Get all jutabs in one array (jutabs without params and content)
				$all_jutabs_arr = self::parseJUTabs($this->_body, $this->_jutabs_open, $this->_jutabs, $this->_jutabs_close, false);
				//Array of jutabs code: {jutabs}...{/jutabs}
				$jutabs_code_arr = $all_jutabs_arr[0];

				//Break if do NOT find any {jutabs}
				if (count($all_jutabs_arr[0]) == 0)
				{
					break;
				}

				foreach ($jutabs_code_arr AS $jutabs_code)
				{
					//Get the deepest {jutabs} if has nested tab. {jutabs}...level1...{jutabs}...level2...{jutabs}...level3...{/jutabs} => {jutabs}...level3...{/jutabs}
					$jutabs_pos = strrpos($jutabs_code, $this->_jutabs_open . $this->_jutabs);
					if ($jutabs_pos !== false || $jutabs_pos > 0)
					{
						$jutabs_code = substr($jutabs_code, $jutabs_pos);
					}

					//Generate tabs HTML
					if (!$disable_tab)
					{
						$jutabs_arr = self::parseJUTabs($jutabs_code, $this->_jutabs_open, $this->_jutabs, $this->_jutabs_close, true);

						//jutabs params string
						$jutabs_params_str = $jutabs_arr[1][0];
						//subtabs string
						$subtabs_str = $jutabs_arr[2][0];

						//Merge jutabs code params with jutabs plugin params
						$_params = self::parseParams($jutabs_params_str);

						//History only support only one tab/page and in accordion mode: NOT click on self accordion to close
						if ($total_tabs >= 1 || ($_params->get('type', 'tab') == 'accordion' && $_params->get('closetab', 'true') == 'true'))
						{
							$_params->set('history', 'false');
						}

						//Check password for JUTabs if it is set and match password in tab code param
						if ($this->params->get('password', '') == '' || $_params->get('password', '') == $this->params->get('password', ''))
						{
							$theme         = $_params->get('theme', 'default');
							$defaultitem   = $_params->get('defaultitem', 0);
							$history       = $_params->get('history', 'false');
							$changetab     = $_params->get('changetab', 'click');
							$initialeffect = $_params->get('initialeffect', 'false');
							$ajax          = $_params->get('ajax', 'false');

							$type          = $_params->get('type', 'tab');
							$duration      = $_params->get('duration', 400);
							$accordionmode = $_params->get('accordionmode', 'vertical');
							$position      = $_params->get('position', 'top');
							$tabscroll     = $_params->get('tabscroll', 'true');

							//Accordion setting
							$closetab      = $_params->get('closetab', 'true');
							$openmultitabs = $_params->get('openmultitabs', 'false');

							//Slideshow setting
							$rotate = $_params->get('rotate', 'true');

							//Callback function
							$onLoad        = $_params->get('onLoad', 'null');
							$onBeforeClick = $_params->get('onBeforeClick', 'null');
							$onClick       = $_params->get('onClick', 'null');

							if ($type == 'accordion')
							{
								$effect = $_params->get('accordioneffect', 'default');
							}
							else
							{
								$effect = $_params->get('tabeffect', 'default');
							}

							$currentitemeasing   = $_params->get('currentitemeasing', 'linear');
							$nextitemeasing      = $_params->get('nextitemeasing', 'linear');
							$swipetouch          = $_params->get('swipetouch', 'true');
							$triggerwindowresize = $_params->get('triggerwindowresize', 'false');
							$responsive          = $_params->get('responsive', 'true');
							$slidetotab          = $_params->get('slidetotab', 'true');

							//Load tab theme, theme in template has higher priority
							$theme_in_template = JPATH_SITE . DS . 'templates' . DS . $app->getTemplate() . DS . 'html' . DS . 'plg_jutabs' . DS . 'themes' . DS . $theme . DS . $type . ".css";
							if (is_file($theme_in_template))
							{
								$css_files[] = JURI::root(true) . "/templates/" . $app->getTemplate() . "/html/plg_jutabs/themes/" . $theme . "/" . $type . ".css";
							}
							else
							{
								$css_files[] = JURI::root(true) . "/plugins/system/jutabs/tabs/themes/" . $theme . "/" . $type . ".css";
							}

							//Load effects
							if ($type == 'accordion')
							{
								$js_files[] = JURI::root(true) . "/plugins/system/jutabs/tabs/assets/js/effects/juaccordion.effects.min.js";
							}
							else $js_files[] = JURI::root(true) . "/plugins/system/jutabs/tabs/assets/js/effects/jutabs.effects.min.js";
							//Load history function
							if ($history == 'true')
							{
								$js_files[] = JURI::root(true) . "/plugins/system/jutabs/tabs/assets/js/toolbox.history.min.js";
							}
							//Load slideshow function
							if ($type == 'slideshow')
							{
								$js_files[] = JURI::root(true) . "/plugins/system/jutabs/tabs/assets/js/jutabs.slideshow.min.js";
							}
							//Load swipe touch
							if ($swipetouch == 'true')
							{
								$js_files[] = JURI::root(true) . "/plugins/system/jutabs/tabs/assets/js/jquery.touchswipe.min.js";
							}
							//Load jQuery actual
							$js_files[] = JURI::root(true) . "/plugins/system/jutabs/tabs/assets/js/jquery.actual.min.js";

							//Make sure jutabs_id is unique, jutabs_id must be in [A-Za-z0-9-_]
							if (trim($_params->get('name', '')) != '')
							{
								$jutabs_id = preg_replace("/[^A-Za-z0-9-_]/", "", $_params->get('name', ''));
							}
							else
							{
								$jutabs_id = rand(100000, 1000000);
							}

							$js_tab_params   = array();
							$js_tab_params[] = "site_root: '" . JURI::Root() . "'";
							$js_tab_params[] = "name: '" . $jutabs_id . "'";
							$js_tab_params[] = "swipetouch: " . $swipetouch;
							$js_tab_params[] = "triggerWindowResize: " . $triggerwindowresize;
							$js_tab_params[] = "slidetotab: " . $slidetotab;
							//Tabscroll only support top/bottom position
							if ($tabscroll == "true" && $type == "tab" && ($position == "top" || $position == "bottom"))
							{
								$js_tab_params[] = "tabscroll: true";
							}
							else
							{
								$js_tab_params[] = "tabscroll: false";
							}

							//Tab
							if ($type == 'tab')
							{
								$js_tab_params[] = "event: '" . $changetab . "'";
								$js_tab_params[] = "effect: '" . $effect . "'";
								$js_tab_params[] = "currentItemEasing: '" . $currentitemeasing . "'";
								$js_tab_params[] = "nextItemEasing: '" . $nextitemeasing . "'";
								$js_tab_params[] = "initialIndex: " . $defaultitem;
								$js_tab_params[] = "history: " . $history;
								$js_tab_params[] = "ajax: " . $ajax;
								$js_tab_params[] = "duration: " . $duration;
								$js_tab_params[] = "initialEffect: " . $initialeffect;
							}
							//Accordions
							if ($type == 'accordion')
							{
								$js_tab_params[] = "tabs: '> li > h3.ju-tabs-accordion-title'";
								$js_tab_params[] = "event: '" . $changetab . "'";
								$js_tab_params[] = "effect: '" . $effect . "'";
								$js_tab_params[] = "currentItemEasing: '" . $currentitemeasing . "'";
								$js_tab_params[] = "nextItemEasing: '" . $nextitemeasing . "'";
								$js_tab_params[] = "initialIndex: " . $defaultitem;
								$js_tab_params[] = "history: " . $history;
								$js_tab_params[] = "ajax: " . $ajax;
								$js_tab_params[] = "duration: " . $duration;
								$js_tab_params[] = "initialEffect: " . $initialeffect;
								$js_tab_params[] = "closetab: " . $closetab;
								$js_tab_params[] = "openmultitabs: " . $openmultitabs;
								$js_tab_params[] = "accordionmode: '" . $accordionmode . "'";
								$js_tab_params[] = "responsive: " . $responsive;
							}
							//Slideshow
							if ($type == 'slideshow')
							{
								$js_tab_params[] = "event: '" . $changetab . "'";
								$js_tab_params[] = "effect: '" . $effect . "'";
								$js_tab_params[] = "currentItemEasing: '" . $currentitemeasing . "'";
								$js_tab_params[] = "nextItemEasing: '" . $nextitemeasing . "'";
								$js_tab_params[] = "initialIndex: " . $defaultitem;
								$js_tab_params[] = "history: " . $history;
								$js_tab_params[] = "ajax: " . $ajax;
								$js_tab_params[] = "duration: " . $duration;
								$js_tab_params[] = "initialEffect: " . $initialeffect;
								$js_tab_params[] = "rotate: " . $rotate;
							}
							//Callback
							$js_tab_params[] = "onLoad: " . $onLoad;
							$js_tab_params[] = "onBeforeClick: " . $onBeforeClick;
							$js_tab_params[] = "onClick: " . $onClick;

							$jutabs_js_params       = implode(", ", $js_tab_params);
							$jutabs_slide_js_params = self::generateSlideJSParams($jutabs_id, $_params);

							$javascript[] = self::generateJavascript($jutabs_id, $jutabs_js_params, $jutabs_slide_js_params, $type);

							//Allows to add extra js, css, javascript
							$addscript            = $_params->get('addscript', '');
							$addscriptdeclaration = $_params->get('addscriptdeclaration', '');
							$addstylesheet        = $_params->get('addstylesheet', '');
							$addstyledeclaration  = $_params->get('addstyledeclaration', '');

							$addscript_arr = preg_split("/[\n,]+/", $addscript);

							//addScript extend array
							if (count($addscript_arr))
							{
								foreach ($addscript_arr AS $addscript_item)
								{
									if (substr(trim($addscript_item), -3) == '.js')
									{
										$addscript_ext[] = trim($addscript_item);
									}
								}
							}

							//addScriptDeclaration extend array
							if (trim($addscriptdeclaration) != '')
							{
								$addscriptdeclaration_ext[] = $addscriptdeclaration;
							}

							//addStyleSheet extend array
							$addstylesheet_arr = preg_split("/[\n,]+/", $addstylesheet);
							if (count($addstylesheet_arr))
							{
								foreach ($addstylesheet_arr AS $addstylesheet_item)
								{
									if (substr(trim($addstylesheet_item), -4) == '.css')
									{
										$addstylesheet_ext[] = trim($addstylesheet_item);
									}
								}
							}

							//addStyleDeclaration extend array
							if (trim($addstyledeclaration) != '')
							{
								$addstyledeclaration_ext[] = $addstyledeclaration;
							}

							//Javascript files will be stripped
							$stripscripts = trim((string) $this->params->get('stripscripts', ''));
							if ($stripscripts)
							{
								$stripscripts     = array_map('trim', (array) preg_split("/[\n,]+/", $stripscripts));
								$all_stripscripts = array_merge($all_stripscripts, $stripscripts);
							}

							//CSS files will be stripped
							$stripstylesheets = trim((string) $this->params->get('stripstylesheets', ''));
							if ($stripstylesheets)
							{
								$stripstylesheets     = array_map('trim', (array) preg_split("/[\n,]+/", $stripstylesheets));
								$all_stripstylesheets = array_merge($all_stripstylesheets, $stripstylesheets);
							}

							//Tab loadcontent, param: loadcontent="moduleid:1,2,3"
							if ($_params->get('loadcontent', ''))
							{
								$tabcontent_arr   = explode(":", $_params->get('loadcontent', ''), 2);
								$tabcontent_type  = $tabcontent_arr[0];
								$tabcontent_value = $tabcontent_arr[1];
							}
							else
							{
								$tabcontent_type  = "content";
								$tabcontent_value = "";
							}

							//Generate an array of JU Tabs items
							$tab_items = self::generateJUTabsItems($tabcontent_type, $tabcontent_value, $subtabs_str, $_params, $jutabs_id);

							if (count($tab_items))
							{
								//Generate tab html from tab items and tabs params
								$html = self::generateJUTabsHtml($_params, $tab_items, $jutabs_id);

								//Increase total_working_tabs if has one more jutabs
								$total_working_tabs++;
							}
							else
							{
								//Has no tab item
								$html = JText::_('<span class="ju-tabs-nocontent">JU Tabs: No content</span>');
							}
						}
						else
						{
							//$html = JText::_('<span class="ju-tabs-wrongpassword">JU Tabs: Wrong password</span>');
							//Replace with wrong JU Tabs code, so this tab code will be ignore
							$html = $jutabs_code;
							$html = str_ireplace("{jutabs", "{<b>jutabs</b>", $html);
							$html = str_ireplace("{/jutabs}", "{/<b>jutabs</b>}", $html);
						}
					}
					else
					{
						//Disable tab => remove jutabs code
						$html = "";
					}

					$total_tabs++;

					//Replace first match tab, not all(incase more than one tab have exactly the same code)
					$this->_body = self::str_replace_first($jutabs_code, $html, $this->_body);
				}

				//Re-check if has {jutabs} after replace jutabs code by html
				$all_jutabs_arr = self::parseJUTabs($this->_body, $this->_jutabs_open, $this->_jutabs, $this->_jutabs_close, false);
				$has_tab        = count($all_jutabs_arr[0]) > 0 ? true : false;
			}

			if ($total_working_tabs)
			{
				//Move JU Tabs div out of p tag to valid W3C, p tag and comment should be in ONE LINE
				$this->_body = preg_replace_callback("/(?!.*<\/p>.*)(<p[^<]*?>.*?)" . $this->_jutabs_start_comment . "/", array($this, 'self::close_tag_before_jutabs_callback'), $this->_body);
				$this->_body = preg_replace_callback("/(?!.*<p[^<]*>.*)" . $this->_jutabs_end_comment . "(.*?<\/p>)/", array($this, 'self::close_tag_after_jutabs_callback'), $this->_body);

				//Only include tab js/css if has at least one tab working
				//Merge JU Tabs files with extend files
				$addstylesheet_arr        = array_merge($css_files, $addstylesheet_ext);
				$addscript_arr            = array_merge($js_files, $addscript_ext);
				$addscriptdeclaration_arr = array_merge($javascript, $addscriptdeclaration_ext);

				//Add headtags
				self::addHeadTag("addStyleSheet", $addstylesheet_arr);
				self::addHeadTag("addScript", $addscript_arr);
				self::addHeadTag("addScriptDeclaration", $addscriptdeclaration_arr);
				//Check if addStyleDeclaration has been set
				if (count($addstyledeclaration_ext))
				{
					self::addHeadTag("addStyleDeclaration", $addstyledeclaration_ext);
				}
				else
				{
					//If don't set, remove anchor
					$this->_body = preg_replace('#JUTABS_ADD_STYLESHEET_DECLARATION_HERE#', '', $this->_body, 1, $count);
				}

				//Strip scripts
				if ($all_stripscripts)
				{
					foreach ($all_stripscripts as $script)
					{
						$count       = 0;
						$this->_body = preg_replace('#<script[^>]*' . $script . '[^>]*></script>#', '', $this->_body, -1, $count);
					}
				}

				//Strip stylesheets
				if ($all_stripstylesheets)
				{
					foreach ($all_stripstylesheets as $stylesheet)
					{
						$count       = 0;
						$this->_body = preg_replace('#<link[^>]*' . $stylesheet . '[^>]*/>#', '', $this->_body, -1, $count);
					}
				}

				//Strip blank line
				$this->_body = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $this->_body, -1, $count);
			}
			else
			{
				//If has no working tab => remove all anchors of js/css
				self::removeTabAnchor();
			}

			//Set new body
			JResponse::setBody($this->_body);
		}
		else
		{
			//Incase view = PDF or Print

		}
	}

	//Callback function of preg_replace_callback to complete p tag
	protected function close_tag_before_jutabs_callback($matches)
	{
		$regex_pattern = "/^<p[^<]*?>$/";
		preg_match_all($regex_pattern, $matches[1], $p_tag_nocontent_matches);
		//If empty line: <p...> => strip it, else complete p tag
		if (count($p_tag_nocontent_matches[0])) return $this->_jutabs_start_comment;
		else return $matches[1] . "</p>" . $this->_jutabs_start_comment;
	}

	protected function close_tag_after_jutabs_callback($matches)
	{
		//If empty line => strip it, else complete p tag
		if (trim($matches[1]) == "</p>") return $this->_jutabs_end_comment;
		else return $this->_jutabs_end_comment . "<p>" . $matches[1];
	}

	//Close all open html tags
	protected function closetags($html)
	{
		preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
		$openedtags = $result[1];
		preg_match_all('#</([a-z]+)>#iU', $html, $result);
		$closedtags = $result[1];
		$len_opened = count($openedtags);
		if (count($closedtags) == $len_opened)
		{
			return $html;
		}
		$openedtags = array_reverse($openedtags);
		for ($i = 0; $i < $len_opened; $i++)
		{
			if (!in_array($openedtags[$i], $closedtags))
			{
				$html .= '</' . $openedtags[$i] . '>';
			}
			else
			{
				unset($closedtags[array_search($openedtags[$i], $closedtags)]);
			}
		}

		return $html;
	}

	/**
	 *
	 * Get module data
	 *
	 * @param int $id module id
	 *
	 * @return array
	 */
	protected function loadModule($id)
	{
		static $clean;

		/* if (isset($clean))
		{
			return $clean;
		} */

		$Itemid   = JRequest::getInt('Itemid');
		$app      = JFactory::getApplication();
		$user     = JFactory::getUser();
		$groups   = implode(',', $user->getAuthorisedViewLevels());
		$lang     = JFactory::getLanguage()->getTag();
		$clientId = (int) $app->getClientId();

		/* $cache = JFactory::getCache('com_modules', '');
		$cacheid = md5(serialize(array($Itemid, $groups, $clientId, $lang)));

		if (!($clean = $cache->get($cacheid)))
		{ */
		$db = JFactory::getDbo();

		$query = $db->getQuery(true);
		$query->select('m.id, m.title, m.module, m.position, m.content, m.showtitle, m.params, mm.menuid');
		$query->from('#__modules AS m');
		$query->join('LEFT', '#__modules_menu AS mm ON mm.moduleid = m.id');
		$query->where('m.published = 1');

		$query->join('LEFT', '#__extensions AS e ON e.element = m.module AND e.client_id = m.client_id');
		$query->where('e.enabled = 1');
		$query->where('m.id = ' . $id);

		$date     = JFactory::getDate();
		$now      = $date->toSql();
		$nullDate = $db->getNullDate();
		$query->where('(m.publish_up = ' . $db->Quote($nullDate) . ' OR m.publish_up <= ' . $db->Quote($now) . ')');
		$query->where('(m.publish_down = ' . $db->Quote($nullDate) . ' OR m.publish_down >= ' . $db->Quote($now) . ')');

		$query->where('m.access IN (' . $groups . ')');
		$query->where('m.client_id = ' . $clientId);
		$query->where('(mm.menuid = ' . (int) $Itemid . ' OR mm.menuid <= 0)');

		// Filter by language
		if ($app->isSite() && $app->getLanguageFilter())
		{
			$query->where('m.language IN (' . $db->Quote($lang) . ',' . $db->Quote('*') . ')');
		}

		$query->order('m.position, m.ordering');

		// Set the query
		$db->setQuery($query);
		$modules = $db->loadObjectList();
		$clean   = array();

		if ($db->getErrorNum())
		{
			JError::raiseWarning(500, JText::sprintf('JLIB_APPLICATION_ERROR_MODULE_LOAD', $db->getErrorMsg()));

			return $clean;
		}

		// Apply negative selections and eliminate duplicates
		$negId = $Itemid ? -(int) $Itemid : false;
		$dupes = array();
		for ($i = 0, $n = count($modules); $i < $n; $i++)
		{
			$module = & $modules[$i];

			// The module is excluded if there is an explicit prohibition
			$negHit = ($negId === (int) $module->menuid);

			if (isset($dupes[$module->id]))
			{
				// If this item has been excluded, keep the duplicate flag set,
				// but remove any item from the cleaned array.
				if ($negHit)
				{
					unset($clean[$module->id]);
				}
				continue;
			}

			$dupes[$module->id] = true;

			// Only accept modules without explicit exclusions.
			if (!$negHit)
			{
				// Determine if this is a 1.0 style custom module (no mod_ prefix)
				// This should be eliminated when the class is refactored.
				// $module->user is deprecated.
				$file         = $module->module;
				$custom       = substr($file, 0, 4) == 'mod_' ? 0 : 1;
				$module->user = $custom;
				// 1.0 style custom module name is given by the title field, otherwise strip off "mod_"
				$module->name       = $custom ? $module->module : substr($file, 4);
				$module->style      = null;
				$module->position   = strtolower($module->position);
				$clean[$module->id] = $module;
			}
		}

		unset($dupes);

		// Return to simple indexing that matches the query order.
		$clean = array_values($clean);

		/* 	$cache->store($clean, $cacheid);
		} */

		return $clean;
	}

	protected function loadModuleById($moduleid)
	{
		$document = JFactory::getDocument();
		$renderer = $document->loadRenderer('module');
		$module   = self::loadModule($moduleid);
		$html     = $renderer->render($module[0]);
		$html     = self::convertURL($html);

		return $html;
	}

	protected function getModuleTitleById($moduleid)
	{
		$db    = JFactory::GetDBO();
		$query = "SELECT title FROM #__modules WHERE id=" . $moduleid;
		$db->setQuery($query);
		$result = $db->loadResult();

		return $result;
	}

	protected function loadModuleByName($modulename)
	{
		$document = JFactory::getDocument();
		$renderer = $document->loadRenderer('module');
		$module   = JModuleHelper::getModule($modulename);
		// If the module without the mod_ isn't found, try it with mod_.
		// This allows people to enter it either way in the content
		if (!isset($module))
		{
			$modulename = 'mod_' . $modulename;
			$module     = JModuleHelper::getModule($modulename);
		}
		$html = $renderer->render($module);
		$html = self::convertURL($html);

		return $html;
	}

	protected function getModuleTitleByName($modulename)
	{
		$document = JFactory::getDocument();
		$renderer = $document->loadRenderer('module');
		$module   = JModuleHelper::getModule($modulename);
		// If the module without the mod_ isn't found, try it with mod_.
		// This allows people to enter it either way in the content
		if (!isset($module))
		{
			$modulename = 'mod_' . $modulename;
			$module     = JModuleHelper::getModule($modulename);
		}
		$title = $module->title;

		return $title;
	}

	protected function loadModulesByPosition($moduleposition)
	{
		$document = JFactory::getDocument();
		$renderer = $document->loadRenderer('module');
		//Get modules by position
		$modules = JModuleHelper::getModules($moduleposition);

		foreach ($modules AS $module)
		{
			$module_item            = array();
			$module_item['id']      = $module->id;
			$module_item['title']   = $module->title;
			$module_item['content'] = self::convertURL($renderer->render($module));
			$modules_array[]        = $module_item;
		}

		return $modules_array;
	}

	protected function loadArticle($articleid, $view)
	{
		if ($view == '') $view = JRequest::getCmd('jutabsview', '');

		if (!(int) $articleid)
		{
			$result = '';
		}
		elseif (JRequest::getVar('option', '') == 'com_content' && JRequest::getVar('view', '') == 'article' && JRequest::getVar('id', '') == $articleid)
		{
			$result = '<p class="jutabs-error">You can not load Article(ID:' . $articleid . ') into itself</p>';
		}
		else
		{
			$db    = JFactory::GetDBO();
			$query = "SELECT `introtext`, `fulltext`, `alias`, `catid` FROM #__content WHERE id=" . $articleid;
			$db->setQuery($query);
			$row = $db->loadObject();
			if (!$row)
			{
				$result = '';
			}
			else
			{
				if (!isset($view) || $view != 'fulltext')
				{
					$result = $row->introtext;
					//Readmore link
					if ($row->fulltext != '')
					{
						require_once JPATH_SITE . '/components/com_content/helpers/route.php';
						$readmore = JRoute::_(ContentHelperRoute::getArticleRoute($articleid . ':' . $row->alias, $row->catid));
						$result .= '<a class="readmore" href="' . $readmore . '">' . JText::_('Read more') . '&hellip;</a>';
					}
				}
				else
				{
					$result = $row->introtext . $row->fulltext;
				}
			}
		}

		$result = self::convertURL($result);

		return $result;
	}

	protected function getArticleTitle($articleid)
	{
		$db    = JFactory::GetDBO();
		$query = "SELECT title FROM #__content WHERE id=" . $articleid;
		$db->setQuery($query);
		$result = $db->loadResult();

		return $result;
	}

	protected function getArticlesByCatid($catid_array, $limit)
	{
		$db    = JFactory::GetDBO();
		$catid = implode(",", $catid_array);
		//Change ORDER BY if you want
		$query = "SELECT id FROM #__content WHERE catid IN (" . $catid . ") AND state = 1 ORDER BY catid, ordering ASC";
		if ($limit > 0) $query .= " LIMIT " . $limit;
		$db->setQuery($query);

		return $db->loadObjectList();
	}

	protected function loadK2Item($k2itemid, $view)
	{
		if ($view == '') $view = JRequest::getCmd('jutabsview', '');

		if (!(int) $k2itemid)
		{
			$result = '';
		}
		elseif (JRequest::getVar('option', '') == 'com_k2' && JRequest::getVar('view', '') == 'item' && JRequest::getVar('id', '') == $k2itemid)
		{
			$result = '<p class="jutabs-error">You can not load K2 Item(ID:' . $k2itemid . ') into itself</p>';
		}
		else
		{
			$db    = JFactory::GetDBO();
			$query = "SELECT i.`introtext`, i.`fulltext`, i.`alias`, i.`catid`, c.`alias` AS cat_alias FROM #__k2_items AS i LEFT JOIN #__k2_categories AS c ON i.catid = c.id WHERE i.id=" . $k2itemid;
			$db->setQuery($query);
			$row = $db->loadObject();
			if (!$row)
			{
				$result = '';
			}
			else
			{
				if (!isset($view) || $view != 'fulltext')
				{
					$result = $row->introtext;

					//Readmore link
					if ($row->fulltext != '')
					{
						$k2_file = JPATH_SITE . '/components/com_k2/helpers/route.php';
						file_exists($k2_file) ? require_once $k2_file : '';
						$readmore = urldecode(JRoute::_(K2HelperRoute::getItemRoute($k2itemid . ':' . urlencode($row->alias), $row->catid . ':' . urlencode($row->cat_alias))));
						$result .= '<a class="readmore" href="' . $readmore . '">' . JText::_('Read more') . '&hellip;</a>';
					}
				}
				else
				{
					$result = $row->introtext . $row->fulltext;
				}
			}

			$result = self::convertURL($result);
		}

		return $result;
	}

	protected function getK2ItemTitle($articleid)
	{
		$db    = JFactory::GetDBO();
		$query = "SELECT title FROM #__k2_items WHERE id=" . $articleid;
		$db->setQuery($query);
		$result = $db->loadResult();

		return $result;
	}

	protected function getK2itemsByCatid($catid_array, $limit)
	{
		$db    = JFactory::GetDBO();
		$catid = implode(",", $catid_array);
		//Change ORDER BY if you want
		$query = "SELECT id FROM #__k2_items WHERE catid IN (" . $catid . ") AND published = 1 ORDER BY catid, ordering ASC";
		if ($limit > 0) $query .= " LIMIT " . $limit;
		$db->setQuery($query);

		return $db->loadObjectList();
	}

	protected function loadUrl($url)
	{
		if (!preg_match('/^https?:\/\/[^\/]+/i', $url))
		{
			$url  = JURI::Base() . $url;
			$base = JURI::Base();
		}
		else
		{
			$url_arr = parse_url($url);
			$base    = $url_arr["scheme"] . "://" . $url_arr["host"] . "/";
		}

		$handle = fopen($url, "r");
		if ($handle)
		{
			$content = '';
			while (!feof($handle))
			{
				$buffer = fgets($handle, 4096);
				$content .= $buffer;
			}
			fclose($handle);
		}

		$content = self::relToAbs($content, $base);
		$content = self::convertURL($content);

		return utf8_encode($content);
	}

	//Replace link/image with relative path to absolute path, for external loadUrl
	protected function relToAbs($text, $base)
	{
		if (empty($base)) return $text;

		// base url needs trailing /
		if (substr($base, -1, 1) != "/") $base .= "/";

		// Replace links/images
		$regex   = "/<(.*?)(src|href|poster)=[\"'](?!(?:http|https|ftp|mailto))(.*?)[\"'](.*?)>/";
		$replace = "<$1$2=\"" . $base . "$3\"$4>";
		$text    = preg_replace($regex, $replace, $text);

		$regex   = '#style\s*=\s*[\'\"](.*):\s*url\s*\([\'\"]?(?!(?:http|https|ftp|mailto))(.*?)([^\)\'\"]+)[\'\"]?\)#m';
		$replace = 'style="$1: url(\'' . $base . '$2$3\')';
		$text    = preg_replace($regex, $replace, $text);

		// Done
		return $text;
	}

	/**
	 * Converting the site URL to fit to the HTTP request
	 */
	protected function convertURL($buffer)
	{
		$app = JFactory::getApplication();

		if ($app->getCfg('sef') == '0')
		{
			return $buffer;
		}

		//Replace src links
		$base = JURI::base(true) . '/';

		$regex  = '#href="index.php\?([^"]*)#m';
		$buffer = preg_replace_callback($regex, array('plgSystemJUTabs', 'route'), $buffer);

		$protocols = '[a-zA-Z0-9]+:'; //To check for all unknown protocals (a protocol must contain at least one alpahnumeric fillowed by :
		$regex     = '#(src|href|poster)=[\"\'](?!/|' . $protocols . '|\#|\')([^"]*)[\"\']#m';
		$buffer    = preg_replace($regex, "$1=\"$base\$2\"", $buffer);
		$regex     = '#(onclick="window.open\(\')(?!/|' . $protocols . '|\#)([^/]+[^\']*?\')#m';
		$buffer    = preg_replace($regex, '$1' . $base . '$2', $buffer);

		// ONMOUSEOVER / ONMOUSEOUT
		$regex  = '#(onmouseover|onmouseout)="this.src=([\']+)(?!/|' . $protocols . '|\#|\')([^"]+)"#m';
		$buffer = preg_replace($regex, '$1="this.src=$2' . $base . '$3$4"', $buffer);

		// Background image
		$regex  = '#style\s*=\s*[\'\"](.*):\s*url\s*\([\'\"]?(?!/|' . $protocols . '|\#)([^\)\'\"]+)[\'\"]?\)#m';
		$buffer = preg_replace($regex, 'style="$1: url(\'' . $base . '$2$3\')', $buffer);

		// OBJECT <param name="xx", value="yy"> -- fix it only inside the <param> tag
		$regex  = '#(<param\s+)name\s*=\s*"(movie|src|url)"[^>]\s*value\s*=\s*"(?!/|' . $protocols . '|\#|\')([^"]*)"#m';
		$buffer = preg_replace($regex, '$1name="$2" value="' . $base . '$3"', $buffer);

		// OBJECT <param value="xx", name="yy"> -- fix it only inside the <param> tag
		$regex  = '#(<param\s+[^>]*)value\s*=\s*"(?!/|' . $protocols . '|\#|\')([^"]*)"\s*name\s*=\s*"(movie|src|url)"#m';
		$buffer = preg_replace($regex, '<param value="' . $base . '$2" name="$3"', $buffer);

		// OBJECT data="xx" attribute -- fix it only in the object tag
		$regex  = '#(<object\s+[^>]*)data\s*=\s*"(?!/|' . $protocols . '|\#|\')([^"]*)"#m';
		$buffer = preg_replace($regex, '$1data="' . $base . '$2"$3', $buffer);

		return $buffer;
	}

	/**
	 * Replaces the matched tags
	 *
	 * @param    array    An array of matches (see preg_match_all)
	 *
	 * @return    string
	 */
	protected static function route(&$matches)
	{
		$original = $matches[0];
		$url      = $matches[1];
		$url      = str_replace('&amp;', '&', $url);
		$route    = JRoute::_('index.php?' . $url);

		return 'href="' . $route;
	}

	/*
	* Ajax load, called by javascript
	* We don't parseJUTabs in ajax mode
	*/
	public function onAfterRoute()
	{
		if (JRequest::getCmd('jutabaction'))
		{
			$action = JRequest::getCmd('jutabaction');
			switch ($action)
			{
				case "loadmodulebyid":
					$moduleid = JRequest::getCmd('moduleid');
					if ($moduleid)
					{
						$html = self::loadModuleById($moduleid);
					}
					break;
				case "loadmodulebyname":
					$modulename = JRequest::getCmd('modulename');
					if ($modulename)
					{
						$html = self::loadModuleByName($modulename);
					}
					break;
				case "loadarticlebyid":
					$articleid = JRequest::getCmd('articleid');
					$view      = JRequest::getCmd('jutabsview');
					if ($articleid)
					{
						$html = self::loadArticle($articleid, $view);
					}
					break;
				case "loadk2itembyid":
					$k2itemid = JRequest::getCmd('k2itemid');
					$view     = JRequest::getCmd('jutabsview');
					if ($k2itemid)
					{
						$html = self::loadK2Item($k2itemid, $view);
					}
					break;
				case "loadurl":
					$url = JRequest::getVar('url');
					if (trim($url) != '')
					{
						$html = self::loadUrl($url);
					}
					break;
			}

			//Already run relToAbs in self::loadUrl
			//if($action != 'loadurl') {
			//	$html = self::relToAbs($html, JURI::Base());
			//}

			//Parse plugin, we use original JU Tabs plugin param here because of Ajax load, can not detect tab code param
			if ($this->params->get('parseplugin', 'true') == 'true' && $action != 'loadurl')
			{
				$html = JHtml::_('content.prepare', $html);
			}

			echo $html;
			exit();
		}
		else
		{
			//Don't run tab in backend
			$app = JFactory::getApplication();
			if ($app->isAdmin())
			{
				return;
			}

			//Only run tab in html mode
			$document = JFactory::getDocument();
			if ($document->getType() !== 'html' && $document->getType() !== 'feed')
			{
				return;
			}

			//Don't run tab in front-end edit layout
			if (JRequest::getVar('option') == 'com_content' && JRequest::getVar('layout') == 'edit')
			{
				return;
			}

			//Add JS/CSS anchor for replacing
			$document = JFactory::getDocument();
			$document->addScript("JUTABS_ADD_SCRIPT_HERE");
			$document->addScriptDeclaration("JUTABS_ADD_SCRIPT_DECLARATION_HERE");
			$document->addStyleSheet("JUTABS_ADD_STYLESHEET_HERE");
			$document->addStyleDeclaration("JUTABS_ADD_STYLESHEET_DECLARATION_HERE");
		}
	}
}