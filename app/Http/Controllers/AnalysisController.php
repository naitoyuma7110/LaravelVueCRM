<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Order;
use Symfony\Component\HttpFoundation\Response;

class AnalysisController extends Controller
{
  public function index()
  {
    return Inertia::render('Analysis');
  }
}
