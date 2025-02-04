<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grupo;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    //
    public function index()
    {

        // $response['grupos'] = Grupo::join('users', 'users.id', 'grupos.aprovador_id')
        //     ->select('grupos.*', 'users.name as aprovador')
        //     ->get();
        return view('admin.grupo.index');
    }
}
