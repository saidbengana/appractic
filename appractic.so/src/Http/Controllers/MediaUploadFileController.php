<?php

namespace Inovector\Appractic\Http\Controllers;

use Illuminate\Routing\Controller;
use Inovector\Appractic\Http\Requests\MediaUploadFile;
use Inovector\Appractic\Http\Resources\MediaResource;

class MediaUploadFileController extends Controller
{
    public function __invoke(MediaUploadFile $upload): MediaResource
    {
        return new MediaResource($upload->handle());
    }
}
