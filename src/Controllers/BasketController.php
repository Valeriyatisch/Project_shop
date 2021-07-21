<?php


namespace Val\SweetsShop\Controllers;


use Val\SweetsShop\Base\Controller;
use Val\SweetsShop\Base\Request;
use Val\SweetsShop\Services\DBService;
use Val\SweetsShop\Services\ProductService;

class BasketController extends Controller
{
    private $productService;
    private $DBService;

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->DBService = new DBService();
    }

    public function show()
    {
        $content = 'basket.php';
        $data = [
            'page_title' => 'Корзина',
            'products' => $_SESSION['basket']
        ];
        return $this->generateResponse($content, $data);
    }

    function checkCount(Request $request)
    {
        $id = $_POST['id'];
        $curr_product = $this->productService->getProduct($id);

        if(!isset($_SESSION['basket']))
        {
            $_SESSION['basket'] = [];
        }

        $check = false;

        foreach ($_SESSION['basket'] as &$product)
        {
            if($product['id_product'] == $id)
            {
                $check = true;

                if($product['current_count'] < $product['count_product'])
                {
                    $product['current_count'] = (int) $product['current_count'] +1;
                }
                break;
            }
        }

        if(!$check)
        {
            $curr_product['current_count'] = 1;
            $_SESSION['basket'][] = $curr_product;
        }

        $result = [
            'commonCount' => $this->getCountValue($_SESSION['basket'], "current_count"),
            'productCount' => $product['current_count'],
            'price' => $product['price_product']];

        echo json_encode($result);
    }

    public function minusCount()
    {
        $id = $_POST['id'];

        foreach ($_SESSION['basket'] as &$product)
        {
            if($product['id_product'] == $id)
            {
                if($product['current_count'] > 1)
                {
                    $product['current_count']--;
                }
                break;
            }
        }

        $result = [
            'commonCount' => $this->getCountValue($_SESSION['basket'], "current_count"),
            'productCount' => $product['current_count'],
            'price' => $product['price_product']
        ];

        echo json_encode($result);
    }

    public function deleteProductFromBasket()
    {
        $id = $_POST['id'];

        if(isset($_SESSION['basket']))
        {
            foreach ($_SESSION['basket'] as $key => $product)
            {
                if ($product['id_product'] == $id)
                {
                    unset($_SESSION['basket'][$key]);
                    break;
                }
            }
            $count = $this->getCountValue($_SESSION['basket'], "current_count");

            if($count == 0)
            {
                unset($_SESSION['basket']);
            }
            echo $count;
        }
    }

    private function getCountValue($array, $property)
    {
        $count = 0;
        foreach ($array as $value)
        {
            $count+= $value["$property"];
        }
        return $count;
    }

}