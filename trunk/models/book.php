<?php
class Book extends AppModel {

	var $name = 'Book';
	
	var $validate = array(
		'id' => array(
			'rule' => 'notempty'
		),
		'title' => array(
			'rule' => 'notempty',
			'required' => true,
			'message' => 'El campo no puede estar vacio.'
		),		
		'author_id' => array(
			'rule' => 'notempty',
			'required' => true,
			'message' => 'El campo no puede estar vacio.'
		),
		'description' => array(
			'rule' => 'notempty',
			'required' => true,
			'message' => 'El campo no puede estar vacio.'
		)		
	);
	
	var $belongsTo = array(
		'Author' => array('className' => 'Author',
						  'foreignKey' => 'author_id'
						 )
	);
}
?>