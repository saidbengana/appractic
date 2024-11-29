<?php

namespace Inovector\Appractic\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Inovector\Appractic\Http\Resources\AccountResource;
use Inovector\Appractic\Models\Account;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Dashboard', [
            'accounts' => fn() => AccountResource::collection(Account::oldest()->get())->resolve()
        ]);
    }
}
