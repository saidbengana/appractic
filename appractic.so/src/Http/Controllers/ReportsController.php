<?php

namespace Inovector\Appractic\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Inovector\Appractic\Http\Requests\Reports;

class ReportsController extends Controller
{
    public function __invoke(Reports $reports): JsonResponse
    {
        return response()->json($reports->handle());
    }
}
