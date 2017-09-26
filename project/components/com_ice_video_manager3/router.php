<?php

/**
 * @version     1.0.0
 * @package     com_ice_video_manager3
 * @copyright   Copyright (C) 2014 SDS International. All rights reserved worldwide.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      SDS International <info@sdsinternational.com> - http://www.sdsinternational.com
 */
// No direct access
defined('_JEXEC') or die;

/**
 * @param	array	A named array
 * @return	array
 */
function Ice_video_manager3BuildRoute(&$query) {
    $segments = array();

    if (isset($query['task'])) {
        $segments[] = implode('/', explode('.', $query['task']));
        unset($query['task']);
    }
    if (isset($query['view'])) {
        $segments[] = $query['view'];
        unset($query['view']);
    }
    if (isset($query['id'])) {
        $segments[] = $query['id'];
        unset($query['id']);
    }

    return $segments;
}

/**
 * @param	array	A named array
 * @param	array
 *
 * Formats:
 *
 * index.php?/ice_video_manager3/task/id/Itemid
 *
 * index.php?/ice_video_manager3/id/Itemid
 */
function Ice_video_manager3ParseRoute($segments) {
    $vars = array();

    // view is always the first element of the array
    $vars['view'] = array_shift($segments);

    while (!empty($segments)) {
        $segment = array_pop($segments);
        if (is_numeric($segment)) {
            $vars['id'] = $segment;
        } else {
            $vars['task'] = $vars['view'] . '.' . $segment;
        }
    }

    return $vars;
}
