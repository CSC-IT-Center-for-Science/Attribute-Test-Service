<?php
$this->extend('./Layout/TwitterBootstrap/dashboard');
$this->element('menu');?>

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
