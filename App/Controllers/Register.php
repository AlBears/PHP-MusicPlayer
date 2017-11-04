<?php

namespace App\Controllers;
use \Core\View;
use \App\Models\User;

class Register extends \Core\Controller
{

    public function indexAction()
    {
        View::renderTemplate('Register/index.html');
    }

    public function createAction()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $user = new User($post);
        if ($user->save()) {
            $this->redirect('/');
        } else {
            View::renderTemplate('Register/index.html', [
                'user' => $user
            ]);
        };
    }
}