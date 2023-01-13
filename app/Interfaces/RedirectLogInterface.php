<?php

namespace App\Interfaces;

interface RedirectLogInterface
{
    /**
     * @param array $slugs
     * @return array
     */
    public function countLink(array $slugs): array;

    /**
     * @param string $slug
     * @return void
     */
    public function store(string $slug): void;
}
