<?php
declare(strict_types=1);


namespace App\Strategies;


use App\Helpers\ArrayHelper;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactStrategy
{
    public $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Prepares and saves contact resource to database
     *
     * @param Request $request
     * @return Contact
     */
    public function process(Request $request)
    {
        $this->contact->first_name = $request->first_name;
        $this->contact->last_name = $request->last_name;
        $phones = $request->phones;

        // remove commas from data
        $cleanPhones = ArrayHelper::removeCommas($phones);

        // concatenate phone numbers into one string
        $this->contact->phone = implode(',', $cleanPhones);

        return $this->contact;
    }
}
