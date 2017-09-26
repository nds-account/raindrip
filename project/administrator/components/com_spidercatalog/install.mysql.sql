CREATE TABLE IF NOT EXISTS `#__spidercatalog_params`(
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `title` varchar(200) CHARACTER SET utf8 NOT NULL,
 `description` text CHARACTER SET utf8 NOT NULL,
  `value` varchar(200) CHARACTER SET utf8 NOT NULL,
  
 PRIMARY KEY (`id`)
 
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=89 ;


CREATE TABLE IF NOT EXISTS `#__spidercatalog_products` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
 `category_id` varchar(200) ,
 `description` text,
  `image_url` varchar(2000) DEFAULT NULL,
  `cost` decimal(11,2) unsigned DEFAULT NULL,
  `market_cost` decimal(11,2) unsigned DEFAULT NULL,
  `param` text,
  `ordering` int(11) NOT NULL,
  `published` tinyint(4) unsigned DEFAULT NULL,
  `published_in_parent` tinyint(4) unsigned DEFAULT NULL,

  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)

) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;


CREATE TABLE IF NOT EXISTS `#__spidercatalog_product_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,  
  `parent` int(11) unsigned DEFAULT NULL,
  `category_image_url` varchar(2000) NOT NULL,
  `description` text,
  `param` text,
  `ordering` int(11) NOT NULL,
  `published` tinyint(4) unsigned DEFAULT NULL,
  
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
  
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


CREATE TABLE IF NOT EXISTS `#__spidercatalog_product_reviews` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int(11) NOT NULL,
  `remote_ip` varchar(15) NOT NULL,
  
  PRIMARY KEY (`id`)

) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;

CREATE TABLE IF NOT EXISTS `#__spidercatalog_id` (
  `id1` int(11)  NOT NULL AUTO_INCREMENT,
  `proid` int(11) NOT NULL,
   `cateid` int(11) NOT NULL,
  
  PRIMARY KEY (`id1`)

) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;


