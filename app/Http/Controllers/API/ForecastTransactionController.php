<?php

namespace App\Http\Controllers\API;

use App\Models\ForecastSimulation;
use App\Models\ForecastTransaction;
use AgileTeknik\API\Controller;
use App\Models\ForecastTransactionType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Exceptions\ValidationRules;

class ForecastTransactionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $forecastTransactions = ForecastTransaction::where('forecast_simulation_id', $request->id)->get();

        return $this->response->resource($forecastTransactions);
    }

    public function show(ForecastTransaction $transaction): JsonResponse
    {
        Gate::authorize('view', $transaction);

        return $this->response->resource($transaction);
    }

    public function detail ($id) {
        try {
            $forecastTransaction = ForecastTransaction::where('id', $id)->first();

            if (!$forecastTransaction) {
                return response()->json([
                    'message' => 'Data Simulation Not Found!'
                ], 404);
            }

            return response()->json([
                'message' => 'Success Gets Simulation',
                'simulation' => $forecastTransaction
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store (Request $req) {
        $validator = Validator::make($req->all(), [
            'simulation_id' => ValidationRules\requiredInteger(),
            'amount' => ValidationRules\requiredInteger(),
            'name' => ValidationRules\requiredString(),
            'type_id' => ValidationRules\requiredInteger(),
            'interval_id' => ValidationRules\requiredString(),
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }
        if($req->amount > 999999999999999){
            return response()->json([
                'message' => 'Data Transaction Amount Too Many',
            ]);
        }else{
            DB::beginTransaction();
            try {
                $transactionType = ForecastTransactionType::find($req->type_id);

                if (!$transactionType) {
                    return response()->json([
                        'message' => 'Transaction Type Not Found!'
                    ], 404);
                }
                $forecastTransaction = ForecastTransaction::create([
                    'forecast_simulation_id' => $req->simulation_id,
                    'amount' => $req->amount,
                    'name' => $req->name,
                    'forecast_transaction_type_id' => $transactionType->id,
                    'forecast_transaction_interval_id' => $req->interval_id,
                ]);

                $forecastSimulation = ForecastSimulation::find($req->simulation_id);
                $forecastSimulation->updateTotalTransaksi();
                $totalTransaction = $forecastSimulation->total_transaction;

                DB::commit();
                return response()->json([
                    'message' => 'Data Transaction has been Created!',
                    'data' => $forecastTransaction,
                    'total_transaction' => $totalTransaction,
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'error' => $e->getMessage()
                ], 500);
            }
        }
    }

    public function update (Request $req, $user_id) {
        $validator = Validator::make($req->all(), [
            'amount' => ValidationRules\requiredInteger(),
            'name' => ValidationRules\requiredString(),
            'type_id' => ValidationRules\requiredInteger(),
            'interval_id' => ValidationRules\requiredString()
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }
        if($req->amount > 1000000000000000){
            return response()->json([
                'message' => 'Data Transaction Amount Too Many',
            ]);
        }else{
            DB::beginTransaction();
            try {
                $transactionType = ForecastTransactionType::find($req->type_id);
                $forecastTransaction = ForecastTransaction::where('id', $user_id)->first();
                if (!$forecastTransaction) {
                    return response()->json([
                    'message' => 'Data Simulation Not Found!'
                ], 404);
                }

                $oldAmount = $forecastTransaction->amount;

                $forecastTransaction->update([
                    'name' => $req->name,
                    'amount' => $req->amount,
                    'forecast_transaction_type_id' => $transactionType->id,
                    'forecast_transaction_interval_id' => $req->interval_id
                ]);

                $forecastSimulation = ForecastSimulation::find($forecastTransaction->forecast_simulation_id);
                $totalTransaksi = $forecastSimulation->forecastTransactions->sum('amount') - $oldAmount + $req->amount;
                $forecastSimulation->updateTotalTransaksi($totalTransaksi);

                DB::commit();
                return response()->json([
                    'message' => 'Data Simulation has been Updated!'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'error' => $e->getMessage()
                ], 500);
            }
        }
    }

    public function destroy ($id) {
        DB::beginTransaction();

        try {
            $forecastTransaction = ForecastTransaction::where('id', $id)->first();
            if (!$forecastTransaction) {
                return response()->json([
                    'message' => 'Data Transaction Not Found!'
                ], 404);
            }

            $amountToDelete = $forecastTransaction->amount;

            $forecastTransaction->delete();

            $forecastSimulation = ForecastSimulation::find($forecastTransaction->forecast_simulation_id);
            $totalTransaksi = $forecastSimulation->forecastTransactions->sum('amount') - $amountToDelete;
            $forecastSimulation->updateTotalTransaksi($totalTransaksi);

            DB::commit();

            return response()->json(['message' => 'Data Transaction has been Deleted!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
