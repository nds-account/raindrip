<?php
defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
JHtml::_('behavior.caption');
//echo JLayoutHelper::render('joomla.content.categories_default', $this);
//echo $this->loadTemplate('items');
?>
<div class="clear full-width zero-padding">
<div class="left catalog-description" style="padding-top:2px">

{jutabs defaultitem="0" openmultitabs="false" name="resources"}
[tab title="&nbsp;&nbsp;&nbsp;&nbsp;Catalogues&nbsp;&nbsp;&nbsp;&nbsp;"]
<div class="catalog-container">
<?php
// BEGIN LOAD CATALOG CATEGORY
$db = JFactory::getDbo();
$id = 98; // replace for CATALOG categories in RESOURCES
$query = $db->getQuery(true);
$query->select('*');
$query->from('#__newsfeeds');
$query->where('catid="' . $id . '" AND vidtitle="" AND published=1');
$db->setQuery((string) $query);
$res = $db->loadObjectList();
$procuctsCount = count($res);
if ($procuctsCount > 0){
$counter = 0;
foreach ($res as $r){
if ($counter % 2 == 1){$extraClass = ' mleft36 ';}else{$extraClass = ' ';}
$JSONimages = json_decode($r->images);
$imageURL = $JSONimages->image_first;
if ($imageURL == '' or is_null($imageURL)){$imageURL = 'images/empty-raindrip.jpg';}
// GET CATALOG FILE
$fileURL = $JSONimages->image_second;
if ($fileURL == '' or is_null($fileURL)){
$downloadLink = '<span class="not-available"> NOT AVAILABLE </span>';
}else{
$downloadLink = '<a target="_blank" href="/' . $fileURL . '" class="download"> DOWNLOAD </a>';}
echo '<div class="catalog-inner ' . $extraClass . '">
<div class="left"><img src="/' . $imageURL . '" alt="Raindrip" /></div>
<div class="left left18">
<div class="title">' . $r->name . '</div>
' . $downloadLink . '
</div>
</div>';
$counter++;
}
}
?>
</div>
[/tab]
[tab title="&nbsp;&nbsp;&nbsp;&nbsp;Timers&nbsp;&nbsp;&nbsp;&nbsp;"]
<div class="catalog-container">
{jutabs defaultitem="0" widthtabs="90px" position="left" openmultitabs="false"}
[tab title="RDTT20"]
<div class="catalog-container">
<?php
// BEGIN LOAD CATALOG CATEGORY
$db = JFactory::getDbo();
$id = 98; // replace for CATALOG categories in RESOURCES
$mod = "R675CT"; // replace for MODEL name in #__newsfeeds->vidtitle
$query = $db->getQuery(true);
$query->select('*');
$query->from('#__newsfeeds');
$query->where('catid="' . $id . '" AND vidtitle="' . $mod . '" AND published=1');
$db->setQuery((string) $query);
$res = $db->loadObjectList();
$procuctsCount = count($res);
if ($procuctsCount > 0){
$counter = 0;
foreach ($res as $r){
if ($counter % 2 == 1){$extraClass = ' mleft36 ';}else{$extraClass = ' ';}
$JSONimages = json_decode($r->images);
$imageURL = $JSONimages->image_first;
if ($imageURL == '' or is_null($imageURL)){$imageURL = 'images/empty-raindrip.jpg';}
// GET CATALOG FILE
$fileURL = $JSONimages->image_second;
if ($fileURL == '' or is_null($fileURL)){
$downloadLink = '<span class="not-available"> NOT AVAILABLE </span>';
}else{
$downloadLink = '<a target="_blank" href="/' . $fileURL . '" class="download"> DOWNLOAD </a>';}
echo '<div class="catalog-inner ' . $extraClass . '">
<div class="left"><img src="/' . $imageURL . '" alt="Raindrip" /></div>
<div class="left left18">
<div class="title">' . $r->name . '</div>
' . $downloadLink . '
</div>
</div>';
$counter++;
}
}
?>
</div>
[/tab]

