<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Sns'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="sns form large-9 medium-8 columns content">
    <?= $this->Form->create($sn) ?>
    <fieldset>
        <legend><?= __('Add Sn') ?></legend>
        <?php
            echo $this->Form->input('sns_name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
