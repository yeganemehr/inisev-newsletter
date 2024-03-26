<?php

namespace Inisev\Newsletter\Http\Controllers;

use Inisev\Newsletter\Http\Requests\StoreSubscriberRequest;
use Inisev\Newsletter\Http\Requests\UpdateSubscriberRequest;
use Inisev\Newsletter\Http\Resources\SubscriberResource;
use Inisev\Newsletter\Models\Subscriber;
use Inisev\Newsletter\Models\Website;

class SubscriberController extends Controller
{
    public function index(Website $website)
    {
        $collection = Subscriber::query()
            ->where('website_id', $website->id)
            ->cursorPaginate();

        return SubscriberResource::collection($collection);
    }

    public function store(StoreSubscriberRequest $request, Website $website)
    {
        $data = $request->validated();
        $subscriber = $website->subscribers()->create($data);

        return SubscriberResource::make($subscriber);
    }

    public function show(Website $website, Subscriber $subscriber)
    {
        return SubscriberResource::make($subscriber);
    }

    public function update(UpdateSubscriberRequest $request, Website $website, Subscriber $subscriber)
    {
        $data = $request->validated();
        $subscriber->update($data);

        return SubscriberResource::make($subscriber);
    }

    public function destroy(Website $website, Subscriber $subscriber)
    {
        $subscriber->delete();

        return response()->noContent();
    }
}
