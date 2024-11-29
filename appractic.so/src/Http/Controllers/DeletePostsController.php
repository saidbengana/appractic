<?php

namespace Inovector\Appractic\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inovector\Appractic\Actions\RedirectAfterDeletedPost;
use Inovector\Appractic\Models\Post;

class DeletePostsController extends Controller
{
    public function __invoke(Request $request, RedirectAfterDeletedPost $redirectAfterPostDeleted): RedirectResponse
    {
        Post::whereIn('id', $request->input('posts'))->delete();

        return $redirectAfterPostDeleted($request);
    }
}
