<?php

namespace App\Http\Controllers\Quiz;

use App\Models\Information;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\InformationResource;

class InformationController extends Controller
{
    public function index()
    {
        $informations = Information::orderBy('id', 'desc')->get();
        return InformationResource::collection($informations);
    }
}
