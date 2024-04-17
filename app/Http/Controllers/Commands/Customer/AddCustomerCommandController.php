<?php

namespace App\Http\Controllers\Commands\Customer;

use App\Helpers\CraydelJSONResponseHelper;
use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Models\CustomerDetail;
use App\Traits\CanLog;
use App\Traits\CanRespond;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AddCustomerCommandController extends Controller
{
    use CanLog;
    use CanRespond;

    /**
     * @param StoreCustomerRequest $request
     * @return JsonResponse
     */
    public function handle(StoreCustomerRequest $request): JsonResponse
    {
        try {
            $saved = false;
            $data = $this->format($request);

            DB::transaction(function () use (&$saved, $data){
                $saved = DB::table((new CustomerDetail())->getTable())
                    ->insert($data);
            });

            $newData = DB::table((new CustomerDetail())->getTable())
                ->where('email', $data['email'])
                ->first();

            if (!$saved){
                throw new Exception('Customer not created');
            }

            return $this->respondInJSON(new CraydelJSONResponseHelper(
                true,
                'Customer added successfully',
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

    /**
     * @param StoreCustomerRequest $request
     * @return array|string[]
     */
    protected function format(StoreCustomerRequest $request): array
    {
        return array_merge($request->safe()->all(), [
           'created_at'=>DateHelper::now()->toDateTimeString(),
        ]);
    }
}
