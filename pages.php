<?php

/**
* A BriskLimbs addon to create and manage pages
* @version: 1.0
* @BriskLimbs: 1.0^
* @since: 21st March, 2019
* @author: Saqib Razzaq
* @website: https://github.com/saqirzzq
*/

require 'pages.class.php';
require 'functions.php';
$addons = new Addons();

define('LIMBSPAGES_CORE_PATH', __DIR__);
define('LIMBSPAGES_CORE_NAME', basename(LIMBSPAGES_CORE_PATH));
$pages = LIMBSPAGES_CORE_NAME . '|pages';
$menu = array(
  'limbs_pages' => array(
    'display_name' => 'Pages Manager',
    'sub' => array(
      'Add' => $pages . '|add.php',
      'Manage' => $pages . '|manage.php'
    )
  )
);

$addons->addMenu($menu);
# $addons->addTrigger('LIMBSPAGESScript', 'footer_end');