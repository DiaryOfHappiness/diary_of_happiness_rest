<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $ref
 * @property string $name
 * @property integer $id_oauth_type
 *
 * @property Appraisal[] $appraisals
 * @property Note[] $notes
 * @property OauthType $idOauthType
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ref', 'name', 'id_oauth_type'], 'required'],
            [['id_oauth_type'], 'integer'],
            [['ref'], 'string', 'max' => 60],
            [['name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ref' => 'Ref',
            'name' => 'Name',
            'id_oauth_type' => 'Id Oauth Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppraisals()
    {
        return $this->hasMany(Appraisal::className(), ['ref_user' => 'ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotes()
    {
        return $this->hasMany(Note::className(), ['ref_user' => 'ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOauthType()
    {
        return $this->hasOne(OauthType::className(), ['id' => 'id_oauth_type']);
    }



    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    static public function getUserId()
    {
        return 'fgfgfgf';
    }
}
