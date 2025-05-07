{{-- Main container for the events list --}}
<div class="p-4 bg-base-200 rounded-box overflow-y-auto">
    {{--
        Loop through the events.
        @forelse is a Blade directive that combines a foreach loop
        with a check for an empty collection.
    --}}
    @forelse ($events as $evt)
        {{--
            Wrapper for each event card.
            Adds a bottom margin if it's not the last item in the loop.
            Tailwind's 'space-y-*' on the parent is an alternative if all items should have spacing.
            However, to precisely match "not forloop.last", this conditional class is accurate.
        --}}
        <div class="@if (!$loop->last) mb-3 @endif">
            @include('event_card', ['evt' => $evt]) {{-- Pass the event data to the partial --}}
        </div>
    @empty
        {{-- This content is shown if the $events collection is empty --}}
        <p class="m-0 text-center text-base-content/75"> {{-- text-base-content with opacity for a "muted" look --}}
            Sorry, there are no upcoming events!
        </p>
    @endforelse
</div>
