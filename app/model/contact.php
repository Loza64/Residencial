<?php  

require_once './app/connection/database.php';  

class Contact extends Database {  
    private ?int $id;  
    private ?int $id_user;  
    private ?string $name;  
    private ?string $birth;  
    private ?string $dui;  
    private ?string $email;  
    private ?string $phone;  
    private ?string $address;  
    private ?string $occupation;  
    private ?float $income;  
    private ?int $family_members;  
    private ?string $reason_interest;  
    private ?string $personal_reference;  
    private ?string $application_date;  

    public function __construct(  
        ?int $id = null,  
        ?int $id_user = null,  
        ?string $name = null,  
        ?string $birth = null,  
        ?string $dui = null,  
        ?string $email = null,  
        ?string $phone = null,  
        ?string $address = null,  
        ?string $occupation = null,  
        ?float $income = null,  
        ?int $family_members = null,  
        ?string $reason_interest = null,  
        ?string $personal_reference = null,  
        ?string $application_date = null  
    ) {  
        $this->id = $id;  
        $this->id_user = $id_user;  
        $this->setName($name);  
        $this->setBirth($birth);  
        $this->setDui($dui);  
        $this->setEmail($email);  
        $this->setPhone($phone);  
        $this->setAddress($address);  
        $this->setOccupation($occupation);  
        $this->setIncome($income);  
        $this->setFamilyMembers($family_members);  
        $this->setReasonInterest($reason_interest);  
        $this->setPersonalReference($personal_reference);  
        $this->setApplicationDate($application_date);  
    }  

    // Getters y setters...  
    
    public function getId(): ?int {  
        return $this->id;  
    }  

    public function setId(?int $id): self {  
        $this->id = $id;  
        return $this;  
    }  

    public function getIdUser(): ?int {  
        return $this->id_user;  
    }  

    public function setIdUser(?int $id_user): self {  
        $this->id_user = $id_user;  
        return $this;  
    }  

    public function getName(): ?string {  
        return $this->name;  
    }  

    public function setName(?string $name): self {  
        $this->name = $name;  
        return $this;  
    }  

    public function getBirth(): ?string {  
        return $this->birth;  
    }  

    public function setBirth(?string $birth): self {  
        $this->birth = $birth;  
        return $this;  
    }  

    public function getDui(): ?string {  
        return $this->dui;  
    }  

    public function setDui(?string $dui): self {  
        $this->dui = $dui;  
        return $this;  
    }  

    public function getEmail(): ?string {  
        return $this->email;  
    }  

    public function setEmail(?string $email): self {  
        if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {  
            throw new InvalidArgumentException("Email inválido");  
        }  
        $this->email = strtolower($email);  
        return $this;  
    }  

    public function getPhone(): ?string {  
        return $this->phone;  
    }  

    public function setPhone(?string $phone): self {  
        $this->phone = $phone;  
        return $this;  
    }  

    public function getAddress(): ?string {  
        return $this->address;  
    }  

    public function setAddress(?string $address): self {  
        $this->address = $address;  
        return $this;  
    }  

    public function getOccupation(): ?string {  
        return $this->occupation;  
    }  

    public function setOccupation(?string $occupation): self {  
        $this->occupation = $occupation;  
        return $this;  
    }  

    public function getIncome(): ?float {  
        return $this->income;  
    }  

    public function setIncome(?float $income): self {  
        $this->income = $income;  
        return $this;  
    }  

    public function getFamilyMembers(): ?int {  
        return $this->family_members;  
    }  

    public function setFamilyMembers(?int $family_members): self {  
        $this->family_members = $family_members;  
        return $this;  
    }  

    public function getReasonInterest(): ?string {  
        return $this->reason_interest;  
    }  

    public function setReasonInterest(?string $reason_interest): self {  
        $this->reason_interest = $reason_interest;  
        return $this;  
    }  

    public function getPersonalReference(): ?string {  
        return $this->personal_reference;  
    }  

    public function setPersonalReference(?string $personal_reference): self {  
        $this->personal_reference = $personal_reference;  
        return $this;  
    }  

    public function getApplicationDate(): ?string {  
        return $this->application_date;  
    }  

    public function setApplicationDate(?string $application_date): self {  
        $this->application_date = $application_date;  
        return $this;  
    }  

    public function toArray(): array {  
        return [  
            'id' => $this->id,  
            'id_user' => $this->id_user,  
            'name' => $this->name,  
            'birth' => $this->birth,  
            'dui' => $this->dui,  
            'email' => $this->email,  
            'phone' => $this->phone,  
            'address' => $this->address,  
            'occupation' => $this->occupation,  
            'income' => $this->income,  
            'family_members' => $this->family_members,  
            'reason_interest' => $this->reason_interest,  
            'personal_reference' => $this->personal_reference,  
            'application_date' => $this->application_date  
        ];  
    }  
}