<?php
use pxgamer\devRant\Connection;

class MainTest extends PHPUnit_Framework_TestCase
{

    public function testCanBeInitialised()
    {
        $devRant = new Connection;
        $this->assertInstanceOf(Connection::class, $devRant);
    }

    public function testCanGetRants()
    {
        $devRant = new Connection;
        $rants = $devRant->getRants();
        $this->assertNotFalse($rants);
    }

    public function testCanGetRantById()
    {
        $devRant = new Connection;
        $rantData = $devRant->getRantById(404);
        $this->assertNotFalse($rantData);
    }

    public function testCanGetUserById()
    {
        $devRant = new Connection;
        $userData = $devRant->getUserById(404);
        $this->assertArrayHasKey('success', $userData);
    }

    public function testCanSearchRants()
    {
        $devRant = new Connection;
        $searchData = $devRant->getRants('Linux');
        $this->assertNotFalse($searchData);
    }

    public function testCanGetUserId()
    {
        $devRant = new Connection;
        $userIdData = $devRant->getUserId('pxgamer');
        $this->assertArrayHasKey('success', $userIdData);
    }

}
