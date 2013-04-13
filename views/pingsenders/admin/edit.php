<?php
/* BaserCMS用　プラグイン
 *
 * @name            Ping送信
 *
 * @link			http://mani-lab.com   mani-lab
 * @version			2.0.0
 * @lastmodified	2012-05-01
 */
 
?>
<?php
echo $bcForm->create('Pingsender', array('url' => array('controller' => 'Pingsenders', 'action' => 'edit','id' =>$blogContentData['BlogContent']['id'])));
?>

<table cellpadding="0" cellspacing="0" class="list-table" id="ListTable">
	<tr>
		<th class="col-head">ブログ名</th>
		<td class="col-input">
        <?php echo $blogContentData['BlogContent']['title']; ?>
        <?php echo $bcForm->hidden('Pingsender.blog_contents_id',array('value'=>$blogContentData['BlogContent']['id']));?>
        </td>
	</tr>

   	<tr>
		<th class="col-head"><span class="required">*</span>&nbsp;<?php echo $bcForm->label('Pingsender.server', '送信先サーバー') ?></th>
		<td class="col-input">
			<?php
			if(!empty($pingsenderDatas[0]['Pingsender']['server'])){
				echo $bcForm->textarea('Pingsender.server',array('cols'=>50,'rows'=>10,'value'=>$pingsenderDatas[0]['Pingsender']['server']));
			}else{
				echo $bcForm->textarea('Pingsender.server',array('cols'=>50,'rows'=>10));
			}
			echo $bcForm->error('Pingsender.server');
			?>
        <br />
        <span style="font-size:11px;color:#F00;">＊</span><span style="font-size:11px">
        送信先のPingサーバーを入力してください。改行をいれて複数設定できます。
        </span>
        </td>
   </tr> 
 
</table>

<div class="submit">
	<?php
	if(!empty($pingsenderDatas[0]['Pingsender']['id'])){
	 echo $bcForm->hidden('Pingsender.id',array('value'=>$pingsenderDatas[0]['Pingsender']['id']));
	}
	 ?>
	<?php echo $bcForm->end(array('label'=>'更　新','div'=>false,'class'=>'btn-orange button')) ?>
	<?php
	if(!empty($pingsenderDatas[0]['Pingsender']['id'])){
	 $bcBaser->link('削　除',array('action'=>'delete', $pingsenderDatas[0]['Pingsender']['id']), array('class'=>'btn-gray button'), sprintf('削除すると設定されているPing送信設定がリセットされます。本当にリセットしてもいいですか？', $bcForm->value('Pingsender.id')),false);
	}
	 ?>

</div>
