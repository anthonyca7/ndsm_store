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
			array('name, description, price, quantity, available', 'required'),
			array('quantity', 'numerical', 'integerOnly'=>true, 'min'=>1),
			array('available', 'numerical', 'integerOnly'=>true, 'min'=>0),
			array('name', 'length', 'max'=>255),
			array('price', 'length', 'max'=>9),
			array('available', 'compare', 'compareAttribute'=>'quantity', 'operator'=>'<=', 
				'message'=>'The number of items available cannot be less than the quantity'),
			array('price', 'numerical', 'min'=>0.01),
			array('image', 'file', 'types'=>'jpg, gif, png'),
			array('image', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, price, quantity, description', 'safe', 'on'=>'search'),
		);
	}

	public static function getImage($id, $name)
	{
		$loc = $this->createAbsoluteUrl('site/index') . Yii::app()->request->baseUrl . "/images/" . $id . '/' . $name; 
		

		if ($name != null) {
    		return $loc;
		}
		return Yii::app()->request->baseUrl . "/images/noimage.jpeg";

		$header_response = get_headers($loc, 1);
		if ( strpos( $header_response[0], "404" ) !== false )
		{
		   return Yii::app()->request->baseUrl . "/images/noimage.jpeg";
		} 
		else 
		{
		   return $loc;
		}

	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'users' => array(self::MANY_MANY, 'User', 'reservation(item_id, user_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'price' => 'Price',
			'quantity' => 'Quantity',
			'description' => 'Description',
			'available' => 'Available',
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