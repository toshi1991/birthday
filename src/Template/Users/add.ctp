
<div class="users form large-9 medium-8 columns content">
    <p>
        <strong>喜友名彩美</strong>へのバースデーメッセージにご協力ありがとうございます。<br />
        お手数ですが、メッセージ投稿の前にログイン方法を選択してください。
    </p>

    <?= $this->Form->create($user, ['url'=> ['action' => 'login', 1]]) ?>
    <fieldset>
        <legend>ゲストログイン</legend>
        <p class="small_mes">
            登録せずにメッセージを投稿できますが、後からの編集・削除ができません。
        </p>
        <div style="text-align:right;">
            <?= $this->Html->link($this->Form->button('ゲストログイン', ['type' => 'none']), ['action' => 'login', 1], ['escape' => false]); ?>
        </div>
    </fieldset>
    <?= $this->Form->end(); ?>
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend>ユーザー登録</legend> <br />
        <p class="small_mes">
            登録すると後からメッセージを編集・削除することができます。
        </p>
        <?php
            echo $this->Form->input('user_name', ['label'=>'ID(英数字)']);
            echo $this->Form->input('password', ['label' => 'パスワード']);
        ?>
    </fieldset>
    <?= $this->Form->button('登録') ?>
    <?= $this->Form->end() ?>

    <div style="clear: both;">登録済みの方は
        <?= $this->Html->link('こちら', ['controller' => 'users', 'action' => 'login']); ?>
    </div>
</div>
