<?php
/**
 * @var $this View
 */
?>
<div class="page-header">
    <h1><?php echo __('Change password');?></h1>
</div>
<div class="row">
    <div class="span12">
    	<?php echo $this->BootstrapForm->create('User',array('class'=>'form-horizontal'));?>
        <fieldset>
    		<?php echo $this->BootstrapForm->input('current_password',array('type'=>'password','div'=>'control-group','label'=>array('text'=>__('Current password'),'class'=>'control-label'),'error'=>array('attributes'=>array('wrap'=>'span','class'=>'help-inline')),'between'=>'<div class="controls">','after'=>'<p class="help-block"></p>')); echo '</div>'; ?>
            <?php echo $this->BootstrapForm->input('new_password',array('type'=>'password','div'=>'control-group','label'=>array('text'=>__('New password'),'class'=>'control-label'),'error'=>array('attributes'=>array('wrap'=>'span','class'=>'help-inline')),'between'=>'<div class="controls">','after'=>'<p class="help-block"></p>')); echo '</div>'; ?>
            <?php echo $this->BootstrapForm->input('repeat_password',array('type'=>'password','div'=>'control-group','label'=>array('text'=>__('Repeat password'),'class'=>'control-label'),'error'=>array('attributes'=>array('wrap'=>'span','class'=>'help-inline')),'between'=>'<div class="controls">','after'=>'<p class="help-block"></p>')); echo '</div>'; ?>
        </fieldset>
		<div class="form-actions">
			<?php echo $this->BootstrapForm->button(__('Change password'), array('type'=>'submit','class'=>'btn btn-primary')); ?>
		</div>
    	<?php echo $this->BootstrapForm->end();?>
    </div>
</div>