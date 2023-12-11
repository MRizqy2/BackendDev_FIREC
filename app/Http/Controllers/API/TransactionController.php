<?php

namespace App\Http\Controllers\API;

use AgileTeknik\API\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class TransactionController extends Controller
{
    public function index(Request $req): JsonResponse
    {
        $transaction = $req->user()->transaction()->orderBy('date', 'desc')->orderBy('updated_at', 'desc')->cursorPaginate();

        return $this->response->resource($transaction);
    }

    public function total(Request $req): JsonResponse
    {
        $transactions = $req->user()->transaction()->get();
        $data['surplus'] = 0;
        $data['defisit'] = 0;

        foreach ($transactions as $transaction)
            ($transaction->transaction_type_id == 1) ? $data['surplus'] += $transaction->amount : $data['defisit'] += $transaction->amount;

        $data['total'] = $data['surplus'] - $data['defisit'];
        return $this->response->resource($data);
    }

    public function store(Request $req): JsonResponse
    {
        $validatedRequestData = $req->validate([
            'amount' => 'required|integer',
            'note' => 'required|string',
            'date' => 'required|date',
            'transaction_type_id' => 'required|integer'
        ]);

        $transaction = $req->user()->transaction()->create($validatedRequestData);

        return $this->response->resource($transaction);
    }

    public function show(Transaction $transaction): JsonResponse
    {
        Gate::authorize('view', $transaction);

        return $this->response->resource($transaction);
    }

    public function update(Request $req, Transaction $transaction)
    {
        Gate::authorize('update', $transaction);

        $validatedRequestData = $req->validate([
            'amount' => 'required|integer',
            'note' => 'required|string',
            'date' => 'required|date',
            'transaction_type_id' => 'required|integer'
        ]);

        $transaction->update($validatedRequestData);

        return $this->response->resource($transaction);
    }

    public function destroy(Transaction $transaction)
    {
        Gate::authorize('delete', $transaction);

        $transaction->delete();

        return $this->response->resource($transaction);
    }
}
