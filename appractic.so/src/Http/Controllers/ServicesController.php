<?php

namespace Inovector\Appractic\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Inovector\Appractic\Facades\Services;
use Inovector\Appractic\Http\Requests\SaveService;

class ServicesController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Services', [
            'services' => Services::all()
        ]);
    }

    public function update(SaveService $saveService): RedirectResponse
    {
        $saveService->handle();

        return back();
    }
}
