<?php
$this->extend('./Layout/TwitterBootstrap/dashboard');

$this->start('tb_actions');
?>
    <li><?=
    $this->Form->postLink(
        __('Delete'),
        ['action' => 'delete', $release->id],
        ['confirm' => __('Are you sure you want to delete # {0}?', $release->id)]
    )
    ?>
    </li>
    <li><?= $this->Html->link(__('List Releases'), ['action' => 'index']) ?></li>
<?php
$this->end();

$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
    <li><?=
    $this->Form->postLink(
        __('Delete'),
        ['action' => 'delete', $release->id],
        ['confirm' => __('Are you sure you want to delete # {0}?', $release->id)]
    )
    ?>
    </li>
    <li><?= $this->Html->link(__('List Releases'), ['action' => 'index']) ?></li>
</ul>
<?php
$this->end();
?>
<?= $this->Form->create($release); ?>
<fieldset>
    <legend><?= __('Edit {0}', ['Release']) ?></legend>
    <?php
    echo $this->Form->input('organization');
    echo $this->Form->input('persistentid');
    echo $this->Form->input('attribute_name');
    echo $this->Form->input('validated');
    ?>
</fieldset>
<?= $this->Form->button(__("Save")); ?>
<?= $this->Form->end() ?>
