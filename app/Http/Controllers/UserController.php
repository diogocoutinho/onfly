<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserFormRequest;
use App\Http\Requests\UserFormRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @author Diogo C. Coutinho
     * @return Object $data
     */
    public function index()
    {
        return Inertia::render('Users/Users', [
            'users' => User::mappingUsers(),
            'create_url' => URL::route('users.create'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @author Diogo C. Coutinho
     * @return \Inertia\View
     */
    public function create()
    {
        return Inertia::render('Users/Create');
    }

    /**
     * Store a new user
     * @author Diogo C. Coutinho
     * @param CreateUserFormRequest $request
     * @return void
     */
    public function store(CreateUserFormRequest $request)
    {
        $vars = $request->all();

        $user = User::newUser($vars);

        $user->createToken('api_token');

        event(new Registered($user));

        return redirect(RouteServiceProvider::USERS);
    }

    /**
     * Show the form for editing the specified resource.
     * @author Diogo C. Coutinho
     * @param  int  $id
     * @return User $data
     */
    public function edit($id = null)
    {
        return Inertia::render('Users/Edit', [
            'user'  => User::find($id)
        ]);
    }
    
    /**
     * Show the profile for a given user.
     * @author Diogo C. Coutinho
     * @param  User  $user
     * @return Inertia\View
     */
    public function show(User $user)
    {
        return Inertia::render('Users/Show', [
            'user' => $user->only('id', 'name', 'email'),
        ]);
    }

    /**
     * Update the given user
     * @author Diogo C. Coutinho
     * @param UserFormRequest $user
     * @return void
     */
    public function update(UserFormRequest $user, $id = null)
    {
        $vars = $user->all();

        $user = User::updateUser($vars);
        
        return Redirect::route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     * @author Diogo C. Coutinho
     * @param  int  $id
     * @return Redirect 'users.index'
     */
    public function destroy($id = null)
    {
        User::destroy($id);

        return Redirect::route('users.index');
    }
}
