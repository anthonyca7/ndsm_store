<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 * @property string $last_login
 *
 * The followings are the available model relations:
 * @property Item[] $items
 */
class User extends CustomActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $password_repeat;

	public function tableName()
	{
		return 'user';
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{

		return array(
			array('email, username, password, first, last, password_repeat, is_admin, is_active', 'required'),
			array('email', 'unique'),
			array('username', 'unique'),
			array('email', 'email'),
			array('email', 'length', 'max'=>255, 'min'=>10),
			array('password, password_repeat, username', 'length', 'max'=>255, 'min'=>6),
			array('password', 'compare'),
			array('password_repeat', 'safe'),

			array('id, email, status, create_time, update_time, last_login', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'items' => array(self::MANY_MANY, 'Item', 'reservation(user_id, item_id)'),
			'store' => array(self::BELONGS_TO, 'Store', 'school_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'first' => 'First Name',
			'last' => 'Last Name',
			'school_id' => 'Store',
			'password_repeat' => 'Confirm Password',
			'email' => 'Email',
			'password' => 'Password',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'last_login' => 'Last Login',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('first',$this->first);
		$criteria->compare('last',$this->last);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('last_login',$this->last_login,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function validatePassword($password)
	{
		return $this->password === crypt($password, '$2a$10$anthony.cabshahdasswor$');
	}

	 /**	
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
