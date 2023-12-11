<?php

namespace App\Http\Controllers\API;

use App\Models\ForecastSimulation;
use AgileTeknik\API\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use App\Exceptions\ValidationRules;

class ForecastSimulationController extends Controller
{
    public function handleBackendRequest(Request $request)
    {
        $totalAcumulation = $request->input('totalAcumulation');
        $forecastSimulationId = $request->input('forecastSimulationId');

        $forecastSimulation = ForecastSimulation::find($forecastSimulationId);
        if ($forecastSimulation) {
            $forecastSimulation->updateTotalTransaksi($totalAcumulation);
        } else {
            return response()->json(['message' => 'Simulasi tidak ditemukan.'], 404);
        }

        return response()->json(['message' => 'Data berhasil diterima di backend.']);
    }

    public function index(Request $request): JsonResponse
    {
        $simulation = ForecastSimulation::where('user_id', $request->user_id)->get();

        return $this->response->resource($simulation);
    }

    public function show(ForecastSimulation $simulation): JsonResponse
    {
        Gate::authorize('view', $simulation);

        return $this->response->resource($simulation);
    }

    public function detail ($id) {
        try {
            $simulation = ForecastSimulation::where('id', $id)->first();

            if (!$simulation) {
                return response()->json([
                    'message' => 'Data Simulation Not Found!'
                ], 404);
            }

            return response()->json([
                'message' => 'Success Gets Simulation',
                'simulation' => $simulation
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $req): JsonResponse
    {
        $validatedRequestData = $req->validate([
            'user_id' => ValidationRules\requiredInteger(),
            'name' => ValidationRules\requiredString()
        ]);

        $initialData = [
            'user_id' => $validatedRequestData['user_id'],
            'name' => $validatedRequestData['name'],
            'total_transaction' => 0
        ];

        $forecastSimulation = ForecastSimulation::create($initialData);

        return $this->response->resource($forecastSimulation);
    }

    public function update (Request $req, $user_id) {
        $validator = Validator::make($req->all(), [
            'name' => ValidationRules\requiredString()
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }
        DB::beginTransaction();
        try {
            $simulation = ForecastSimulation::where('id', $user_id)->first();
            if (!$simulation) {
                return response()->json([
                    'message' => 'Data Simulation Not Found!'
                ], 404);
            }
            $simulation->update([
                'name' => $req->name
            ]);
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

    public function destroy($id)
    {
        $forecastSimulation = ForecastSimulation::findOrFail($id);
        $forecastSimulation->delete();

        return $this->response->resource($forecastSimulation);
    }
}
