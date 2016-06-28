<?php
$this->extend('./Layout/TwitterBootstrap/dashboard');

$this->start('tb_actions');
?>
    <li><?= $this->Html->link(__('List Releases'), ['action' => 'index']) ?></li>
<?php
$this->end();

$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
    <li><?= $this->Html->link(__('List Releases'), ['action' => 'index']) ?></li>
</ul>
<?php
$this->end();
?>
<?= $this->Form->create($release); ?>
<fieldset>
    <legend><?= __('Add {0}', ['Release']) ?></legend>
    <?php
    echo $this->Form->input('organization');
    echo $this->Form->input('persistentid');
    echo $this->Form->input('attribute_name');
    echo $this->Form->input('validated');
    ?>
</fieldset>
<?= $this->Form->button(__("Add")); ?>
<?= $this->Form->end() ?>
