@php use Carbon\Carbon; @endphp
{{--
    Assumptions:
    - $evt is an object passed to this view (likely within a loop).
    - $evt has properties like: pk, image_url (or image->url), name, start, end (optional), location, description.
    - You have a named route 'event.page' that accepts the event's primary key (or slug).
    - You have @tailwindcss/line-clamp plugin installed and configured in tailwind.config.js for line clamping the description.
      (npm install -D @tailwindcss/line-clamp; add require('@tailwindcss/line-clamp') to plugins in tailwind.config.js)
    - A placeholder image exists at public/images/event_placeholder.png if $evt->image_url is not set.
--}}

<a href="{{ route('event_page', $evt->id) }}"
   class="block no-underline text-inherit transition-all duration-150 ease-in-out group">
    {{-- DaisyUI card with horizontal layout (card-side) --}}
    {{-- Added group class to the link for potential group-hover effects on children --}}
    <div
        class="card card-side bg-base-100 shadow-md hover:shadow-lg transition-shadow duration-150 ease-in-out rounded-lg overflow-hidden h-full">
        {{-- Image Section --}}
        {{-- Bootstrap 'col-2' is 2/12 = 1/6 of the width. Adjust w-1/6, w-1/5, or w-1/4 as visually preferred.
             Or use fixed widths e.g. sm:w-32 md:w-40 for more control.
             flex-shrink-0 prevents the image container from shrinking. --}}
        <figure class="w-1/4 md:w-1/5 lg:w-1/6 flex-shrink-0 bg-base-200">
            {{-- The image itself will be a square and cover its container --}}
            <img src="{{ $evt->image_url ?? asset('images/event_placeholder.png') }}"
                 alt="Image for event: {{ $evt->name }}"
                 class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-200 ease-in-out"/>
        </figure>

        {{-- Content Section --}}
        <div class="card-body p-3 py-2 sm:p-4 flex flex-col">
            <h3 class="card-title text-sm sm:text-base md:text-lg font-semibold mb-1 leading-tight">
                {{ $evt->name }}
            </h3>

            <div class="text-xs sm:text-sm text-base-content/80 space-y-0.5 flex-grow">
                <p>
                    <strong class="font-medium">When: </strong>
                    {{-- It's good practice to format dates using Accessors in your Event model (e.g., getStartFormattedAttribute)
                         or in the Controller before passing to the view. --}}
                    {{-- Example assumes $evt->start might be a Carbon instance or a string parsable by Carbon --}}
                    {{ $evt->start_formatted ?? (Carbon::parse($evt->start)->translatedFormat(config('app.date_formats.event_card_datetime', 'M j, Y g:i A'))) }}
                    @if ($evt->end)
                        - {{ $evt->end_formatted ?? (Carbon::parse($evt->end)->translatedFormat(config('app.date_formats.event_card_time_only', 'M j, Y g:i A'))) }}
                    @endif
                </p>
                @if($evt->location)
                    <p>
                        <strong class="font-medium">Where: </strong> {{ $evt->location }}
                    </p>
                @endif
            </div>

            @if ($evt->description)
                <p class="text-xs sm:text-sm text-base-content/90 mt-1 sm:mt-2 line-clamp-2 md:line-clamp-3 hidden sm:block"> {{-- Requires @tailwindcss/line-clamp --}}
                    {{ $evt->description }}
                </p>
            @endif

            {{-- Optional: Add a "Read more" or other actions if card-actions are desired
                 Use mt-auto to push actions to the bottom if the card-body is flex flex-col and has space.
            --}}
            {{-- <div class="card-actions justify-end mt-auto pt-2">
                <span class="text-primary hover:underline text-sm font-medium">View Details</span>
            </div> --}}
        </div>
    </div>
</a>
