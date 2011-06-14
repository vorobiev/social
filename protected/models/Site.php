<?php

/**
 * This is the model class for table "site".
 *
 * The followings are the available columns in table 'site':
 * @property integer $site_id
 * @property string $name
 * @property string $url
 * @property string $about
 */
class Site extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Site the static model class
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
		return 'site';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, url, about', 'required'),
			array('name, url', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('site_id, name, url, about', 'safe', 'on'=>'search'),
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
			'tags' => array ( self::MANY_MANY , 'Tag' , 'site2tag(site_id,tag_id)' ),
			'marks' => array( self::HAS_MANY , 'Mark' , 'site_id' ),
			'comments' => array( self::HAS_MANY , 'Comment' , 'site_id' ),
		);
	}
	
	
	public function getAvgValue()
	{
		$marks = $this -> marks ;
		$_avg = 0;
		$i = 0;
		
		foreach ( $marks as $mark )
		{
		
			$_avg += $mark -> value ;
			$i++;
		
			
		}
		
		
		if ( $_avg * $i > 0 )
		{
			return $_avg / $i ;
		}
		else
		{
			return 0;
		}
	}
	
	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'site_id' => 'Site',
			'name' => 'Name',
			'url' => 'Url',
			'about' => 'About',
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

		$criteria->compare('site_id',$this->site_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('about',$this->about,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}