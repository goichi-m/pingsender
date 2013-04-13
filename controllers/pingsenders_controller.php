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
**　インポート
**
********************************************/
App::import('Controller', 'Plugins');



/********************************************
**
**　コントローラー
**
********************************************/
class PingsendersController extends PluginsController {



	/*-----------------------------------------*/
	//　設定
	/*-----------------------------------------*/
	var $name = 'Pingsenders';
	var $components = array('BcAuth','Cookie','BcAuthConfigure','RequestHandler');
	var $pageTitle = 'Ping送信';
	var $uses = array('Plugin','Pingsender.Pingsender','Pingsender.PingsenderRes','Blog.BlogContent');
	var $helpers = array('BcText','BcTime','BcForm');
	var $navis = array('Ping送信'=>'/admin/pingsender/pingsenders/index');
	
	

	/********************************************
	*　Ping送信設定画面　index
	********************************************/
	function admin_index() {
		
		//ページネートの設定
		$this->paginate = array('conditions'=>array(),
				'fields'=>array(),
				'order'=>'id',
				'limit'=>10
		);
		
		//現在、存在しているブログの一覧をページネートを使って取得する。
		$listDatas = $this->paginate('BlogContent');
		
		//ブログデータを取得できていれば、View側へセットする。
		if($listDatas) {
			$this->set('listDatas',$listDatas);
		}
		
		//サイドメニューをView側にセットする。
		$this->subMenuElements = am($this->subMenuElements,array('pingsender'));
		
		//ページタイトル
		$this->pageTitle = 'Ping送信設定';
		
		//ヘルプ
		$this->help = 'pingsenders_index';

	}
	
	


	/********************************************
	*　Ping送信設定画面　設定編集
	********************************************/
	function admin_edit($blogContentsId){

		//ブログのidが指定されていない場合の処理
		if(!$blogContentsId && empty($this->data)) {
			//表示するメッセージ
			$this->Session->setFlash('無効なIDです。');
			//画面遷移
			$this->redirect(array('action'=>'admin_index'));
		}
		
		//引数で得たブログIDから、このブログの名前等を取得する。
		$blogContentData = $this->BlogContent->find('all',array('conditions'=>array(
			'id' => $blogContentsId
		)));
		
		//View側へブログ情報をセット
		$this->set('blogContentData',$blogContentData[0]);
		
		//初期表示
		if(empty($this->data)) {
			
			//選択されたブログのPing送信設定データを取得し、
			//View側へセットする。
			$this->data = $this->Pingsender->find('all',array('conditions'=>array(
				'blog_contents_id' => $blogContentsId
			)));
			$this->set('pingsenderDatas',$this->data);

		
		//更新ボタン押下後
		}else{
			
			// データを保存する
			if($this->Pingsender->save($this->data)) {
				//完了後、表示するメッセージ
				$this->Session->setFlash('Ping送信設定を更新しました。');
				//ログに残すメッセージ
				$this->Pingsender->saveDbLog('Ping送信設定を更新しました。');
				//画面遷移
				$this->redirect('/admin/pingsender/pingsenders/index');
			
			//保存に失敗した場合の処理
			}else {
				$this->data = $this->Pingsender->find('all',array('conditions'=>array(
				'blog_contents_id' => $blogContentsId
				)));
				$this->set('PingsenderDatas',$this->data);			
				$this->Session->setFlash('入力エラーです。内容を修正してください。');
			}

	
		}

		//サイドメニューをView側へセット
		$this->subMenuElements = am($this->subMenuElements,array('pingsender'));
		//ページタイトル
		$this->pageTitle = 'Ping送信設定　編集';

		//ヘルプ
		$this->help = 'pingsenders_edit';
		
		
		}



	
	/********************************************
	*　Ping送信設定画面　削除
	********************************************/
	function admin_delete($id = null) {
		
		//idが指定されていない場合の処理
		if(!$id) {
			//表示するメッセージ
			$this->Session->setFlash('無効なIDです。');
			//画面遷移
			$this->redirect(array('action'=>'admin_index'));
		}

		// メッセージ用にデータを取得
		$pageSenderDatas = $this->Pingsender->read(null, $id);
		
		//ブログIDを取得して、ブログ名を取得する。
		$blogDatas = $this->BlogContent->read(null, $pageSenderDatas['Pingsender']['blog_contents_id']);
		$blogName = $blogDatas['BlogContent']['name'];

		// 削除実行
		if($this->Pingsender->del($id)) {
			$this->Session->setFlash('ブログ「'.$blogName.'」のPing送信設定を初期化しました。');
			$this->Pingsender->saveDbLog('ブログ「'.$blogName.'」のPing送信設定を初期化しました。');
		
		//削除に失敗した場合の処理
		}else {

			//表示するメッセージ
			$this->Session->setFlash('データベース処理中にエラーが発生しました。');

		}
		
		//画面遷移
		$this->redirect(array('action'=>'admin_index'));
	}
	
	
	
	
	
	/********************************************
	*　Ping送信設定画面　実行結果の確認
	********************************************/
	function admin_result() {
		
		//最新の実行結果を取得する。
		$resultData = $this->PingsenderRes->find('first');
		
		//取得結果をViewへ渡す。
		if(!empty($resultData)){
			$this->set('resultData',$resultData);
		}
		
		//サイドメニューをView側へセット
		$this->subMenuElements = am($this->subMenuElements,array('pingsender'));
		//ページタイトル
		$this->pageTitle = 'Ping送信設定　実行結果の確認';
		
		//ヘルプ
		$this->help = 'pingsenders_result';
		
	}

}

?>