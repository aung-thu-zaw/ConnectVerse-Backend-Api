<?php

namespace App\Http\Controllers\Api\V1\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ContactController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [new Middleware('auth:api')];
    }

    public function index(): JsonResponse
    {
        try {
            $contacts = Contact::with('phoneOwner')->where("user_id", auth()->id())->get();

            $result = ContactResource::collection($contacts);

            return $this->responseWithResult('success', 'All contacts retrieved successfully.', 200, $result);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function show(Contact $contact): JsonResponse
    {
        try {
            $contact->load('phoneOwner');

            $result = new ContactResource($contact);

            return $this->responseWithResult('success', 'Specific contact retrieved successfully.', 200, $result);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function store(ContactRequest $request): JsonResponse
    {
        try {
            $user = User::findOrFail(auth()->id());

            if($user->phone_number === $request->phone_number) {
                return $this->responseWithResult('error', 'You cannot add your own phone number as a contact!', 400);
            }

            $existingContact = Contact::where('phone_number', $request->phone_number)->first();

            if ($existingContact) {
                return $this->responseWithResult('error', 'This phone number is already associated with another contact!', 400);
            }

            $contact = Contact::create($request->validated() + ["user_id" => auth()->id()]);

            $contact->load('phoneOwner');

            $result = new ContactResource($contact);

            return $this->responseWithResult('success', 'Contact created successfully.', 200, $result);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function update(ContactRequest $request, Contact $contact): JsonResponse
    {
        try {
            $contact->update($request->validated());

            $contact->load('phoneOwner');

            $result = new ContactResource($contact);

            return $this->responseWithResult('success', 'Contact updated successfully.', 200, $result);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function destroy(Contact $contact): JsonResponse
    {
        try {
            $contact->delete();

            return $this->responseWithResult('success', 'Contact deleted successfully.', 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
