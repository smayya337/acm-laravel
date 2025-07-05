<div class="card card-side bg-base-100 basis-sm w-full not-prose shadow-md transition-shadow">
    <a href="{{ route('user_page', $user->username) }}" class="flex items-center p-4 w-full flex-row text-nowrap">
        @if($user->image)
            <div class="avatar">
                <div class="mask mask-circle w-12 h-12">
                    <img src="{{ Storage::url($user->image) }}" alt="{{ $user->first_name }}">
                </div>
            </div>
        @else
            <div class="avatar">
                <div class="bg-neutral text-neutral-content w-12 h-12 rounded-full flex items-center justify-center">
                    <span class="text-sm font-bold">{{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}</span>
                </div>
            </div>
        @endif
        <div class="ml-4">
            <h3 class="font-semibold">{{ $user->first_name }} {{ $user->last_name }}</h3>
            <p class="text-sm text-base-content/70">{{ $user->username }}</p>
        </div>
    </a>
</div>