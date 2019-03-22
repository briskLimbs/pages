<?php

function getPage($id) {
	global $database;
	$database->where('id', $id);
	return $database->getOne('pages');
}