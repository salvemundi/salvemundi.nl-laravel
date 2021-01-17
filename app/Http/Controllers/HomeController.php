<?php
// Copyright (c) Microsoft Corporation.
// Licensed under the MIT License.

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;


class HomeController extends Controller
{
  public function welcome()
  {
    $viewData = $this->loadViewData();
    $sponsorsData = Sponsor::all();
    //dd($sponsorsData);
    return view('index', ['viewData' => $viewData,'sponsorsData' => $sponsorsData]);
  }
}