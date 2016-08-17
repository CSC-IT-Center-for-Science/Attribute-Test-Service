<style>
th.rotate {
  /* Something you can count on */
  height: 140px;
  white-space: nowrap;
}

th.rotate > div {
  transform: translate3d(40px, 1px, 0) rotate(-90deg);
  width: 10px;
  transform-origin: left bottom;
  box-sizing: border-box;
}
th.rotate > div > span {
  border-bottom: 1px solid #ccc;
  padding: 2px 10px;
}
.csstransforms & th.rotate {
  height: 140px;
  white-space: nowrap;
}
td.box {
  border-right: 1px solid #ccc;
  border-bottom: 1px solid #ccc;
  width: 10px;
  padding: 0px;
}
</style>
<?php
/* @var $this \Cake\View\View */
$this->extend('./Layout/TwitterBootstrap/dashboard');
$this->element('menu');?>

<?php $this->assign('tb_sidebar', '<ul class="nav nav-sidebar">' . $this->fetch('tb_actions') . '</ul>'); ?>
<table class="table" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th width=0px><div><span><?=__('Identity Provider');?></span></div></th>
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
        <td class="box" bgcolor=<?php echo $background;?>>
          <small><?=isset($myAttributes[$attribute][0]->validated) ? $myAttributes[$attribute][0]->validated:''; ?></small>
        </td>
        <?php endforeach;?>

      </tr>
        <?php foreach ($idps as $idp): ?>
        <tr>
            <td width=0x;><?= $idp ?></td>
            <?php foreach ($attribute_names as $attribute) : 
               $pass = isset($results[$idp][$attribute]['pass']) ? $results[$idp][$attribute]['pass'] : 0; 
               $fail = isset($results[$idp][$attribute]['fail']) ? $results[$idp][$attribute]['fail'] : 0; 
               $ratio = round($pass / ($pass + $fail)*100) ;
               $background="white";
               if ($ratio<100) $background = "red";?>
              <td class="box" bgcolor=<?php echo $background;?>><small><?= $ratio?>% </small></td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
