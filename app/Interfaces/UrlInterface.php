<?php

namespace App\Interfaces;

use App\Models\Url;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

interface UrlInterface
{
    /**
     * @param string $id
     * @return Url
     */
    public function getById(string $id): Url;

    /**
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * @param int $id
     * @return array
     */
    public function getAllSlugs(int $id): array;

    /**
     * @param string|null $search
     * @param int $perPage
     * @return Paginator
     */
    public function getFiltered(?string $search = null, int $perPage = 10): Paginator;

    /**
     * @param string $slug
     * @return bool
     */
    public function slugExist(string $slug): bool;

    /**
     * @param string $slug
     * @return string
     */
    public function findBySlug(string $slug): string;

    /**
     * @param array $data
     * @return Url
     */
    public function store(array $data): Url;

    /**
     * @param Url $url
     * @param array $data
     * @return Url
     */
    public function update(Url $url, array $data): Url;

    /**
     * @param Url $url
     * @return bool
     */
    public function destroy(Url $url): bool;
}
