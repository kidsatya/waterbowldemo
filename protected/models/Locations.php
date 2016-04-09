<?php

/**
 * This is the model class for table "locations".
 *
 * The followings are the available columns in table 'locations':
 * @property integer $id
 * @property string $locality
 * @property string $location
 * @property string $latitude
 * @property string $longitude
 * @property string $created_time
 * @property string $updated_time
 * @property string $status
 */
class Locations extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'locations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('location', 'required'),
			array('locality, latitude, longitude', 'length', 'max'=>256),
			array('location', 'length', 'max'=>256),
			array('city', 'length', 'max'=>32),
			array('status', 'length', 'max'=>45),
			array('created_time, updated_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, locality, location, city, latitude, longitude, created_time, updated_time, status, rid', 'safe', 'on'=>'search'),
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
			'locality' => 'Locality',
			'location' => 'Location',
			'city' => 'City',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
			'created_time' => 'Created Time',
			'updated_time' => 'Updated Time',
			'status' => 'Status',
			'rid' => "Request ID",
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
		$criteria->compare('locality',$this->locality,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Locations the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
