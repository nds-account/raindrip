<div class="clear full-width zero-padding">

    <?php
    defined('_JEXEC') or die;
    JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

    JHtml::_('behavior.caption');
    JHtml::_('formbehavior.chosen', 'select');

    $pageClass = $this->params->get('pageclass_sfx');
    $idCategory = $this->category->id;

    $idParent = $this->category->parent_id;

    if ($idCategory == 98) {
        // CATALOG
        // BEGIN LOAD CATALOG CATEGORY
        $db = JFactory::getDbo();
        $id = 98; // replace for CATALOG categories in RESOURCES
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__newsfeeds');
        $query->where('catid="' . $id . '"');
        $db->setQuery((string) $query);
        $res = $db->loadObjectList();
        $procuctsCount = count($res);


        if ($procuctsCount > 0) {
            $counter = 0;

            echo '<div class="left catalog-description" >
                        <h1 class="secondary-headline" id="catalogs">Catalogs</h1>
                            <div class="catalog-container">';
            foreach ($res as $r) {

                if ($counter % 2 == 1) {
                    $extraClass = ' mleft36 ';
                } else {
                    $extraClass = ' ';
                }

                $JSONimages = json_decode($r->images);
                $imageURL = $JSONimages->image_first;
                if ($imageURL == '' or is_null($imageURL)) {
                    $imageURL = 'images/empty-raindrip.jpg';
                }

                // GET CATALOG FILE
                $fileURL = $JSONimages->image_second;
                if ($fileURL == '' or is_null($fileURL)) {
                    $downloadLink = '<span class="not-available"> NOT AVAILABLE </span>';
                } else {
                    $downloadLink = '<a target="_blank" href="/' . $fileURL . '" class="download"> DOWNLOAD </a>';
                }

                echo '<div class="catalog-inner ' . $extraClass . '">
                            <div class="left"><img src="/' . $imageURL . '" alt="Raindrip" /></div>
                            <div class="left left18">

                                <div class="title">' . $r->name . '</div>
                                ' . $downloadLink . '
                            </div>
                        </div>';

                $counter++;
            }

            echo '</div>
                    </div>
               </div>';
        }
    } elseif ($idCategory == 99) {
        // VIDEOS

        $db = JFactory::getDbo();
        $id = 99; // replace for VIDEOS categories in RESOURCES
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__newsfeeds');
        $query->where('catid="' . $id . '"');
        $db->setQuery((string) $query);
        $res = $db->loadObjectList();
        $procuctsCount = count($res);


        if ($procuctsCount > 0) {

            echo '<div class="left lone-resources-content" >
                        <h1 class="secondary-headline clear second-title" id="videos">Videos</h1>';
            foreach ($res as $r) {

                echo '<div class="video-container">
                    <div class="inner-container">
                        <iframe width="238" height="144" src="' . $r->link . '"  allowfullscreen></iframe>
                        <div class="title">' . strip_tags($r->description) . '</div>
                    </div>
                </div>';
            }

            echo '</div>
                    </div>';
        }
    } elseif ($idCategory == 100) {
        // FAQ
        $dbChildren = JFactory::getDbo();
        $idChildren = $idCategory; // FAQ CATEGORY (100)

        $queryChildren = $dbChildren->getQuery(true);
        $queryChildren->select('*');
        $queryChildren->from('#__categories');
        $queryChildren->where('parent_id="' . $idChildren . '"');

        $dbChildren->setQuery((string) $queryChildren);
        $resChildren = $dbChildren->loadObjectList();

        $childrenCount = count($resChildren);

        if ($childrenCount > 0) {

            echo '<div class="left lone-resources-content"  >
                <div class="secondary-headline clear second-title" id="faq">Frequently Asked Questions</div>
                    <div class="faq-container">';
            foreach ($resChildren as $childrenCategory) {

                echo '<div class="product-faq clear" id="' . $childrenCategory->title . '" >' . $childrenCategory->title . '</div>
                        <ul class="faq-ul">';

                $idThisCategorry = $childrenCategory->id;

                // LOAD FAQS ELEMENTS
                $db = JFactory::getDbo();
                $query = $db->getQuery(true);
                $query->select('*');
                $query->from('#__newsfeeds');
                $query->where('catid="' . $idThisCategorry . '"');
                $db->setQuery((string) $query);
                $res = $db->loadObjectList();
                $procuctsCount = count($res);

                if ($procuctsCount > 0) {

                    foreach ($res as $r) {

                        echo '<li class="collapsed faqlist-item" data-id="' . $r->id . '">
                                    <span>' . $r->name . '</span>
                                    <div class="separator-faq" style="display:none" id="separator-' . $r->id . '"> </div>
                                    <p class="inner-faq" style="display:none" id="paragraph-' . $r->id . '">
                                        ' . strip_tags($r->description) . '
                                    </p>
                                 </li>';
                    }
                }

                echo '</ul>';
            }
            echo '<div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        // FAQ SUBCATEGORIES
        if ($idParent == 100) {

            // LOAD FAQS ELEMENTS
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('*');
            $query->from('#__newsfeeds');
            $query->where('catid="' . $idCategory . '"');
            $db->setQuery((string) $query);
            $res = $db->loadObjectList();
            $procuctsCount = count($res);


            echo '<div class="left lone-resources-content" >
                <h1 class="secondary-headline clear second-title">Frequently Asked Questions</h1>
                    <div class="faq-container">';

            echo '<h2 class="product-faq clear">' . $this->category->title . '</h2>
                        <ul class="faq-ul">';



            if ($procuctsCount > 0) {

                foreach ($res as $r) {

                    echo '<li class="collapsed faqlist-item" data-id="' . $r->id . '">
                                    <span>' . $r->name . '</span>
                                    <div class="separator-faq" style="display:none" id="separator-' . $r->id . '"> </div>
                                    <p class="inner-faq" style="display:none" id="paragraph-' . $r->id . '">
                                        ' . strip_tags($r->description) . '
                                    </p>
                                 </li>';
                }
            }

            echo '</ul>';


            echo '<div>';
            echo '</div>';
            echo '</div>';
        }
    }
    ?>

</div>


</div>