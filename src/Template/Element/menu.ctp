<?php $this->start('tb_actions');?>

<!-- <li><?= $this->Html->link(__('Test Attributes'),     ['controller' => 'attributes', 'action' => 'test']); ?></li> -->

<li><?= $this->Html->link(__('Show Attributes'),     ['controller' => 'attributes', 'action' => 'index']); ?></li>
<?php if ($this->request->session()->read('Auth.User.role') == 'admin') : ?>
<li><?= $this->Html->link(__('Populate Attributes'), ['controller' => 'attributes', 'action' => 'map']); ?></li>
<li><?= $this->Html->link(__('New Attribute'),       ['controller' => 'attributes', 'action' => 'add']); ?></li>
<?php endif; ?>
<li><?= $this->Html->link(__('Show All Releases'),       ['controller' => 'releases',   'action' => 'index']); ?></li>

<?php $this->end(); ?>
