<div class="card card-side bg-base-100 basis-sm w-full not-prose h-55">
    @if($event->image)
        <img src="{{ Storage::url($event->image) }}" alt="{{ $event->name }}" class="aspect-square h-full object-cover shrink-0">
    @else
        <div class="aspect-square h-full bg-secondary text-secondary-content flex items-center justify-center shrink-0">
            <span class="text-4xl font-bold">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    @endif
    <div class="card-body grow flex flex-col">
        <h5 class="card-title">{{ $event->name }}</h5>
        <div class="mb-2 flex-grow">
            @if($event->description)
            <p class="card-text">{{ $event->description }}</p>
            @endif
            <p class="card-text">
                <i class="fa fa-calendar mr-2"></i> {{ $event->start->format('M j, Y g:i A') }}
                @if($event->end)
                    - {{ $event->end->format('M j, Y g:i A') }}
                @endif
            </p>
            <p class="card-text">
                <i class="fa fa-map-marker mr-2"></i> {{ $event->location }}
            </p>
        </div>
        <a href="{{ route('event_page', $event->id) }}" class="btn btn-primary">View Details</a>
    </div>
</div>