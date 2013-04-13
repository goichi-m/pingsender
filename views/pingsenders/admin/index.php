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
**　ビュー　index
**
********************************************/
?>
					


<!-- list -->
<table cellpadding="0" cellspacing="0" class="list-table" id="ListTable">
	<tr>
		<th style="width:180px">操作</th>
		<th>NO</th>
		<th>ブログアカウント</th>
		<th>ブログタイトル</th>
		<th>登録日<br />更新日</th>
	</tr>
<?php if(!empty($listDatas)): ?>
	<?php $count=0; ?>
	<?php foreach($listDatas as $listData): ?>
		<?php if ($count%2 === 0): ?>
			<?php $class=' class="altrow"'; ?>
		<?php else: ?>
			<?php $class=''; ?>
		<?php endif; ?>
	<tr<?php echo $class; ?>>
		<td class="operation-button">
		<?php $bcBaser->link($bcBaser->getImg('admin/icn_tool_edit.png', array('width' => 24, 'height' => 24, 'alt' => '編集', 'class' => 'btn')), array('action' => 'edit', $listData['BlogContent']['id']), array('title' => '編集')) ?>        
		<?php
         $bcBaser->link($bcBaser->getImg('admin/icn_tool_delete.png', array('width' => 24, 'height' => 24, 'alt' => '削除', 'class' => 'btn')),
        array('action' => 'delete', $listData['BlogContent']['id']),
        array('class' => 'btn-gray-s button-s'),
        sprintf('削除を行うと設定されているPing送信先などがリセットされ、初期状態に戻ります。\n本当に「%s」の設定を削除してもいいですか？', $listData['BlogContent']['title']),
        false); 
        ?>
                    
		</td>
		<td><?php echo $listData['BlogContent']['id']; ?></td>
		<td><?php $bcBaser->link($listData['BlogContent']['name'], array('action' => 'edit', $listData['BlogContent']['id'])) ?></td>
		<td><?php echo $listData['BlogContent']['title'] ?></td>
		<td><?php echo $bcTime->format('y-m-d',$listData['BlogContent']['created']); ?><br />
			<?php echo $bcTime->format('y-m-d',$listData['BlogContent']['modified']); ?></td>
	</tr>
		<?php $count++; ?>
	<?php endforeach; ?>
<?php else: ?>
	<tr>
		<td colspan="6"><p class="no-data">データが見つかりませんでした。</p></td>
	</tr>
<?php endif; ?>
</table>

