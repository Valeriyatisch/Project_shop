<?php


namespace Val\SweetsShop\Controllers;


use Val\SweetsShop\Base\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $content = 'main.php';
        $data = [
            'page_title' => 'Главная страница',
        ];
        return $this->generateResponse($content, $data);
    }
}