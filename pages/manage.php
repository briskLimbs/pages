<?php

global $limbs;

if (!$users->isAdmin()) {
	jumpTo('home');
}

$pages = new Pages();
$addons = new Addons();

if (isset($_GET['deactivate'])) {
	if ($pages->deactivate($_GET['deactivate'])) {
		$parameters['message'] = sprintf("Page %s deactivated successfully", $_GET['deactivate']);
	}
}

if (isset($_GET['activate'])) {
	if ($pages->activate($_GET['activate'])) {
		$parameters['message'] = sprintf("Page %s activated successfully", $_GET['activate']);
	}
}

if (isset($_GET['delete'])) {
	if ($pages->delete($_GET['delete'])) {
		$parameters['message'] = sprintf("Page %s deleted successfully", $_GET['delete']);
	}
}

$list = isset($_GET['list']) ? $_GET['list'] : 'all';
switch ($list) {
	case 'active':
	case 'inactive':
		$listParameters['status'] = $list;
		break;
	
	default:
		break;
}

$size = 10;
$list = isset($_GET['list']) ? $_GET['list'] : 'all';
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $size;
$limit = array($start, $size);

$listParameters = array();
switch ($list) {
	case 'active':
	case 'inactive':
		$listParameters['status'] = $list;
		break;
	
	default:
		break;
}

# pr($listParameters);
$listParameters['sort'] = 'id';
$listParameters['limit'] = $limit;
$results = $pages->list($listParameters);
$totalFound = count($results);
$parameters['total'] = $pages->count($listParameters);
$parameters['results'] = $results;
$parameters['mainSection'] = 'limbs_pages';

$parameters['_errors'] = array_merge($addons->errors->collect(), $limbs->errors->collect());
$parameters['_title'] = 'Pages Manager - Dashboard';
$addons->display(LIMBSPAGES_CORE_NAME, 'pages/manage.html', $parameters);