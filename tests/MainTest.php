<?php

use PHPUnit\Framework\TestCase;
use pxgamer\devRant\Connection;
use pxgamer\devRant\Rant;

class MainTest extends TestCase
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
        $this->assertInternalType('array', $rants);
        $this->assertNotEmpty($rants);
    }

    public function testCanGetRantById()
    {
        $devRant = new Connection;
        $rantData = $devRant->getRantById(938509);
        $this->assertInstanceOf(Rant::class, $rantData);
    }

    public function testCanGetUserById()
    {
        $devRant = new Connection;
        $userData = $devRant->getUserById(653921);
        $this->assertInternalType('array', $userData);
        $this->assertArrayHasKey('success', $userData);
    }

    public function testCanSearchRants()
    {
        $devRant = new Connection;
        $searchData = $devRant->getRants('Linux');
        $this->assertInternalType('array', $searchData);
        $this->assertNotEmpty($searchData);
    }

    public function testCanGetUserId()
    {
        $devRant = new Connection;
        $userIdData = $devRant->getUserId('pxgamer');
        $this->assertInternalType('array', $userIdData);
        $this->assertArrayHasKey('success', $userIdData);
    }

    public function testCanGetCollabs()
    {
        $devRant = new Connection;
        $collabs = $devRant->collabs();
        $this->assertInternalType('array', $collabs);
        $this->assertArrayHasKey('success', $collabs);
    }
}
