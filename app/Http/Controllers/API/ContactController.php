<?php
declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Helpers\ArrayHelper;
use App\Models\Contact;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Strategies\ContactStrategy;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Exception;

class ContactController extends Controller
{
    /**
     * Define your validation rules in a property in
     * the controller to reuse the rules.
     */
    protected $validationRules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'phones' => 'required',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $contacts = Contact::all();

        return ContactResource::collection($contacts);
    }

    /**
     * Creates a new Contact record
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validationRules);

        if ($validator->fails()) {
            return response()->json(
                [
                    'Error' => 'request failed: data did not pass validation'
                ],
                200
            );
        }

        $contact = new Contact();
        $contactStrategy = new ContactStrategy($contact);
        if ($contactStrategy->save($request)) {
            return response()->json(
                [
                    'message' => 'request successful, data created.',
                    'data' => $contact->attributesToArray(),
                ],
                201
            );
        }

        return response()->json(
            [
                'Error' => 'request failed: data was not saved.'
            ],
            500
        );
    }

    /**
     * Deletes a contact record
     *
     * @param Contact $contact
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Contact $contact)
    {
        if ($contact->delete()) {
            return response()->json(
                [
                    'message' => 'successfully deleted a record.'
                ],
                200
            );
        }

        return response()->json(
            [
                'Error' => 'request failed: data was not deleted.'
            ],
            500
        );

    }
}
