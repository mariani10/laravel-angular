<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\AclGrupo;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user, AclGrupo $acl_grupos)
    {
        $this->user = $user;
        $this->acl_grupos = $acl_grupos;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->with(['acl_grupos', 'ultimo_login'])->get();

        return view('users.index', compact('users'));
    }    

    public function create()
    {
        #$users = User::with(['acl_grupos', 'ultimo_login'])->get();
        $acl_grupos = $this->acl_grupos->all();

        return view('users.create', compact('acl_grupos'));
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->user->validar_agregar());

        $this->user->name = $request->name;
        $this->user->email = $request->email;
        $this->user->password = bcrypt($request->password);

        if ($this->user->save())
            return redirect('usuarios')->$request->session()->flash('status', 'Task was successful!');
    }
}
