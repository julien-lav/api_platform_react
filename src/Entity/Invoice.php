<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

use App\Repository\InvoiceRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=InvoiceRepository::class)
 * @ApiResource(
 *   subresourceOperations={
 *      "api_customers_invoices_get_subresource"={
 *          "normalization_context"={
 *               "groups"={
 *                  "invoices_subresource"  
 *              }  
 *          }
 *      }
 *   },
 *   itemOperations={"GET", "PUT", "DELETE", "increment"= {
 *      "method"="post", 
 *      "path"="/invoices/{id}/increment", 
 *      "controller"="App\Controller\InvoiceIncrementationController", 
 *      "openapi_context"={
 *          "summary"="Incrémente une facture", 
 *          "description"="Incrémente le chrono d'une facture donnée"
 *      }
 *   }},
 *   attributes={
 *     "pagination_enabled" = false, 
 *     "pagination_items_per_page" = 20,
 *     "order" : {"sentAt" : "desc"}
 *   }, 
 *   normalizationContext={
 *       "groups"={
 *          "invoices_read"  
 *      } 
 *   },
 *   denormalizationContext={
 *       "disable_type_enforcement"=true 
 *   }
 * )
 * @ApiFilter(OrderFilter::class, properties={"amount","sentAt"})
 */
class Invoice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"invoices_read", "customers_read", "invoices_subresource"})
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups({"invoices_read", "customers_read", "invoices_subresource"}) 
     * @Assert\NotBlank(message="Amount is mandatory")
     * @Assert\Type(type="numeric", message="Amount is mandatory")
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"invoices_read", "customers_read", "invoices_subresource"})
     * @Assert\NotBlank(message="Date is mandatory")
     * @Assert\Type(type = "\DateTime", message="La date renseignée doit être au format YYYY-MM-DD")
     */
    private $sentAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"invoices_read", "customers_read", "invoices_subresource"})
     * @Assert\NotBlank(message="Status is mandatory")
     * @Assert\Choice(choices={"SENT", "PAID", "CANCELLED"}, message="Le statut doit être SENT, PAID ou CANCELLED")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="invoices")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"invoices_read"})
     */
    private $customer;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"invoices_read", "customers_read"})
     * @Groups({"invoices_read", "customers_read", "invoices_subresource"})     
     * @Assert\NotBlank(message="Chrono is mandatory")
     * @Assert\Type(type="integer", message="Chrono is a number")
     */
    private $chrono;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount($amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getSentAt(): ?\DateTimeInterface
    {
        return $this->sentAt;
    }

    public function setSentAt($sentAt): self
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    // /**
    //  * Undocumented function
    //  * @Groups({"invoices_read"}
    //  * 
    //  * @return User
    //  */
    // public function getUser(): User
    // {
    //     return $this->customer->getUser();
    // }

    public function getChrono(): ?int
    {
        return $this->chrono;
    }

    public function setChrono(int $chrono): self
    {
        $this->chrono = $chrono;

        return $this;
    }
}
