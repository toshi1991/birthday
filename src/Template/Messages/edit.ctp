<?= $this->Html->script('imageuploader.js'); ?>
<?= $this->Html->script('videouploader.js'); ?>
<?= $this->Html->css('lightbox.css'); ?>
<?= $this->Html->script('lightbox.js'); ?>

<script>
	var message_id = <?= $message->id; ?>;
	var max_size = <?php
	function get_size($val) {
		$val = ini_get($val);
		$val = trim($val);
		$last = strtolower($val[strlen($val)-1]);
		switch($last) {
			// 'G' は PHP 5.1.0 以降で使用可能です
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}

		return $val;
	}

	echo min(get_size('post_max_size'), get_size('upload_max_filesize'), get_size('memory_limit'));
	?>;
</script>


<div class="messages form large-9 medium-8 columns content clearfix">
	<p class="small_mes">
		メッセージの投稿ありがとうございます！<br />
		この画面ではメッセージの修正や画像・動画の追加ができます。<br />
		終了の際はそのままページを閉じてください。
	</p>
	<div class="clearfix">
    <?= $this->Form->create($message) ?>
    <fieldset>
        <legend>メッセージ編集</legend>
        <?php
			echo $this->Form->input('name');
            // echo $this->Form->input('user_id', ['options' => $users]);
            echo $this->Form->input('comment');
        ?>
    </fieldset>
    <?= $this->Form->button('変更') ?>
    <?= $this->Form->end() ?>
	</div>

	<div class="imageArea" style="margin-top: 10px;">
		<div class="imageList">
		<?php foreach($message->images as $img): ?>
			<a href="<?= $this->Url->build(['controller'=>'Images', 'action' => 'show', $img->id]); ?>" data-lightbox="messageImages">
				<img src="<?= $this->Url->build(['controller'=>'Images', 'action' => 'show', $img->id, 1]); ?>" />
			</a>
		<?php endforeach; ?>
			<img src="<?= $this->request->webroot; ?>img/noimage.png" id="addimage" />
		</div>
		<?= $this->Form->create(null, ['id' => 'imageuploader']) ?>
			<input id="file" type="file" multiple accept="image/jpeg, image/gif, image/png">
		<?= $this->Form->end(); ?>
		<?= $this->Form->create(null, ['id' => 'videouploader']) ?>
			<input id="video_file" type="file" multiple accept="video/*">
		<?= $this->Form->end(); ?>
		<p class="notices">
			*画像のサイズが大きすぎると投稿できない可能性があります。<br />
			*一度投稿した画像は削除できません。
		</p>
	</div>
	<div class="videoArea">
		<?php foreach($message->movies as $movie): ?>
			<video controls poster="<?= $this->request->webroot; ?>img/novideo.jpg">
			<source src="<?= $this->request->webroot . "videos/" . $movie->path; ?>">
			</video>
		<?php endforeach; ?>
		<img src="<?= $this->request->webroot; ?>img/nomovie.png" id="addvideo" />
		<p class="notices">
			*Wi-fi環境での追加をオススメします。<br />
			*通信環境によっては5〜10分以上かかる場合がございます。<br />
			*動画が長すぎると投稿できない場合があります。(目安: 10秒程度)<br />
			*サイズの大きい動画を投稿したい場合や、動画の投稿に失敗する場合はお手数ですが、lineで連絡ください。
		</p>
	</div>
	<span id="del_link">
		<?= $this->Form->postLink(
			'メッセージを削除',
			['action' => 'delete', $message->id],
			['confirm' => '削除すると元に戻せません。本当に削除しますか？']
		)
		?>
	</span>
</div>
