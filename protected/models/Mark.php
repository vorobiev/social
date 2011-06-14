<?php

/**
 * This is the model class for table "mark".
 *
 * The followings are the available columns in table 'mark':
 * @property integer $mark_id
 * @property integer $user_id
 * @property integer $site_id
 * @property integer $value
 */
class Mark extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Mark the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mark';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, site_id, value', 'required'),
			array('user_id, site_id, value', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mark_id, user_id, site_id, value', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'site' => array(self::BELONGS_TO , 'Site' , 'site_id' ),
			'user' => array(self::BELONGS_TO , 'User' , 'user_id' ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mark_id' => 'Mark',
			'user_id' => 'User',
			'site_id' => 'Site',
			'value' => 'Value',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('mark_id',$this->mark_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('site_id',$this->site_id);
		$criteria->compare('value',$this->value);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}