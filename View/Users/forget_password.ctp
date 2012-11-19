<div class="page-header">
  <h1><?php echo __('User');?> <small><?php echo __('Forget Password'); ?></small></h1>
</div>
<div class="row">
    <div class="span12">
    	<?php echo $this->BootstrapForm->create('User', array('class'=>'form-horizontal'));?>
        <fieldset>
			<?php echo $this->BootstrapForm->input('User.email',array('div'=>'control-group','label'=>array('text'=>__('Email Address'),'class'=>'control-label'),'error'=>array('attributes'=>array('wrap'=>'span','class'=>'help-inline')),'between'=>'<div class="controls">','after'=>'<p class="help-block"></p>')); echo '</div>'; ?>
        </fieldset>
		<div class="form-actions">
			<?php echo $this->BootstrapForm->button(__('Send'), array('type'=>'submit','class'=>'btn btn-primary')); ?>
			<?php echo $this->BootstrapForm->button(__('Cancel'), array('type'=>'cancel','class'=>'btn btn-default')); ?>
		</div>
		<?php echo $this->BootstrapForm->end();?>
    </div>
</div>