{/jutabs}
</div>
[/tab]
[tab title="&nbsp;&nbsp;&nbsp;&nbsp;Videos&nbsp;&nbsp;&nbsp;&nbsp;"]
{jutabs type="accordion" openmultitabs="false"}
[tab title="Smart Watering Made Easy"]
       <?php
        //BEGIN LOAD VIDEOS  CATEGORY
        $db = JFactory::getDbo();
        $id = 99; // replace for VIDEOS categories in RESOURCES
        $ytc = 1; // replace for YOUTUBECHANNEL in DB
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__newsfeeds');
        $query->where('catid="' . $id . '" AND published=1 AND youtubechannel="' . $ytc . '" ORDER BY ordering');
        $db->setQuery((string) $query);
        $res = $db->loadObjectList();
        $procuctsCount = count($res);

        if ($procuctsCount > 0) {

            foreach ($res as $r) {
                echo '<div class="video-container">
                    <div class="inner-container">
					<div class="vidtitle">'. strip_tags($r->vidtitle) .'</div>
					{modal '. $r->link .'?autoplay=1|width=560|height=315}'. $r->image .'{/modal}
                        <!--iframe width="238" height="144" src="' . $r->link . '"  allowfullscreen></iframe-->
                        <div class="title">' . strip_tags($r->description) . '</div>
                    </div>
                </div>';
            }
        }
        ?>
[/tab]
[tab title="Raindrip Watering Kits"]
       <?php
        //BEGIN LOAD VIDEOS  CATEGORY
        $db = JFactory::getDbo();
        $id = 99; // replace for VIDEOS categories in RESOURCES
        $ytc = 2; // replace for YOUTUBECHANNEL in DB
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__newsfeeds');
        $query->where('catid="' . $id . '" AND published=1 AND youtubechannel="' . $ytc . '" ORDER BY ordering');
        $db->setQuery((string) $query);
        $res = $db->loadObjectList();
        $procuctsCount = count($res);

        if ($procuctsCount > 0) {
            foreach ($res as $r) {
                echo '<div class="video-container">
                    <div class="inner-container">
					<div class="vidtitle">'. strip_tags($r->name) .'</div>
					{modal '. $r->link .'?autoplay=1|width=560|height=315}'. $r->image .'{/modal}
                        <!--iframe width="238" height="144" src="' . $r->link . '"  allowfullscreen></iframe-->
                        <div class="title">' . strip_tags($r->description) . '</div>
                    </div>
                </div>';
            }
        }
        ?>
[/tab]
 
[tab title="Programming Raindrip Timer"]
       <?php
        //BEGIN LOAD VIDEOS  CATEGORY
        $db = JFactory::getDbo();
        $id = 99; // replace for VIDEOS categories in RESOURCES
        $ytc = 3; // replace for YOUTUBECHANNEL in DB
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__newsfeeds');
        $query->where('catid="' . $id . '" AND published=1 AND youtubechannel="' . $ytc . '" ORDER BY ordering');
        $db->setQuery((string) $query);
        $res = $db->loadObjectList();
        $procuctsCount = count($res);

        if ($procuctsCount > 0) {

            foreach ($res as $r) {
                echo '<div class="video-container">
                    <div class="inner-container">
				<div class="vidtitle">'. strip_tags($r->name) .'</div>
					{modal '. $r->link .'?autoplay=1|width=560|height=315}'. $r->image .'{/modal}
                        <!--iframe width="238" height="144" src="' . $r->link . '"  allowfullscreen></iframe-->
                        <div class="title">' . strip_tags($r->description) . '</div>
                    </div>
                </div>';
            }
        }
        ?>
[/tab]
[tab title="DIY Drip System Expansion and Additions"]
       <?php
        //BEGIN LOAD VIDEOS  CATEGORY
        $db = JFactory::getDbo();
        $id = 99; // replace for VIDEOS categories in RESOURCES
        $ytc = 4; // replace for YOUTUBECHANNEL in DB
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__newsfeeds');
        $query->where('catid="' . $id . '" AND published=1 AND youtubechannel="' . $ytc . '" ORDER BY ordering');
        $db->setQuery((string) $query);
        $res = $db->loadObjectList();
        $procuctsCount = count($res);

        if ($procuctsCount > 0) {

            foreach ($res as $r) {
                echo '<div class="video-container">
                    <div class="inner-container">
					<div class="vidtitle">'. strip_tags($r->vidtitle) .'</div>
					{modal '. $r->link .'?autoplay=1|width=560|height=315}'. $r->image .'{/modal}
                        <!--iframe width="238" height="144" src="' . $r->link . '"  allowfullscreen></iframe-->
                        <div class="title">' . strip_tags($r->description) . '</div>
                    </div>
                </div>';
            }
        }
        ?>
