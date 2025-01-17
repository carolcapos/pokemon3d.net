<?php

namespace App\Http\Livewire\Resource;

use AliBayat\LaravelCategorizable\Category;
use App\Models\Resource;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class ResourceList extends Component
{
    use WithPagination;

    protected $listeners = [
        'resourceUpdated' => '$refresh',
    ];

    public function render()
    {
        if (request()->is('resource/category/*')) {
            $perPage = 15; // Default for pagination
            $filtered = Resource::orderBy('created_at', 'desc')->get()->filter(function ($resource) {
                return $resource->hasCategory(Category::where('slug', request()->segment(3))->first());
            });
            $resources = new LengthAwarePaginator(
                $filtered->slice(LengthAwarePaginator::resolveCurrentPage() * $perPage - $perPage, $perPage)->all(),
                count($filtered),
                $perPage,
                null,
                ['path' => '']
            );
        } else {
            $resources = Resource::orderBy('created_at', 'desc')->paginate(15);
        }

        return view('livewire.resource.resource-list', [
            'resources' => $resources,
        ]);
    }
}
