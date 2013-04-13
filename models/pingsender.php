<?php
/* BaserCMS用　プラグイン
 *
 * @name            Ping送信
 *
 * @link			http://mani-lab.com   mani-lab
 * @version			2.0.0
 * @lastmodified	2012-05-01
 */


/********************************************
**
**　モデル
**
********************************************/
class Pingsender extends AppModel {


	/*-----------------------------------------*/
	//　設定
	/*-----------------------------------------*/
	var $name = 'Pingsender';
	var $useDbConfig = 'plugin';
	var $plugin = 'Pingsender';
	
	
	/********************************************
	*　Ping送信設定　バリデート
	********************************************/
	function beforeValidate() {
		
		//Pingサーバー記入欄に記述がない場合、ここで止める。
		$this->validate['server'] = array(array('rule' => array('minLength',1),
						'message' => "Pingサーバーを入力して下さい。",
						'required' => true));	
						
		return true;
	}
	
}
?>