<div class="admin-header">
	<h1>Latest Posts</h1>
	<span class="last-update"></span>
	<div class="button-wrap">
		<a href="admin-blog/create" class="button right">Add new</a>
	</div>
</div>

<div class="admin-content">
    <?php Alert::show() ?>
	
	<?php if (count($this->view->posts) != 0): ?>
		<ul>
		<?php foreach ($this->view->posts as &$post): ?>
			<li><a href="admin-blog/edit/<?php echo $post['id'] ?>"><?php echo $post['title'] ?></a></li>
		<?php endforeach ?>
		</ul>
	<?php endif	?>

	<?php if (count($this->view->comments) != 0): ?>
		<div class="section-header">
			<span>Latest Comments</span>
			<div class="line"></div>
		</div>
	
		<ul class="comments border">
		<?php foreach ($this->view->comments as &$comment): ?>

			<li class="cf <?php if(!$comment['approved']): ?>disapproved <?php endif ?>">
				<a class="article-title" href="blog/post-edit/<?php echo $comment['post']->id ?>" target="_blank"><?php echo $comment['post']->title ?></a>
				<div class="name"><?php echo $comment['name'] ?> / <?php echo $comment['email'] ?></div>
				<p><?php echo $comment['content'] ?></p>
				<div class="created_at"><?php echo $comment['created_at']->format('Y-m-d H:i') ?>h</div>

				<?php if ($comment['approved']): ?>
					<a class="action button" href="blog/disapprove-comment/<?php echo $comment['id'] ?>">Disapprove</a>
				<?php else: ?>
					<a class="action button disapproved" href="blog/approve-comment/<?php echo $comment['id'] ?>">Approve</a>
				<?php endif ?>
			</li>
		<?php endforeach ?>
		</ul>

	<?php endif	?>
</div>