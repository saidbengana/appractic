<?php

namespace Inovector\Appractic\Http\Controllers;

use Illuminate\Routing\Controller;
use Inovector\Appractic\Http\Requests\MediaDownloadExternal;
use Inovector\Appractic\Http\Resources\MediaResource;

class MediaDownloadExternalController extends Controller
{
    public function __invoke(MediaDownloadExternal $downloadMedia): array
    {
        $media = $downloadMedia->handle();

        return MediaResource::collection($media)->resolve();
    }
}
