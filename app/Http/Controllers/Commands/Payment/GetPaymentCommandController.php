<?php

namespace App\Http\Controllers\Commands\Payment;

use App\Helpers\CraydelJSONResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\PaymentDetail;
use App\Traits\CanLog;
use App\Traits\CanRespond;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetPaymentCommandController extends Controller
{
    use CanLog;
    use CanRespond;

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function handle(Request $request, $id): JsonResponse
    {
        try {

            $newData = DB::table((new PaymentDetail())->getTable())
                ->where('id', $id)
                ->first();

            return $this->respondInJSON(new CraydelJSONResponseHelper(
                true,
                'Payment details.',
                $newData
            ));
        }catch (Exception $exception){
            $this->logException($exception);

            return $this->respondInJSON(new CraydelJSONResponseHelper(
                false,
                $this->makeExceptionMessage($exception)
            ));
        }
    }
}
