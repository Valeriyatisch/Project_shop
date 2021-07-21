<?php


namespace Val\SweetsShop\Base;


class Validator
{
    const NOT_EMAIL = 'E-mail адрес указан неверно';
    const NOT_PHONE = 'Номер телефона указан неверно';
    const NOT_DATE = 'Число не является датой';
    const WRONG_LENGTH = 'Неверная длина строки';
    const WRONG_SIZE = 'Неверное значение';
    const FILE_ERROR = 'Ошибка загрузки файла';


    public function trimValues($mas)
    {
        foreach ($mas as &$elem)
        {
            $elem = trim($elem);
        }
        return $mas;
    }

    public function isEmail($email)
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return false;
        }
        return self::NOT_EMAIL;
    }

    public function isPhone($phone)
    {
        $reg = "/^\+[1-9][0-9]{10}/";
        if(preg_match($reg, $phone))
        {
            return false;
        }
        return self::NOT_PHONE;
    }

    public function isDate($date)
    {
        $date = date_parse_from_format("Y.n.j", $date);
        if(checkdate($date['month'], $date['day'], $date['year']))
        {
            return false;
        }
        return self::NOT_DATE;
    }

    public function checkLength($value, $min, $max)
    {
        $length = strlen($value);
        if($min > $length || $max < $length)
        {
            return self::WRONG_LENGTH;
        }
        return false;
    }

    public function checkSize($value, $min, $max)
    {
        if($min > $value || $max < $value)
        {
            return self::WRONG_SIZE;
        }
        return false;
    }

    function checkTypeImg($file_name)
    {
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if( in_array($ext, array('jpg', 'jpeg', 'png', 'gif', 'bmp')))
        {
            return $ext;
        }
        return false;
    }

    function checkSizeImg($file_size)
    {
        $maxSize = 1024 * 1024 *2;

        if($file_size > $maxSize)
        {
            return false;
        }
        return true;
    }

    public function loadFile($picture)
    {
        if(isset($picture['name']))
        {
            if ($ext = $this->checkTypeImg($picture['name']))
            {
                if($this->checkSizeImg($picture['size']))
                {
                    $name = md5($picture['name'] . microtime() .rand(0, 999));
                    $name .= ".$ext";
                    $tmp_name = $picture['tmp_name'];

                    if(move_uploaded_file($tmp_name, "../public/static/img/$name"))
                    {
                        return $name;
                    }
                }
            }
        }
        return self::FILE_ERROR;
    }

    public function checkRegistration(array $data)
    {
        $email_answer = $this->isEmail($data['email']);
        if($email_answer)
            return $email_answer;

        $phone_answer = $this->isPhone($data['phone']);
        if($phone_answer)
            return $phone_answer;

        $date_answer = $this->isDate($data['bith']);
        if($date_answer)
            return $date_answer;

        $length_name = $this->checkLength($data['uname'], 2, 50);
        if($length_name)
            return $length_name . ' в имени';

        $length_surname = $this->checkLength($data['surname'], 1, 50);
        if($length_surname)
            return $length_surname . ' в фамилии';;

        if(array_key_exists('pwd', $data))
        {
            $pwd_answer = $this->checkLength($data['pwd'], 5, 10);
            if($pwd_answer)
                return $pwd_answer . ' в пароле';;
        }

        if(array_key_exists('newpwd', $data))
        {
            if(!empty($data['newpwd']))
            {
                $pwd_answer = $this->checkLength($data['newpwd'], 5, 10);
                if($pwd_answer)
                    return $pwd_answer . ' в новом пароле';
            }
        }

        $address_answer = $this->checkLength($data['address'], 0, 200);
        if($address_answer)
            return $address_answer;

        return false;
    }

    public function checkLogin(array $data)
    {
        $email_answer = $this->isEmail($data['email']);
        if($email_answer)
            return $email_answer;

        $pwd_answer = $this->checkLength($data['pwd'], 5, 10);
        if($pwd_answer)
            return $pwd_answer;

        return false;
    }

    public function checkProduct(array $data)
    {
        $title_answer = $this->checkLength($data['title'], 5, 50);
        if($title_answer)
            return $title_answer . ' в названии';

        $desc_answer = $this->checkLength($data['description'], 10, 800);
        if($desc_answer)
            return $desc_answer . ' в описании';

        $weight_answer = $this->checkSize($data['weight'], 0.1, 5);
        if($weight_answer)
            return $weight_answer . ' в весе';

        $price_answer = $this->checkSize($data['price'], 50, 10000);
        if($price_answer)
            return $price_answer . ' в цене';

        $amount_answer = $this->checkSize($data['amount'], 1, 10000);
        if($amount_answer)
            return $amount_answer . ' в количестве';

        $sale_answer = $this->checkSize($data['sale'], 0, 20);
        if($sale_answer)
            return $sale_answer . ' в скидке';

        return false;
    }
}