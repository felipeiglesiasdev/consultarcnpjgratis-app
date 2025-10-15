@props(['statusMap', 'currentStatusSlug'])

<div class="flex flex-wrap justify-center gap-2 md:gap-4 mb-12">
    @foreach ($statusMap as $slug => $info)
        <a href="{{ route('empresas.status', ['status_slug' => $slug]) }}"
           @class([
                'px-4 py-2 text-sm font-bold rounded-full transition-all duration-200 border-2',
                'bg-white text-gray-700 border-gray-200 hover:bg-gray-100 hover:border-gray-300' => $slug !== $currentStatusSlug,
                'bg-green-600 text-white border-green-700 shadow-md scale-105' => $slug === $currentStatusSlug,
           ])>
            {{ $info['nome'] }}
        </a>
    @endforeach
</div>