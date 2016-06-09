<?php
$this->extend('./Layout/TwitterBootstrap/dashboard');
echo $this->element('menu');
?>
<?= $this->Form->create($attribute); ?>
<fieldset>
    <legend><?= __('Edit {0}', ['Attribute']) ?></legend>
    <?php
    echo $this->Form->input('friendlyname');
    echo $this->Form->input('oid');
    echo $this->Form->input('name');
    echo $this->Form->input('schema');
    echo $this->Form->input('validation');
    ?>
</fieldset>
   <div class="controls form-inline">
           <div class=" input-append">
<?=$this->Form->button(__("Save")); ?>
<?=$this->Form->postLink(__('Delete'),
      ['action' => 'delete', $attribute->id],
      ['class' => 'btn btn-danger'],
      ['confirm' => __('Are you sure you want to delete # {0}?', $attribute->id)]
    )?>
    </div></div>

<?= $this->Form->end() ?>
