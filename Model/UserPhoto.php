<?php
App::uses('AppModel', 'Model');

/**
 * UserPhoto Model
 *
 * @property User $User
 */
class UserPhoto extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'name';

	/**
	 * Behaviors
	 *
	 * @var array
	 */
	public $actsAs = array(
		'Containable',
		'MeioUpload.MeioUpload' => array(
			'filename' => array(
				//'dir' => 'uploads{DS}{model}{DS}{field}',
				'maxSize' => '10 Mb',
				'createDirectory' => true,
				'allowedMime' => array('image/jpeg', 'image/pjpeg', 'image/png','image/jpeg'),
				'allowedExt' => array('.jpg', '.jpeg', '.png', '.gif'),
				'thumbsizes' => array(
					'index' => array('width'=>80, 'height'=>80, 'zoomCrop' => true),
				),
				'default' => 'default.jpg'
			)
		)
	);

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
