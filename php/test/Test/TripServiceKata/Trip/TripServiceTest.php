<?php

namespace Test\Test\TripServiceKata\Trip;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use TripServiceKata\Exception\UserNotLoggedInException;
use TripServiceKata\Trip\Trip;
use TripServiceKata\User\User;

class TripServiceTest extends TestCase
{
    #[Test]
    public function user_must_be_logged_in()
    {
        $sut = new TripServiceTestable(null);

        $this->expectException(UserNotLoggedInException::class);

        $sut->getTripsByUser($friend = new User(''));
    }

    #[Test]
    public function user_with_no_friends_has_no_trips(): void
    {
        $loggedUser = new User('');
        $sut = new TripServiceTestable($loggedUser);

        $actual = $sut->getTripsByUser($friend = new User(''));

        $this->assertCount(0, $actual);
    }

    #[Test]
    public function find_trips_for_user_if_friend_of_logged_user(): void
    {
        $loggedUser = new User('');
        $friend = new User('friend');
        $friend->addFriend($loggedUser);
        $friend->addTrip(new Trip());
        $sut = new TripServiceTestable($loggedUser);

        $actual = $sut->getTripsByUser($friend);

        $this->assertCount(1, $actual);
    }
}
