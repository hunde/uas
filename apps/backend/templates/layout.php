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
	<div id="menu">
		<ul>
			  <li class="first"><?php echo link_to('Users', '@user') ?></li>
		          <li><?php echo link_to('Identifications', '@user_identification') ?></li>
		          <li><?php echo link_to('Aliases', '@email_alias') ?></li>
		          <li><?php echo link_to('Domains', '@domainname') ?></li>
		          <li><?php echo link_to('Unix', '@unix_account') ?></li>
		          <li><?php echo link_to('FTP', '@ftp_account') ?></li>
                          <li><?php echo link_to('Samba', '@samba_account') ?></li>

		</ul>
	</div>
	<!-- end #menu -->
</div>
<!-- end #header -->
<div id="page">
        <?php if ($sf_user->getUserHistory() != NULL): ?>
	<div id="user_history">
	    Recent viewed users:
	    <?php foreach ($sf_user->getUserHistory() as $user): ?>
	    <?php echo link_to($user->getFullName(), 'user', $user) ?>
	    <?php endforeach; ?>
	</div>
	<?php endif; ?>
	<div id="content">
        <?php if($sf_user->isAuthenticated()): ?>
        <div> <?php echo link_to('Logout', 'session/logout') ?> </div>
        <?php endif; ?>
        <?php echo $sf_content ?>
	</div>
	<!-- end #content -->
	
	<div id="footer">
        <div class="content">
        <!-- footer content -->
       
       <ul>
      <li>
        <a href=""><?php echo __('About UAS') ?></a>
      </li>
      <li class="feed">
        <?php echo link_to(__('Full feed'), '@user?sf_format=atom') ?>
      </li>
      <li>
        <a href=""><?php echo __('UAS API') ?></a>
      </li>
      <li class="last">
        <?php echo link_to(__('Become an a Member'), '@user') ?>
      </li>
    </ul>
    <?php include_component('language', 'language') ?>
  </div>
 </div>



</div>
<div id="footer">
<p>
Powered by <a href="http://www.symfony-project.org/"><img align="middle" src="/images/symfony_button.gif" alt="Symfony_button" /></a>&nbsp;-&nbsp;
The development of this system was sponsored by <a target="_blank" href="http://www.vliruos.be/"><img align="middle" src="/images/vliruos.jpg" alt="VLIRUOS" /></a>
</div>
<!-- end #page -->

</body>
</html>

