<?= $this->Html->script('imageuploader.js'); ?>
<?= $this->Html->script('videouploader.js'); ?>

<script>
	var message_id = <?= $message->id; ?>;
</script>


<div class="messages form large-9 medium-8 columns content clearfix">
	<div class="clearfix">
    <?= $this->Form->create($message) ?>
    <fieldset>
        <legend>メッセージ編集</legend>
        <?php
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
			<a href="<?= $this->Url->build(['controller'=>'Images', 'action' => 'show', $img->id]); ?>">
				<img src="<?= $this->Url->build(['controller'=>'Images', 'action' => 'show', $img->id, 1]); ?>" />
			</a>
		<?php endforeach; ?>
			<img src="/birthday/img/noimage.png" id="addimage" />
		</div>
		<?= $this->Form->create(null, ['id' => 'imageuploader']) ?>
			<input id="file" type="file" multiple accept="image/jpeg, image/gif, image/png">
		<?= $this->Form->end(); ?>
		<?= $this->Form->create(null, ['id' => 'videouploader']) ?>
			<input id="video_file" type="file" multiple accept="video/*">
		<?= $this->Form->end(); ?>
	</div>
	<div class="videoArea">
		<?php foreach($message->movies as $movie): ?>
			<video controls poster="<?= $this->request->webroot; ?>img/novideo.png" width="100">
			<source src="<?= $this->request->webroot . "videos/" . $movie->path; ?>">
			</video>
		<?php endforeach; ?>
		<img src="<?= $this->request->webroot; ?>img/nomovie.png" id="addvideo" />
	</div>
	<span id="del_link">
		<?= $this->Form->postLink(
			'メッセージを削除',
			['action' => 'delete', $message->id],
			['confirm' => '本当に削除しますか？']
		)
		?>
	</span>
</div>
