<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ocorrencia;
use Illuminate\Http\Request;

class OcorrenciaController extends Controller
{
    public function index()
    {
        $data['ocorrencias'] = Ocorrencia::with('user')->get();
        return view('admin.ocorrencia.index', $data);
    }
}