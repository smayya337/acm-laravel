@extends('layouts.app')

@section('title', 'Home - ACM @ UVA')

@section('content')
<header class="row align-items-center">
  <div class="col-lg-8">
    <h1><span class="text-primary">ACM</span> @ <span class="text-accent">UVA</span></h1>
    <h2 class="h3 text-muted mt-n2 me-n1">The Undergraduate Computer Science Community!</h2>
    <nav class="mt-3 mb-8 d-flex flex-wrap space-x-4 justify-content-end" aria-label="Quick links">
      <a class="btn btn-primary d-flex align-items-center gap-2" href="https://discord.gg/wxWgbVs" target="_blank" rel="noopener" aria-label="Join Discord">
        <i class="fa-brands fa-discord fa-lg"></i> Discord
      </a>
      <a id="joinACM" href="https://lists.virginia.edu/sympa/subscribe/acm-members" target="_blank" rel="noopener" class="btn btn-secondary d-flex align-items-center gap-2" aria-label="Join Mailing List">
        <i class="fa-solid fa-user-plus fa-lg"></i> Mailing List
      </a>
      <a href="mailto:acm-officers@virginia.edu" class="btn btn-accent d-flex align-items-center gap-2" aria-label="Contact ACM Officers">
        <i class="fa-solid fa-envelope fa-lg"></i> Contact
      </a>
    </nav>
  </div>
</header>

<div class="w-3xl max-w-full mx-auto">
  <div class="carousel w-full mx-auto rounded-box">
    <div id="slide1" class="carousel-item relative w-full object-contain">
      <img
        src="{{ asset('images/professor_dinner.jpg') }}"
        alt="Professor dinner"
        class="w-full object-contain" />
      <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
        <a href="#slide4" class="btn btn-circle">❮</a>
        <a href="#slide2" class="btn btn-circle">❯</a>
      </div>
    </div>
    <div id="slide2" class="carousel-item relative w-full object-contain">
      <img
        src="{{ asset('images/corn_maze.jpg') }}"
        alt="Corn maze"
        class="w-full object-contain" />
      <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
        <a href="#slide1" class="btn btn-circle">❮</a>
        <a href="#slide3" class="btn btn-circle">❯</a>
      </div>
    </div>
    <div id="slide3" class="carousel-item relative w-full object-contain">
      <img
        src="{{ asset('images/pumpkin_trip.jpg') }}"
        alt="Pumpkin trip"
        class="w-full object-contain" />
      <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
        <a href="#slide2" class="btn btn-circle">❮</a>
        <a href="#slide4" class="btn btn-circle">❯</a>
      </div>
    </div>
    <div id="slide4" class="carousel-item relative w-full object-contain">
      <img
        src="{{ asset('images/rope_course.jpg') }}"
        alt="Rope course"
        class="w-full object-contain" />
      <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
        <a href="#slide3" class="btn btn-circle">❮</a>
        <a href="#slide1" class="btn btn-circle">❯</a>
      </div>
    </div>
  </div>
</div>
@endsection 