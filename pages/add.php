<?php

global $limbs;

if (!$users->isAdmin()) {
	jumpTo('home');
}

$pages = new Pages();
$addons = new Addons();

if (isset($_POST['add'])) {
	unset($_POST['add']);
	if ($pages->add($_POST)) {
		$parameters['message'] = sprintf("Page created successfully");
	}
}

if (isset($_GET['edit']) && isset($_POST['update'])) {
	unset($_POST['update']);
	if ($pages->update($_GET['edit'], $_POST)) {
		$parameters['message'] = sprintf("Page updated successfully");
	}
}

$parameters['page'] = isset($_GET['edit']) ? $pages->get($_GET['edit']) : false;
$parameters['update'] = isset($_GET['edit']) ? true : false;
$parameters['mainSection'] = 'limbs_pages';
$parameters['_errors'] = array_merge($addons->errors->collect(), $limbs->errors->collect());
$parameters['_title'] = 'Add Page - Dashboard';
$addons->display(LIMBSPAGES_CORE_NAME, 'pages/add.html', $parameters);