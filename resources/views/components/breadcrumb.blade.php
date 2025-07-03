<div class="">
    @foreach ($links ?? [] as $item)
        <a href="{{ $item['link'] ?? '#' }}" class="text-sm text-gray-600 hover:text-gray-800">{{ $item['name'] }}</a>
        @if (!$loop->last)
            <i class="fa-solid fa-chevron-right text-xs text-gray-600 mx-1"></i>
        @endif
    @endforeach
</div>
