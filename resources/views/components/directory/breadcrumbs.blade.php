@props(['breadcrumbs'])

@if (isset($breadcrumbs) && count($breadcrumbs) > 0)
    <nav class="mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm">
            @foreach ($breadcrumbs as $breadcrumb)
                <li>
                    <div class="flex items-center">
                        @if (!$loop->first)
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        @endif

                        @if ($breadcrumb['url'])
                            <a href="{{ $breadcrumb['url'] }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700">
                                {{ $breadcrumb['title'] }}
                            </a>
                        @else
                            <span class="ml-2 text-sm font-medium text-gray-700">
                                {{ $breadcrumb['title'] }}
                            </span>
                        @endif
                    </div>
                </li>
            @endforeach
        </ol>
    </nav>
@endif