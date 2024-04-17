<?php

namespace App\Http\Controllers\Commands\Customer;

use App\Helpers\CraydelJSONResponseHelper;
use App\Http\Controllers\Controller;
use App\Traits\CanLog;
use App\Traits\CanRespond;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddCustomerCommandController extends Controller
{
    use CanLog;
    use CanRespond;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function handle(Request $request): JsonResponse
    {
        try {
            return $this->respondInJSON(new CraydelJSONResponseHelper(
                true,
                'Customer added successfully',
            ));
        } catch (Exception $exception) {
            $this->logException($exception);

            return $this->respondInJSON(new CraydelJSONResponseHelper(
                false,
                $this->makeExceptionMessage($exception)
            ));
        }
    }
}
