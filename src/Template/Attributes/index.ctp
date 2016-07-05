<?php
/* @var $this \Cake\View\View */
$this->extend('./Layout/TwitterBootstrap/dashboard');
$this->element('menu');?>

<table class="table table-striped" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id'); ?></th>
            <th><?= $this->Paginator->sort('friendlyname'); ?></th>
            <th><?= $this->Paginator->sort('oid'); ?></th>
            <th><?= $this->Paginator->sort('name'); ?></th>
            <th><?= $this->Paginator->sort('schema'); ?></th>
            <th><?= $this->Paginator->sort('validation'); ?></th>
            <th><?= $this->Paginator->sort('created'); ?></th>
            <th class="actions"><?= __('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($attributes as $attribute): ?>
        <tr>
            <td><?= $this->Number->format($attribute->id) ?></td>
            <td><?= h($attribute->friendlyname) ?></td>
            <td><?= h($attribute->oid) ?></td>
            <td><?= h($attribute->name) ?></td>
            <td><?= h($attribute->schema) ?></td>
            <td><?= h($attribute->validation) ?></td>
            <td><?= h($attribute->created) ?></td>
            <td class="actions">
                <?= $this->Html->link('', ['action' => 'view', $attribute->id], ['title' => __('View'), 'class' => 'btn btn-default glyphicon glyphicon-eye-open']) ?>
                <?php if ($this->request->session()->read('Auth.User.role') == 'admin') : ?>
                  <?= $this->Html->link('', ['action' => 'edit', $attribute->id], ['title' => __('Edit'), 'class' => 'btn btn-default glyphicon glyphicon-pencil']) ?>
                  <?= $this->Form->postLink('', ['action' => 'delete', $attribute->id], ['confirm' => __('Are you sure you want to delete # {0}?', $attribute->id), 'title' => __('Delete'), 'class' => 'btn btn-default glyphicon glyphicon-trash']) ?>
                <?php endif;?>
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
