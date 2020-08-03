<?php


namespace Val\SweetsShop\Services;


use Val\SweetsShop\Base\DBConnection;
use Val\SweetsShop\Base\Request;
use Val\SweetsShop\Base\Service;

class ProductService extends Service
{
    public function getAllProducts()
    {
        $sql = 'select * from product';
        $statement = $this->dbConnection->queryAll($sql);
        return $statement;
    }

     public function addProductDB($product_data)
     {
         $sql = 'insert into product(img_product, name_product, weight_product, description_product, count_product, price_product, sale_product, id_category, id_provider) values(:img, :title, :weight, :description, :amount, :price, :sale, :category, :provider)';
         return $this->dbConnection->executeSql($sql, $product_data);
     }

     public function getProduct($id)
     {
         $sql = 'select * from product where id_product = :id';
         $product = $this->dbConnection->execute($sql, ['id' => $id], false);
         return $product;
     }

     public function getProductOfCategory($id)
     {
         $sql = 'select * from product where id_category = :id';
         $product = $this->dbConnection->execute($sql, ['id' => $id]);
         return $product;
     }

     public function deleteProduct($id)
     {
         $sql = 'delete from product where id_product = :id';
         $result = $this->dbConnection->executeSql($sql, ['id' => $id]);
         return $result;
     }
}