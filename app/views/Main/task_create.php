
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
					<label for="username" class="form-label">User name:</label>
					<input type="text" class="form-control" value="<?=$this->username;?>" name="username" id="username">
				</div>
				<div class="mb-3">
					<label for="mail" class="form-label">Email:</label>
					<input type="email" class="form-control" value="<?=$this->mail;?>" name="mail" id="mail">
				</div>
				<div class="mb-3">
					<label for="task_text" class="form-label">Task text:</label>
					<textarea class="form-control" name="task_text" id="task_text" rows="3"><?=$this->task_text;?></textarea>
				</div>
				<input type="hidden" value="1" name="from_create" />
				<button type="submit" class="btn btn-primary">Save task</button>
			</form>
		</div>
		<div class="col-2"></div>
	</div>
</div>