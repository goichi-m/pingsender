<?php
/*
** プラグイン用TBL「pingsender」の構築用（結果格納TBL)
*/

class PingsenderResSchema extends CakeSchema {

	var $name = 'PingsenderRes';
	var $file = 'pingsender_res.php';
	var $connection = 'plugin';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}
	
	//テーブル作成
	var $pingsender_res = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'result' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL)
	);
}

?>