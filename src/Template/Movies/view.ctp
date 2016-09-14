<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Movie'), ['action' => 'edit', $movie->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Movie'), ['action' => 'delete', $movie->id], ['confirm' => __('Are you sure you want to delete # {0}?', $movie->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Movies'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Movie'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Messages'), ['controller' => 'Messages', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Message'), ['controller' => 'Messages', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="movies view large-9 medium-8 columns content">
    <h3><?= h($movie->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Message') ?></th>
            <td><?= $movie->has('message') ? $this->Html->link($movie->message->id, ['controller' => 'Messages', 'action' => 'view', $movie->message->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Path') ?></th>
            <td><?= h($movie->path) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($movie->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Del Flg') ?></th>
            <td><?= $this->Number->format($movie->del_flg) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($movie->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($movie->modified) ?></td>
        </tr>
    </table>
</div>
