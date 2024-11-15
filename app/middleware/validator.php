<?php

function validateParameter($get)
{
    $errors = [];
    if (!preg_match('/^[a-zA-ZÁ-ÿ0-9]{0,40}$/', $get)) {
        $errors["parameter"] = "Please input a valid data.";
    }
    return $errors;
}

function validateParameterInt($get)
{
    $errors = [];
    if (!filter_var($get, FILTER_VALIDATE_INT) || $get <= 0) {
        $errors["parameter"] = "Please input a valid data.";
    }
    return $errors;
}

function validateSignUp($post)
{
    $errors = [];

    if (!preg_match('/^[a-zA-ZÁ-ÿ0-9]{4,13}$/', $post["username"])) {
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

function validateLogin($post)
{
    $errors = [];

    if (!preg_match('/^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/', $post["email"])) {
        $errors["email"] = "Please input a valid email.";
    }

    if (!preg_match('/^[a-zA-ZÁ-ÿ\s(),.-]{3,240}$/', $post["pass"])) {
        $errors["password"] = "Please input a valid password.";
    }

    return $errors;
}

function validateProfile($put){
    $errors = [];
    if (!preg_match('/^[a-zA-ZÁ-ÿ0-9]{4,13}$/', $put["username"])) {
        $errors["username"] = "Please input a valid username.";
    }

    if (!preg_match('/^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/', $put["email"])) {
        $errors["email"] = "Please input a valid email.";
    }
    return $errors;
}

function validDate($data)
{
    $date = DateTime::createFromFormat('Y-m-d', $data);
    return $date && $date->format('Y-m-d') === $data;
}

function validateContact($post)
{
    $errors = [];

    // Validación del ID de usuario  
    if (!is_numeric($post["iduser"]) || $post["iduser"] < 0) {
        $errors["iduser"] = "Please enter a valid id user (it must be a positive number).";
    }

    if (!preg_match('/^[a-zA-ZÁ-ÿ\s]{3,150}$/', $post["name"])) {
        $errors["name"] = "The name must be between 3 and 150 characters long and contain only letters.";
    }

    // Validación de la fecha de nacimiento  
    if (!validDate($post["birth"])) {
        $errors["birth"] = "Please enter a valid date in the format 'Y-m-d'.";
    } else {
        $birthDate = DateTime::createFromFormat('Y-m-d', $post["birth"]);
        $currentDate = new DateTime();
        $age = $currentDate->diff($birthDate)->y;
        if ($age < 18) {
            $errors["birth"] = "You must be at least 18 years old.";
        }
    }

    if (!preg_match('/^[0-9]{8}-[0-9]{1}$/', $post["dui"])) {
        $errors["dui"] = "The DUI must be in the format 12345678-9.";
    }

    if (!filter_var($post["email"], FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Please enter a valid email address.";
    } elseif (!preg_match('/^[\w._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/', $post["email"])) {
        $errors["email"] = "The email address is in an invalid format.";
    }

    if (!preg_match('/^[0-9]{8}$/', $post["phone"])) {
        $errors["phone"] = "The phone number must be 8 digits long.";
    }

    if (!preg_match('/^[a-zA-Z0-9Á-ÿ ,.-]{4,400}$/', $post["address"])) {
        $errors["address"] = "The address must be between 4 and 400 characters long and contain valid values.";
    }

    if (!preg_match('/^[a-zA-Z0-9Á-ÿ\s]{3,120}$/', $post["occupation"])) {
        $errors["occupation"] = "The occupation must be between 3 and 120 characters long and contain only letters or numbers.";
    }

    if (!is_numeric($post["income"]) || $post["income"] < 0) {
        $errors["income"] = "Please enter a valid monthly income (it must be a positive number).";
    }

    if (!filter_var($post["family_members"], FILTER_VALIDATE_INT) || $post["family_members"] < 0) {
        $errors["family_members"] = "The number of family members must be a non-negative integer.";
    }

    if (!preg_match('/^[a-zA-Z0-9Á-ÿ ,.-]{4,350}$/', $post["reason_interest"])) {
        $errors["reason_interest"] = "The reason for interest must be between 4 and 350 characters long and contain only valid characters.";
    }

    if (!preg_match('/^[a-zA-Z0-9Á-ÿ ,.-]{4,200}$/', $post["personal_reference"])) {
        $errors["personal_reference"] = "The personal reference must be between 4 and 200 characters long and contain only valid characters.";
    }

    if (!validDate($post["application_date"])) {
        $errors["application_date"] = "Please enter a valid application date in the format 'Y-m-d'.";
    } else {
        $applicationDate = DateTime::createFromFormat('Y-m-d', $post["application_date"]);
        $now = new DateTime();
        $now->setTime(0, 0, 0);
        if ($applicationDate < $now) {
            $errors["application_date"] = "The application date must be today or in the future.";
        }
    }

    return $errors;
}
