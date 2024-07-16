<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Plan;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        //
        $plan = Plan::all();
        return view('superadmin.plans.index')->with('plan',$plan);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        //
        return view('superadmin.plans.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // $value  = $request->authenticate();
        $validatedData = $request->validate([
            'sp_name' => 'required|string|max:255',
            'sp_amount' => 'required|numeric',
            'sp_month' => 'required|integer',
            'sp_desc' => 'nullable|string',
            'sp_user' => 'nullable|integer',
        ], [
            'sp_name.required' => 'The name field is required.',
            'sp_amount.required' => 'The amount field is required.',
            'sp_month.required' => 'The validity field is required.',
            'sp_desc.string' => 'The description must be a string.',
            'sp_user.integer' => 'The user field must be an integer.',
        ]);

        // Assuming you have a Plan model to handle database interactions
        Plan::create($validatedData);

        return redirect()->route('plans.index')->with(['plan-add' =>__('messages.admin.plan.add_plan_success')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
