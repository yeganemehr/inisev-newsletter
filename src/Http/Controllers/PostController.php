<?php

namespace Inisev\Newsletter\Http\Controllers;

use Illuminate\Support\Arr;
use Inisev\Newsletter\Http\Requests\StorePostRequest;
use Inisev\Newsletter\Http\Requests\UpdatePostRequest;
use Inisev\Newsletter\Http\Resources\PostResource;
use Inisev\Newsletter\Jobs\SendPostToSubscribers;
use Inisev\Newsletter\Models\Post;
use Inisev\Newsletter\Models\Website;

class PostController extends Controller
{
    public function index(Website $website)
    {
        $collection = Post::query()
            ->where('website_id', $website->id)
            ->cursorPaginate();

        return PostResource::collection($collection);
    }

    public function store(StorePostRequest $request, Website $website)
    {
        $data = $request->validated();
        $post = $website->posts()->create($data);

        SendPostToSubscribers::dispatch($post);

        return PostResource::make($post);
    }

    public function show(Website $website, Post $post)
    {
        return PostResource::make($post);
    }

    public function update(UpdatePostRequest $request, Website $website, Post $post)
    {
        $data = $request->validated();
        $resend = Arr::pull($data, 'resend');
        $post->update($data);

        if (in_array($resend, [true, 1, '1'], true)) {
            $post->notifications()->delete();

            SendPostToSubscribers::dispatch($post);
        }

        return PostResource::make($post);
    }

    public function destroy(Website $website, Post $post)
    {
        $post->delete();

        return response()->noContent();
    }
}
