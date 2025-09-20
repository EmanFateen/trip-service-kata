<?php

namespace TripServiceKata\Trip;

use TripServiceKata\User\User;
use TripServiceKata\User\UserSession;
use TripServiceKata\Exception\UserNotLoggedInException;

class TripService
{
    /**
     * @return Trip[]
     * @throws UserNotLoggedInException
     */
    public function getTripsByUser(User $user): array
    {
        $loggedUser = $this->getLoggedUser();

        if ($loggedUser === null) {
            throw new UserNotLoggedInException();
        }

        return $this->getTripsForLoggedUserFriend($user, $loggedUser);
    }

    public function getTripsForLoggedUserFriend(User $user, User $loggedUser): array
    {
        return $loggedUser->isFriendOf($user) ? $this->findTrips($user) : [];
    }

    protected function getLoggedUser(): ?User
    {
        return UserSession::getInstance()->getLoggedUser();
    }

    protected function findTrips(User $user): array
    {
        return TripDAO::findTripsByUser($user);
    }
}
