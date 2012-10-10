<div class="page-header">
  <h1><?php  echo __('Mi Cuenta');?> <small><?php echo __('Perfil');?></small></h1>
</div>
<div class="row">
    <div class="span12">
        <dl>
			<dt><?php echo __('Nombre Completo'); ?></dt>
			<dd><?php echo h($admin['Admin']['name_completo']); ?>&nbsp;</dd>
			<dt><?php echo __('Adminname'); ?></dt>
			<dd><?php echo h($admin['Admin']['username']); ?>&nbsp;</dd>
			<dt><?php echo __('Email'); ?></dt>
			<dd><?php echo $this->Html->link($admin['Admin']['email'],'mailto:'.$admin['Admin']['email']); ?>&nbsp;</dd>
			<dt><?php echo __('Status'); ?></dt>
			<dd>
                <?php if ($admin['Admin']['is_active']) { ?>
                    <?php echo $this->Icon->get('tick'); ?> <?php echo __('Active'); ?>
                <?php } else { ?>
                    <?php echo $this->Icon->get('cross'); ?> <?php echo __('Inactive'); ?>
                <?php } ?>
			</dd>
			<dt><?php echo __('Role'); ?></dt>
   			<dd><?php echo $this->Html->link($admin['Role']['name'], array('controller' => 'roles', 'action' => 'view', $admin['Role']['id'])); ?>&nbsp;</dd>
        </dl>
    </div>
	<br clear="all" />
	<div class="form-actions">
		<?php echo $this->Html->link(__('Cambiar Contraseña'), array('action' => 'changepassword'), array('class'=>'btn default')); ?>
	</div>
</div>