<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Sn'), ['action' => 'edit', $sn->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Sn'), ['action' => 'delete', $sn->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sn->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Sns'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sn'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="sns view large-9 medium-8 columns content">
    <h3><?= h($sn->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Sns Name') ?></th>
            <td><?= h($sn->sns_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($sn->id) ?></td>
        </tr>
    </table>
</div>
