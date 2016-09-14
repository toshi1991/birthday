<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Sn'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="sns index large-9 medium-8 columns content">
    <h3><?= __('Sns') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sns_name') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sns as $sn): ?>
            <tr>
                <td><?= $this->Number->format($sn->id) ?></td>
                <td><?= h($sn->sns_name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $sn->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $sn->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $sn->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sn->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
