<?php


namespace Val\SweetsShop\Controllers;


use Val\SweetsShop\Base\Controller;
use Val\SweetsShop\Base\Request;
use Val\SweetsShop\Services\DBService;
use Val\SweetsShop\Services\ProductService;

class ProductController extends Controller
{
    private $productService;
    private $DBService;

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->DBService = new DBService();
    }

    public function showProduct(Request $request)
    {
        $id = $request->params()['id'];
        $category_id = $request->params()['category'];
        $product = $this->productService->getProduct($id);
        $category = $this->DBService->getNameCategory($product['id_category']);
        $provider = $this->DBService->getNameProvider($product['id_provider']);
        $comments = $this->DBService->getComment($product['id_product']);
        $content = 'product.php';
        $data = [
            'page_title' => 'Продукт',
            'product' => $product,
            'category' => $category['name_category'],
            'provider' => $provider['name_provider'],
            'comments' => $comments,
            'category_id' => $category_id
        ];
        return $this->generateResponse($content, $data);
    }

    public function addProduct(Request $request)
    {
        $product_data = $request->post();
        $file = $request->files()['img']['name'];

        $product_data['weight'] = (float) $product_data['weight'];
        $product_data['amount'] = (int) $product_data['amount'];
        $product_data['price'] = (float) $product_data['price'];
        $product_data['sale'] = (int) $product_data['sale'];
        $product_data['category'] = (int) $product_data['category'];
        $product_data['provider'] = (int) $product_data['provider'];
        $product_data['img'] = $file;

        $answer = $this->productService->addProductDB($product_data);
        return $this->ajaxResponse($answer);
    }

    public function showCategoryProducts(Request $request)
    {
        $category_name = $request->params()['category'];
        if($category_name === 'all')
        {
            $products = $this->productService->getAllProducts();
            $category = $this->DBService->getCategory();
            $content = 'catalog.php';
            $data = [
                'page_title' => 'Каталог',
                'products' => $products,
                'category' => $category,
                'category_name' => $category_name
            ];
            return $this->generateResponse($content, $data);
        }
        $products = $this->productService->getProductOfCategory($category_name);
        $category = $this->DBService->getCategory();
        $content = 'catalog.php';
        $data = [
            'page_title' => 'Каталог',
            'products' => $products,
            'category' => $category,
            'category_name' => $category_name
        ];
        return $this->generateResponse($content, $data);
    }
}