<?php
/**
 * @package      ITPGoogleSearch
 * @subpackage   Modules
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2014 Todor Iliev <todor.iliev@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
 
defined('_JEXEC') or die; ?>
<script>
	function formsubmitnow(){
		document.getElementById("itpform").submit();
	}
</script>
<div id="top-search">
	<form action="<?php echo JRoute::_('index.php?option=com_itpgooglesearch&view=search'); ?>" method="get" accept-charset="utf-8" id="itpform">
        <input name="gsquery" id="searchword" class="input-big" type="text" placeholder="Search" value="Search..." onblur="if (this.value=='') this.value='Search...';" onfocus="if (this.value=='Search...') this.value='';" />
        <div class="glass-outer" onclick="javascript:formsubmitnow()"> <div class="magnifying-glass"> </div> </div>
        <input type="hidden" name="Itemid" value="552">
    </form>
</div>