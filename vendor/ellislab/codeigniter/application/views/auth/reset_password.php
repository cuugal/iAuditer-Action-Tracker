<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-md-12">

		<h1><?php echo lang('reset_password_heading');?></h1>
		<div id="infoMessage"><?php echo $message;?></div>


		<?php echo form_open('auth/reset_password/' . $code, "class='form-horizontal col-sm-12'");?>

		<div class="form-group">
			<div class="col-sm-3 control-label">
				<label
					for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label>
				<br/>
			</div>
			<div class="col-sm-8">
				<?php echo form_input($new_password,'','class="form-control"'); ?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-3 control-label">
				<label <?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?></label>
				<br/>
			</div>
			<div class="col-sm-8">
				<?php echo form_input($new_password_confirm,'','class="form-control"'); ?>
			</div>
		</div>

		<?php echo form_input($user_id);?>
		<?php echo form_hidden($csrf); ?>

		<div class="form-group">
			<div class="col-sm-3 control-label">
				&nbsp;
			</div>
			<div class="col-sm-8">
				<?php echo form_submit('submit', lang('reset_password_submit_btn'), "class='btn btn-primary'"); ?>
			</div>
		</div>

		<?php echo form_close(); ?>
	</div>
</div>


