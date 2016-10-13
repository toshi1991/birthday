
<div class="users index large-9 medium-8 columns content">
    <?= $this->Form->create() ?>
    <?= $this->Form->input('user_name') ?>
    <?= $this->Form->input('password') ?>
    <?= $this->Form->button('ログイン') ?>
    <?= $this->Form->end() ?>
    <?= $this->Html->link($this->Form->button('ゲストログイン', ['type' => 'none']), ['action' => 'login', 1], ['escape' => false]); ?>
    <div style="clear: both">
        <strong>登録は<?= $this->Html->link('こちら', ['action' => 'add']); ?></strong><br />
        *ゲストログインの場合は一定時間が経過するかブラウザを閉じると自動的にログアウトされ、その後は編集や削除ができなくなります。
    </div>
