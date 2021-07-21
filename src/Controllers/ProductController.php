<?php


namespace Val\SweetsShop\Controllers;


use Val\SweetsShop\Base\Controller;
use Val\SweetsShop\Base\Request;
use Val\SweetsShop\Base\Validator;
use Val\SweetsShop\Services\DBService;
use Val\SweetsShop\Services\ProductService;

class ProductController extends Controller
{
    private $productService;
    private $DBService;
    private $validator;

    const WRONG_NUMBER = 'Неверное число';

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->DBService = new DBService();
        $this->validator = new Validator();
    }

    public function showProduct(Request $request)
    {
        $id = $request->params()['id'];
        $category_id = $request->params()['category'];

        if($category_id !== 'all')
            $category_id = $this->DBService->getCategoryById($category_id);
        else $category_id = true;

        $product = $this->productService->getProduct($id);
        if($product && $category_id)
        {
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
        return $this->generateResponse('error.php', ['page_title' => 'Ошибка']);
    }

    public function addProduct(Request $request)
    {
        $product_data = $request->post();
        $product_data = $this->validator->trimValues($product_data);
        $file = $request->files()['img'];

        if(is_numeric($product_data['weight']) && is_numeric($product_data['amount']) && is_numeric($product_data['price'])
            && is_numeric($product_data['sale']) && is_numeric($product_data['category']) && is_numeric($product_data['provider']))
        {
            $product_data['weight'] = (float) $product_data['weight'];
            $product_data['amount'] = (int) $product_data['amount'];
            $product_data['price'] = (float) $product_data['price'];
            $product_data['sale'] = (int) $product_data['sale'];
            $product_data['category'] = (int) $product_data['category'];
            $product_data['provider'] = (int) $product_data['provider'];
        }
        else return $this->ajaxResponse(self::WRONG_NUMBER);

        $answer = $this->validator->checkProduct($product_data);
        if($answer)
            return $this->ajaxResponse($answer);

        $answer = $this->validator->loadFile($file);
        if($answer === 'Ошибка загрузки файла')
            return $this->ajaxResponse($answer);

        $product_data['img'] = $answer;

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
                'category_name' => $category_name,
                'category_id' => 'all'
            ];
            return $this->generateResponse($content, $data);
        }

        $category_id = $this->DBService->getCategoryById($category_name);
        if($category_id)
        {
            $products = $this->productService->getProductOfCategory($category_name);
            $category = $this->DBService->getCategory();
            $content = 'catalog.php';
            $data = [
                'page_title' => 'Каталог',
                'products' => $products,
                'category' => $category,
                'category_id' => $category_id['id_category']
            ];
            return $this->generateResponse($content, $data);
        }
        return $this->generateResponse('error.php', ['page_title' => 'Ошибка']);
    }

    public function removeProduct(Request $request)
    {
        $id_product = $request->params()['id'];
        $category = $request->params()['category'];
        if($category === 'remove')
        {
            $answer = $this->productService->deleteProduct($id_product);
            if($this->ajaxResponse($answer))
            {
                header('Location: /account/remove');
            }
        }
        return $this->generateResponse('error.php', ['page_title' => 'Ошибка']);
    }
}