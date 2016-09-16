<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Services'), ['controller' => 'Services', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Service'), ['controller' => 'Services', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Messages'), ['controller' => 'Messages', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Message'), ['controller' => 'Messages', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users index large-9 medium-8 columns content">
	<h3><?= __('My Page') ?></h3>
	<article>
		<div>ユーザー画像</div>
		<div>ユーザー名</div>
		<div><?= $this->Html->link(__('New Message'), ['controller' => 'Messages', 'action' => 'add']) ?></div>
		<div><?= $this->Html->link(__('List Messages'), ['controller' => 'Messages', 'action' => 'index']) ?></div>

	