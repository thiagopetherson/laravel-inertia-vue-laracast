<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::query()->select(['name', 'id'])->when($request->input('search'), function ($query, $search) {
            $query->where('name','like','%' . $search . '%');
        })
        ->paginate(10)
        ->withQueryString()
        ->through(fn($user) => [ // through é quase igual ao map
            'id' => $user->id,
            'name' => $user->name,
            'can' => [  // Permissão em cada item
                'edit' => Auth::user()->can('edit', $user),
                'delete' => Auth::user()->can('delete', $user)
            ],
        ]);

        $filters = $request->only(['search']);
        $can = ['createUser' => Auth::user()->can('create', User::class)];

        return Inertia::render('Users/Index', ['users' => $users, 'filters' => $filters, 'can' => $can]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Users/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => 'required|min:8',
        ]);

        User::create($data);

        return redirect('/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return Inertia::render('Users/Edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => ['']
        ]);

        $user = User::find($id);


        $dataForm = [];

        if ($request->input('name'))
            $dataForm['name'] = $data['name'];

        if ($request->input('email'))
            $dataForm['email'] = $data['email'];

        if ($request->input('password'))
            $dataForm['password'] = $data['password'];

        $user->update($dataForm);

        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/users');
    }
}
