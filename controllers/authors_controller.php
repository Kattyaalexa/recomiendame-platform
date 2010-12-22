<?php
/** 
*
* @autor: Carlos Loredo
*
*/
class AuthorsController extends AppController 
{
	var $name = 'Authors';
	var $components = array( 'RequestHandler' );
	
	function index() 
	{		
		$this->Author->recursive = 0;
		$authors = $this->paginate('Book');
		if (!$authors){			
			$this->set('message', 'La base de datos no dispone de autores.');
			$this->layout = 'nodata';
		}
		else
			$this->set('authors', $authors);		
	}
	
	function autoComplete()
	{
		$this->set('authors', $this->Author->find('all', array(
						'conditions' => array(
							'Author.name LIKE' => $this->data['Book']['author_id'].'%'
						),
					'fields' => array('name')
		)));
	}
	
	function add() 
	{
		if (!empty($this->data)) 
		{			
			$this->Author->create();
			if ($this->Author->save($this->data)){
				$this->Session->setFlash('Se ha guardado el autor corréctamente.', 'flash_message_ok');
				$this->redirect(array('action'=>'index'));
			} 
			else 
				$this->Session->setFlash('Se produjo un error, por favor vuelve a intentarlo.', 'flash_message');							
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
			$this->Session->setFlash('La sesión ha expirado.', 'flash_message');
			$this->redirect(array('controller'=> 'login', 'action'=>'index'));	
		}
	}
	
}
?>