<?php

namespace App\Features\PaymentOptions\Controllers;

use App\Features\PaymentOptions\Interfaces\PaymentOptionServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\PaymentOptions\Resources\PaymentOptionCollection;

class PaymentOptionToggleStatusController extends Controller
{
    public function __construct(private PaymentOptionServiceInterface $optionService) {}

    /**
     * Toggle the active status of an option.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * This method retrieves the option by the given ID, starts a database transaction,
     * and toggles the 'is_active' status of the option. It returns a JSON response
     * indicating whether the option was active or unactive successfully. In case
     * of an error, it returns a 400 status JSON response with an error message.
     */

    public function index($id)
    {
        $option = $this->optionService->getById($id);
        try {
            //code...
            $updated_option = $this->optionService->toggleActive($option);
            if ($updated_option->is_active) {
                return response()->json(["message" => "Payment option is now active.", "data" => PaymentOptionCollection::make($updated_option)], 200);
            }
            return response()->json(["message" => "Payment option is now inactive.", "data" => PaymentOptionCollection::make($updated_option)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
