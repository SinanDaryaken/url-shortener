<?php

namespace App\Services;

use App\Exceptions\SlugExceptions;
use App\Models\Url;
use App\Repositories\UrlRepository;
use Illuminate\Http\JsonResponse;

class SlugService
{
    /**
     * @var UrlRepository
     */
    private UrlRepository $urlRepository;

    /**
     *
     */
    public function __construct()
    {
        $this->urlRepository = new UrlRepository(new Url());
    }

    /**
     * @param string $slug
     * @return JsonResponse|null|SlugExceptions
     * @throws SlugExceptions
     */
    public function isExists(string $slug): JsonResponse|bool|SlugExceptions
    {
        if (!$this->urlRepository->slugExist($slug)) {
            throw new SlugExceptions();
        }
        return true;
    }
}
