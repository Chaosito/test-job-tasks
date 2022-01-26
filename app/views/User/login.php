<div class="container">
	<div class="row">
		<div class="col-2"></div>
		<div class="col">
			<h1><?=$this->pageTitle;?></h1>
			
			<?php if ($this->viewErrors) : ?>
			<div class="alert alert-danger" role="alert">
				<?php foreach($this->viewErrors as $error): ?>
					<div>• <?=$error;?></div>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
			
			<form method="POST">
				<div class="mb-3">
					<label for="username" class="form-label">Login:</label>
					<input type="text" class="form-control" name="login" id="login" value="<?=$this->login;?>">
				</div>
				<div class="mb-3">
					<label for="exampleInputPassword1" class="form-label">Password</label>
					<input type="password" class="form-control" name="password" id="password">
				</div>
				<input type="hidden" value="1" name="from_login" />
				<button type="submit" class="btn btn-primary">Login</button>
			</form>
		</div>
		<div class="col-2"></div>
	</div>
</div>