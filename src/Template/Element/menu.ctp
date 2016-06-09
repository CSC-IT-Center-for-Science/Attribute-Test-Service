<?php $this->start('tb_actions');?>
<li><?= $this->Html->link(__('Test Attributes'), ['action' => 'test']); ?></li>
<li><?= $this->Html->link(__('List Attributes'), ['action' => 'index']); ?></li>
<li><?= $this->Html->link(__('Populate Attributes'), ['action' => 'index']); ?></li>
<li><?= $this->Html->link(__('New Attribute'),   ['action' => 'add']); ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav nav-sidebar">' . $this->fetch('tb_actions') . '</ul>'); ?>
