<?php
/*
* Default template for application
*/
$template['title'] = 'Php Test';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $template['title']; ?></title>    
	<!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
	<script type="text/javascript"> var siteUrl = "<?php echo site_url(); ?>"</script>
    <!-- Include CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="<?php echo $this->config->item('ASSESTS_PATH');?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $this->config->item('ASSESTS_PATH');?>css/angular-confirm.min.css">   
    <link rel="stylesheet" href="<?php echo $this->config->item('ASSESTS_PATH');?>css/app.css">   
    
	<!-- Include jquery JS -->
    <script src="<?php echo $this->config->item('ASSESTS_PATH');?>js/jquery.min.js"></script> 
	<script src="<?php echo $this->config->item('ASSESTS_PATH');?>js/popper.min.js"></script> 
    <script src="<?php echo $this->config->item('ASSESTS_PATH');?>js/bootstrap.min.js"></script> 
    <script src="<?php echo $this->config->item('ASSESTS_PATH');?>js/angular.min.js"></script> 
    <script src="<?php echo $this->config->item('ASSESTS_PATH');?>js/dirPagination.js"></script> 
    <script src="<?php echo $this->config->item('ASSESTS_PATH');?>js/angular-confirm.min.js"></script> 
    
	
  </head>
	<body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">		
			<!-- Content Wrapper. Contains page content -->
			<div class="container">		
				<?php echo $template['body']; ?>	 
			
		  
				<footer class="main-footer" style="text-align: center;">
				copyright &copy; Netwin Infosolutions
				</footer>
			</div><!-- /.content-wrapper --> 
		</div><!-- ./wrapper -->
		
		<!-- Include JS files -->		  
		<script src="<?php echo $this->config->item('ASSESTS_PATH');?>js/addressbook.js"></script>    
	</body>
</html>
