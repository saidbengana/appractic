<?php

namespace Inovector\Appractic\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Inovector\Appractic\Http\Requests\CreateMastodonApp;

class CreateMastodonAppController extends Controller
{
    public function __invoke(CreateMastodonApp $createMastodonApp): Response
    {
        $createMastodonApp->handle();

        return response()->noContent();
    }
}
