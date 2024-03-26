<?php

namespace Inisev\Newsletter\Http\Controllers;

use Inisev\Newsletter\Http\Requests\StoreWebsiteRequest;
use Inisev\Newsletter\Http\Requests\UpdateWebsiteRequest;
use Inisev\Newsletter\Http\Resources\WebsiteResource;
use Inisev\Newsletter\Models\Website;

class WebsiteController extends Controller
{
    public function index()
    {
        return WebsiteResource::collection(Website::query()->cursorPaginate());
    }

    public function store(StoreWebsiteRequest $request)
    {
        $data = $request->validated();
        $website = Website::query()->create($data);

        return WebsiteResource::make($website);
    }

    public function show(Website $website)
    {
        return WebsiteResource::make($website);
    }

    public function update(UpdateWebsiteRequest $request, Website $website)
    {
        $data = $request->validated();
        $website->update($data);

        return WebsiteResource::make($website);
    }

    public function destroy(Website $website)
    {
        $website->delete();

        return response()->noContent();
    }
}
