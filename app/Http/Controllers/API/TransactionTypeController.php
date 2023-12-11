<?php

namespace App\Http\Controllers\API;

use AgileTeknik\API\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\TransactionType;
use Illuminate\Support\Facades\Gate;

class TransactionTypeController extends Controller
{
    public function index(): JsonResponse
    {
        $typeTransaction = TransactionType::cursorPaginate();

        return $this->response->resource($typeTransaction);
    }

    public function store(Request $req): JsonResponse
    {
        $validatedRequestData = $req->validate([
            'name' => 'required|string'
        ]);

        $typeTransaction = TransactionType::create($validatedRequestData);

        return $this->response->resource($typeTransaction);
    }

    public function show($id): JsonResponse
    {
        $type = TransactionType::find($id);

        return $this->response->resource($type);
    }

    public function update(Request $req, $id): JsonResponse
    {
        $validatedRequestData = $req->validate([
            'name' => 'required|string'
        ]);

        $type = TransactionType::where('id', $id)->update($validatedRequestData);

        $type = TransactionType::find($id);

        return $this->response->resource($type);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $type = TransactionType::find($id);
        $type->delete();

        return $this->response->resource($type);
    }
}
