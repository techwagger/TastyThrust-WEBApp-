<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Model\BusinessSetting; // Corrected namespace for the model
use Illuminate\Http\JsonResponse;

class BusinessSettingsController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function get_business_settings(): JsonResponse
    {
      
        try {
            // Fetch business settings where key is 'restaurant_name'
            $businessSettings = BusinessSetting::whereIn('key', ['restaurant_name', 'logo'])->get();

            
            return response()->json($businessSettings, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database query exception
            return response()->json(['error' => 'Database error'], 500);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
}
