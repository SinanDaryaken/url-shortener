<?php

namespace App\Http\Controllers;

use App\Facades\JsonOutputFaced;
use App\Http\Requests\Url\StoreRequest;
use App\Http\Requests\Url\UpdateRequest;
use App\Models\Url;
use App\Repositories\UrlRepository;
use App\Services\UrlService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    /**
     * @param UrlRepository $urlRepository
     * @param UrlService $urlService
     */
    public function __construct(
        private UrlRepository $urlRepository,
        private UrlService    $urlService
    )
    {
    }

    /**
     * @param Url $url
     * @return JsonResponse
     */
    public function getById(Url $url): JsonResponse
    {
        $url = $this->urlRepository->getById($url);
        $url = $this->urlService->setSingle($url);
        return JsonOutputFaced::setData($url)->response();
    }

    /**
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $urls = $this->urlRepository->getAll();
        $urls = $this->urlService->setPlural($urls);
        return JsonOutputFaced::setData($urls)->response();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getFiltered(Request $request): JsonResponse
    {
        $search = $request->get('search');
        $perPage = $request->get('limit', 10);
        $urls = $this->urlRepository->getFiltered($search, $perPage);
        return JsonOutputFaced::setData($urls)->response();
    }

    /**
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        if (!isset($data['slug'])) {
            $data['slug'] = $this->urlService->generateSlug();
        }
        $this->urlRepository->store($data);
        return JsonOutputFaced::response();
    }

    /**
     * @param UpdateRequest $request
     * @param Url $url
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Url $url): JsonResponse
    {
        $data = $request->validated();
        if (!isset($data['slug'])) {
            $data['slug'] = $this->urlService->generateSlug();
        }
        $this->urlRepository->update($url, $data);
        return JsonOutputFaced::response();
    }

    /**
     * @param Url $url
     * @return JsonResponse
     */
    public function destroy(Url $url): JsonResponse
    {
        $this->urlRepository->destroy($url);
        return JsonOutputFaced::response();
    }
}
