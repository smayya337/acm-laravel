<div class="card card-side bg-base-100 basis-sm w-full not-prose shadow-md transition-shadow">
    <a href="{{ route('event_page', $event) }}" class="flex items-center w-full flex-row text-nowrap">
        @if($event->image)
            <div class="h-full aspect-square">
                <img src="{{ Storage::url($event->image) }}" alt="{{ $event->name }}">
            </div>
        @else
            <div class="h-full aspect-square bg-secondary text-secondary-content flex items-center justify-center">
                <span class="text-lg font-bold">
                    <i class="fa fa-calendar"></i>
                </span>
            </div>
        @endif
        <div class="p-4">
            <h3 class="font-semibold">{{ $event->name }}</h3>
            <p class="text-sm text-base-content/70">{{ $event->start->format('M j, Y') }}
                @if($event->end && $event->end->format('M j, Y') != $event->start->format('M j, Y'))
                    - {{ $event->end->format('M j, Y') }}
                @endif</p>
        </div>
    </a>
</div>