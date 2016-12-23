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
        $data = json_decode($rants, true);
        $this->assertArrayHasKey('success', $data);
    }

    public function testCanGetRantById()
    {
        $devRant = new Connection;
        $rantData = $devRant->getRantById(404);
        $data = json_decode($rantData, true);
        $this->assertArrayHasKey('success', $data);
    }

    public function testCanGetUserById()
    {
        $devRant = new Connection;
        $userData = $devRant->getUserById(404);
        $data = json_decode($userData, true);
        $this->assertArrayHasKey('success', $data);
    }

    public function testCanSearchRants()
    {
        $devRant = new Connection;
        $searchData = $devRant->searchRants('Linux');
        $data = json_decode($searchData, true);
        $this->assertArrayHasKey('success', $data);
    }

    public function testCanGetUsersId()
    {
        $devRant = new Connection;
        $userIdData = $devRant->getUsersId('pxgamer');
        $data = json_decode($userIdData, true);
        $this->assertArrayHasKey('success', $data);
    }

}
