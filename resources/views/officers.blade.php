@extends('app')

@section('title', $year . '-' . (($year + 1) % 100) . ' Officers | ACM @ UVA')

@section('content')
    <h1>{{ $year }}-{{ ($year + 1) % 100 }} Officers</h1>
    <div class="mb-3 p-8 bg-base-200 rounded-box gap-8 grid place-content-around place-items-center">
        @foreach($officers as $officer)
            @include('officer_card', ['officer' => $officer])
        @endforeach
    </div>
    <h2>Past Years</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 pb-3">
        @foreach($all_years as $py)
            <a href="{{ route('officers.by_year', ['year' => $py]) }}">{{ $py }}-{{ ($py + 1) % 100 }}</a>
        @endforeach
    </div>
@endsection
