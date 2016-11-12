<?= $this->Html->css('lightbox.css'); ?>
<?= $this->Html->script('lightbox.js'); ?>

<div class="messages view large-9 medium-8 columns content">
    <div>
        From: <?= $message->name ?><br />
        <?= $this->Text->autoParagraph(h($message->comment)); ?>
    </div>
    <div class="imageArea" style="margin-top: 10px;">
		<div class="imageList">
        <?php if (!empty($message->images)): ?>
            <?php foreach ($message->images as $img): ?>
                <a href="<?= $this->Url->build(['controller'=>'Images', 'action' => 'show', $img->id]); ?>" data-lightbox="messageImages">
    				<img src="<?= $this->Url->build(['controller'=>'Images', 'action' => 'show', $img->id, 1]); ?>" />
    			</a>
            <?php endforeach; ?>
        <?php endif; ?>
		</div>
    </div>
    <div class="videoArea">
		<?php foreach($message->movies as $movie): ?>
			<video controls poster="<?= $this->request->webroot; ?>img/novideo.jpg">
			<source src="<?= $this->request->webroot . "videos/" . $movie->path; ?>">
			</video>
		<?php endforeach; ?>
	</div>
</div>
