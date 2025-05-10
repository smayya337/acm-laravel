@php use Illuminate\Support\Facades\Storage; @endphp
<div class="card h-full bg-base-100 shadow-md officer-card not-prose w-96">
    @if($officer->user->image)
        <figure class="overflow-hidden">
            <img
                src="{{ Storage::url($officer->user->image) }}"
                alt="Image of {{ $officer->user->first_name }} {{ $officer->user->last_name }}"
                class="object-cover aspect-square w-full"
            />
        </figure>
    @else
        <figure class="overflow-hidden h-96">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="-224 -192 896 1024" fill="currentColor"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z"/></svg>
        </figure>
    @endif

    <div class="card-body flex flex-col">
        <h5 class="card-title officer-card-title">
            {{ $officer->user->first_name }} {{ $officer->user->last_name }}
        </h5>
        <h6 class="text-sm text-base-content/60 officer-card-subtitle">
            {{ $officer->position }}
        </h6>
    </div>

    <div class="card-actions justify-end p-4">
        <a
            href="{{ route('user_page', ['user' => $officer->user]) }}"
            class="btn btn-primary"
        >
            Profile
        </a>
    </div>
</div>
