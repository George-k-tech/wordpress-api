<?php

namespace App\Http\Controllers\Commands\Payment;

use App\Helpers\CraydelJSONResponseHelper;
use App\Http\Controllers\Controller;
use App\Traits\CanLog;
use App\Traits\CanRespond;
use Exception;
use Illuminate\Http\Request;

class AddPaymentCommandController extends Controller
{
    use CanLog;
    use CanRespond;

    public function handle(Request $request)
    {
        try {

            $this->respondInJSON(new CraydelJSONResponseHelper(
                true,
                'Payment details added successfully.',
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
