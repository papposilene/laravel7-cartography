<?php

namespace App\Http\Controllers\Admin;

use App\Activity;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteUser;
use App\Http\Requests\UpdateRole;
use App\Http\Requests\UpdateUser;
use App\Http\Requests\RestoreUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('accept');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->filled('deleted'))
        {
            $users = User::withTrashed()->paginate(25);
        }
        elseif($request->filled('q'))
        {
            $request->flash();
            $query = $request->get('q');
            $users = User::search($query)
                ->orderBy('uname', 'asc')
                ->paginate(25);
        }
        else
        {
            $users = User::orderBy('uname', 'asc')
                ->paginate(25);
        }
        
        return view('admin.users.index',
            compact(
                'users'
            )
        );
    }

    /**
     * Display the waiting-for-approval page.
     *
     * @return \Illuminate\Http\Response
     */
    public function approval()
    {
        return view('auth.approval');
    }
    
    /**
     * Approve the user's registration
     *
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function approve($uuid)
    {
        $admin = Auth::user();
        if ($admin->hasRole('superAdmin')) {
            $user = User::findOrFail($uuid);
            $user->update([
                'approved_at' => date("Y-m-d H:i:s"),
                'approved_by' => Auth::id(),
            ]);
            $user->save();
            
            return redirect()->route('admin.user.index')->withMessage('User approved successfully.');
        }
		
		abort(403, 'Unauthorized action.');
    }

    /**
     * Dispprove the user's registration
     *
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function disapprove($uuid)
    {
        $admin = Auth::user();
        if ($admin->hasRole('superAdmin')) {
            User::where('uuid', $uuid)->delete();
            
            return redirect()->route('admin.user.index')->withMessage('User disapproved successfully.');
        }
		
		abort(403, 'Unauthorized action.');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function activity()
    {
        $activities = Activity::orderByDesc('id')->paginate(25);
        
        return view('admin.activity', compact('activities'));
    }

    /**
     * Display the specified resource.
     *
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $user = User::findOrFail($uuid);
        $roles = Role::all();
        
        return view('admin.users.show',
            compact(
                'roles',
                'user'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $user = User::findOrFail($uuid);
        
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request)
    {
        $validated = $request->validated();
        
        $user = User::findOrFail($request->input('user_uuid'));
        $user->fname = $request->input('user_fname');
        $user->lname = $request->input('user_lname');
        $user->uname = $request->input('user_uname');
        $user->email = $request->input('user_email');
        $user->password = Hash::make($request->input('user_password'));
        $user->save();
        
        return redirect()->route('admin.user.show', ['uuid' => $user->uuid]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function role(UpdateRole $request)
    {
        $validated = $request->validated();
        
        $user = User::findOrFail($request->input('user_uuid'));
        $user->syncRoles($request->input('user_role'));
        $user->save();
        
        return redirect()->route('admin.user.show', ['uuid' => $user->uuid]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function permission(Request $request)
    {
        $user = User::findOrFail($uuid);
        $role = $request->input('role');
        $user->assignRole($role);
        
        return redirect()->route('admin.user.show', ['uuid' => $user->uuid]);
    }
	
    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(DeleteUser $request)
    {
        $uuid = $request->input('user_uuid');
        User::where('uuid', $uuid)->delete();
        
        return redirect()->back();
    }
    
    /**
     * Restore the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function restore(RestoreUser $request)
    {
        $uuid = $request->input('user_uuid');
        User::withTrashed()->where('uuid', $uuid)->restore();
        
        return redirect()->back();
    }
}
