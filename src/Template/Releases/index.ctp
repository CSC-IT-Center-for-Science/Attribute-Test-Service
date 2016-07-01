<style>
th.rotate {
  /* Something you can count on */
  height: 140px;
  white-space: nowrap;
}

th.rotate > div {
  transform:
  /* Magic Numbers */
  translate(25px, 51px)
  /* 45 is really 360 - 45 */
  rotate(315deg);
  width: 30px;
}
th.rotate > div > span {
  border-bottom: 0px solid #ccc;
  padding: 5px 80px;
}
</style>

<?php
/* @var $this \Cake\View\View */
$this->extend('./Layout/TwitterBootstrap/dashboard');
$this->element('menu');?>

<?php $this->assign('tb_sidebar', '<ul class="nav nav-sidebar">' . $this->fetch('tb_actions') . '</ul>'); ?>
<table class="table table-striped" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><div><span><?=__('Identity Provider');?></span></div></th>
            <?php foreach ($attribute_names as $attribute) : ?>
            <th class="rotate"><div><span><?=$attribute ?></span></div></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
      <tr><td>Your releases</td>

        <?php foreach ($attribute_names as $attribute) : ?>
        <?php $background="white"; ?>
        <?php if (isset($myAttributes[$attribute][0]->validated)) :
          if (strtolower($myAttributes[$attribute][0]->validated)=='fail') $background="red";
        endif;?>
        <td bgcolor=<?php echo $background;?>>
          <?=isset($myAttributes[$attribute][0]->validated) ? $myAttributes[$attribute][0]->validated:''; ?>
        </td>
        <?php endforeach;?>

      </tr>
        <?php foreach ($idps as $idp): ?>
        <tr>
            <td><?= $idp ?></td>
            <?php foreach ($attribute_names as $attribute) : 
               $pass = isset($results[$idp][$attribute]['pass']) ? $results[$idp][$attribute]['pass'] : 0; 
               $fail = isset($results[$idp][$attribute]['fail']) ? $results[$idp][$attribute]['fail'] : 0; 
               $ratio = round($pass / ($pass + $fail)*100) ;
               $background="white";
               if ($ratio<100) $background = "red";?>
              <td bgcolor=<?php echo $background;?>><?= $ratio?>% </td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
