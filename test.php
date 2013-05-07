<?php
include 'includes/functions.php';

/* Add Widgets */

// registerWidgets();

/* Register Widgets */

debug(getWidgets(), 'Register Widgets');

/* Available Widgets */

// $widgets = getDB()
// 				->options
// 				->where('option_name LIKE ?', '%widget%')
// 				->where('option_name != ?', 'register_widgets');
// $availableWidgets = array();
// foreach($widgets as $widget){
// 	$indentity = array(
// 		'id' => $widget['option_id'],
// 		'name' => $widget['option_name']
// 	);
// 	$availableWidgets[$widget['option_name']] = array_merge(unserialize($widget['option_value']), $indentity);
// }
$availableWidgets = getAvailableWidgets();
debug($availableWidgets, 'Available Widgets');

/* Add Data Widgets */

$replacements = array(
	'data' => array(
		1 => array(
			'title' => 'test title 1',
			'count' => 5
		)
	)
);
$widgets = array_merge_recursive($availableWidgets['widget_social'], $replacements);
debug($widgets, 'Add Widget');

/* Add Multi Data Widgets */

$replacements2 = array(
	'data' => array(
		array(
			'title' => 'test title 2',
			'count' => 5
		)
	)
);
$widgets = array_merge_recursive( $widgets, $replacements2 );
debug($widgets, 'Add Widget Multi');

/* Update Data Widgets */

$index = 2;
if( $widgets['data'][$index] )
{
	$replacements = array(
		$index => array(
			'title' => 'test title 8',
			'count' => 10
		)
	);
	$replace = array_replace( $widgets['data'], $replacements );
	debug($replace, 'Update Widget');
}

/* Remove Data Widgets */

$index = 1;
if( $widgets['data'][$index] )
{
	$count = count($widgets['data']);
	if( $count == 1 )
		unset($widgets['data']);
	else 
		unset($widgets['data'][$index]);
	
	debug($widgets, 'Remove Widget');
}