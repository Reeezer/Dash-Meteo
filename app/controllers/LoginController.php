<?php

require_once "core/DatabaseManager.php";
require_once "core/Request.php";

require_once "app/controllers/Controller.php";
require_once "app/models/User.php";

class LoginController extends Controller
{
    public function showLogin()
    {
        return $this->view("login");
    }

    public function doLogin()
    {
        if (!isset($_POST['email']) || !isset($_POST['password']))
            Request::redirect_notify('login', 'error', "Please fill in all required fields");
        
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = User::fetchUser(DatabaseManager::$dbh, $email);
        if (!$user)
            Request::redirect_notify('login', 'error', "Wrong email or password"); // for safety don't specify if a given email is registered
        
        $hash = $user->passhash();
        
        if (password_verify($password, $hash))
        {
            $_SESSION['user'] = serialize($user);
            Request::redirect_notify('home', 'success', "Login successful");
        }
        else
        {
            Request::redirect_notify('login', 'error', "Wrong email or password");
        }
    }

    public function doLogout()
    {
        unset($_SESSION['user']);
        Request::redirect('home');
    }

    public function showSignup()
    {
        return $this->view("signup");
    }

    public function doSignup()
    {
        if (!isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['password_confirmation']))
            Request::redirect_notify("signup", "error", "Please fill in all required fields");

        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_confirmation = $_POST['password_confirmation'];

        if ($password === $password_confirmation)
        {
            $passhash = password_hash($password, PASSWORD_DEFAULT);

            $user = new User();
            $user->set("EN", "C", $email, $passhash);
            $user->save(DatabaseManager::$dbh);

            // log-in the user
            $_SESSION['user'] = serialize($user);

            Request::redirect_notify("home", "success", "Signup successful");
        }
    }
}