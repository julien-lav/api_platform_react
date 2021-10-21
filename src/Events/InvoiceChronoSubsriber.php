<?php 

namespace App\Events;

use App\Entity\Invoice;
use Symfony\Component\Security\Core\Security;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Repository\InvoiceRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class InvoiceChronoSubsriber implements EventSubscriberInterface 
{
    private $security;
    private $repository;

    public function __construct(Security $security, InvoiceRepository $repository)
    {
        $this->security = $security;
        $this->repository = $repository;
    }

    public static function getSubscribedEvents()
    {        
        return [
            KernelEvents::VIEW => ['setChrono', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function setChrono(ViewEvent $event) 
    {
        $result = $event->getControllerResult();
        $method = $event->getRequest()->getMethod(); 

        if($result instanceof Invoice && $method === "POST") {
            $user = $this->security->getUser();
            $nextChrono = $this->repository->findNextChrono($user);
            
            $result->setChrono($nextChrono);
            
            // TODO : A déplacer dans une classe dédiée
            if (empty($result->getSentAt())) {
                $result->setSentAt(new \DateTime());
            }
        }
    }
}