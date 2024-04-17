<?php

namespace App\Http\Controllers\Commands\Payment;

use App\Helpers\CraydelJSONResponseHelper;
use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Models\PaymentDetail;
use App\Traits\CanLog;
use App\Traits\CanRespond;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AddPaymentCommandController extends Controller
{
    use CanLog;
    use CanRespond;

    /**
     * @param StorePaymentRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function handle(StorePaymentRequest $request, int $id): JsonResponse
    {
        try {
            $saved = false;
            $data = $this->format($request, $id);

            DB::transaction(function () use (&$saved, $data) {
                $saved = DB::table((new PaymentDetail())->getTable())
                    ->insert($data);
            });

            if (!$saved) {
                throw  new Exception('unable to add payment');
            }

            $newData = DB::table((new PaymentDetail())->getTable())
                ->where('customer_id', $data['customer_id'])
                ->first();

            return $this->respondInJSON(new CraydelJSONResponseHelper(
                true,
                'Payment details added successfully.',
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
     * @param StorePaymentRequest $request
     * @param $id
     * @return array
     */
    protected function format(StorePaymentRequest $request, $id): array
    {
        return array_merge($request->safe()->all(), [
            'customer_id' => $id,
            'created_at' => DateHelper::now()->toDateTimeString()
        ]);
    }
}
