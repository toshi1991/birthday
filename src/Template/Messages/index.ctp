<div class="messages index large-9 medium-8 columns content">
    <h3>メッセージ一覧</h3>
    <ul>
    <?php foreach ($messages as $message): ?>
        <li class="message">
            <section class="user_name">
                From: <?= h($message->name) ?>
            </section>
            <section class="comment">
                <pre><?= h($message->comment); ?></pre>
            </section>
            <footer>
                <?= $this->Html->link($this->Html->image('edit.png'), ['action' => 'edit', $message->id], ['class' => 'action_button', 'escape' => false]) ?>
                <span class="action_button_wrap"><?= $this->Form->postLink($this->Html->image('trash.png'), ['action' => 'delete', $message->id], ['confirm' => '本当に削除しますか？', 'class' => 'action_button', 'escape' => false]); ?></span>
            </footer>
        </li>
    <?php endforeach; ?>
    </ul>
    <?php if(count($messages) == 0): ?>
        メッセージはまだありません。-><?= $this->Html->link('投稿する', ['action' => 'add']); ?>
    <?php endif; ?>
    <?php if($this->Paginator->param('pageCount') > 1): ?>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
            </ul>
            <p><?= $this->Paginator->counter() ?></p>
        </div>
    <?php endif; ?>
</div>
