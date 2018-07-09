<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

      public function testLoginSuccess()
    {
        $credential = [
            'email' => 'kongarn@gmail.com',
            'password' => '11111111'
        ];
        
        $this->withoutMiddleware();
        
        Auth::shouldReceive('attempt')->once()->withAnyArgs()->andReturn(true);
        Auth::shouldReceive('user')->once()->withAnyArgs()->andReturn(true);

        $response = $this->post('api/login',$credential);

        $response->assertRedirect('admin/user');
    }
     
    public function testLoginFail()
    {
        $credential = [
            'email' => 'user@ad.com',
            'password' => 'incorrectpass'
        ];
        
        $this->withoutMiddleware();

        $response = $this->post('/login',$credential);
        
        $response->assertRedirect('/login');
    }

    public function testGetResourceAPISuccess()
    {
            $user = factory(User::class)->create([
                'surname' => 'pizzamuncher'
            ]);
         
         $this->withoutMiddleware();
         
         Auth::shouldReceive('user')->once()->withAnyArgs()->andReturn($user);

         $response = $this
             ->json('GET','/api/resource/user');

         $response->assertStatus(200);
         $response->assertSee($user->surname,'pizzamuncher');

    }
    
    public function testGetResourceAPIFail()
    {
         
         $response = $this
             ->json('GET','/api/resource/user');

         $response->assertStatus(401);

    }


}
