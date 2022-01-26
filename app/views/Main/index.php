<?php
$sortBy = ($this->sorting == 'DESC') ? 'ASC' : 'DESC';
$linkValue = ($sortBy == 'ASC') ? '&uarr;' : '&darr;';
?>
<div class="container">
  <div class="row">
    <div class="col-2"></div>
    <div class="col">
		<h1><?=$this->pageTitle;?></h1>
		<a class="btn btn-primary" href="/main/task_create">Add Task</a>
		<?php if ($this->tasks): ?>
		<table class="table">
			<thead>
				<tr>
					<th>Username <a href="/main/index/?orderby=username&sort=<?=$sortBy;?>&cur_page=<?=$this->curPage;?>"><?=$linkValue;?></a></th>
					<th>Mail <a href="/main/index/?orderby=mail&sort=<?=$sortBy;?>&cur_page=<?=$this->curPage;?>"><?=$linkValue;?></a></th>
					<th>Task text <a href="/main/index/?orderby=task_text&sort=<?=$sortBy;?>&cur_page=<?=$this->curPage;?>"><?=$linkValue;?></a></th>
					<th>Is complete <a href="/main/index/?orderby=is_complete&sort=<?=$sortBy;?>&cur_page=<?=$this->curPage;?>"><?=$linkValue;?></a></th>
				</tr>	
			</thead>
			<?php foreach($this->tasks as $task): ?>
				<?php $link = ($this->adminIsLogged) ? "<a href='/main/task_edit/?task_id={$task['rowid']}'>{$task['username']}</a>" : "{$task['username']}"; ?>
				<?php $editedByAdmin = ((int)$task['edited_by_admin']) ? ' (Edited by Admin)' : ''; ?>
				<?="<tr><td>{$link}</td><td>{$task['mail']}</td><td>{$task['task_text']}</td><td>".($task['is_complete'] == 1 ? "Yes" : "No").$editedByAdmin."</td></tr>";?>
			<?php endforeach;?>
		</table>
		<?php endif;?>
		
		<nav aria-label="Page navigation example">
		  <ul class="pagination justify-content-center">
			<?php for($i = 1; $i <= $this->maxPages; $i++): ?>
				<li class="page-item"><a class="page-link" href="/main/index/?orderby=<?=$orderBy;?>&sort=<?=$this->sorting;?>&cur_page=<?=$i;?>"><?=$i;?></a></li>
			<?php endfor;?>
		  </ul>
		</nav>
    </div>
    <div class="col-2"></div>
  </div>
</div>