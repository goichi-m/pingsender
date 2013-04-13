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
**　フック
**
********************************************/
class PingsenderHookComponent extends Object {

	/*-----------------------------------------*/
	//　設定
	/*-----------------------------------------*/
    var $registerHooks = array('afterBlogPostAdd','afterBlogPostEdit');


	/********************************************
	*　ブログ作成時に処理を追加実行する
	********************************************/		
	function afterBlogPostAdd($data){		
			//Baserヘルパーを使えるようにする。
			App::import('Helper','BcBaser');
			$baser =new BcBaserHelper();
			
			//データあるかどうか確認
			if(!empty($data->data)){
				
				//ブログのIDを確認する。
				$blogContentId = $data->data['BlogPost']['blog_content_id'];
				
				//モデルを追加する。
				$pingSendModel = ClassRegistry::init('Pingsender.Pingsender');
				$pingSendResModel = ClassRegistry::init('Pingsender.PingsenderRes');
				$blogContentsModel = ClassRegistry::init('Blog.BlogContent');
				
				//このブログのPing送信設定を取得する。
				$pingSenderData = $pingSendModel->find('all',array('conditions'=>array(
					'blog_contents_id' => $blogContentId
				)));
				
				//このブログ情報を取得する
				$blogContentData = $blogContentsModel->find('all',array('conditions'=>array(
					'id' => $blogContentId
				)));
				
				//実行結果格納用変数
				$pingSendRes = array();
				$pingSendRes['result'] = '';
				
				//空の場合は未設定かリセットされている
				if(!empty($pingSenderData)){
					
					
					//非公開でないかどうかを確認
					if($data->data['BlogPost']['status'] == "1"){
						
						//Pingサーバー一覧を改行文字で区切って配列に。
						$serverArray = explode("\n",$pingSenderData[0]['Pingsender']['server']);
						
						
						//Ping送信実行処理
						for($i=0;$i<count($serverArray);$i++){
							
							//タイトル
							$sendTitle = $blogContentData[0]['BlogContent']['title'];
							
							//ブログのアドレス
							$url = array('admin'=>false,'plugin'=>'','controller'=>$blogContentData[0]['BlogContent']['name'],'action'=>'index');
							$sendUrl = $baser->getUrl($url,true);
							
							//URLをパースして、ホスト名とパスとに分割する。
							$serverUrl = parse_url($serverArray[$i]);
							
							//送信先の登録時に空の改行を入れた場合のエラーに対処して
							//HOSTが空の場合は送信作業を実行しないようにする。
							if(!empty($serverUrl['host'])){
								$serverHost = $serverUrl['host'];
								$serverPath = $serverUrl['path'];
								
								//parse_urlを使うと、文末にアンダーコアが付加される場合があるので、
								//これを削除する。
								$serverHost = ereg_replace('_$',"",$serverHost);
								$serverPath = ereg_replace('_$',"",$serverPath);
	
								//実行して送信結果を格納
								$pingSendResData = $this->updatePing($serverHost,$serverPath, $sendTitle, $sendUrl);
								
								//送信結果を送信結果TBLに保存する。
								//送信結果は最新のものだけを保存するので、idに0を設定。
								$pingSendRes['id'] = 1;
								
								//送信先のサーバーと、結果の保存
								//結果は一行に返ってくるので、改行コードで配列化する。
								$pingSendResDataArray = explode("\n",$pingSendResData);
								
								//サーバー名と結果をつなげて保存
								//結果が空で返ってくる場合（サーバーが見つからない、タイムアウトなど）は
								//エラーを入れる。
								if($pingSendResDataArray[0] == ''){
									$pingSendResDataArray[0] = 'ERROR（応答なし）';
								}
								$pingSendRes['result'] .= $serverArray[$i].'<br />実行結果：'.$pingSendResDataArray[0].'<br /><br />';
							}
						}
						
						//結果の保存
						if(!empty($pingSendRes)){
							$pingSendResModel->save($pingSendRes);
						}
					}
				}
			}
		}




