<?php
$this->extend('./Layout/TwitterBootstrap/dashboard');


$this->start('tb_actions');
?>
<li><?= $this->Html->link(__('Edit Release'), ['action' => 'edit', $release->id]) ?> </li>
<li><?= $this->Form->postLink(__('Delete Release'), ['action' => 'delete', $release->id], ['confirm' => __('Are you sure you want to delete # {0}?', $release->id)]) ?> </li>
<li><?= $this->Html->link(__('List Releases'), ['action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Release'), ['action' => 'add']) ?> </li>
<?php
$this->end();

$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
<li><?= $this->Html->link(__('Edit Release'), ['action' => 'edit', $release->id]) ?> </li>
<li><?= $this->Form->postLink(__('Delete Release'), ['action' => 'delete', $release->id], ['confirm' => __('Are you sure you want to delete # {0}?', $release->id)]) ?> </li>
<li><?= $this->Html->link(__('List Releases'), ['action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Release'), ['action' => 'add']) ?> </li>
</ul>
<?php
$this->end();
?>
<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title"><?= h($release->id) ?></h3>
    </div>
    <table class="table table-striped" cellpadding="0" cellspacing="0">
        <tr>
            <td><?= __('Organization') ?></td>
            <td><?= h($release->organization) ?></td>
        </tr>
        <tr>
            <td><?= __('Persistentid') ?></td>
            <td><?= h($release->persistentid) ?></td>
        </tr>
        <tr>
            <td><?= __('Attribute Name') ?></td>
            <td><?= h($release->attribute_name) ?></td>
        </tr>
        <tr>
            <td><?= __('Validated') ?></td>
            <td><?= h($release->validated) ?></td>
        </tr>
        <tr>
            <td><?= __('Id') ?></td>
            <td><?= $this->Number->format($release->id) ?></td>
        </tr>
        <tr>
            <td><?= __('Modified') ?></td>
            <td><?= h($release->modified) ?></td>
        </tr>
    </table>
</div>

