<?php

namespace Test\Test\TripServiceKata\Trip;

use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;

class TripServiceTestable extends TripService
{
    public function __construct(private readonly ?User $loggedUser = null)
    {
    }

    protected function getLoggedUser(): ?User
    {
        return $this->loggedUser;
    }

    protected function findTrips(User $user): array
    {
        return $user->getTrips();
    }

}
