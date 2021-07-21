<?php


namespace Val\SweetsShop\Services;


use Val\SweetsShop\Base\Service;

class DBService extends Service
{
    public function getCategory()
    {
        $sql = 'select * from category';
        $statement = $this->dbConnection->queryAll($sql);
        return $statement;
    }

    public function getProvider()
    {
        $sql = 'select id_provider, name_provider from provider';
        $statement = $this->dbConnection->queryAll($sql);
        return $statement;
    }

    public function getNameCategory($id)
    {
        $sql = 'select name_category from category where id_category = :id';
        $name = $this->dbConnection->execute($sql, ['id' => $id], false);
        return $name;
    }

    public function getCategoryById($id)
    {
        $sql = 'select * from category where id_category = :id';
        $category = $this->dbConnection->execute($sql, ['id' => $id], false);
        return $category;
    }

    public  function getNameProvider($id)
    {
        $sql = 'select name_provider from provider where id_provider = :id';
        $name = $this->dbConnection->execute($sql, ['id' => $id], false);
        return $name;
    }

    public function getComment($id)
    {
        $sql = 'select text_comment, name_user from comment c left join user u on c.id_user = u.id_user where c.id_product = :id LIMIT 10';
        $comment = $this->dbConnection->execute($sql, ['id' => $id]);
        return $comment;
    }

    public function getUserName($id)
    {
        $sql = 'select name_user from user where id_user = :id';
        $name = $this->dbConnection->execute($sql, ['id' => $id], false);
        return $name;
    }

    public function insertComment($id_user, $id_product, $text)
    {
        $sql = 'insert into comment(text_comment, id_product, id_user) values(:text, :id_product, :id_user)';
        $params = [
            'id_user' => $id_user,
            'id_product' => $id_product,
            'text' => $text

        ];
        $answer = $this->dbConnection->executeSql($sql, $params);
        return $answer;
    }
}