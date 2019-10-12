<?php

namespace App\Http\Controllers\API;

use App\Models\Contact;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    /**
     * Define your validation rules in a property in
     * the controller to reuse the rules.
     */
    protected $validationRules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'phone' => 'required',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $customerScores = Contact::all();
        return ContactResource::collection($customerScores);
    }

    /**
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
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $strippedCommaPhone = str_replace(',', '', $request->phone);
        $contact->phone = implode(',', $strippedCommaPhone);

        if ($contact->save()) {
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
     * Display the specified resource.
     *
     * @param \App\Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
