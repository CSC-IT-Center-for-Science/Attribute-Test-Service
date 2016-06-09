<?php
$this->extend('./Layout/TwitterBootstrap/dashboard');
$this->start('tb_actions');
?>
<li><?= $this->Html->link(__('Edit Attribute'), ['action' => 'edit', $attribute->id]) ?> </li>
<li><?= $this->Form->postLink(__('Delete Attribute'), ['action' => 'delete', $attribute->id], ['confirm' => __('Are you sure you want to delete # {0}?', $attribute->id)]) ?> </li>
<li><?= $this->Html->link(__('List Attributes'), ['action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Attribute'), ['action' => 'add']) ?> </li>
<?php
$this->end();

$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
<li><?= $this->Html->link(__('Edit Attribute'), ['action' => 'edit', $attribute->id]) ?> </li>
<li><?= $this->Form->postLink(__('Delete Attribute'), ['action' => 'delete', $attribute->id], ['confirm' => __('Are you sure you want to delete # {0}?', $attribute->id)]) ?> </li>
<li><?= $this->Html->link(__('List Attributes'), ['action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Attribute'), ['action' => 'add']) ?> </li>
</ul>
<?php
$this->end();
?>
<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title"><?= h($attribute->name) ?></h3>
    </div>
    <table class="table table-striped" cellpadding="0" cellspacing="0">
        <tr>
            <td><?= __('Friendlyname') ?></td>
            <td><?= h($attribute->friendlyname) ?></td>
        </tr>
        <tr>
            <td><?= __('Oid') ?></td>
            <td><?= h($attribute->oid) ?></td>
        </tr>
        <tr>
            <td><?= __('Name') ?></td>
            <td><?= h($attribute->name) ?></td>
        </tr>
        <tr>
            <td><?= __('Schema') ?></td>
            <td><?= h($attribute->schema) ?></td>
        </tr>
        <tr>
            <td><?= __('Validation') ?></td>
            <td><?= h($attribute->validation) ?></td>
        </tr>
        <tr>
            <td><?= __('Id') ?></td>
            <td><?= $this->Number->format($attribute->id) ?></td>
        </tr>
        <tr>
            <td><?= __('Created') ?></td>
            <td><?= h($attribute->created) ?></td>
        </tr>
        <tr>
            <td><?= __('Modified') ?></td>
            <td><?= h($attribute->modified) ?></td>
        </tr>
    </table>
</div>

