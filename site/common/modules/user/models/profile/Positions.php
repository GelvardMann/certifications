<?php

namespace common\modules\user\models\profile;

use Yii;

/**
 * This is the model class for table "positions".
 *
 * @property int $id
 * @property string $name
 *
 * @property UsersProfile[] $usersProfiles
 */
class Positions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'positions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[UsersProfiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersProfiles()
    {
        return $this->hasMany(UsersProfile::className(), ['position' => 'id']);
    }
}
