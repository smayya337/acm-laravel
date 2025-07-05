<div class="card card-side bg-base-100 basis-sm w-full not-prose">
    @if($event->image)
        <img src="{{ Storage::url($event->image) }}" alt="{{ $event->name }}" class="aspect-square h-full object-cover">
    @else
        <div class="aspect-square h-full bg-neutral text-neutral-content flex items-center justify-center">
            <span class="text-4xl font-bold">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    @endif
    <div class="card-body grow">
        <h5 class="card-title">{{ $event->name }}</h5>
        <p class="card-text">{{ $event->description }}</p>
        <p class="card-text">
            <small class="text-muted">
                <i class="fa fa-calendar mr-2"></i> {{ $event->start->format('M j, Y g:i A') }}
                @if($event->end)
                    - {{ $event->end->format('M j, Y g:i A') }}
                @endif
            </small>
        </p>
        <p class="card-text">
            <small class="text-muted">
                <i class="fa fa-map-marker mr-2"></i> {{ $event->location }}
            </small>
        </p>
        <a href="{{ route('event_page', $event->id) }}" class="btn btn-primary">View Details</a>
    </div>
</div>