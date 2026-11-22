<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->subscriptions()->latest()->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'in:monthly,yearly',
            'is_active' => 'boolean',
            'renewal_date' => 'nullable|date',
        ]);

        $sub = $request->user()->subscriptions()->create($data);

        return response()->json($sub, 201);
    }

    public function update(Request $request, Subscription $subscription)
    {
        abort_if($subscription->user_id !== $request->user()->id, 403);

        $data = $request->validate([
            'name' => 'string|max:255',
            'category' => 'string|max:100',
            'price' => 'numeric|min:0',
            'billing_cycle' => 'in:monthly,yearly',
            'is_active' => 'boolean',
            'renewal_date' => 'nullable|date',
        ]);

        $subscription->update($data);

        return $subscription;
    }

    public function destroy(Request $request, Subscription $subscription)
    {
        abort_if($subscription->user_id !== $request->user()->id, 403);

        $subscription->delete();

        return response()->noContent();
    }
}