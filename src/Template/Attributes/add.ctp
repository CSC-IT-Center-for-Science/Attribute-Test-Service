<?php
$this->extend('./Layout/TwitterBootstrap/dashboard');
$this->start('tb_actions');
?>
    <li><?= $this->Html->link(__('List Attributes'), ['action' => 'index']) ?></li>
<?php
$this->end();

$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
    <li><?= $this->Html->link(__('List Attributes'), ['action' => 'index']) ?></li>
</ul>
<?php
$this->end();
?>
<?= $this->Form->create($attribute); ?>
<fieldset>
    <legend><?= __('Add {0}', ['Attribute']) ?></legend>
    <?php
    echo $this->Form->input('friendlyname');
    echo $this->Form->input('oid');
    echo $this->Form->input('name');
    echo $this->Form->input('schema');
    echo $this->Form->input('validation');
    ?>
</fieldset>
<?= $this->Form->button(__("Add")); ?>
<?= $this->Form->end() ?>
