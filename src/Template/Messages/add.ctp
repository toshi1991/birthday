<div class="messages form large-9 medium-8 columns content clearfix">
    <?= $this->Form->create($message) ?>
    <fieldset>
        <legend>メッセージ投稿</legend>
        <?php
            //echo $this->Form->input('user_id', ['type' => 'hidden', 'value' => 1,  => $user["user_name"]]);
			echo $this->Form->input('name', ['label' => 'お名前(ニックネーム)', 'value' => $user["user_name"]]);
            echo $this->Form->input('comment', ['label' => 'メッセージ']);
        ?>
    </fieldset>
    <?= $this->Form->button('送信') ?>
    <?= $this->Form->end() ?>
</div>
