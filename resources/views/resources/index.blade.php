<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            @lang('Resources') <button onclick="Livewire.emit('openModal', 'resource.resource-form')" class="px-2 py-1 ml-4 text-sm font-bold text-white bg-green-500 rounded hover:bg-green-700"><svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg> @lang('Create')</button>
        </h2>
    </x-slot>

    <div>
        <div class="px-4 py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if(Request::is('resource/category/*'))
                @component('components.breadcrumb', ['breadcrumbs' => [
                    ['url' => route('resource.index'), 'label' => __('Resources')],
                    ['url' => null, 'label' => $category->name],
                ]])
                @endcomponent
            @else
                @component('components.breadcrumb', ['breadcrumbs' => [
                    ['url' => null, 'label' => __('Resources')],
                ]])
                @endcomponent
            @endif
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 md:grid-cols-4 grid-flow-cols">
                <div>
                    <div class="flex flex-col items-center justify-center w-full mx-auto overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-900 dark:shadow-gray-700">
                        <div class="w-full px-4 py-3 border-b dark:border-gray-700">
                            <h3 class="font-medium leading-6 text-gray-900 dark:text-white">
                                @lang('Categories')
                            </h3>
                        </div>
                        <div class="flex flex-col w-full text-gray-900 divide-y divide dark:divide-gray-700 dark:text-white">
                            <a href="{{ route('resource.index') }}" class="px-4 py-3 text-xs hover:bg-black/10 dark:hover:bg-white/10">@lang('All categories')</a>
                            @foreach ($categories as $category)
                                <a href="{{ route('resource.category', $category->slug) }}" class="px-4 py-3 text-xs hover:bg-black/10 dark:hover:bg-white/10 {{ $category->slug === request()->segment(3) ? 'bg-green-400/20 font-bold' : '' }}">{{ $category->name }}</a>
                                @forelse($category->children as $child)
                                    <a href="{{ route('resource.category', $child->slug) }}" class="px-4 py-3 text-xs hover:bg-black/10 dark:hover:bg-white/10 {{ $child->slug === request()->segment(3) ? 'bg-green-400/20 font-bold' : '' }}">&mdash; {{ $child->name }}</a>
                                @empty
                                @endforelse
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="sm:col-span-2 md:col-span-3">

                    @livewire('resource.resource-list')

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
