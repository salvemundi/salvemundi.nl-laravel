<?php
// Copyright (c) Microsoft Corporation.
// Licensed under the MIT License.

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\News;
use App\Models\Product;
use Illuminate\Http\Request;


class HomeController extends Controller
{
  public function welcome()
  {
    $viewData = $this->loadViewData();
    $sponsorsData = Sponsor::all();
    $newsData = News::latest()->take(3)->get();
    $activitiesData = Product::latest()->where('index', null)->take(3)->get();
    return view('index', ['viewData' => $viewData,'sponsorsData' => $sponsorsData, 'newsData' => $newsData, 'activitiesData' => $activitiesData]);
  }
}
