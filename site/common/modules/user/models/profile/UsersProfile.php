<?php

namespace common\modules\user\models\profile;

use common\modules\user\models\User;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "users_profile".
 *
 * @property int $id
 * @property int $user_id
 * @property int $department_id
 * @property string $surname
 * @property string $name
 * @property string $middle_name
 * @property string $image
 * @property int $shop_id
 * @property int $position_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 * @property Positions $position
 * @property Shops $shop
 */
class UsersProfile extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'department_id', 'surname', 'name', 'middle_name', 'image', 'shop_id', 'position_id'], 'required'],
            [['user_id', 'department_id', 'shop_id', 'position_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['surname', 'name', 'middle_name'], 'string', 'max' => 50],
            [['image'], 'string', 'max' => 80],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => Positions::className(), 'targetAttribute' => ['position_id' => 'id']],
            [['shop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shops::className(), 'targetAttribute' => ['shop_id' => 'id']],

        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Логин',
            'email' => 'Эл. почта',
            'department_id' => 'Департамент',
            'surname' => 'Фамилия',
            'name' => 'Имя',
            'middle_name' => 'Отчество',
            'image' => 'Image',
            'shop_id' => 'Магазин',
            'position_id' => 'Позиция',
            'created_at' => 'Аккаунт создан',
            'updated_at' => 'Аккаунт обновлен',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Position]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasOne(Positions::className(), ['id' => 'position_id']);
    }

    /**
     * Gets query for [[Shop]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shops::className(), ['id' => 'shop_id']);
    }
}
