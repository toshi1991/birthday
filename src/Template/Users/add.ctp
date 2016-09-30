
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend>ユーザー登録</legend>
        <?php
            echo $this->Form->input('user_name', ['label'=>'ID']);
            echo $this->Form->input('password', ['label' => 'パスワード']);
        ?>
    </fieldset>
    <?= $this->Form->button('登録') ?>
    <?= $this->Form->end() ?>
    <div>登録済みの方は
        <?= $this->Html->link('こちら', ['action' => 'login']); ?>
    </div>
</div>
