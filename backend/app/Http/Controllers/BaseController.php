<?php

namespace App\Http\Controllers;

use App\Traits\FilterTrait;
use App\Helpers\Utilidade;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, FilterTrait;

    public function setResponse($content, $status = 200)
    {
        return Utilidade::toJson($content, $status);
    }
}
