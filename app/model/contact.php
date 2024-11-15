<?php
require_once './app/connection/database.php';

class Contact extends Database
{
    private ?int $id;
    private ?int $id_user;
    private ?string $name;
    private ?string $dui;
    private ?string $email;
    private ?string $phone;
    private ?string $address;
    private ?string $occupation;
    private ?float $income;
    private ?int $family_members;
    private ?string $reason_interest;
    private ?string $personal_reference;
    private ?DateTime $birth;
    private ?DateTime $application_date;

    public function __construct(
        ?int $id = null,
        ?int $id_user = null,
        ?string $name = null,
        ?DateTime $birth = null,
        ?string $dui = null,
        ?string $email = null,
        ?string $phone = null,
        ?string $address = null,
        ?string $occupation = null,
        ?float $income = null,
        ?int $family_members = null,
        ?string $reason_interest = null,
        ?string $personal_reference = null,
        ?DateTime $application_date = null
    ) {
        $this->id = $id;
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDui(): ?string
    {
        return $this->dui;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getOccupation(): ?string
    {
        return $this->occupation;
    }

    public function getIncome(): ?float
    {
        return $this->income;
    }

    public function getFamilyMembers(): ?int
    {
        return $this->family_members;
    }

    public function getReasonInterest(): ?string
    {
        return $this->reason_interest;
    }

    public function getPersonalReference(): ?string
    {
        return $this->personal_reference;
    }

    public function getBirth(): ?DateTime
    {
        return $this->birth;
    }

    public function getApplicationDate(): ?DateTime
    {
        return $this->application_date;
    }

    private function isSubmited(int $iduser, PDO $con): bool
    {
        try {
            $stmt = $con->prepare("select * from contact where id_user = :iduser");
            $stmt->bindParam(":iduser", $iduser);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (\Throwable $th) {
            error_log("Error checking user existence: " . $th->getMessage());
            throw new Exception("Error checking user existence: " . $th->getMessage());
        }
    }

    public function create(Contact $contact): bool
    {
        try {
            $con = $this->getConnection();
            if (!$this->isSubmited($contact->getIdUser(), $con)) {
                $stmt = $con->prepare("INSERT INTO contact (id_user, name, birth, dui, email, phone, address, occupation, income, family_members, reason_interest, personal_reference, application_date) VALUES (:id_user, :name, :birth, :dui, :email, :phone, :address, :occupation, :income, :family_members, :reason_interest, :personal_reference, :application_date)");
                $stmt->bindValue(":id_user", $contact->getIdUser());
                $stmt->bindValue(":name", $contact->getName());
                $stmt->bindValue(":birth", $contact->getBirth()->format('Y-m-d'));
                $stmt->bindValue(":dui", $contact->getDui());
                $stmt->bindValue(":email", $contact->getEmail());
                $stmt->bindValue(":phone", $contact->getPhone());
                $stmt->bindValue(":address", $contact->getAddress());
                $stmt->bindValue(":occupation", $contact->getOccupation());
                $stmt->bindValue(":income", $contact->getIncome());
                $stmt->bindValue(":family_members", $contact->getFamilyMembers());
                $stmt->bindValue(":reason_interest", $contact->getReasonInterest());
                $stmt->bindValue(":personal_reference", $contact->getPersonalReference());
                $stmt->bindValue(":application_date", $contact->getApplicationDate()->format('Y-m-d'));
                $stmt->execute();
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            error_log("Error saving form contact: " . $th->getMessage());
            throw new Exception("Error saving form contact: " . $th->getMessage());
        }
    }

    public function getContactByUserId(int $iduser): ?Contact
    {
        try {
            $con = $this->getConnection();
            $stmt = $con->prepare("SELECT * FROM contact WHERE id_user = :iduser");
            $stmt->bindParam(":iduser", $iduser);
            $stmt->execute();
            $response = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($response) {
                return new Contact(
                    $response["id"],
                    $response["id_user"],
                    $response["name"],
                    new DateTime($response["birth"]),
                    $response["dui"],
                    $response["email"],
                    $response["phone"],
                    $response["address"],
                    $response["occupation"],
                    $response["income"],
                    $response["family_members"],
                    $response["reason_interest"],
                    $response["personal_reference"],
                    new DateTime($response["application_date"])
                );
            } else {
                return null;
            }
        } catch (\Throwable $th) {
            error_log("Error to get info: " . $th->getMessage());
            throw new Exception("Error to get info: " . $th->getMessage());
        }
    }

    public function getListContacts(string $search)
    {
        try {
            $con = $this->getConnection();
            $stmt = $con->prepare("SELECT 
                c.id as idcontact , u.id AS iduser, u.username AS user, u.state, c.name, c.birth,   
                c.dui, c.email, c.phone, c.address, c.occupation, c.income,   
                c.family_members, c.reason_interest, c.personal_reference, c.application_date   
                FROM contact c   
                LEFT JOIN users u ON u.id = c.id_user   
                WHERE u.username LIKE CONCAT('%', :search, '%')");
            $stmt->bindParam(":search", $search);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            error_log("Error retrieving contact information: " . $th->getMessage());
            throw new Exception("An error occurred while fetching contacts."); // More generic message  
        }
    }
}
