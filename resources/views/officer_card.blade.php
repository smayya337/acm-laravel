{{-- <div class="card bg-base-100 shadow-sm w-full flex flex-col">
    @if($officer->user->image)
        <figure class="w-full">
            <img src="{{ $officer->user->image }}" class="w-full aspect-square object-cover" alt="{{ $officer->user->first_name }}">
        </figure>
    @endif
    <div class="card-body items-center text-center flex-1">
        <h5 class="card-title text-lg font-bold"></h5>
        <p class="card-text text-base text-gray-500"></p>
    </div>
</div> --}}

<div class="card bg-base-100 basis-sm shadow-md not-prose">
    <figure>
        @if($officer->user->image)
        <img src="{{ Storage::url($officer->user->image) }}" class="w-full aspect-square object-cover" alt="{{ $officer->user->first_name }}">
        @else
        <div class="w-full aspect-square bg-secondary text-secondary-content flex items-center justify-center">
            @if($officer->user->first_name && $officer->user->last_name)
                <span class="text-4xl font-bold">{{ substr($officer->user->first_name, 0, 1) }}{{ substr($officer->user->last_name, 0, 1) }}</span>
            @elseif($officer->user->first_name)
                <span class="text-4xl font-bold">{{ substr($officer->user->first_name, 0, 1) }}</span>
            @else
                <span class="text-4xl font-bold">{{ substr($officer->user->username, 0, 1) }}</span>
            @endif
        </div>
        @endif
    </figure>
    <div class="card-body">
      <h2 class="card-title">{{ $officer->user->first_name }} {{ $officer->user->last_name }}</h2>
      <p>{{ $officer->position }}</p>
      <div class="card-actions justify-end">
        <a href="{{ route('user_page', $officer->user->username) }}" class="btn btn-primary">Profile</a>
      </div>
    </div>
  </div>