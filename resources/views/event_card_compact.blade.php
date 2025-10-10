<div class="card bg-base-100 shadow-sm hover:shadow-md transition-shadow not-prose">
  <div class="card-body p-4">
    <h3 class="card-title text-lg">{{ $event->name }}</h3>
    <p class="text-sm text-base-content/70">
      <i class="fa fa-calendar mr-1"></i> {{ $event->start->format('M j, g:i A') }}
    </p>
    @if($event->location)
      <p class="text-sm text-base-content/70">
        <i class="fa fa-map-marker mr-1"></i> {{ $event->location }}
      </p>
    @endif
    <a href="{{ route('event_page', $event->id) }}" class="btn btn-primary btn-sm mt-2">
      View Details
    </a>
  </div>
</div>
