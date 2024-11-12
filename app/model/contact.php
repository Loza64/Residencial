<?php  

class Contact {  
    private $id;  
    private $id_user;  
    private $name;  
    private $birth;  
    private $dui;  
    private $email;  
    private $phone;  
    private $address;  
    private $occupation;  
    private $income;  
    private $family_members;  
    private $reason_interest;  
    private $personal_reference;  
    private $application_date;  

    // Constructor vacío  
    public function __construct() {  

    }  

    public function __constructFull(  
        $id_user,  
        $name,  
        $birth,  
        $dui,  
        $email,  
        $phone,  
        $address,  
        $occupation,  
        $income,  
        $family_members,  
        $reason_interest,  
        $personal_reference,  
        $application_date  
    ) {  
        $this->id_user = $id_user;  
        $this->name = $name;  
        $this->birth = $birth;  
        $this->dui = $dui;  
        $this->email = $email;  
        $this->phone = $phone;  
        $this->address = $address;  
        $this->occupation = $occupation;  
        $this->income = $income;  
        $this->family_members = $family_members;  
        $this->reason_interest = $reason_interest;  
        $this->personal_reference = $personal_reference;  
        $this->application_date = $application_date;  
    }  

    public function getId() {  
        return $this->id;  
    }  

    public function setId($id) {  
        $this->id = $id;  
    }  

    public function getIdUser() {  
        return $this->id_user;  
    }  

    public function setIdUser($id_user) {  
        $this->id_user = $id_user;  
    }  

    public function getName() {  
        return $this->name;  
    }  

    public function setName($name) {  
        $this->name = $name;  
    }  

    public function getBirth() {  
        return $this->birth;  
    }  

    public function setBirth($birth) {  
        $this->birth = $birth;  
    }  

    public function getDui() {  
        return $this->dui;  
    }  

    public function setDui($dui) {  
        $this->dui = $dui;  
    }  

    public function getEmail() {  
        return $this->email;  
    }  

    public function setEmail($email) {  
        $this->email = $email;  
    }  

    public function getPhone() {  
        return $this->phone;  
    }  

    public function setPhone($phone) {  
        $this->phone = $phone;  
    }  

    public function getAddress() {  
        return $this->address;  
    }  

    public function setAddress($address) {  
        $this->address = $address;  
    }  

    public function getOccupation() {  
        return $this->occupation;  
    }  

    public function setOccupation($occupation) {  
        $this->occupation = $occupation;  
    }  

    public function getIncome() {  
        return $this->income;  
    }  

    public function setIncome($income) {  
        $this->income = $income;  
    }  

    public function getFamilyMembers() {  
        return $this->family_members;  
    }  

    public function setFamilyMembers($family_members) {  
        $this->family_members = $family_members;  
    }  

    public function getReasonInterest() {  
        return $this->reason_interest;  
    }  

    public function setReasonInterest($reason_interest) {  
        $this->reason_interest = $reason_interest;  
    }  

    public function getPersonalReference() {  
        return $this->personal_reference;  
    }  

    public function setPersonalReference($personal_reference) {  
        $this->personal_reference = $personal_reference;  
    }  

    public function getApplicationDate() {  
        return $this->application_date;  
    }  

    public function setApplicationDate($application_date) {  
        $this->application_date = $application_date;  
    }  
}  