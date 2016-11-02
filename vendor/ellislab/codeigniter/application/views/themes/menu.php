<!-- Navigation -->
  <nav class="navbar navbar-default navbar-fixed-top" role="navigation" >
      <div class="container">
          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand page-scroll" href="<?php echo site_url(); ?>"><img src="<?php echo base_url(); ?>assets/images/Black-UTS-logo.png" height="30px"></a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse navbar-ex1-collapse">
              <ul class="nav navbar-nav">
                  <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                  <li class="hidden">
                      <a class="page-scroll" href="#page-top"></a>
                  </li>

                    <li>
                        <a class="page-scroll active" href="<?php echo site_url('Inspection'); ?>">Inspections</a>
                    </li>
                  <?php if($this->ion_auth->logged_in()): ?>


                      <li>
                          <a class="page-scroll" href="<?php echo site_url('ActionRegister'); ?>">Action Register</a>
                      </li>
                      <li>
                          <a class="page-scroll" href="<?php echo site_url('HazardEdit'); ?>">Hazard Edit</a>
                      </li>

                          <?php if($this->ion_auth->is_admin()): ?>
                              <li>
                                  <a class="page-scroll" href="<?php echo site_url('Register'); ?>">Register New User</a>
                              </li>

                              <li>
                                  <a class="page-scroll" href="<?php echo site_url('Register'); ?>">Admin Functions</a>
                              </li>
                              <li>
                                  <a class="page-scroll " href="<?php echo site_url('Import/GetData'); ?>">Reload Audits</a>
                              </li>
                          <?php endif; ?>
                  <?php endif; ?>
                  </ul>

                    <ul class="nav navbar-nav" style="float:right">
                        <?php  if($this->ion_auth->logged_in()): ?>
                      <li><a class="page-scroll">Welcome, <?= $this->ion_auth->user()->row()->first_name;?>
                              <?=$this->ion_auth->user()->row()->last_name;?></a>
                      </li>
                      <li>
                          <a class="page-scroll" href="<?php echo site_url('user/logout'); ?>"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span></a>
                      </li>

                    <?php else: ?>
                      <li>
                          <a class="page-scroll" href="<?php echo site_url('user/login'); ?>"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span></a>
                      </li>

                        <?php endif; ?>
              </ul>

          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container -->
  </nav>