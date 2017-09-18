<?php
use pxgamer\devRant\Modules;

class MainTest extends PHPUnit_Framework_TestCase
{
    public function testCanGetRants()
    {
        $devRant = new Modules\Rants;
        $rants = $devRant->getRants();
        $this->assertNotFalse($rants);
    }

    public function testCanGetRantById()
    {
        $devRant = new Modules\Rants;
        $response = $devRant->getRantById(404);
        $this->assertNotFalse($response);
    }

    public function testCanGetUserById()
    {
        $devRant = new Modules\Users;
        $response = $devRant->getUserById(404);
        $this->assertArrayHasKey('success', $response);
    }

    public function testCanSearchRants()
    {
        $devRant = new \pxgamer\devRant\Modules\Rants;
        $response = $devRant->getRants('Linux');
        $this->assertNotFalse($response);
    }

    public function testCanGetUserId()
    {
        $devRant = new Modules\Users();
        $response = $devRant->getUserId('pxgamer');
        $this->assertArrayHasKey('success', $response);
    }

    public function testCanGetCollabs()
    {
        $devRant = new Modules\Collabs;
        $response = $devRant->collabs();
        $this->assertArrayHasKey('success', $response);
    }
}
