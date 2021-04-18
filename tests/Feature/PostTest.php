<?php

namespace Tests\Feature;

use App\Posts;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    public function testHasPosts()
    {
        $this->assertNotEmpty(Posts::all());
    }

    public function testHasUsers()
	{
		$this->assertNotEmpty(User::all());
	}
}
