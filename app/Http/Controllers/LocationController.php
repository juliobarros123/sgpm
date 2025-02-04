<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Municipio;

class LocationController extends Controller
{
    //
    public function getMunicipios($provincia_id)
    {
        $municipios = Municipio::where('it_id_provincia', $provincia_id)->get();
        return response()->json($municipios);
    }
}
