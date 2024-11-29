<?php

namespace Inovector\Appractic\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Inovector\Appractic\Actions\RedirectAfterDeletedPost;
use Inovector\Appractic\Builders\PostQuery;
use Inovector\Appractic\Facades\Services;
use Inovector\Appractic\Facades\Settings;
use Inovector\Appractic\Http\Requests\StorePost;
use Inovector\Appractic\Http\Requests\UpdatePost;
use Inovector\Appractic\Http\Resources\AccountResource;
use Inovector\Appractic\Http\Resources\PostResource;
use Inovector\Appractic\Http\Resources\TagResource;
use Inovector\Appractic\Models\Account;
use Inovector\Appractic\Models\Post;
use Inovector\Appractic\Models\Tag;
use Inovector\Appractic\Support\EagerLoadPostVersionsMedia;

class PostsController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection|Response
    {
        $posts = PostQuery::apply($request)
            ->latest()
            ->latest('id')
            ->paginate(20)
            ->onEachSide(1)
            ->withQueryString();

        EagerLoadPostVersionsMedia::apply($posts);

        return Inertia::render('Posts/Index', [
            'accounts' => fn() => AccountResource::collection(Account::oldest()->get())->resolve(),
            'tags' => fn() => TagResource::collection(Tag::latest()->get())->resolve(),
            'filter' => [
                'keyword' => $request->query('keyword', ''),
                'status' => $request->query('status'),
                'tags' => $request->query('tags', []),
                'accounts' => $request->query('accounts', [])
            ],
            'posts' => fn() => PostResource::collection($posts)->additional([
                'filter' => [
                    'accounts' => Arr::map($request->query('accounts', []), 'intval')
                ]
            ]),
            'has_failed_posts' => Post::failed()->exists()
        ]);
    }

    public function create(Request $request): Response
    {
        return Inertia::render('Posts/CreateEdit', [
            'default_accounts' => Settings::get('default_accounts'),
            'accounts' => AccountResource::collection(Account::oldest()->get())->resolve(),
            'tags' => TagResource::collection(Tag::latest()->get())->resolve(),
            'post' => null,
            'schedule_at' => [
                'date' => Str::before($request->route('schedule_at'), ' '),
                'time' => Str::after($request->route('schedule_at'), ' '),
            ],
            'prefill' => [
                'body' => $request->query('body', '')
            ],
            'is_configured_service' =>  Services::isConfigured()
        ]);
    }

    public function store(StorePost $storePost): RedirectResponse
    {
        $post = $storePost->handle();

        return redirect()->route('appractic.posts.edit', ['post' => $post->id]);
    }

    public function edit(Post $post): Response
    {
        $post->load('accounts', 'versions', 'tags');

        EagerLoadPostVersionsMedia::apply($post);

        return Inertia::render('Posts/CreateEdit', [
            'accounts' => AccountResource::collection(Account::oldest()->get())->resolve(),
            'tags' => TagResource::collection(Tag::latest()->get())->resolve(),
            'post' => new PostResource($post),
            'is_configured_service' =>  Services::isConfigured()
        ]);
    }

    public function update(UpdatePost $updatePost): HttpResponse
    {
        $updatePost->handle();

        return response()->noContent();
    }

    public function destroy(Request $request, RedirectAfterDeletedPost $redirectAfterPostDeleted, $id): RedirectResponse
    {
        Post::where('id', $id)->delete();

        return $redirectAfterPostDeleted($request);
    }
}
