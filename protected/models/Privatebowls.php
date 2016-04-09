<?php

/**
 * This is the model class for table "privatebowls".
 *
 * The followings are the available columns in table 'privatebowls':
 * @property integer $id
 * @property integer $userid
 * @property string $locality
 * @property string $location
 * @property string $latitude
 * @property string $longitude
 * @property string $status
 * @property string $bowltype
 * @property string $amount
 */
class Privatebowls extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'privatebowls';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid', 'numerical', 'integerOnly'=>true),
			array('locality, location', 'length', 'max'=>256),
			array('latitude, longitude, status, bowltype', 'length', 'max'=>45),
			array('amount', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, userid, locality, location, latitude, longitude, status, bowltype, amount', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'userid' => 'Userid',
			'locality' => 'Locality',
			'location' => 'Location',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
			'status' => 'Status',
			'bowltype' => 'Bowltype',
			'amount' => 'Amount',
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
		$criteria->compare('userid',$this->userid);
		$criteria->compare('locality',$this->locality,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('bowltype',$this->bowltype,true);
		$criteria->compare('amount',$this->amount,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Privatebowls the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
