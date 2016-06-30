<?php
/* @var $this \Cake\View\View */
$this->extend('./Layout/TwitterBootstrap/dashboard');
$this->element('menu');
?>
<div class="container-fluid">
  <div class="row">

    <?php $i=0;
    if (isset($attributes)) : 
    foreach ($attributes as $schema => $attribute) :
      // This one makes half of 'schemas' to go separate columns
      if($i%(count($attributes)/2) == 0) :
        echo $i > 0 ? "</div>" : "";?>
        <div class="col-sm-6">
      <? endif;
      if ($i==0) : ?>
      <div class="jumbotron">
      <h2> Released attributes </h2>
      <b>IdP :</b> <?=$this->request->env('Shib-Identity-Provider');?><br/>
      <b>Auth Method :</b> <?=$this->request->env('Shib-Authentication-Method');?><br/>
      <b>PersistentID : </b> <small><?=$this->request->env('persistent-id');?></small>
      </div>
      <?php endif; ?>


        <table class="table table-striped">
          <thead>
            <tr><th>
              <h4><?=$schema;?></h4>
            </th></tr>
          </thead>
          <tbody>
            <?php foreach ($attribute as $attr => $value) :?>
              <tr><td>
                <small><?=$attr;?></small>  </td><td width=100%"> <?=isset($value['errors']) ? '<font color=red>'.$value['value'].'</font>' : $value['value'];?>
              </td></tr>
            <?php endforeach;?>
          </tbody>
        </table>
    <?php $i++;
    endforeach; 
    endif;?>
    </div>

  </div>
</div>
