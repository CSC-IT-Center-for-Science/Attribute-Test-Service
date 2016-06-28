<?php
/* @var $this \Cake\View\View */
$this->extend('./Layout/TwitterBootstrap/dashboard');
$this->element('menu');?>

<?php $this->assign('tb_sidebar', '<ul class="nav nav-sidebar">' . $this->fetch('tb_actions') . '</ul>'); ?>

<table class="table table-striped" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id'); ?></th>
            <th><?= $this->Paginator->sort('organization'); ?></th>
            <th><?= $this->Paginator->sort('persistentid'); ?></th>
            <th><?= $this->Paginator->sort('attribute_name'); ?></th>
            <th><?= $this->Paginator->sort('validated'); ?></th>
            <th><?= $this->Paginator->sort('modified'); ?></th>
            <th class="actions"><?= __('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($releases as $release): ?>
        <tr>
            <td><?= $this->Number->format($release->id) ?></td>
            <td><?= h($release->organization) ?></td>
            <td><?= h($release->persistentid) ?></td>
            <td><?= h($release->attribute_name) ?></td>
            <td><?= h($release->validated) ?></td>
            <td><?= h($release->modified) ?></td>
            <td class="actions">
                <?= $this->Html->link('', ['action' => 'view', $release->id], ['title' => __('View'), 'class' => 'btn btn-default glyphicon glyphicon-eye-open']) ?>
                <?= $this->Html->link('', ['action' => 'edit', $release->id], ['title' => __('Edit'), 'class' => 'btn btn-default glyphicon glyphicon-pencil']) ?>
                <?= $this->Form->postLink('', ['action' => 'delete', $release->id], ['confirm' => __('Are you sure you want to delete # {0}?', $release->id), 'title' => __('Delete'), 'class' => 'btn btn-default glyphicon glyphicon-trash']) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
    </ul>
    <p><?= $this->Paginator->counter() ?></p>
</div>
