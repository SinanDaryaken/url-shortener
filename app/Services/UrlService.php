<?php

namespace App\Services;

use App\Http\Resources\UrlResource;
use App\Models\Url;
use App\Repositories\UrlRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class UrlService
{
    /**
     * @param UrlRepository $urlRepository
     */
    public function __construct(private UrlRepository $urlRepository)
    {
    }

    /**
     * @param Url $url
     * @return UrlResource
     */
    public function setSingle(Url $url): UrlResource
    {
        return new UrlResource($url);
    }

    /**
     * @param Collection $urls
     * @return JsonResource
     */
    public function setPlural(Collection $urls): JsonResource
    {
        return UrlResource::collection($urls);
    }

    /**
     * @return string
     */
    public function generateSlug(): string
    {
        $slug = Str::random(15);
        $slugExists = $this->urlRepository->slugExist($slug);
        if ($slugExists) {
            $this->generateSlug();
        }
        return $slug;
    }
}
