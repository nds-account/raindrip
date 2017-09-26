<?php
/**
 * @package      ITPGoogleSearch 
 * @subpackage   Components
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2014 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Method to build Route
 * 
 * @param array $query
 *
 * @return string
 */
function ITPGoogleSearchBuildRoute(&$query){
    
    $segments = array();
    
    // get a menu item based on Itemid or currently active
    $app = JFactory::getApplication();
    $menu = $app->getMenu();
    /* @var $menu JMenu */
    
    // we need a menu item.  Either the one specified in the query, or the current active one if none specified
    if(empty($query['Itemid'])){
        $menuItem = $menu->getActive();
    }else{
        $menuItem = $menu->getItem($query['Itemid']);
    }

    if(isset($query['view'])){
        if(empty($query['Itemid'])){
            $attritubes = array("component");
            $values = array("com_itpgooglesearch");
            $menuItems = $menu->getItems($attritubes, $values );
            
            if(!empty($menuItems)) {
                
                foreach ($menuItems as $menuItem) {
                    if(
                    (strcmp("com_itpgooglesearch",$menuItem->query['option']) == 0 ) 
                    AND 
                    (strcmp("search",$menuItem->query['view']) == 0)){
                        break;
                    } else {
                        $menuItem = null;
                    }
                }
                if(!is_null($menuItem)) {
                    $query['Itemid'] = $menuItem->id;
                }

            } else {
                $segments[] = $query['view'];
            }
        }
        
        unset($query['view']);
        
    }
    
    return $segments;
}

/**
 * Method to parse Route.
 *
 * @param array $segments
 *
 * @return array
 */
function ITPGoogleSearchParseRoute($segments){
    
    $vars = array();
    
    //Get the active menu item.
    $app        = JFactory::getApplication();
    $menu       = $app->getMenu();
    $menuItem   = $menu->getActive();
    
    if(!isset($menuItem)) {
        $vars['view']   = $segments[0];
        return $vars;
    } 
    
    return $vars;
}