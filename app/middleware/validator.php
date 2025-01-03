<?php
function validateParameter($get)
{
    $errors = [];
    if (!preg_match('/^[a-zA-ZÁ-ÿ0-9]{0,40}$/', $get)) {
        $errors["parameter"] = "The input is invalid. It should only contain letters, numbers, and be up to 40 characters long.";
    }
    return $errors;
}

function validateParameterInt($get)
{
    $errors = [];
    if (!filter_var($get, FILTER_VALIDATE_INT) || $get <= 0) {
        $errors["parameter"] = "The input must be a positive integer.";
    }
    return $errors;
}

function validateSignUp($post)
{
    $errors = [];

    if (!preg_match('/^[a-zA-ZÁ-ÿ0-9]{4,13}$/', $post["username"])) {
        $errors["username"] = "Username must be between 4 and 13 characters long and can only contain letters and numbers.";
    }

    if (!preg_match('/(?=.{6,150}$)[a-z0-9._%+-]{5,}@[a-z.-]{5,}\.[a-z]{2,}$/', $post["email"])) {
        $errors["email"] = "Please enter a valid email address.";
    }

    if (!preg_match('/^[a-zA-ZÁ-ÿ0-9\s(),.-]{4,240}$/', $post["pass"])) {
        $errors["pass"] = "Password must be between 4 and 240 characters long and can include letters, spaces, and some symbols.";
    }

    return $errors;
}

function validateLogin($post)
{
    $errors = [];

    if (!preg_match('/(?=.{6,150}$)[a-z0-9._%+-]{5,}@[a-z.-]{5,}\.[a-z]{2,}$/', $post["email"])) {
        $errors["email"] = "Please enter a valid email address.";
    }

    if (!preg_match('/^[a-zA-ZÁ-ÿ0-9\s(),.-]{3,240}$/', $post["pass"])) {
        $errors["password"] = "Password must be between 3 and 240 characters long and can include letters, spaces, and some symbols.";
    }

    return $errors;
}

function validateProfile($put)
{
    $errors = [];
    if (!preg_match('/^[a-zA-ZÁ-ÿ0-9]{4,13}$/', $put["username"])) {
        $errors["username"] = "Username must be between 4 and 13 characters long and can only contain letters and numbers.";
    }

    if (!preg_match('/(?=.{6,150}$)[a-z0-9._%+-]{5,}@[a-z.-]{5,}\.[a-z]{2,}$/', $put["email"])) {
        $errors["email"] = "Please enter a valid email address.";
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

    // User ID validation  
    if (!is_numeric($post["iduser"]) || $post["iduser"] < 0) {
        $errors["iduser"] = "Please enter a valid user ID (must be a positive number).";
    }

    if (!preg_match('/^[a-zA-ZÁ-ÿ\s]{3,150}$/', $post["name"])) {
        $errors["name"] = "Name must be between 3 and 150 characters long and can only contain letters.";
    }
  
    if (!validDate($post["birth"])) {
        $errors["birth"] = "Please enter a valid birth date in the format 'Y-m-d'.";
    } else {
        $birthDate = DateTime::createFromFormat('Y-m-d', $post["birth"]);
        $currentDate = new DateTime();
        $age = $currentDate->diff($birthDate)->y;
        if ($age < 18) {
            $errors["birth"] = "You must be at least 18 years old.";
        }
    }

    if (!preg_match('/^[0-9]{8}-[0-9]{1}$/', $post["dui"])) {
        $errors["dui"] = "DUI must be in the format 12345678-9.";
    }

    if (!filter_var($post["email"], FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Please enter a valid email address.";
    } elseif (!preg_match('/(?=.{6,150}$)[a-z0-9._%+-]{5,}@[a-z.-]{5,}\.[a-z]{2,}$/', $post["email"])) {
        $errors["email"] = "The email address is in an invalid format.";
    }

    if (!preg_match('/^[0-9]{8}$/', $post["phone"])) {
        $errors["phone"] = "Phone number must be exactly 8 digits.";
    }

    if (!preg_match('/^[a-zA-Z0-9Á-ÿ ,.-]{4,400}$/', $post["address"])) {
        $errors["address"] = "Address must be between 4 and 400 characters long and contain valid characters.";
    }

    if (!preg_match('/^[a-zA-Z0-9Á-ÿ\s]{5,120}$/', $post["occupation"])) {
        $errors["occupation"] = "Occupation must be between 5 and 120 characters long and contain only letters or numbers.";
    }

    if (!is_numeric($post["income"]) || $post["income"] < 0) {
        $errors["income"] = "Please enter a valid monthly income (must be a positive number).";
    }

    if (!filter_var($post["family_members"], FILTER_VALIDATE_INT) || $post["family_members"] < 0) {
        $errors["family_members"] = "The number of family members must be a non-negative integer.";
    }

    if (!preg_match('/^[a-zA-Z0-9Á-ÿ ,.-]{5,350}$/', $post["reason_interest"])) {
        $errors["reason_interest"] = "The reason for interest must be between 5 and 350 characters long and contain only valid characters.";
    }

    if (!preg_match('/^[a-zA-Z0-9Á-ÿ ,.-]{5,200}$/', $post["personal_reference"])) {
        $errors["personal_reference"] = "The personal reference must be between 5 and 200 characters long and contain only valid characters.";
    }

   return $errors;
}