<?= $this->Html->script('imageuploader.js'); ?>
<?= $this->Html->script('videouploader.js'); ?>

<script>
	var message_id = <?= $message->id; ?>;
</script>


<div class="messages form large-9 medium-8 columns content">
	<div>
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

	<div class="imageArea" style="clear:both;">
		<div class="imageList">
		<?php foreach($message->images as $img): ?>
			<a href="<?= $this->Url->build(['controller'=>'Images', 'action' => 'show', $img->id]); ?>">
				<img src="<?= $this->Url->build(['controller'=>'Images', 'action' => 'show', $img->id, 1]); ?>" />
			</a>
		<?php endforeach; ?>
		</div>
		<div class="addImage" style="clear:both;">
			<?= $this->Form->create(null, ['id' => 'imageuploader']) ?>
				<fieldset>
					<legend>画像</legend>
					<input id="file" type="file" multiple accept="image/jpeg, image/gif, image/png">
				</fieldset>
			<?= $this->Form->end(); ?>
		</div>
		<div class="addVideo" style="clear:both;">
			<?= $this->Form->create(null, ['id' => 'videouploader']) ?>
				<fieldset>
					<legend>動画</legend>
					<input id="video_file" type="file" multiple accept="video/*">
				</fieldset>
			<?= $this->Form->end(); ?>
		</div>
	</div>
	<?= $this->Form->postLink(
			__('Delete'),
			['action' => 'delete', $message->id],
			['confirm' => '本当に削除しますか？']
		)
	?>
</div>
