<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=$this->pageTitle;?></title>
	<?=($this->page_css != '' ? '<link href="' . $this->page_css . '" rel="stylesheet" media="all">' : '');?>
	<?=($this->page_js != '' ? '<script src="' . $this->page_js . '"></script>' : '');?>
	<link href="/css/bootstrap/bootstrap.min.css" rel="stylesheet">
	<script src="/js/bootstrap/bootstrap.bundle.min.js"></script>
</head>
<body>
	<ul class="nav justify-content-center">
		<li class="nav-item">
			<a class="nav-link active" aria-current="page" href="/main">Home</a>
		</li>
		<?php if (!$this->adminIsLogged): ?>
		<li class="nav-item">
			<a class="nav-link" href="/login">Login</a>
		</li>
		<?php else: ?>
		<li class="nav-item">
			<a class="nav-link" href="/logout">Logout</a>
		</li>
		<?php endif; ?>
	</ul>