CREATE TABLE IF NOT EXISTS `#__spidercatalog_product_votes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `remote_ip` varchar(15) NOT NULL,
  `vote_value` int(3) NOT NULL,
  `product_id` int(11) NOT NULL,
  
  PRIMARY KEY (`id`)

) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;

INSERT INTO `#__spidercatalog_params` (`id`, `name`, `title`, `description`, `value`) VALUES
(1, 'market_price', 'Market Price', 'Show or hide market Price', '1'),
(5, 'currency_symbol_position', 'Currency Symbol Position', 'Currency Symbol Position (after or before number )', '0'),
(15, 'params_background_color1', 'Parameters Background color 1', 'Background Color of odd parameters', 'F4F2F2'),
(9, 'currency_symbol', 'Currency Symbol', 'Currency Symbol', '$'),
(10, 'enable_rating', 'Enable/Disable Product Ratings', 'Enable/Disable Product Ratings', '1'),
(11, 'enable_review', 'Enable/Disable Customer Reviews', 'Enable/Disable Customer Reviews', '1'),
(16, 'params_background_color2', 'Parameters Background color 2', 'Background Color of odd parameters', 'F4F2F2'),
(17, 'parameters_select_box_width', 'Parameters Select Box Width', 'Parameters Select Box Width', '104'),
(18, 'background_color', 'Background color', 'Background color', 'f5f5f5'),
(19, 'border_style', 'Border Style', 'Border Style', 'ridge'),
(20, 'border_width', 'Border Width', 'Border Width', '0'),
(21, 'border_color', 'Border Color', 'Border Color', '00AEEF'),
(22, 'text_color', 'Text Color', 'Text Color', '636363'),
(23, 'params_color', 'Color of Parameter Values', 'Color of Parameter Values', '2F699E'),
(24, 'hyperlink_color', 'Hyperlink Color', 'Hyperlink Color', '000000'),
(25, 'price_color', 'Price Color', 'Price Color', 'FFFFFF'),
(26, 'title_color', 'Title Color', 'Title Color', '004372'),
(27, 'title_background_color', 'Title Background color', 'Title Background color', 'FFFFFF'),
(28, 'button_color', 'Buttons Text color', 'Color of text of buttons', 'FFFFFF'),
(29, 'button_background_color', 'Buttons Background color', 'Background Color of buttons', '00AEEF'),
(30, 'rating_star', 'Rating Star Design', 'Rating Star Design', '3'),
(31, 'count_of_product_in_the_row', 'Count of Products in the Row', 'Count of Products in the Row', '2'),
(32, 'count_of_rows_in_the_page', 'Count of Rows in the Page', 'Count of Rows in the Page', '3'),
(33, 'product_cell_width', 'Product Cell Width', 'Product Cell Width', '290'),
(34, 'product_cell_height', 'Product Cell Height', 'Product Cell Height', '665'),
(35, 'small_picture_width', 'Picture Width', 'Picture Width', '210'),
(36, 'small_picture_height', 'Picture Height', 'Picture Height', '140'),
(37, 'text_size_small', 'Text Size', 'Text Size', ''),
(38, 'price_size_small', 'Price Size', 'Price Size', '20'),
(39, 'title_size_small', 'Title Size', 'Title Size', '16'),
(40, 'large_picture_width', 'Picture Width', 'Picture Width', '300'),
(41, 'large_picture_height', 'Picture Height', 'Picture Height', '200'),
(42, 'text_size_big', 'Text Size', 'Text Size', ''),
(43, 'price_size_big', 'Price Size', 'Price Size', '20'),
(44, 'title_size_big', 'Title Size', 'Title Size', '16'),
(45, 'review_background_color', 'Background Color of ''Add your review here'' block', 'Background Color of ''Add your review here'' block', 'F4F4F4'),
(46, 'review_color', 'Color of Review Texts', 'Color of Review Texts', '2F699E'),
(47, 'review_author_background_color', 'Background Color of Review Author block', 'Background Color of Review Author block', 'C9EFFE'),
(48, 'review_text_background_color', 'Background Color of Author block', 'Background Color of Review text', 'EFF9FD'),
(49, 'reviews_perpage', 'Number of reviews per page', 'Number of reviews per page', '10'),
(70, 'choose_category', 'Choose category', 'Search product on frontend by category', '1'),
(71, 'price', 'Price', 'Show or hide Price', '1'),
(73, 'search_by_name', 'Search by name', 'Search product on frontend by name', '1'),
(74, 'list_picture_width', 'Picture Width', 'Picture Width', '100'),
(75, 'list_picture_height', 'Picture Height', 'Picture Height', '100'),
(76, 'count_of_products_in_the_page', 'Count of Products in the page', 'Count of Products in the page', '10'),
(77, 'category_picture_height', 'Category picture height', 'Category picture height', '200'),
(78, 'category_picture_width', 'Category picture width', 'Category picture width', '300'),
(79, 'text_size_list', 'List text size', 'List text size', '14'),
(80, 'price_size_list', 'List price size', 'List price size', '18'),
(81, 'cell_show_category', 'Show Category', 'Show Category', '1'),
(82, 'list_show_category', 'Show Category', 'Show Category', '1'),
(83, 'cell_show_parameters', 'Show Parameters', 'Show Parameters', '1'),
(84, 'list_show_parameters', 'Show Parameters', 'Show Parameters', '1'),
(85, 'category_title_size', 'Category title size', 'Category title size', '22'),
(87, 'rounded_corners', 'Rounded Corners', 'Rounded Corners', '1'),
(88, 'list_show_description', 'Show Description', 'Show Description', '1'),
(89, 'width_spider_main_table_lists', 'Product List  Width', 'Product List  Width', '620'),
(90, 'category_details_width', 'Category Details Width', 'Category Details Width', '600'),
(91, 'spider_catalog_product_page_width', 'Product Page Width', 'Product Page Width', '600'),
(92, 'description_size_list', 'Description Text Size', 'Description Text Size', '12'),
(93, 'name_price_size_list', 'Name Price List Text Size', 'Name Price List Text Size', '12'),
(94, 'Parameters_size_list', 'Parameters List Text Size', 'Parameters List Text Size', '12'),
(95, 'cell_crop_image', 'Save proportions', 'Save proportions', '0'),
(96, 'list_crop_image', 'Save proportions', 'Save proportions', '0'),
(97, 'cell_big_title_size', 'Cell Big Title Size', 'Cell Big Title Size', '24'),
(98, 'cell_price_background_color', 'Cell Price Background Color', 'Cell Price Background Color', '004372'),
(99, 'cell_small_image_backround_color', 'Cell Small Image Backround Color', 'Cell Small Image Backround Color', 'DDDBDB'),
(100, 'cell_parameters_left_size', 'Cell Parameters Left Size', 'Cell Parameters Left Size', '13'),
(101, 'cell_more_font_size', 'Cell More Font size', 'Cell More Font size', '15'),
(102, 'cell_more_font_color', 'Cell More Font Color', 'Cell More Font Color', 'FFFFFF'),
(103, 'cell_more_background_color', 'Cell More Background Color', 'Cell More Background Color', '004372'),
(104, 'cell_params_text_color', 'Cell Params Text Color', 'Cell Params Text Color', '3E3E3E'),
(105, 'product_back_add_your_review_here', 'Product back Add your review here', 'Product back Add your review here', '004372'),
(106, 'product_big_title_size', 'Product Big Title Size', 'Product Big Title Size', '28'),
(107, 'product_price_background_color', 'Product Price Background color', 'Product Price Background color', '004372'),
(108, 'cell_new_big_title_size', 'Cell New Big Title Size', 'Cell New Big Title Size', '20'),
(109, 'cell_new_title_size', 'Cell New Title Size', 'Cell New Title Size', '10'),
(110, 'cell_new_price_size', 'Cell New Price Size', 'Cell New Price Size', '20'),
(111, 'cell_new_market_price_size', 'Cell New Market Price Size', 'Cell New Market Price Size', '12'),
(112, 'cell_new_picture_width', 'Cell New Picture Width', 'Cell New Picture Width', '110'),
(113, 'cell_new_picture_height', 'Cell New Picture Height', 'Cell New Picture Height', '95'),
(114, 'cell_new_title_color', 'Cell New Title Color', 'Cell New Title Color', '004372'),
(115, 'new_cell_all_width', 'New Cell Width', 'New Cell Width', '290'),
(116, 'new_cell_all_height', 'New Cell All Height', 'New Cell All Height', '550'),
(117, 'cell_new_text_size', 'Cell New Text Size', 'Cell New Text Size', '12'),
(118, 'cell_new_text_back_color_1', 'Cell New Text Background Color 1', 'Cell New Text Background Color 1', 'F6F6F6'),
(119, 'cell_new_text_back_color_2', 'Cell New Text Background Color 2', 'Cell New Text Background Color 2', 'F0EDED'),
(120, 'cell_new_text_color', 'Cell New Text Color', 'Cell New Text Color', '3D3D3D'),
(121, 'new_cell_more_font_size', 'New Cell More Font Size', 'New Cell More Font Size', '17'),
(122, 'cell_new_more_font_color', 'More Font Color', 'More Font Color', 'FFFFFF'),
(123, 'cell_new_more_background_color', 'More Background Color', 'More Background Color', '004372'),
(124, 'cell_tumble_title_size', 'Title Size', 'Title Size', '10'),
(125, 'cell_tumble_title_font_color', 'Title Font Color', 'Title Font Color', '004372'),
(126, 'cell_tumble_price_size', 'Price Size', 'Price Size', '14'),
(127, 'cell_tumble_price_text_color', 'Price Text Color', 'Price Text Color', 'FFFFFF'),
(128, 'cell_tumble_picture_width', 'Picture Width', 'Picture Width', '120'),
(129, 'cell_tumble_picture_height', 'Picture Height', 'Picture Height', '120'),
(130, 'cell_tumble_text_size', 'Text Size', 'Text Size', '10'),
(131, 'cell_tumble_text_color', 'Text Color', 'Text Color', '434242'),
(132, 'cell_tumble_all_width', 'All Width', 'All Width', '290'),
(133, 'cell_tumble_all_height', 'All Height', 'All Height', '225'),
(134, 'all_cell_title_size', 'Title Size', 'Title Sizes', '12'),
(135, 'all_cell_title_color', 'Title Color', 'Title Color', '004372'),
(136, 'all_cell_price_size', 'Price Size', 'Price Size', '13'),
(137, 'all_cell_price_text_color', 'Price Text Color', 'Price Text Color', 'FFFFFF'),
(138, 'all_cell_picture_width', 'Picture Width', 'Picture Width', '285'),
(139, 'all_cell_picture_height', 'Picture Height', 'Picture Height', '200'),
(140, 'all_cell_text_size', 'Text Size', 'Text Size', '10'),
(141, 'all_cell_text_color', 'Text Color', 'Text Color', '434242'),
(142, 'all_cell_all_width', 'All Width', 'All Width', '290'),
(143, 'all_cell_all_height', 'All Height', 'All Height', '420'),
(144, 'single_cell_title_size', 'Title Size', 'Title Size', '16'),
(145, 'single_cell_title_color', 'Title Color', 'Title Color', '004372'),
(146, 'single_cell_font_1_size', 'Font 1 Size', 'Font 1 Size', '10'),
(147, 'single_cell_font_2_size', 'Font 2 Size', 'Font 2 Size', '10'),
(148, 'single_cell_background_color_1', 'Background Color 1', 'Background Color 1', 'F5F4F4'),
(149, 'single_cell_background_color_2', 'Background Color 2', 'Background Color 2', 'FFFFFF'),
(150, 'single_cell_text_color_1', 'Text Color 1', 'Text Color 1', '004372'),
(151, 'single_cell_text_color_2', 'Text Color 2', 'Text Color 2', '636363'),
(152, 'single_cell_picture_width', 'Picture Width', 'Picture Width', '215'),
(153, 'single_cell_picture_height', 'Picture Height', 'Picture Height', '200'),
(154, 'list_page_up_names_text_color', 'List Page Up Names Text Color', 'List Page Up Names Text Color', '3D3D3D'),
(155, 'list_page_up_names_background_color', 'List Page Up names Background Color', 'List Page Up names Background Color', 'E2E2E2'),
(156, 'list_page_background_color_1', 'List Page Background Color 1', 'List Page Background Color 1', 'F6F6F6'),
(157, 'list_page_background_color_2', 'List Page Background Color 2', 'List Page Background Color 2', 'FFFFFF'),
(158, 'list_cell_price_color', 'List Cell Price Color', 'List Cell Price Color', 'B02E2E'),
(159, 'list_cell_market_price_color', 'List Cell Market Price Color', 'List Cell Market Price Color', '3C6680'),
(160, 'list_page_text_color_1', 'Text Color 1', 'Text Color 1', '3E3E3E'),
(161, 'list_page_text_color_2', 'Text Color 2', 'Text Color 2', '235775'),
(162, 'search_icon_color', 'Search Icon Color', 'Search Icon Color', '004372'),
(163, 'reset_icon_color', 'Reset Icon Color', 'Reset Icon Color', '004372'),
(164, 'select_icon_color', 'Select icon color', 'Select icon color', '004372'),
(165, 'global_revers', 'Global Revers', 'Global Revers', '0');


