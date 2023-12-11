<?php

namespace App\Http\Controllers\API;

use App\Models\ForecastTransaction;
use App\Models\ForecastTransactionInterval;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use AgileTeknik\API\Controller;

class ForecastTransactionIntervalController extends Controller
{
    public function index(): JsonResponse
    {

        try {
            $interval = ForecastTransactionInterval::get();


            return response()->json([
                'message' => 'Data Interval has been Updated!',
                'data' => $interval
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store (Request $req) {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string',
        ]);
        if ($validator->fails()) return response()->json([
            'message' => $validator->errors()
        ], 422);
        DB::beginTransaction();
        try {
            $interval = ForecastTransactionInterval::create([
                'name' => $req->name,
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Data Interval has been Created!',
                'data' => $interval
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy ($id) {
        DB::beginTransaction();
        try {
            ForecastTransactionInterval::where('id', $id)->delete();
            DB::commit();
            return response()->json(['message' => 'Data Interval has been Deleted!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
