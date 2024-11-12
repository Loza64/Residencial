<?php
function validateSignUp($post) {  
    $errors = [];  

    if (!preg_match('/^[a-zA-ZÁ-ÿ0-9]{4,40}$/', $post["username"])) {  
        $errors["username"] = "Please input a valid username.";  
    }  

    if (!preg_match('/^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/', $post["email"])) {  
        $errors["email"] = "Please input a valid email.";  
    }  

    if (!preg_match('/^[a-zA-ZÁ-ÿ\s(),.-]{4,240}$/', $post["pass"])) {  
        $errors["pass"] = "Please input a valid password.";  
    }  

    return $errors;  
}   

function validateLogin($post) {  
    $errors = [];  

    if (!preg_match('/^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/', $post["email"])) {  
        $errors["email"] = "Please input a valid email.";  
    }  

    if (!preg_match('/^[a-zA-ZÁ-ÿ\s(),.-]{3,240}$/', $post["pass"])) {  
        $errors["password"] = "Please input a valid password.";  
    }  

    return $errors;  
}