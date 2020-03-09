<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SerieColor;

class serieColorController extends Controller
{
    public function index($codigo){
    	$color = SerieColor::where('codigo',$codigo)->first();
    	return $color->color;
    }
    public function save(Request $request){
    	$serieColor = new SerieColor;

    	$serieColor->codigo = $request->input('codigo');
    	$serieColor->color = $request->input('color');

    	$serieColor->save();
    	return $serieColor;
    }
}