	/********************************************
	*　ブログ更新時に処理を追加実行する
	********************************************/		
	function afterBlogPostEdit($data){		
			//Baserヘルパーを使えるようにする。
			App::import('Helper','BcBaser');
			$baser =new BcBaserHelper();
			
			//データあるかどうか確認
			if(!empty($data->data)){
				
				//ブログのIDを確認する。
				$blogContentId = $data->data['BlogPost']['blog_content_id'];
				
				//モデルを追加する。
				$pingSendModel = ClassRegistry::init('Pingsender.Pingsender');
				$pingSendResModel = ClassRegistry::init('Pingsender.PingsenderRes');
				$blogContentsModel = ClassRegistry::init('Blog.BlogContent');
				
				//このブログのPing送信設定を取得する。
				$pingSenderData = $pingSendModel->find('all',array('conditions'=>array(
					'blog_contents_id' => $blogContentId
				)));
				
				//このブログ情報を取得する
				$blogContentData = $blogContentsModel->find('all',array('conditions'=>array(
					'id' => $blogContentId
				)));
				
				//実行結果格納用変数
				$pingSendRes = array();
				$pingSendRes['result'] = '';
				
				//空の場合は未設定かリセットされている
				if(!empty($pingSenderData)){
					
					//非公開でないかどうかを確認
					if($data->data['BlogPost']['status'] == "1"){
						
						//Pingサーバー一覧を改行文字で区切って配列に。
						$serverArray = explode("\n",$pingSenderData[0]['Pingsender']['server']);
						
						//Ping送信実行処理
						for($i=0;$i<count($serverArray);$i++){
							
							//タイトル
							$sendTitle = $blogContentData[0]['BlogContent']['title'];
							
							//ブログのアドレス
							$url = array('admin'=>false,'plugin'=>'','controller'=>$blogContentData[0]['BlogContent']['name'],'action'=>'index');
							$sendUrl = $baser->getUrl($url,true);
							
							//URLをパースして、ホスト名とパスとに分割する。
							$serverUrl = parse_url($serverArray[$i]);
							
							//送信先の登録時に空の改行を入れた場合のエラーに対処して
							//HOSTが空の場合は送信作業を実行しないようにする。
							if(!empty($serverUrl['host'])){
							
								$serverHost = $serverUrl['host'];
								$serverPath = $serverUrl['path'];
								
								//parse_urlを使うと、文末にアンダーコアが付加される場合があるので、
								//これを削除する。
								$serverHost = ereg_replace('_$',"",$serverHost);
								$serverPath = ereg_replace('_$',"",$serverPath);
								
	
								//実行して送信結果を格納
								$pingSendResData = $this->updatePing($serverHost,$serverPath, $sendTitle, $sendUrl);
								
								//送信結果を送信結果TBLに保存する。
								//送信結果は最新のものだけを保存するので、idに0を設定。
								$pingSendRes['id'] = 1;
								
								//送信先のサーバーと、結果の保存
								//結果は一行に返ってくるので、改行コードで配列化する。
								$pingSendResDataArray = explode("\n",$pingSendResData);
								
								//サーバー名と結果をつなげて保存
								//結果が空で返ってくる場合（サーバーが見つからない、タイムアウトなど）は
								//エラーを入れる。
								if($pingSendResDataArray[0] == ''){
									$pingSendResDataArray[0] = 'ERROR（応答なし）';
								}
								$pingSendRes['result'] .= $serverArray[$i].'<br />実行結果：'.$pingSendResDataArray[0].'<br /><br />';
							}
							
						}
						
						//結果の保存
						if(!empty($pingSendRes)){
							$pingSendResModel->save($pingSendRes);
						}
					}
				}
			}
		}





	/********************************************
	*
	* Ping送信実行関数
	*
	* @param str $host　Pingサーバーのホスト
	* @param str $path　Pingサーバーのホスト以下
	* @param str $title　ブログのタイトル
	* @param str $utl　ブログのUTL
	* @return str $result
	* 
	* 指定されたサーバーに対してPing送信を行う。
	* この関数は以下のサイトを参考にさせていただきました。
	* http://blog.myrss.jp/archives/2007/04/24_rss_ping.html
	*
	*********************************************/	
	function updatePing($host, $path, $title, $url){
		
		//$hostの80番ポートへむけて以下のXMLを送信
		$sock = @fsockopen($host, 80, $errno, $errstr, 2.0);
		
		//戻り値格納用変数
		$result = "";
		
		//接続できれば以下の処理
		if ($sock){
			
			//タイトル
			$title_str = htmlspecialchars($title);
			
			//送信するXMLの内容
			$content =
				   "<?xml version=\"1.0\"?>\r\n" .
				   "<methodCall>\r\n" .
				   "<methodName>weblogUpdates.ping</methodName>\r\n" .
				   "<params>\r\n" .
				   "<param>\r\n" .
				   "<value>$title_str</value>\r\n" .
				   "</param>\r\n" .
				   "<param>\r\n" .
				   "<value>$url</value>\r\n" .
				   "</param>\r\n" .
				   "</params>\r\n" .
				   "</methodCall>\r\n";
			$length = strlen($content);
			
			//設定情報（ヘッダ部分）
			$req = "POST $path HTTP/1.0\r\n" .
				   "Host: $host\r\n" .
				   "Content-Type: text/xml\r\n" .
				   "Content-Length: $length\r\n" .
				   "\r\n" . $content;
				   
			//送信
			fputs($sock, $req);			
			
			//ファイルポインタが終端まで行ったかどうかで、送信完了を確認する。
			while(!feof($sock)){
				$result .= fread($sock, 1024);
			}
			
		}
		
		return $result;
	}
	

}

?>