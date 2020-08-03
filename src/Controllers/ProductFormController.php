<?php


namespace Val\SweetsShop\Controllers;


use Val\SweetsShop\Base\Controller;
use Val\SweetsShop\Services\DBService;

class ProductFormController extends Controller
{
    private $DBServiceService;

    public function __construct()
    {
        $this->productFormService = new DBService();
    }

    public function showProductForm()
    {
        $category = $this->DBServiceService->getCategory();
        $provider = $this->DBServiceService->getProvider();
        $content = 'product-form.php';
        $data = [
            'page_title' => 'Форма добавления товара',
            'category' => $category,
            'provider' => $provider
        ];
        return $this->generateResponse($content, $data);
    }
}