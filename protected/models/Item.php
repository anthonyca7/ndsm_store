<?php

/**
 * This is the model class for table "item".
 *
 * The followings are the available columns in table 'item':
 * @property integer $id
 * @property string $name
 * @property string $price
 * @property integer $quantity
 * @property string $description
 *
 * The followings are the available model relations:
 * @property User[] $users
 */
class Item extends CustomActiveRecord
{


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'unique'),
			array('name, description, price, quantity, available, school_id', 'required'),
			array('quantity', 'numerical', 'integerOnly'=>true, 'min'=>1),
			array('available', 'numerical', 'integerOnly'=>true, 'min'=>0),
			array('name', 'length', 'max'=>255),
			array('price', 'length', 'max'=>9),
			array('available', 'compare', 'compareAttribute'=>'quantity', 'operator'=>'<=', 
				'message'=>'The number of items available cannot be less than the quantity'),
			array('price', 'numerical', 'min'=>0.01),
			array('image', 'file', 'types'=>'jpg, gif, png'),
			array('image, school_id', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, price, quantity, description', 'safe', 'on'=>'search'),
		);
	}

	public static function capitalize($str)
	{
		$str[0] = strtoupper($str[0]);
		return $str;
	}

	public static function getImage($id, $name)
	{
		$loc = Yii::app()->basePath . "/../images/" . $id . '/' . $name; 

		if ( @getimagesize($loc) )
		{
		   return Yii::app()->baseUrl . "/images/" . $id . '/' . $name;
		} 
		else 
		{
		   return Yii::app()->baseUrl . "/images/noimage.jpg";
		}

	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'users' => array(self::MANY_MANY, 'User', 'reservation(item_id, user_id)'),
			'store' => array(self::BELONGS_TO, 'Store', 'school_id')
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'school_id' => 'Store',
			'price' => 'Price',
			'quantity' => 'Quantity',
			'description' => 'Description',
			'available' => 'Available',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('available',$this->available);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Item the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}