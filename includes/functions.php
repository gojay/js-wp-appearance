<?php
include 'config.php';
include 'NotORM/NotORM.php';

function debug( $data, $title = 'debug' )
{
    echo '<h2>'. $title .'</h2><pre>'. print_r($data, 1).'</pre>';
}

if( !function_exists(array_replace) ) 
{
	function array_replace( )
	{
		$numArgs = func_num_args();
	    $argList = func_get_args();

	    if( $numArgs == 1 ){ return $argList[0]; }
	    $toBeReplacedArray = $argList[0];
		
		if( !function_exists( 'array_replace' ) )
	    {
	        for( $i = 1; $i < $numArgs ; $i++ ){
	            foreach( $argList[$i] as $key => $value ){
	                $toBeReplacedArray[$key] = $value;
	            }
	        }
	    } else {
	        //normal Flux array_replace()
	        for( $i = 1; $i < $numArgs ; $i++ ){
	            $toBeReplacedArray = array_replace( $toBeReplacedArray, $argList[$i] );
	        }
	    }
		return $toBeReplacedArray;
	}
}

function getDB()
{
	global $db;

	$dsn = sprintf("mysql:host=%s;dbname=%s", $db['host'], $db['name']);
	$pdo = new PDO($dsn, $db['user'], $db['pass']);  
	$library = new NotORM($pdo, new NotORM_Structure_Convention(
	    $primary = "%s_id", // id_$table
	    $foreign = "%s_id", // id_$table
	    $table   = "%ss" 	// {$table}s
	));

	return $library;
}

function registerWidgets()
{
	$widget_data = array(
		'widget_menus' => array(
			'title'	  	 => 'Custom Menu',
			'description'=> 'Use this widget to add one of your custom menus as a widget.',
			'action' 	 => 'menu',
			'attrbs'	 => array(
				'element' => 'select',
				'type' => 'getMenus'
			)
		),
		'widget_search' => array(
			'title'	  	 => 'Search Site',
			'description'=> 'A search form for your site',
			'action' 	 => 'search',
			'attrbs'	 => array()
		),
		'widget_feed' => array(
			'title'	  	 => 'Feeds',
			'description'=> 'Entries from any RSS or Atom feed ',
			'action' 	 => 'feed',
			'attrbs'	 => array()
		),
		'widget_category' => array(
			'title'	  	 => 'Category',
			'description'=> 'A list of categories',
			'action' 	 => 'category',
			'attrbs'	 => array()
		),
		'widget_post' => array(
			'title'	  	 => 'Recent Posts',
			'description'=> 'The most recent posts on your site',
			'action' 	 => 'post',
			'attrbs'	 => array(
				'element' => 'text',
				'type' => 'count'
			)
		),
		'widget_social' => array(
			'title'	  	 => 'Social',
			'description'=> 'Use this widget to add social as a widget.',
			'action' 	 => 'social',
			'attrbs'	 => array()
		),
		'widget_text' => array(
			'title'	  	 => 'Text',
			'description'=> 'Arbitrary text or HTML .',
			'action' 	 => 'text',
			'attrbs'	 => array(
				'element' => 'textarea',
				'type' => 'text'
			)
		),
		'register_widgets' => array(
			'widget_sidebar_left' => array(),
			'widget_sidebar_right' => array(),
			'widget_footer_left_1' => array(),
			'widget_footer_left_2' => array(),
			'widget_footer_right_1' => array(),
			'widget_footer_right_2' => array()
		)		
	);
	
	$options = getDB()->options();
	foreach($widget_data as $key => $value)
	{
		$data = array(
			'option_name'  => $key,
			'option_value' => serialize($value)
		);
		$options->insert($data);
	}
}

function getAvailableWidgets()
{
	$widgets = getDB()
				->options
				->where('option_name LIKE ?', '%widget%')
				->where('option_name != ?', 'widget_menus')
				->where('option_name != ?', 'register_widgets');

	$availableWidgets = array();
	foreach($widgets as $widget){
		$indentity = array(
			'id' => $widget['option_id'],
			'name' => $widget['option_name']
		);
		$availableWidgets[$widget['option_name']] = array_merge(unserialize($widget['option_value']), $indentity);
	}

	return $availableWidgets;
}

function addDataWidget($widget_name)
{
	$availableWidgets = getAvailableWidgets();
	if(!$availableWidgets[$widget_name])
		return false;

	return array_merge_recursive($availableWidgets['widget_menus'], $replacements);
}

function getWidgets($name = 'register_widgets')
{
	$widgets = getDB()->options('option_name = ?', $name)->fetch();
	return unserialize($widgets['option_value']);
}