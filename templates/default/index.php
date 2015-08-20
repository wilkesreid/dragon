<html>
	<head>
		<!-- <title><?="<? echo \$CMS->config->title; ?>";?></title> -->
		<title><? echo $CMS->config->title; ?></title>
	</head>
	<body>
		<div style='margin:0 auto;width:950px;padding:20px;border:1px solid gray;'>
			<!-- <h1><?="<? echo \$CMS->config->title;?>";?></h1> -->
			<h1><? echo $CMS->config->title;?></h1>
			<hr>
			<!-- <?="<? \$CMS->mod('nav');?>";?> -->
			<? $CMS->location('nav_bar'); ?>
			<hr>
			<!-- <?="<? echo \$CMS->page; ?>";?> -->
			<? echo $CMS->page; ?>
			<hr>
			<!-- <?="<? \$CMS->mod('footer');?>";?> -->
			<?
			$CMS->location('footer');
			?>
		</div>
	</body>
</html>