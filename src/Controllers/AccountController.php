<?php


namespace Val\SweetsShop\Controllers;


use Val\SweetsShop\Base\Controller;
use Val\SweetsShop\Base\Request;
use Val\SweetsShop\Services\AccountService;
use Val\SweetsShop\Services\DBService;
use Val\SweetsShop\Services\ProductService;

class AccountController extends Controller
{
    private $accountService;
    private $DBService;
    private $productService;

    public function __construct()
    {
        $this->accountService = new AccountService();
        $this->DBService = new DBService();
        $this->productService = new ProductService();

    }

    public function showRegistration()
    {
        if(isset($_SESSION['email'])) header('Location: /account');
        $content = 'registration.php';
        $data = [
            'page_title' => 'Регистрация',
        ];
        return $this->generateResponse($content, $data);
    }

    public function regUser(Request $request)
    {
        //var_dump($request->post());
        $result = $this->accountService->addUser($request->post());
        return $this->ajaxResponse($result);
    }

    public function showLoginForm()
    {
        if(isset($_SESSION['email'])) header('Location: /account');
        $content = 'login.php';
        $data = [
            'page_title' => 'Авторизация',
        ];
        return $this->generateResponse($content, $data);
    }

    public function login(Request $request)
    {
        $auth_data = $request->post();
        $result = $this->accountService->auth($auth_data);
        if($result == AccountService::AUTH_OK)
        {
            $_SESSION['email'] = $auth_data['email'];
        }
        return $this->ajaxResponse($result);
    }

    public function showAccountCategory(Request $request)
    {
        $cat_admin = $request->params()['category'];
        $email = $_SESSION['email'];
        if(!isset($email)) header('Location: /login');
        $user = $this->accountService->getUser($email);
        $id_user = $user['id_user'];
        $role = $this->accountService->getUserRole($id_user);
        if($role['name_role'] === 'admin')
        {
            if($cat_admin === 'addto')
            {
                $category = $this->DBService->getCategory();
                $provider = $this->DBService->getProvider();
                $content = 'admin.php';
                $data = [
                    'page_title' => 'Форма добавления товара',
                    'category' => $category,
                    'provider' => $provider,
                    'cat_admin' => $cat_admin
                ];
                return $this->generateResponse($content, $data);
            }
            if($cat_admin === 'remove')
            {
                $products = $this->productService->getAllProducts();
                $content = 'admin.php';
                $data = [
                    'page_title' => 'Удалить товар',
                    'products' => $products,
                    'cat_admin' => $cat_admin
                ];
                return $this->generateResponse($content, $data);
            }
        }
        $content = 'account.php';
        $data = [
            'page_title' => 'Личный кабинет',
            'user' => $user
        ];
        return $this->generateResponse($content, $data);
    }

    public function removeProduct(Request $request)
    {
        $id_product = $request->params()['id'];
        $answer = $this->productService->deleteProduct($id_product);
        if($this->ajaxResponse($answer))
        {
            header('Location: /account/remove');
        }
    }

    public function logout()
    {
        $_SESSION = [];
        header('Location: /');
    }

    public  function updateData(Request $request)
    {
        $update_data = $request->post();
        $old_email = $_SESSION['email'];
        $result = $this->accountService->update($update_data, $old_email);
        return $this->ajaxResponse($result);
    }

    public function addComment(Request $request)
    {
        $id_product = (int) $request->params()['id'];
        $user = $this->accountService->getUser($_SESSION['email']);
        $user_id = (int) $user['id_user'];
        $text = $request->post()['comment'];
        var_dump($user_id, $request->params(), $text);
        $answer = $this->DBService->insertComment($user_id, $id_product, $text);
        return $this->ajaxResponse($answer);
    }

}