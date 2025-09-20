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

        $sut->getTripsByUser($customer = new User(''));
    }

    #[Test]
    public function user_with_no_friends_has_no_trips(): void
    {
        $loggedUser = new User('');
        $sut = new TripServiceTestable($loggedUser);

        $actual = $sut->getTripsByUser($customer = new User(''));

        $this->assertCount(0, $actual);
    }

    #[Test]
    public function find_trips_for_user_if_friend_of_logged_user(): void
    {
        $loggedUser = new User('');
        $customer = new User('customer');
        $customer->addFriend($loggedUser);
        $customer->addTrip(new Trip());
        $sut = new TripServiceTestable($loggedUser);

        $actual = $sut->getTripsByUser($customer);

        $this->assertCount(1, $actual);
    }
}
