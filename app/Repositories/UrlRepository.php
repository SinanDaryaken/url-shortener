<?php

namespace App\Repositories;

use App\Interfaces\UrlInterface;
use App\Models\Url;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

class UrlRepository implements UrlInterface
{
    /**
     * @param Url $url
     */
    public function __construct(protected Url $url)
    {
    }

    /**
     * @param string $id
     * @return Url
     */
    public function getById(string $id): Url
    {
        return $this->url->isUserAuth()->find($id);
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->url->isUserAuth()->get();
    }

    /**
     * @param int $id
     * @return array
     */
    public function getAllSlugs(int $id): array
    {
        return $this->url->where('user_id', $id)->pluck('slug')->toArray();
    }

    /**
     * @param string|null $search
     * @param int $perPage
     * @return Paginator
     */
    public function getFiltered(?string $search = null, int $perPage = 10): Paginator
    {
        return $this->url
            ->isUserAuth()
            ->when($search, function ($query, $search) {
                $query->orWhere('name', 'ilike', "%{$search}%");
                $query->orWhere('link', 'ilike', "%{$search}%");
                $query->orWhere('slug', 'ilike', "%{$search}%");
            })
            ->paginate($perPage);
    }

    /**
     * @param string $slug
     * @return bool
     */
    public function slugExist(string $slug): bool
    {
        return $this->url->where('slug', $slug)->exists();
    }

    /**
     * @param string $slug
     * @return string
     */
    public function findBySlug(string $slug): string
    {
        return $this->url->where('slug', $slug)->pluck('link')->first();
    }

    /**
     * @param array $data
     * @return Url
     */
    public function store(array $data): Url
    {
        $data['user_id'] = auth()->id();
        return $this->url->create($data);
    }

    /**
     * @param Url $url
     * @param array $data
     * @return Url
     */
    public function update(Url $url, array $data): Url
    {
        $url->update($data);
        return $url;
    }

    /**
     * @param Url $url
     * @return bool
     */
    public function destroy(Url $url): bool
    {
        return $url->delete();
    }
}
