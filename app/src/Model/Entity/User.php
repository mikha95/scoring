<?php

namespace App\Model\Entity;

use App\Model\EducationEnum;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity(repositoryClass: UserRepository::class)]
class User
{
    public function __construct(
        #[Id]
        #[GeneratedValue(strategy: 'IDENTITY')]
        #[Column(type: 'integer')]
        private ?int $id = null,
        #[Column(type: 'string')]
        private ?string $name = null,
        #[Column(type: 'string')]
        private ?string $surname = null,
        #[Column(type: 'string')]
        private ?string $phone = null,
        #[Column(type: 'string')]
        private ?string $email = null,
        #[Column(type: 'string')]
        private ?string $education = null,
        #[Column(type: 'boolean')]
        private ?bool $agree = null,
        #[Column(type: 'integer')]
        private ?int $phoneScore = null,
        #[Column(type: 'integer')]
        private ?int $emailScore = null,
        #[Column(type: 'integer')]
        private ?int $educationScore = null,
        #[Column(type: 'integer')]
        private ?int $agreeScore = null,
        #[Column(type: 'integer')]
        private ?int $sum = null,
    ) {

    }

       public function getId(): ?int
       {
           return $this->id;
       }

    public function setId(?int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getEducation(): ?string
    {
        return $this->education;
    }

    public function setEducation(?string $education): static
    {
        $this->education = $education;

        return $this;
    }

    public function getEducationLabel(): string
    {
        return EducationEnum::getLabel($this->education ?? '');
    }

    public function getAgree(): ?bool
    {
        return $this->agree;
    }

    public function setAgree(?bool $agree): static
    {
        $this->agree = $agree;

        return $this;
    }

    public function getPhoneScore(): ?int
    {
        return $this->phoneScore;
    }

    public function setPhoneScore(?int $phoneScore): static
    {
        $this->phoneScore = $phoneScore;

        return $this;
    }

    public function getEmailScore(): ?int
    {
        return $this->emailScore;
    }

    public function setEmailScore(?int $emailScore): static
    {
        $this->emailScore = $emailScore;

        return $this;
    }

    public function getEducationScore(): ?int
    {
        return $this->educationScore;
    }

    public function setEducationScore(?int $educationScore): static
    {
        $this->educationScore = $educationScore;

        return $this;
    }

    public function getAgreeScore(): ?int
    {
        return $this->agreeScore;
    }

    public function setAgreeScore(?int $agreeScore): static
    {
        $this->agreeScore = $agreeScore;

        return $this;
    }

    public function getSum(): ?int
    {
        return $this->sum;
    }

    public function setSum(?int $sum): static
    {
        $this->sum = $sum;

        return $this;
    }
}
