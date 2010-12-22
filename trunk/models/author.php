<?php
class Author extends AppModel {

	var $name = 'Author';
	
	var $validate = array(
		'id' => array(
			'rule' => 'notempty'
		),
		'name' => array(
			'rule' => 'notempty',
			'required' => true,
			'message' => 'El campo no puede estar vacio.'
		)	
	);	
	
	var $hasMany = array(
	'Book' => array('className' => 'Book',
						'foreignKey' => 'author_id',
						'dependent' => false
					));
}
?>