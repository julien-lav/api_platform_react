<?php 

namespace App\Token;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedSubscriber 
{
    public function updateJWTData(JWTCreatedEvent $event) 
    {
        $user = $event->getUser();
        $data = $event->getData();

        $data["firstname"] = $user->getFirstname();
        $data["lastname"] = $user->getLastname();
        
        $event->setData($data);
    }
}