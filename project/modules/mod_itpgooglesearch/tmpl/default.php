<?php
/**
 * @package      ITPGoogleSearch
 * @subpackage   Modules
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2014 Todor Iliev <todor.iliev@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
 
defined('_JEXEC') or die; ?>
<div class="itp-gs<?php echo $moduleclass_sfx;?>">
	<form action="<?php echo JRoute::_('index.php?option=com_itpgooglesearch&view=search'); ?>" method="get" accept-charset="utf-8">
        <input name="gsquery" type="text" class="inputbox" placeholder="<?php echo JText::_("MOD_ITPGOOGLESEARCH_SEARCH_FOR"); ?>" value="<?php echo $phrase; ?>" />
        <?php if($params->get("searchButton")) {?>
        <input type="submit" class="btn" value="<?php echo JText::_("MOD_ITPGOOGLESEARCH_SEARCH"); ?>" />
        <?php }?>
    </form>
</div>