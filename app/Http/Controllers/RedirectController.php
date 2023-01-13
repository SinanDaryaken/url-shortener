<?php

namespace App\Http\Controllers;

use App\Facades\SlugExistsFaced;
use App\Repositories\RedirectLogRepository;
use App\Repositories\UrlRepository;
use Illuminate\Support\Facades\Redirect;

class RedirectController extends Controller
{
    /**
     * @param UrlRepository $urlRepository
     * @param RedirectLogRepository $redirectLogRepository
     */
    public function __construct(
        private UrlRepository         $urlRepository,
        private RedirectLogRepository $redirectLogRepository
    )
    {
    }

    /**
     * @param string|null $slug
     * @return void
     */
    public function redirect(?string $slug): void
    {
        SlugExistsFaced::isExists($slug);
        $link = $this->urlRepository->findBySlug($slug);
        if ($link) {
            $this->redirectLogRepository->store($slug);
            Redirect::away($link);
        }
    }
}
