<div id="message" class="grid_16">
	<?php echo $session->flash(); ?>
</div>

<div id="content_header" class="grid_16">	
	<div id="section" class="grid_8">	
		<p>Editar libro: <?php //echo $this->data['Book']['title']; ?></p>
	</div>
</div>

<?php echo $form->create('Book', array('action' => 'edit', 'enctype' => 'multipart/form-data', 'name' => 'form', 'class' => 'grid_16 form'));?>
<fieldset>
	<?php echo $form->input('id'); ?>
	<div class="grid_10">
		<?php echo $form->input('title', array('error' => false, 'label' => 'Título')); ?>
		<?php echo $form->error('title', array('class' => 'error', 'wrap' => 'span'));?>
		<div class="input text required">
			<label for="BookAuthor">Autor</label>		
			<?php echo $ajax->autoComplete('Book.author_id', '/authors/autoComplete', array('error' => false, 'label' => 'Título'));?>
		</div>
		<?php echo $form->error('author_id', array('class' => 'error', 'wrap' => 'span'));?>
	</div>		
	<div class="grid_2 book">
		<?php echo $this->Html->image('books/'. $this->data['Book']['image']); ?>
		<?php echo $this->Html->link('', array('controller' => 'books', 'action' => 'delete', $this->data['Book']['id']), array('class' => 'delete'), '¿Seguro que quieres borrar la imagen del libro?'); ?>		
	</div>
	<div class="grid_16">
	<?php echo $form->input('description', array('error' => false, 'label' => 'Descripción')); ?>
	<?php echo $form->error('description', array('class' => 'error', 'wrap' => 'span'));?>					
	</div>
	<div class="grid_8 input text required">
		<label for="BookImage">Portada</label>		
		<?php echo $this->Form->file('Book.image_upload'); ?>
	</div>	
	<p>&nbsp;</p>
	<?php echo $form->submit('Enviar', array('class' => 'button')); ?>
	<span class="clear"></span>
</fieldset>
<?php echo $form->end(); ?>
