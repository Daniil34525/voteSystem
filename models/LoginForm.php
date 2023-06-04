<?php

namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $typeUser;
    public $rules;

    public function init()
    {
        if ($this->typeUser == 'user')
            $this->rules = [['email', 'password'], 'required'];
        elseif ($this->typeUser == 'hidden')
            $this->rules = ['code', 'required'];
        parent::init();
    }

    public $email;
    public $password;
    public $code;
    private $_user;

    public function rules(): array
    {
        return [
            $this->rules
        ];
    }

    /**
     * @throws \Exception
     */
    public function login(): bool
    {
        if ($this->validate()) {
            if ($this->typeUser == 'user') {
                $user = $this->getUser();
                if (!password_verify($this->password, $user->password_hash))
                    return false;
            } elseif ($this->typeUser == 'hidden')
                $user = $this->getHidden();

            if (isset($user)) {
                if ($user->getRole() === 'admin')
                    $role = Yii::$app->authManager->getRole('admin');
                elseif ($user->getRole() == 'hidden')
                    $role = Yii::$app->authManager->getRole('hidden');
                elseif ($user->getRole() == 'user')
                    $role = Yii::$app->authManager->getRole('user');

                Yii::$app->user->login($user, 1);
                if (isset($role)) {
                    if (!Yii::$app->authManager->getAssignment($role->name, $user->id))
                        Yii::$app->authManager->assign($role, $user->id);
                }
                return true;
            }
        }
        return false;
    }

    public function getUser(): ?Users
    {
        if ($this->_user === null) {
            $this->_user = Users::findByEmail($this->email);
        }

        return $this->_user;
    }

    public function getHidden(): ?Users
    {
        if ($this->_user === null) {
            $this->_user = Users::findByCode($this->code);
        }

        return $this->_user;
    }
}
