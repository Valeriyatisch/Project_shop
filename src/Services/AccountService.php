<?php


namespace Val\SweetsShop\Services;


use Val\SweetsShop\Base\Service;

class AccountService extends Service
{
    const REGISTRATION_SUCCESS = 'Регистрация прошла успешно';
    const REGISTRATION_ERROR = 'Ошибка регистрации';
    const USER_EXISTS = 'Пользователь с таким логином уже существует';

    const AUTH_ERROR = 'Ошибка авторизации';
    const AUTH_OK = 'Авторизация прошла успешно';

    const PWD_ERROR = 'Неверный пароль';
    const UPDATE_SUCCESS = 'Данные обновлены';
    const UPDATE_ERROR = 'Ошибка обновления даанных';


    public function addUser(array $reg_data)
    {
        //проверка на наличие пользователя в бд
        //шифрование пароля
        //заносим данные в бд
        $email = $reg_data['email'];
        if($this->getUser($email)) return self::USER_EXISTS;
        $pwd = $reg_data['pwd'];
        $pwd = password_hash($pwd, PASSWORD_DEFAULT);
        $reg_data['pwd'] = $pwd;

        //открыть транзакцию
        //выполнить все запросы
        //если все ок, подтвердить транзакцию
        //если возникли ошибки, откатываем транзакцию к моменту открытия

        $user_sql = 'insert into user(name_user, surname_user, phone_user, email_user, pwd_user, bith_user, address_user) 
                        values(:uname, :surname, :phone, :email, :pwd, :bith, :address)';
        $user_info_sql = 'insert into user_role(id_user) values(:id_user)';

        try {
            $this->dbConnection->getConnection()->beginTransaction();
            $this->dbConnection->executeSql($user_sql, $reg_data);

            $user_role_params = [
                'id_user' => $this->dbConnection->getConnection()->lastInsertId()
                //метод lastInsertId объект PDO возврщает последний добавленный PK
            ];
            $this->dbConnection->executeSql($user_info_sql, $user_role_params);

            //подтверждение транзакции
            $this->dbConnection->getConnection()->commit();
            return self::REGISTRATION_SUCCESS;
        } catch (Exception $exception){
            $this->dbConnection->getConnection()->rollBack();
            return self::REGISTRATION_ERROR;
        }
    }

    public function getUser($email)
    {
        $sql = 'select * from user where email_user = :email';
        $user = $this->dbConnection->execute($sql, ['email' => $email], false);
        return $user;
    }

    public function getUserRole($id_user)
    {
        $sql = 'select * from user_role where id_user = :id';
        $role = $this->dbConnection->execute($sql, ['id' => $id_user], false);
        $sql = 'select * from role where id_role = :role';
        $role_name = $this->dbConnection->execute($sql, ['role' => $role['id_role']], false);
        return $role_name;
    }

    public function auth(array $auth_data)
    {
        $email = $auth_data['email'];
        $pwd = $auth_data['pwd'];
        $user = $this->getUser($email);
        if(!$user) return self::AUTH_ERROR;
        if(!password_verify($pwd, $user['pwd_user']))
        {
            return self::AUTH_ERROR;
        }
        return self::AUTH_OK;
    }

    public function update(array $update_data, $old_email)
    {
        $user = $this->getUser($old_email);
        if(!password_verify($update_data['pwd'], $user['pwd_user']))
        {
            return self::PWD_ERROR;
        }
        $pwd = password_hash($update_data['newpwd'], PASSWORD_DEFAULT);
        $sql = 'update user set name_user = :uname, surname_user = :surname, phone_user = :phone, email_user = :email, pwd_user = :newpwd, 
                    bith_user = :bith, address_user = :address where id_user = :id';
        $params = [
            'uname' => $update_data['uname'],
            'surname' => $update_data['surname'],
            'phone' => $update_data['phone'],
            'email' => $update_data['email'],
            'newpwd' => $pwd,
            'bith' => $update_data['bith'],
            'address' => $update_data['address'],
            'id' => $user['id_user']
        ];

        if($this->dbConnection->executeSql($sql, $params))
        {
            $_SESSION['email'] = $update_data['email'];
            return self::UPDATE_SUCCESS;
        }
        return self::UPDATE_ERROR;
    }
}