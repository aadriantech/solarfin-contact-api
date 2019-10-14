<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckApiContactListStatusTest extends TestCase
{
    public function testApiContactListPageStatusIsUp()
    {
        $response = $this->get('/api/contacts');

        $response->assertStatus(200);
    }

    public function testApiContactListJsonDataCount()
    {
        $response = $this->get('/api/contacts');
        $count = Contact::all()->count();

        $response->assertJsonCount($count, 'data');
    }

    public function testApiContactListJsonStructureIsCorrect()
    {
        $response = $this->get('/api/contacts');
        
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'first_name', 'last_name', 'phone', 'created_at', 'updated_at']
            ]
        ]);
    }
}
