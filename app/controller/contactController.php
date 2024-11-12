<?php

require_once '../connection/database.php';

class ContactController {
    public static function isFormSubmitted($user_id) {
        $db = new Database();
        $query = "SELECT * FROM contact_forms WHERE id_user = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->rowCount() > 0;
    }

    // Función para guardar el formulario de contacto en la base de datos
    public static function submitForm($formData) {
        $db = new Database();
        $query = "INSERT INTO contact_forms (id_user, name, birth_date, dui, email, phone, address, occupation, income, household_size, interest_reason, references, application_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        return $stmt->execute([
            $formData['id_user'],
            $formData['name'],
            $formData['birth_date'],
            $formData['dui'],
            $formData['email'],
            $formData['phone'],
            $formData['address'],
            $formData['occupation'],
            $formData['income'],
            $formData['household_size'],
            $formData['interest_reason'],
            $formData['references'],
            $formData['application_date']
        ]);
    }

    // Función para obtener todos los formularios de contacto
    public static function getAllForms() {
        $db = new Database();
        $query = "SELECT * FROM contact_forms";
        $stmt = $db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = [
        'id_user' => $_SESSION['user']['id'],
        'name' => $_POST['name'],
        'birth_date' => $_POST['birth_date'],
        'dui' => $_POST['dui'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'address' => $_POST['address'],
        'occupation' => $_POST['occupation'],
        'income' => $_POST['income'],
        'household_size' => $_POST['household_size'],
        'interest_reason' => $_POST['interest_reason'],
        'references' => $_POST['references'],
        'application_date' => $_POST['application_date']
    ];

    $isSaved = ContactController::submitForm($formData);
    if ($isSaved) {
        header('Location: ../view/contact.php?success=1');
        exit();
    } else {
        header('Location: ../view/contact.php?error=1');
        exit();
    }
}


