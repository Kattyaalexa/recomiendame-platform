<div id="message" class="grid_16">
	<?php echo $session->flash(); ?>
</div>

<div id="content_header" class="grid_16">	
	<div id="section" class="grid_4">	
		<p>Libros</p>
	</div>
	<div id="section_new" class="grid_5">	
		<?php echo $this->Html->link('Añadir nuevo libro', array('controller' => 'books', 'action' => 'add')); ?>
	</div>	
</div>

<?php foreach ($books as $book): ?>

<div class="grid_16 element">	
	<div class="grid_2 book">
		<?php echo $this->Html->image('books/'. $book['Book']['image']); ?>
		<div class="score">8</div>
		<?php echo $this->Html->link('', array('controller' => 'books', 'action' => 'edit', $book['Book']['id']), array('class' => 'edit')); ?>
		<?php echo $this->Html->link('', array('controller' => 'books', 'action' => 'delete', $book['Book']['id']), array('class' => 'delete'), '¿Seguro que quieres borrar el libro '. $book['Book']['title'] . "?"); ?>
		
	</div>
	<div class="grid_6">
		<div class="grid_6 title"><?php echo $this->Html->link($book['Book']['title'], array('controller' => 'books', 'action' => 'view', $book['Book']['id'])); ?></div>
		<div class="grid_6 author"><?php echo $book['Author']['name']; ?></div>
		<div class="grid_6 created">Añadido: <?php echo $book['Book']['created']; ?></div>
	</div>
	<div class="grid_7">
		<div class="grid_7 opinion">Hay <strong>5</strong> opiniones sobre este libro.</div>
		<div class="button"><span><?php echo $this->Html->link('Opinar', array('controller' => 'books', 'action' => 'opinion', $book['Book']['id'])); ?></span></div>
		<div class="button"><span>Descargar</span></div>
		<div class="button"><span><?php echo $this->Html->link('Detalles', array('controller' => 'books', 'action' => 'view', $book['Book']['id'])); ?></span></div>
	</div>
	
</div>

<?php endforeach; ?>

<p id="pagin" class="grid_16">
	<?php echo $paginator->counter(array('format' => __('Página %page% de %pages%, mostrando %current% libros de %count%', true)));?><br>
	<?php echo $paginator->prev('<< ', array(), null);?>
	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(' >>', array(), null);?>
</p>