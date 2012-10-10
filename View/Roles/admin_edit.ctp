<div class="page-header">
	<h1><?php echo __('Roles');?> <small><?php echo __('Edit Role'); ?></small></h1>
</div>
<div class="row">
	<div class="span12">
		<?php echo $this->Form->create('Role',array('class'=>'form-horizontal'));?>
		<fieldset>
			<legend><?php echo __('Edit Role'); ?></legend>
			<?php echo $this->Form->input('id',array('div'=>'control-group','label'=>array('class'=>'control-label'),'error'=>array('attributes'=>array('wrap'=>'span','class'=>'help-inline')),'between'=>'<div class="controls">','after'=>'<p class="help-block"></p>')); ?>
			<?php echo $this->Form->input('name',array('div'=>'control-group','label'=>array('class'=>'control-label'),'error'=>array('attributes'=>array('wrap'=>'span','class'=>'help-inline')),'between'=>'<div class="controls">','after'=>'<p class="help-block"></p>')); echo '</div>'; ?>
			<div class="form-actions">
				<?php echo $this->Form->button(__('Submit'),array('class'=>'btn btn-primary')); ?>
				<?php echo $this->Form->button(__('Cancel'),array('class'=>'btn btn-default')); ?>
			</div>
		</fieldset>
		<?php echo $this->Form->end();?>
	</div>
</div>