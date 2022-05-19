<?php

// class User
// {
    // public $username = 'chris';
    // protected $email;

    // public function fullName()
    // {
    //     return 'Chris Dawson';
    // }

    // public function avatar($size = 60)
    // {
    //     return $size;
    // }

//     public function setEmail($email)
//     {
//         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//             return;
//         }

//         $this->email = $email;
//     }

//     public function getEmail()
//     {
//         return strtolower($this->email);
//     }
// }

// $user = new User;

// // echo $user->fullName();
// // echo $user->avatar();
// var_dump($user);

// $user->setEmail('chRis@mysite.com');

// echo $user->getEmail();

// class Validator
// {
//     protected $errors = [];

//     public function validate($data, $rules)
//     {
//         //

//         $this->errors[] = 'The email is required';
//     }

//     public function fails()
//     {
//         return !empty($this->errors);
//     }

//     public function getErrors()
//     {
//         return $this->errors;
//     }
// }

// $validatro = new Validator;
// $validator->validate([''], ['required']);

// class Model
// {
//     protected $dates = [];

//     public function __get($property)
//     {
//         if (in_array($property, $this->dates)) {
//             return new DateTime($this->{$property});
//         }

//         return $this->{$property};
//     }
// }

// class User extends Model
// {
//     protected $dates = ['created_at'];
//     protected $created_at = '2016-01-01 12:30:00';
// }

// class Comment extends Model
// {
//     // public $created_at = '2016-01-01 12:30:00';

//     // public function getCeatedAt()
//     // {
//     //     return new DateTime($this->created_at);
//     // }
// }

// $user = new User;

// var_dump($user->created_at);