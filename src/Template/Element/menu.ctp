<?php $this->start('tb_actions');?>
<li><?= $this->Html->link(__('Test Attributes'),     ['controller' => 'attributes', 'action' => 'test']); ?></li>
<li><?= $this->Html->link(__('List Attributes'),     ['controller' => 'attributes', 'action' => 'index']); ?></li>
<li><?= $this->Html->link(__('Populate Attributes'), ['controller' => 'attributes', 'action' => 'map']); ?></li>
<li><?= $this->Html->link(__('New Attribute'),       ['controller' => 'attributes', 'action' => 'add']); ?></li>
<li><?= $this->Html->link(__('List Releases'),       ['controller' => 'releases',   'action' => 'index']); ?></li>

<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav nav-sidebar">' . $this->fetch('tb_actions') . '</ul>'); ?>
