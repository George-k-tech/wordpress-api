<?php

namespace App\Http\Controllers\Commands\Order;

use App\Helpers\CraydelJSONResponseHelper;
use App\Http\Controllers\Controller;
use App\Traits\CanLog;
use App\Traits\CanRespond;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddOrderCommandController extends Controller
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

            return  $this->respondInJSON(new CraydelJSONResponseHelper(
                true,
                'Order details added successfully.'
            ));
        } catch (\Exception $exception) {
            $this->logException($exception);

            return $this->respondInJSON(new CraydelJSONResponseHelper(
                false,
                $this->makeExceptionMessage($exception)
            ));
        }
    }
}
