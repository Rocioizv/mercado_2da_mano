<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use \Illuminate\Support\Facades\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
         // Obtener los últimos productos publicados
         $sales = Sale::latest()->take(9)->get();

         // Verificar si la consulta devuelve datos
         if ($sales->isEmpty()) {
             \Log::info('No se encontraron productos en venta.');
         }
 
         return view('home', compact('sales'));
    }
}
