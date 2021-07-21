<?php


namespace Val\SweetsShop\Controllers;


use Val\SweetsShop\Base\Controller;
use Val\SweetsShop\Base\Request;
use Val\SweetsShop\Base\Validator;
use Val\SweetsShop\Services\AccountService;
use Val\SweetsShop\Services\DBService;
use Val\SweetsShop\Services\ProductService;

class AccountController extends Controller
{
    private $accountService;
    private $DBService;
    private $productService;
    private $validator;

    public function __construct()
    {
        $this->accountService = new AccountService();
        $this->DBService = new DBService();
        $this->productService = new ProductService();
        $this->validator = new Validator();

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
        $data = $request->post();
        $data = $this->validator->trimValues($data);

        $answer = $this->validator->checkRegistration($data);

        if($answer)
            return $this->ajaxResponse($answer);

        $result = $this->accountService->addUser($data);
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
        $auth_data = $this->validator->trimValues($auth_data);

        $answer = $this->validator->checkLogin($auth_data);
        if($answer)
            return $this->ajaxResponse($answer);

        $result = $this->accountService->auth($auth_data);
        if($result == AccountService::AUTH_OK)
        {
            $_SESSION['email'] = $auth_data['email'];
        }
        return $this->ajaxResponse($result);
    }

    public function showAccountCategory(Request $request)
    {
        $cat = $request->params()['category'];
        $email = $_SESSION['email'];
        if(!isset($email)) header('Location: /login');
        $user = $this->accountService->getUser($email);
        $id_user = $user['id_user'];
        $role = $this->accountService->getUserRole($id_user);
        if($role['name_role'] === 'admin')
        {
            if($cat === 'addto')
            {
                $category = $this->DBService->getCategory();
                $provider = $this->DBService->getProvider();
                $content = 'admin.php';
                $data = [
                    'page_title' => 'Форма добавления товара',
                    'category' => $category,
                    'provider' => $provider,
                    'cat_admin' => $cat
                ];
                return $this->generateResponse($content, $data);
            }
            if($cat === 'remove')
            {
                $products = $this->productService->getAllProducts();
                $content = 'admin.php';
                $data = [
                    'page_title' => 'Удалить товар',
                    'products' => $products,
                    'cat_admin' => $cat
                ];
                return $this->generateResponse($content, $data);
            }
        }
        if($role['name_role'] === 'user' && $cat === 'addto')
        {
            $content = 'account.php';
            $data = [
                'page_title' => 'Личный кабинет',
                'user' => $user
            ];
            return $this->generateResponse($content, $data);
        }
        return $this->generateResponse('error.php', ['page_title' => 'Ошибка']);
    }

    public function logout()
    {
        $_SESSION = [];
        header('Location: /');
    }

    public  function updateData(Request $request)
    {
        $update_data = $request->post();
        $update_data = $this->validator->trimValues($update_data);

        $answer = $this->validator->checkRegistration($update_data);
        if($answer)
            return $this->ajaxResponse($answer);

        $old_email = $_SESSION['email'];
        $result = $this->accountService->update($update_data, $old_email);
        return $this->ajaxResponse($result);
    }

    public function addComment(Request $request)
    {
        $id_product = (int) $request->params()['id'];
        $user = $this->accountService->getUser($_SESSION['email']);
        $user_id = (int) $user['id_user'];
        $text = trim($request->post()['comment']);

        $answer = $this->validator->checkLength($text, 5, 300);
        if($answer)
            return $this->ajaxResponse($answer);

        $answer = $this->DBService->insertComment($user_id, $id_product, $text);
        return $this->ajaxResponse($answer);
    }

}