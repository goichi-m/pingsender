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

<table cellpadding="0" cellspacing="0" class="list-table" id="ListTable">
	<?php
		if(!empty($resultData)){
	?>
	<tr>
		<th class="col-head">送信日時</th>
		<td class="col-input"><?php echo $resultData['PingsenderRes']['modified'] ?></td>
	</tr>

	<tr>
		<th class="col-head">実行結果</th>
		<td class="col-input">
		<?php
		
		 echo $resultData['PingsenderRes']['result'] ?>
        
        </td>
	</tr>
    <?php
		}else{
	?>
	<tr>
		<td>データがありません。</td>
	</tr>
    <?php
		}
	?>
 
</table>

