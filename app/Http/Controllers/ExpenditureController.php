<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateExpenditureRequest;
use App\Http\Requests\EditExpenditureRequest;
use App\Mail\NewExpenditure;
use App\Models\Expenditure;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

class ExpenditureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Expenditures/Expenditures', [
            'expenditures' => Expenditure::mappingExpenditures() ?? '',
            'create_url' => URL::route('expenditures.create'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Expenditures/Create', [
            'users' => User::mappingUsers()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateExpenditureRequest $request)
    {
        $vars = $request->all();

        $expenditure = Expenditure::newExpenditure($vars);

        Mail::to(User::find($expenditure->user_id))->queue(new NewExpenditure($expenditure));

        return redirect(RouteServiceProvider::EXPENDITURE);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function show(Expenditure $expenditure)
    {
        return Inertia::render('Expenditures/Show', [
            'expenditure' => $expenditure,
            'users' => User::mappingUsers()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function edit($id = null)
    {
        return Inertia::render('Expenditures/Edit', [
            'expenditure' => Expenditure::find($id),
            'users' => User::mappingUsers()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function update(EditExpenditureRequest $expenditure, $id = null)
    {
        $vars = $expenditure->all();

        $expenditure = Expenditure::updateExpenditure($vars);
        
        return Redirect::route('expenditures.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function destroy($id = null)
    {
        Expenditure::destroy($id);

        return Redirect::route('expenditures.index');
    }
}
