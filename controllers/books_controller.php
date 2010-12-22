<?php
/** 
*
* @autor: Carlos Loredo
*
*/
class BooksController extends AppController 
{
	var $name = 'Books';
	var $helpers = array('Ajax');
	var $uses = array('Book', 'Author');
	var $components = array('SimpleImage');
	
	function index() 
	{			
		$this->Book->recursive = 0;
		$books = $this->paginate('Book');
		if (!$books){			
			$this->set('message', 'La base de datos no dispone de libros.');
			$this->layout = 'nodata';
		}
		else
			$this->set('books', $books);		
	}
	
	function add() 
	{
		if (!empty($this->data)) 
		{						
			if (!$this->Author->field('name', array('Author.name LIKE' => $this->data['Book']['author_id'].'%')))
			{	
				$author_record = array('name' => $this->data['Book']['author_id']);
				$this->Author->create($author_record);
				$this->Author->save($author_record);				
			}
			$author_id = $this->Author->field('id', array('Author.name LIKE' => $this->data['Book']['author_id'].'%'));
			$author_name = $this->data['Book']['author_id'];
			$this->data['Book']['author_id'] = $author_id;
			
			$image_name = md5($this->data['Book']['title'] . $author_name) . '.jpg';
			$this->__processImage($this->data, 'add', $image_name);			
			
			$this->Book->create();
			if ($this->Book->save($this->data))
			{
				$this->Session->setFlash('Se ha guardado el libro corréctamente.', 'flash_message_ok');
				$this->redirect(array('action'=>'index'));
			} 
			else
			{
				$this->data['Book']['author_id'] = $author_name;
				$this->Session->setFlash('Se produjo un error, por favor vuelve a intentarlo.', 'flash_message_error');							
			}			
		}		
	}

	function edit($id = null) 
	{
		if (!$id && empty($this->data)) 
		{
			$this->Session->setFlash('No existe el libro.', 'flash_message_error');
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) 
		{
			if (!$this->Author->field('name', array('Author.name LIKE' => $this->data['Book']['author_id'].'%')))
			{	
				$author_record = array('name' => $this->data['Book']['author_id']);
				$this->Author->create($author_record);
				$this->Author->save($author_record);				
			}
			$author_id = $this->Author->field('id', array('Author.name LIKE' => $this->data['Book']['author_id'].'%'));
			$author_name = $this->data['Book']['author_id'];
			$this->data['Book']['author_id'] = $author_id;
			
			$image_name = md5($this->data['Book']['title'] . $author_name) . '.jpg';
			$this->__processImage($this->data, 'edit', $image_name);			
			
			if ($this->Book->save($this->data))
			{
				$this->Session->setFlash('Se ha actualizado el libro corréctamente.', 'flash_message_ok');			
				$this->redirect(array('action'=>'index'));
			}
			else
			{
				$this->data['Book']['author_id'] = $author_name;
				$this->Session->setFlash('There was an error. Please, try again.', 'flash_message_error');			
			}
		}
		if (empty($this->data)) 
		{						
			$this->data = $this->Book->read(null, $id);
			$this->data['Book']['author_id'] = $this->Author->field('name', array('Author.id' => $this->data['Book']['author_id'].'%'));
		}
	}
	
	function __processImage($data, $action, $image_name)
	{
		if ($data['Book']['image_upload']['name'])
		{
			if ($data['Book']['image_upload']['type'] != 'image/jpeg')
			{
				$this->Session->setFlash('El formato de la imagen debe ser jpeg.', 'flash_message_error');							
				$this->redirect(array('action'=>$action));
			}
			if ($data['Book']['image_upload']['error'] != 0)
			{
				$this->Session->setFlash('Se produjo un error al subir la imagen.', 'flash_message_error');							
				$this->redirect(array('action'=>$action));
			}
			else
			{
				$upload_path = WWW_ROOT. 'img/books/';
				if (file_exists($upload_path . $image_name))
					unlink($upload_path . $image_name);
				if (!move_uploaded_file($data['Book']['image_upload']['tmp_name'], $upload_path . $image_name))
				{
					$this->Session->setFlash('Se produjo un error al subir la imagen.', 'flash_message_error');		
					$this->redirect(array('action'=>$action));
				}	
				$data['Book']['image'] = $image_name;					
				$this->SimpleImage->load($upload_path . $image_name);
				$this->SimpleImage->resize(100,145);
				$this->SimpleImage->save($upload_path . $image_name);
			}
		}	
	}	
	
	
	function delete($id = null) 
	{
		if (!$id) 
		{
			$this->Session->setFlash('No existe el libro.', 'flash_message_error');
			$this->redirect(array('action'=>'index'));
		}
		$image = $this->Book->field('Book.image', array('Book.id'=>$id));
		if ($this->Book->delete($id)) 
		{
			if ($image && file_exists(WWW_ROOT . 'img/books/' . $image))
				unlink(WWW_ROOT . 'img/books/' . $image);
			$this->Session->setFlash('Se ha eliminado el libro.', 'flash_message_ok');
			$this->redirect(array('action'=>'index'));
		}
		else
		{
			$this->Session->setFlash('Hubo un problema al eliminar el libro.', 'flash_message_error');
			$this->redirect(array('action'=>'index'));		
		}
	}	
	
	function beforeFilter()
	{
		//$this->__validaSesion();
	}

	// @Comprueba si la sesión esta activa. Privado.		
	function __validaSesion()
	{
		// Comprueba si esta en sesión.
		if(!$this->Session->check('Admin'))
		{
			$this->Session->setFlash('La sesión ha expirado.', 'flash_message_error');
			$this->redirect(array('controller'=> 'login', 'action'=>'index'));	
		}
	}
	
}
?>