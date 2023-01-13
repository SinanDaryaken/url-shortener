<?php

namespace App\Repositories;

use App\Interfaces\RedirectLogInterface;
use App\Models\RedirectLog;

class RedirectLogRepository implements RedirectLogInterface
{
    /**
     * @param RedirectLog $redirectLog
     */
    public function __construct(protected RedirectLog $redirectLog)
    {
    }

    /**
     * @param array $slugs
     * @return array
     */
    public function countLink(array $slugs): array
    {
        $return = [];
        foreach ($slugs as $slug) {
            $return [$slug] = $this->redirectLog->where('slug', $slug)->count();
        }
        return $return;
    }

    /**
     * @param string $slug
     * @return void
     */
    public function store(string $slug): void
    {
        $this->redirectLog->create(['slug' => $slug]);
    }
}
