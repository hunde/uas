
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>User Administration System</title>
	<?php use_stylesheet('admin.css') ?>
   <?php include_javascripts() ?>
   <?php include_stylesheets() ?></head>
<body>
<div id="header">
	<div id="logo">
		<h1><a href="#">UAS</a></h1>
		<p>User Administration System</p>
	</div>
	<!-- end #logo -->
	<?php if($sf_user->isAuthenticated()): ?>
	<div id="menu">
		<ul>
			  <li class="first">
			  <li> <?php echo link_to('Account', 'user/show') ?> </li> 
			  <li> <?php echo link_to('Comment', 'comment/new') ?></li> 
			  <li> <?php echo link_to('Logout', 'session/logout') ?></li>
		</ul>
	</div>
	<!-- end #menu -->
	<?php endif; ?>
</div>
<!-- end #header -->
<div id="page">
	<div id="content">
        <h3><?php if ($sf_user->hasFlash('notice')): ?>
        <div class="flash_notice"><?php echo $sf_user->getFlash('notice');
                                             $sf_user->setFlash('notice', '');
                                   ?>
        </div>
        <?php endif; ?>
        <?php if ($sf_user->hasFlash('error')): ?>
          <div class="flash_error"><?php echo $sf_user->getFlash('error');
                                              $sf_user->setFlash('error', '');  
                                   ?>
          </div>
        <?php endif; ?>
        </h3>

        <?php echo $sf_content ?>
	</div>
	<!-- end #content -->

</div>
<div id="footer">
<p>
Powered by <a href="http://www.symfony-project.org/"><img align="middle" src="/images/symfony_button.gif" alt="Symfony_button" /></a>&nbsp;-&nbsp;
The development of this system was sponsored by <a target="_blank" href="http://www.vliruos.be/"><img align="middle" src="/images/vliruos.jpg" alt="VLIRUOS" /></a>
</div>
<!-- end #page -->
</body>
</html>