[/tab]
{/jutabs}
[/tab]
[tab title="&nbsp;&nbsp;&nbsp;&nbsp;FAQs&nbsp;&nbsp;&nbsp;&nbsp;"]
<div class="catalog-container">
{jutabs defaultitem="0" tabscroll="false"}
[tab title="Kits"]
{jutabs defaultitem="0" widthtabs="200px" position="left"}
[tab title="Pot &amp; Hanging Baskets"]
{jutabs loadcontent="sql:SELECT title, introtext AS content FROM #__content WHERE catid=214 ORDER BY ordering" type="accordion"}
{/jutabs}
[/tab]
[tab title="Vegetable Garden"]
{jutabs loadcontent="sql:SELECT title, introtext AS content FROM #__content WHERE catid=215 ORDER BY ordering" type="accordion"}
{/jutabs}
[/tab]
[tab title="Flower, Shrub &amp; Tree"]
{jutabs loadcontent="sql:SELECT title, introtext AS content FROM #__content WHERE catid=216 ORDER BY ordering" type="accordion"}
{/jutabs}
[/tab]
[tab title="Ground Cover &amp; Flower Bed"]
{jutabs loadcontent="sql:SELECT title, introtext AS content FROM #__content WHERE catid=217 ORDER BY ordering" type="accordion"}
{/jutabs}
[/tab]
{/jutabs}
[/tab]
[tab title="Where to Buy"]
{jutabs loadcontent="sql:SELECT title, introtext AS content FROM #__content WHERE catid=210 ORDER BY ordering" type="accordion"}
{/jutabs}
[/tab]
[tab title="Tubing"]
{jutabs loadcontent="sql:SELECT title, introtext AS content FROM #__content WHERE catid=211 ORDER BY ordering" type="accordion"}
{/jutabs}
[/tab]
[tab title="Emitters"]
{jutabs loadcontent="sql:SELECT title, introtext AS content FROM #__content WHERE catid=212 ORDER BY ordering" type="accordion"}
{/jutabs}
[/tab]
[tab title="Fittings"]
{jutabs loadcontent="sql:SELECT title, introtext AS content FROM #__content WHERE catid=213 ORDER BY ordering" type="accordion"}
{/jutabs}
[/tab]
[tab title="Timers"]
{jutabs defaultitem="0" widthtabs="200px" position="left"}
  
[tab title="RDTT20"]
{jutabs loadcontent="sql:SELECT title, introtext AS content FROM #__content WHERE catid=220 ORDER BY ordering" type="accordion"}
{/jutabs}
[/tab]
{/jutabs}
[/tab]
{/jutabs}
</div>
[/tab]

[tab title="&nbsp;&nbsp;&nbsp;&nbsp;Video FAQs&nbsp;&nbsp;&nbsp;&nbsp;"]
<div class="catalog-container">
       <?php
        //BEGIN LOAD VIDEOS  CATEGORY
        $db = JFactory::getDbo();
        $id = 99; // replace for VIDEOS categories in RESOURCES
        $ytc = 61; // replace for YOUTUBECHANNEL in DB
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__newsfeeds');
        $query->where('catid="' . $id . '" AND published=1 AND youtubechannel="' . $ytc . '" ORDER BY ordering');
        $db->setQuery((string) $query);
        $res = $db->loadObjectList();
        $procuctsCount = count($res);

        if ($procuctsCount > 0){
$counter = 0;
            foreach ($res as $r) {
				
                echo '<div class="video-container">
                    <div class="inner-container">
					<div class="vidtitle">'. strip_tags($r->vidtitle) .'</div>
					{modal '. $r->link .'?autoplay=1|width=560|height=315}'. $r->image .'{/modal}
                        <!--iframe width="238" height="144" src="' . $r->link . '"  allowfullscreen></iframe-->
                        <div class="title">' . strip_tags($r->description) . '</div>
                    </div>
                </div>';
			$counter++;
if ($counter == 3){echo '<div style="clear:both; height: 0px; margin: 0px; padding: 0px;"></div>'; $counter = 0;}
            }
        }
        ?>
</div>
[/tab]

{/jutabs}
</div>
</div>
<style type="text/css">
.jutabs-item {
    float: left;
    width: 100%;
}
</style>