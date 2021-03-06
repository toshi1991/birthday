<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'バースデーメッセージ';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>
        <?= $cakeDescription ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
	<?php //$this->Html->css('https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.css'); ?>

	<?= $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js'); ?>
	<?php // $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.js'); ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <?= $this->element('analytics'); ?>
    <script>
        var root_url = '<?= $this->request->webroot; ?>';
    </script>
    <nav class="top_bar" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
                <h1><?= $this->Html->link('Birthday Message', ['controller' => 'messages']); ?></h1>
            </li>
        </ul>
        <div class="top_bar_section">
            <ul class="right">
                <li><?= $this->Html->link($this->Html->image('add.png'), ['controller' => 'messages', 'action' => 'add'], ['escape' => false]) ?></li>
<?php /*                <li><?= $this->Html->link('メッセージ確認', ['action' => 'index']) ?></li>

                <li><a target="_blank" href="http://book.cakephp.org/3.0/">Documentation</a></li>
                <li><a target="_blank" href="http://api.cakephp.org/3.0/">API</a></li>
*/ ?>
<?php /*            <li>
                <?= $this->Html->link('logout', ['controller'=>'users', 'action'=>'logout']);?>
            </li>
            */ ?>
            </ul>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
