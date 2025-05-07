{{-- TODO: how do I include this component in other views? --}}
@if($user->image)
    <img src="{{ $user->image }}" class="rounded-full border"  alt="Image of {{ $user->first_name }} {{ $user->last_name }}"/>
@else
    {{-- TODO: make this appropriately sized --}}
    <div class="rounded-full border flex"
         style="object-fit: cover; aspect-ratio: 1/1; align-items: center;">
        <div class="w-75 mx-auto block">
            <svg xmlns="http://www.w3.org/2000/svg" fill="var(--bs-secondary-color)" class="bi bi-person-fill"
                 viewBox="0 0 16 16" role="img" aria-label="[title + description]">
                <title>Placeholder image for {{ $user->first_name }} {{ $user->last_name }}</title>
                <desc>This user has not set an image.</desc>
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"></path>
            </svg>
        </div>
    </div>
@endif
