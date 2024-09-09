<?php

namespace App\Entity;

use App\Repository\EntryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EntryRepository::class)]
class Entry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $task = null;

    #[ORM\Column]
    #[Assert\Type('float')]
    #[Assert\NotBlank]
    private ?float $hours_planned = null;

    #[ORM\Column]
    #[Assert\Type('float')]
    #[Assert\NotBlank]
    private ?float $hours_actual = null;

    #[ORM\ManyToOne(inversedBy: 'entries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Submission $submission = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTask(): ?string
    {
        return $this->task;
    }

    public function setTask(string $task): static
    {
        $this->task = $task;

        return $this;
    }

    public function getHoursPlanned(): ?float
    {
        return $this->hours_planned;
    }

    public function setHoursPlanned(float $hours_planned): static
    {
        $this->hours_planned = $hours_planned;

        return $this;
    }

    public function getHoursActual(): ?float
    {
        return $this->hours_actual;
    }

    public function setHoursActual(?float $hours_actual): static
    {
        $this->hours_actual = $hours_actual;

        return $this;
    }

    public function getSubmission(): ?Submission
    {
        return $this->submission;
    }

    public function setSubmission(?Submission $submission): static
    {
        $this->submission = $submission;

        return $this;
    }
}
