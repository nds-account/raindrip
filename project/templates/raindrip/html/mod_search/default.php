<?php
defined('_JEXEC') or die;
?>
<div id="top-search">
    <form action="<?php echo JRoute::_('index.php'); ?>" method="post" class="form-inline" name="form" id="form">

        <input name="searchword" id="searchword" class="input-big" type="text"  placeholder="Search" value="<?php echo $text; ?>" <?php echo 'onblur="if (this.value==\'\') this.value=\'' . $text . '\';" onfocus="if (this.value==\'' . $text . '\') this.value=\'\';"'; ?> />
<!--        <div class="glass-outer" onclick="form.submit();"> <div class="magnifying-glass"> </div> </div>-->
	      <input type="submit" class="glass-outer" value="" target="_blank" />
        <input type="hidden" name="task" value="search" />
        <input type="hidden" name="option" value="com_search" />
        <input type="hidden" name="Itemid" value="<?php echo $mitemid; ?>" />
    </form>
</div>