<?php

namespace Tests\Unit;

use App\Models\Contact;
use App\Strategies\ContactStrategy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class ContactStrategyProcessTest extends TestCase
{
    public $request;

    public function __construct()
    {
        parent::__construct();
        $this->request = Request::create('/api/contacts', 'POST', [
            'first_name' => 'first',
            'last_name' => 'last',
            'phones' => ['123456789', '+657894564563'],
        ]);
    }

    public function testContactStrategyProcessReturnsInstanceContactClass()
    {
        $contact = new Contact();
        $contactStrategy = new ContactStrategy($contact);
        $contact = $contactStrategy->process($this->request);

        $this->assertInstanceOf(Contact::class, $contact);
    }

    public function testAcceptsRequestValuesReturnsCorrectValues()
    {
        $contact = new Contact();
        $contactStrategy = new ContactStrategy($contact);
        $contact = $contactStrategy->process($this->request);

        $this->assertSame($this->request->first_name, $contact->first_name);
        $this->assertSame($this->request->last_name, $contact->last_name);
        $this->assertIsString($contact->phone);
        $this->assertSame('123456789,+657894564563', $contact->phone);
    }
}
