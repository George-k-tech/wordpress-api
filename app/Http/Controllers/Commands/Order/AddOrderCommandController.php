<?php

namespace App\Http\Controllers\Commands\Order;

use App\Helpers\CraydelJSONResponseHelper;
use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\OrderDetail;
use App\Traits\CanLog;
use App\Traits\CanRespond;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AddOrderCommandController extends Controller
{
    use CanLog;
    use CanRespond;

    /**
     * @param StoreOrderRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function handle(StoreOrderRequest $request, $id): JsonResponse
    {
        try {
            $saved = false;
            $data = $this->format($request, $id);

            DB::transaction(function () use(&$saved, $data){
                $saved = DB::table((new OrderDetail())->getTable())
                    ->insert($data);
            });

            if (!$saved){
                throw new Exception('unable t add order');
            }

            $newData = DB::table((new OrderDetail())->getTable())
                ->where('shipping_address', $data['shipping_address'])
                ->first();

            return $this->respondInJSON(new CraydelJSONResponseHelper(
                true,
                'Order details added successfully.',
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
     * @param StoreOrderRequest $request
     * @param $id
     * @return array
     */
    protected function format(StoreOrderRequest $request, $id): array
    {
        return array_merge($request->safe()->all(), [
            'customer_id' => $id,
            'created_at' => DateHelper::now()->toDateTimeString()
        ]);
    }
}
