<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Plan;
use App\Models\AdminMenu;
use App\Models\UserAccess;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        //
        // dd('hii');
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
    public function edit($sp_id, Request $request): View
    {
        $plan = Plan::where('sp_id', $sp_id)->firstOrFail();

        return view('superadmin.plans.edit', compact('plan'));
    }  

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $sp_id): RedirectResponse
    {
        // Find the plan by sp_id
        $plan = Plan::where('sp_id', $sp_id)->firstOrFail();

        // Validate incoming request data
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

        // Update the plan attributes based on validated data
        $plan->where('sp_id', $sp_id)->update($validatedData);

        // Redirect back to the edit form with a success message
        return redirect()->route('plans.edit', ['plan' => $plan->sp_id])
                        ->with('plan-edit', __('messages.admin.plan.edit_plan_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($sp_id): RedirectResponse
    {
        //
        $plan = Plan::where('sp_id', $sp_id)->firstOrFail();

        // Delete the plan
        $plan->where('sp_id', $sp_id)->delete();
         
        return redirect()->route('plans.index')
                        ->with('plan-delete', __('messages.admin.plan.delete_plan_success'));

    }

    public function planrole(): View
    {
        $permissions = AdminMenu::where('pmenu', 0)->where('is_deleted', 0)->get();

        foreach ($permissions as $permission) {
            $permission->is_access = $this->checkIsAccess($permission->mname, request()->id);
            $permission->is_access_add = $this->checkIsAccess('add_' . $permission->mname, request()->id);
            $permission->is_access_view = $this->checkIsAccess('view_' . $permission->mname, request()->id);
            $permission->is_access_update = $this->checkIsAccess('update_' . $permission->mname, request()->id);
            $permission->is_access_delete = $this->checkIsAccess('delete_' . $permission->mname, request()->id);
        }

        return view('superadmin.plans.plan_role_access', compact('permissions'));
    }
    private function checkIsAccess($permissionName, $roleId)
    {
        return UserAccess::where('sp_id', $roleId)
            ->where('mname', $permissionName)
            ->where('is_access', 1)
            ->exists();
    }

}
