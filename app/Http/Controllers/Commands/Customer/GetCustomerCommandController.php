<?php

namespace App\Http\Controllers\Commands\Customer;

use App\Helpers\CraydelJSONResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\CustomerDetail;
use App\Traits\CanLog;
use App\Traits\CanRespond;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetCustomerCommandController extends Controller
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
            $newData = DB::table((new CustomerDetail())->getTable())
                ->where('id', $id)
                ->first();

            return $this->respondInJSON(new CraydelJSONResponseHelper(
                true,
                'Customer details',
                $newData
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
