<?php
/* BaserCMS用　プラグイン
 *
 * @name            Ping送信
 *
 * @link			http://mani-lab.com   mani-lab
 * @version			2.0.0
 * @lastmodified	2012-05-01
 */
/**
 * データベース初期化開始
 */
 
 	//pingsenders.phpを実行しTBLを作成する。
	$this->Plugin->initDb('pingsender');
	//pingsender_res.phpを実行しTBLを作成する。
	$this->Plugin->initDb('pingsenderRes');

?>