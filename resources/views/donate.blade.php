@extends('app')

@section('content')
    <h1>Donate</h1>
    <h2>What is our mission?</h2>
    <p>ACM has a number of events each semester, ranging from social events (game nights, student-faculty luncheons,
        etc.), academic events (tutoring, talks, etc.), and competitive events (ICPC and HSPC). With the support of the
        university and our donators, we are able to host high quality events that all students across UVA are able to
        enjoy. With your donations, we are able to use those funds to plan even more events for students!</p>
    <h2>Want to donate to ACM?</h2>
    <p>We accept Venmo and Zelle (linked below). If neither of these options work for you, feel free to contact us at <a
            href="mailto:acm-officers@virginia.edu">acm-officers@virginia.edu</a>.</p>
    <div class="pt-2">
        <a href="{{ env('VENMO') }}" class="btn btn-primary">
            Venmo
        </a>
        <a href="{{ env('ZELLE') }}" class="btn btn-primary">
            Zelle
        </a>
    </div>
@endsection
