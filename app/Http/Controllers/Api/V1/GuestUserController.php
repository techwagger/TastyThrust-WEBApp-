<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\GuestUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GuestUserController extends Controller
{
    public function __construct(
        private GuestUser $guest_user,
    ){}

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function guest_store(Request $request): JsonResponse
    {
        $guest = $this->guest_user;
        $guest->ip_address = $request->ip();
        $guest->fcm_token = $request->fcm_token;
        $guest->save();

        return response()->json(['guest' => $guest], 200);
    }
}
