@props(['badge'])

@if($badge->description)
    <div class="tooltip" data-tip="{{ $badge->description }}">
        <span class="badge badge-{{ $badge->color }} hover:badge-{{ $badge->color }}-800">
            {{ $badge->name }}
        </span>
    </div>
@else
    <span class="badge badge-{{ $badge->color }} hover:badge-{{ $badge->color }}-800">
        {{ $badge->name }}
    </span>
@endif 