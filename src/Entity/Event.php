<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\Extension\Core\Type\DateTime;

#[Assert\EnableAutoMapping]
#[ORM\Entity(repositoryClass: EventRepository::class)]
#[Vich\Uploadable] 
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Name cannot be empty')]
    #[Assert\Regex([
        'pattern' => "/^[\w'\s\p{L}.,-]*$/u",
        'match' => true,
        'message' => 'Unauthorized special character',
    ])]
    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[Assert\NotBlank(message: 'Date cannot be empty')]
    // TODO Add regex on very specific date format 
    #[Assert\GreaterThan('today')]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datetime = null;

    #[Assert\NotBlank(message: 'Place cannot be empty')]
    #[Assert\Regex([
        'pattern' => "/^[\w'\s\p{L}.,-]*$/u",
        'match' => true,
        'message' => 'Unauthorized special character',
    ])]
    #[ORM\Column(length: 100)]
    private ?string $place = null;

    #[Assert\NotBlank(message: 'City cannot be empty')]
    #[Assert\Regex([
        'pattern' => "/^[a-zA-Z'\s\p{L}.,-]*$/u",
        'match' => true,
        'message' => 'Unauthorized special character',
    ])]
    #[ORM\Column(length: 100)]
    private ?string $city = null;

    #[Assert\Regex([
        'pattern' => "/^[\w'\s\p{L})(?!.,;:-]*$/u",
        'match' => true,
        'message' => 'Unauthorized special character',
    ])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    // TODO Add verification on image
    #[ORM\Column(length: 2048, nullable: true)]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'image')]
    #[Assert\File(
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
        maxSize: '2M',
    )]
    private ?File $imageFile = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Style $style = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $imageUploadAt = null;
    
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addConstraint(new UniqueEntity([
            'fields' => ['name', 'datetime'],
            'errorPath' => 'datetime',
            'message' => 'This date is already in use on this name.',
        ]));

        $metadata->addConstraint(new UniqueEntity([
            'fields' => ['place', 'datetime', 'city'],
            'message' => 'This place and city are already in use at this date.',
        ]));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image = null): self
    {
        $this->image = $image;

        return $this;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        if ($image) {
            $this->imageUploadAt = new \DateTimeImmutable('now');
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getStyle(): ?Style
    {
        return $this->style;
    }

    public function setStyle(?Style $style): self
    {
        $this->style = $style;

        return $this;
    }

    public function getImageUploadAt(): ?\DateTimeImmutable
    {
        return $this->imageUploadAt;
    }

    public function setImageUploadAt(?\DateTimeImmutable $imageUploadAt): self
    {
        $this->imageUploadAt = $imageUploadAt;

        return $this;
    }
}
