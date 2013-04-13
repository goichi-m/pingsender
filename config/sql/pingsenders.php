<?php
/*
** プラグイン用TBL「pingsender」の構築用
*/

class PingsendersSchema extends CakeSchema {
	
	var $name = 'Pingsenders';
	var $file = 'pingsenders.php';
	var $connection = 'plugin';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}
	
	//テーブル作成
	var $pingsenders = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'blog_contents_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'server' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL)
	);
}

?>