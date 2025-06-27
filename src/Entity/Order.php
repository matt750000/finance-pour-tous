<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column]
    private ?float $totalPrice = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Name is required.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Name cannot exceed {{ limit }} characters."
    )]
    #[Assert\Regex(
        pattern: '/^[\p{L} \'-]+$/u',
        message: "Name can only contain letters, spaces, apostrophes or hyphens."
    )]
    private ?string $name = null;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: "Address is required.")]
    #[Assert\Length(
        max: 1000,
        maxMessage: "Address cannot exceed {{ limit }} characters."
    )]
    private ?string $address = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "City is required.")]
    #[Assert\Length(
        max: 100,
        maxMessage: "City cannot exceed {{ limit }} characters."
    )]
    #[Assert\Regex(
        pattern: '/^[\p{L} \'-]+$/u',
        message: "City can only contain letters, spaces, apostrophes or hyphens."
    )]
    private ?string $city = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank(message: "Postal code is required.")]
    #[Assert\Length(
        min: 5,
        max: 5,
        exactMessage: "Postal code must be exactly {{ limit }} digits."
    )]
    #[Assert\Regex(
        pattern: '/^\d{5}$/',
        message: "Postal code must be exactly 5 digits."
    )]
    private ?string $postalCode = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: "Phone number is required.")]
    #[Assert\Regex(
        pattern: '/^0[1-9](\d{2}){4}$/',
        message: "Phone number must be in French format, e.g. 0601020304."
    )]
    private ?string $phone = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "Payment method is required.")]
    #[Assert\Choice(
        choices: ['bank_transfer', 'credit_card', 'paypal'],
        message: "Payment method must be one of: 'bank_transfer', 'credit_card', or 'paypal'."
    )]
    private ?string $paymentMethod = null;


    /**
     * @var Collection<int, OrderItem>
     */
    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'orderRef', orphanRemoval: true)]
    private Collection $orderItems;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(onDelete: 'CASCADE', nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }


    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): static
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): static
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setOrderRef($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): static
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getOrderRef() === $this) {
                $orderItem->setOrderRef(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;
        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): static
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;
        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(string $paymentMethod): static
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }
}
