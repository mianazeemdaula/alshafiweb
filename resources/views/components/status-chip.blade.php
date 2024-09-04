<div>
    @php
        $color = 'gray';
        switch (strtolower($status)) {
            case 'active':
            case 'completed':
                $color = 'green';
                break;
            case 'inactive':
            case 'cancelled':
                $color = 'red';
                break;
            case 'pending':
                $color = 'yellow';
                break;

            default:
                break;
        }
    @endphp
    <span class="px-2 inline-flex text-xs leading-5 rounded-full bg-{{ $color }}-500 text-white">
        {{ ucFirst($status) }}
    </span>
</div>
