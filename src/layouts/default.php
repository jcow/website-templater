<html>


<head>

	<link rel="stylesheet" type="text/css" href="<?=$_pageVars['config']['baseUrl']?>/_static/css/mysite.css">

</head>


<body>
	<div class="content-container">
		<h1><?= (array_key_exists('title', $_pageVars) ? $_pageVars['title'] : '');?></h1>

		<nav>
			<a href="<?= $_pageVars['config']['baseUrl'];?>/content/myFirstPage.html">My First Page</a>
		</nav>

		<div><?= $_pageVars['pageContent']; ?></div>
	</div>
</body>

</html>