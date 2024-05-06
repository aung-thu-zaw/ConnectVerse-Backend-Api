<?php

namespace App\Http\Controllers\Api\V1\Chat;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChatListResource;
use App\Models\ChatList;
use App\Models\Conversation;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class GetUserChatListController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [new Middleware('auth:api')];
    }

    public function __invoke(): JsonResponse
    {
        try {
            $chatLists = ChatList::with('chat')->where("user_id", auth()->id())->get();

            $result = ChatListResource::collection($chatLists);

            return $this->responseWithResult('success', 'User-associated chat lists retrieved successfully.', 200, $result);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
