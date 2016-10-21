<?php
if($this->ion_auth->logged_in()===FALSE):
    ?>

<ul class="nav navbar-right">
    <li class="active"><a href="<?php echo site_url(); ?>">Home</a></li>

</ul>

<?php
else: ?>
<ul class="nav navbar-right">
    <li class="active"><a href="<?php echo site_url(); ?>">Home</a></li>
    <li><a href="<?php echo site_url('Register'); ?>">Register</a></li>
    <li><a href="<?php echo site_url('example/example_2'); ?>">Example 2</a></li>
    <li><a href="<?php echo site_url('example/example_3'); ?>">Example 3</a></li>
    <li><a href="<?php echo site_url('user/logout'); ?>">Log Out</a></li>
</ul>

<?php endif;