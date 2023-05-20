<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property int $size
 * @property resource $content
 * @property string $hash
 * @property string $date_create
 */
class Files extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'files';
    }

    public function rules()
    {
        return [
            [['name', 'description', 'type', 'size', 'content', 'hash', 'date_create'], 'required'],
            [['size'], 'integer'],
            [['content'], 'string'],
            [['date_create'], 'safe'],
            [['name', 'description', 'type', 'hash'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('app', 'ID'),
            'name'        => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'type'        => Yii::t('app', 'Type'),
            'size'        => Yii::t('app', 'Size'),
            'content'     => Yii::t('app', 'Content'),
            'hash'        => Yii::t('app', 'Hash'),
            'date_create' => Yii::t('app', 'Date Create'),
        ];
    }
}
