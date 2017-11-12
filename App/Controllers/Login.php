<?php

namespace App\Controllers;
use \Core\View;
use \App\Models\User;
use \App\Constants;

class Login extends \Core\Controller
{

    public function createAction()
    {
        $user = User::authenticate($_POST['loginUsername'], $_POST['loginPassword']); 
        
        if ($user) {
            $this->redirect('/');
        } else {
            View::renderTemplate('Register/index.html', [
                'username' => $_POST['loginUsername'],
                'error' => Constants::$loginFailed
            ]);
        };
    }
}