INSERT INTO `#__spidercatalog_products` (`id`, `name`, `category_id`, `description`, `image_url`, `cost`, `market_cost`, `param`, `ordering`, `published`, `published_in_parent`) VALUES
(1, 'Panasonic Television TX-PR50U30', '1,', '<p>50&quot; / 127 cm, Full-HD Plasma Display Panel, 600 Hz Sub Field Drive , DVB-T, DVB-C, RCA, RGB, VGA, HDMI x2, Scart, SD card</p>', 'media/com_spidercatalog/upload/7_19977_1324390185.jpg;media/com_spidercatalog/upload/11448_2.jpg;media/com_spidercatalog/upload/panasonictx-pr50u30.jpg;;', '950.00', '1000.00', 'par_TV System@@:@@DVB-T	DVB-C		par_Diagonal@@:@@50&quot; / 127 cm		par_Interface@@:@@RCA, RGB, VGA, HDMI x2, Scart, SD card		par_Refresh Rate@@:@@600 Hz Sub Field Drive		', 2, 1, 0),
(2, 'Sony KDL-46EX710AEP ', '1,', '<p><b>Sony Television KDL-46EX710AEP</b></p><p>46&quot; / 117 cm, MotionFlow 100Hz, Bravia Engine 3, Analog, DVB-T, DVB-C, 4xHDMI, VGA, RGB, RCA, USB, 2xSCART </p>', 'media/com_spidercatalog/upload/7_7557_1298400832.jpg;media/com_spidercatalog/upload/r1.jpg;media/com_spidercatalog/upload/sony-kdl32ex700aep-3.jpg;;', '1450.00', '1700.00', 'par_TV System@@:@@Analog	DVB-T	DVB-C		par_Diagonal@@:@@46&quot; / 117 cm		par_Interface@@:@@4xHDMI, VGA, RGB, RCA, USB, 2xSCART		par_Refresh Rate@@:@@MotionFlow 100Hz		', 1, 1, 0),
(3, 'Samsung UE46D6100S', '1,', '<p><strong>Samsung Television UE46D6100S </strong></p><p>46&quot; / 117 cm, 200Hz , 6 Series, 3D, SMART TV ,Smarthub, 3D HyperReal Engine, Samsung Apps, Social TV, WiFi Ready</p>', 'media/com_spidercatalog/upload/7_20107_1324712747.jpg;;', '1630.00', '1900.00', 'par_TV System@@:@@DTV DVB-T/C		par_Diagonal@@:@@46&quot; / 117 cm		par_Interface@@:@@4xHDMI,3xUSB, RGB, RCA, D-SUB,1xSCART, Ethernet (LAN)		par_Refresh Rate@@:@@200Hz		', 3, 1, 0),
(4, 'Sony KDL-32EX421BAEP ', '1,', '<p><strong>Sony Television KDL-32EX421BAEP </strong></p><p>32&quot; / 80 cm, 50 Hz, Analog, DVB-T/T2/C, AV, SCART, RGB, VGA, HDMI x4, USB x2, Ethernet (RJ-45),24p True Cinema, X-Reality, DLNA, WiFi Ready, Internet Video, Internet Widgets, Web Browser, Skype, USB HDD Recording</p>', 'media/com_spidercatalog/upload/7_19644_1323935170.jpg;;', '950.00', '0.00', 'par_TV System@@:@@	par_Diagonal@@:@@32&quot; / 80 cm		par_Interface@@:@@AV, VGA, HDMI, USB, Ethernet 		par_Refresh Rate@@:@@	', 4, 1, 0);


INSERT INTO `#__spidercatalog_product_categories` (`id`, `name`, `parent`, `category_image_url`, `description`, `param`, `ordering`, `published`) VALUES
(1, 'Televisions', 0, 'media/com_spidercatalog/upload/category242.jpg;;', 'Television (TV) is a telecommunication medium for transmitting and receiving moving images that can be monochrome (black-and-white) or colored, with or without accompanying sound. &quot;Television&quot; may also refer specifically to a television set, television programming, or television transmission.The etymology of the word has a mixed Latin and Greek origin, meaning &quot;far sight&quot;: Greek tele, far, and Latin visio, sight (from video, vis- to see, or to view in the first person).', 'TV System	Diagonal	Interface	Refresh Rate	', 1, 1);


INSERT INTO `#__spidercatalog_product_reviews` (`id`, `name`, `content`, `product_id`, `remote_ip`) VALUES
(2, 'A Customer', 'A Good TV', 1, '127.0.0.1');


INSERT INTO `#__spidercatalog_product_votes` (`id`, `remote_ip`, `vote_value`, `product_id`) VALUES
(6, '127.0.0.1', 4, 1),
(7, '127.0.0.1', 5, 2);

INSERT INTO `#__spidercatalog_id` (`proid`, `cateid`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1);