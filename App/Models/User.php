<?php

namespace App\Models;

use PDO;
use \App\Constants;
use Core\View;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{

    public $errors = [];

  /**
   * Class constructor
   *
   * @param array $data  Initial property values
   *
   * @return void
   */
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    public function save()
    {
        $this->validate();

        if (empty($this->errors)) {

            $profilePic = "public/img/profile-pics/head-emerald.png";

            $sql = 'INSERT INTO users (username, firstName, lastName, email, password, signUpDate, profilePic)
                 VALUES (:username, :firstName, :lastName, :email, :password, :signUpDate, :profilePic)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
            $stmt->bindValue(':firstName', $this->firstName, PDO::PARAM_STR);
            $stmt->bindValue(':lastName', $this->lastName, PDO::PARAM_STR);
            $stmt->bindValue(':email', ucfirst(strtolower($this->email)), PDO::PARAM_STR);
            $stmt->bindValue(':password', md5($this->password), PDO::PARAM_STR);
            $stmt->bindValue(':signUpDate', date("Y-m-d"), PDO::PARAM_STR);
            $stmt->bindValue(':profilePic', $profilePic, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }

    public function validate()
    {
       // Username
        if (strlen($this->username) > 25 || strlen($this->username) < 5) {
            $this->errors['username'] = Constants::$usernameCharacters;
        }
        if ($this->username != str_replace(" ", "", $this->username)) {
            $this->errors['username'] = Constants::$usernameSpace;
        }
        if (static::itemExists('users', ['username' => $this->username])) {
            $this->errors['usernameExists'] = Constants::$usernameExists;
        }

        // FirstName
        if (strlen($this->firstName) > 25 || strlen($this->firstName) < 5) {
            $this->errors['firstName'] = Constants::$firstNameCharacters;
        }

        // LastName
        if (strlen($this->lastName) > 25 || strlen($this->lastName) < 5) {
            $this->errors['lastName'] = Constants::$lastNameCharacters;
        }

       // email address
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors['emailValidation'] = Constants::$emailInvalid;
        }

        if ($this->email != $this->email2) {
            $this->errors['emailMatch'] = Constants::$emailsDoNotMatch;
        }
        if (static::itemExists('users', ['email' => $this->email])) {
            $this->errors['emailExists'] = Constants::$emailExists;
        }
        
       // Password
        if (strlen($this->password) < 6) {
            $this->errors['passwordLength'] = Constants::$passwordCharacters;
        }

        if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
            $this->errors['passwordLetter'] = Constants::$passwordLetter;
        }

        if (preg_match('/.*\d+.*/i', $this->password) == 0) {
            $this->errors['passwordNumber'] = Constants::$passwordNumber;
        }

        if ($this->password != $this->password2) {
            $this->errors['passwordMatch'] = Constants::$passwordsDoNoMatch;
        }
    }

    public static function authenticate($username, $password)
    {
        $user = static::findByField('users', ['username' => $username]);

        if ($user) {
            if (md5($password) == $user->password) {
                return $user;
            }
        }

        return false;
    }
}
