<?php
use PHPUnit\Framework\TestCase;
use pxgamer\devRant;

class MainTest extends TestCase
{

	public function testCanBeInitialised()
	{
    $devRant = new devRant();
    $this->assertInstanceOf(devRant::class, $devRant);
  }

	public function testCanGetRants()
	{
    $devRant = new devRant();
    $rants = $devRant->getRants();
    $data = json_decode($rants, true);
    $this->assertArrayHasKey('success', $data);
  }

	public function testCanGetRantById()
	{
    $devRant = new devRant();
    $rantData = $devRant->getRantById(404);
    $data = json_decode($rantData, true);
    $this->assertArrayHasKey('success', $data);
  }

	public function testCanGetUserById()
	{
    $devRant = new devRant();
    $userData = $devRant->getUserById(404);
    $data = json_decode($userData, true);
    $this->assertArrayHasKey('success', $data);
  }

	public function testCanSearchRants()
	{
    $devRant = new devRant();
    $searchData = $devRant->searchRants('Linux');
    $data = json_decode($searchData, true);
    $this->assertArrayHasKey('success', $data);
  }

	public function testCanGetUsersId()
	{
    $devRant = new devRant();
    $userIdData = $devRant->getUsersId('pxgamer');
    $data = json_decode($userIdData, true);
    $this->assertArrayHasKey('success', $data);
  }

}