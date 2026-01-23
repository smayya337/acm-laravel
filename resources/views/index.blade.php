@extends('layouts.app')

@section('title', 'Home - ACM @ UVA')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full" id="home-grid">
  <!-- Left Column: Header and Carousel -->
  <div class="md:col-span-2">
    <header class="mb-6" id="home-header">
      <h1 class="text-center mb-4"><span class="text-primary">ACM</span> @ <span class="text-accent">UVA</span></h1>
      <h2 class="h3 text-center text-muted -mt-2 mb-4">The Undergraduate Computer Science Community!</h2>
      <nav class="mt-3 flex flex-col md:flex-row gap-4 justify-center items-center mb-4" aria-label="Quick links">
        <a class="btn btn-primary flex items-center gap-2" href="https://discord.gg/wxWgbVs" target="_blank" rel="noopener" aria-label="Join Discord">
          <i class="fa-brands fa-discord fa-lg"></i> Discord
        </a>
        <a id="joinACM" href="https://lists.virginia.edu/sympa/subscribe/acm-members" target="_blank" rel="noopener" class="btn btn-secondary flex items-center gap-2" aria-label="Join Mailing List">
          <i class="fa-solid fa-user-plus fa-lg"></i> Mailing List
        </a>
        <a href="mailto:acm-officers@virginia.edu" class="btn btn-accent flex items-center gap-2" aria-label="Contact ACM Officers">
          <i class="fa-solid fa-envelope fa-lg"></i> Contact
        </a>
      </nav>
    </header>
    <div class="carousel w-full rounded-box not-prose md:h-[500px]" id="home-carousel">
      <div id="slide1" class="carousel-item relative w-full h-full">
        <img
          src="{{ asset('images/hspc_volunteers.jpg') }}"
          alt="Professor dinner"
          class="w-full h-full object-contain" />
        <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
          <a href="#slide4" class="btn btn-circle">❮</a>
          <a href="#slide2" class="btn btn-circle">❯</a>
        </div>
      </div>
      <div id="slide2" class="carousel-item relative w-full h-full">
        <img
          src="{{ asset('images/bingo_winners.jpg') }}"
          alt="Corn maze"
          class="w-full h-full object-contain" />
        <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
          <a href="#slide1" class="btn btn-circle">❮</a>
          <a href="#slide3" class="btn btn-circle">❯</a>
        </div>
      </div>
      <div id="slide3" class="carousel-item relative w-full h-full">
        <img
          src="{{ asset('images/pumpkin_painting.jpg') }}"
          alt="Pumpkin trip"
          class="w-full h-full object-contain" />
        <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
          <a href="#slide2" class="btn btn-circle">❮</a>
          <a href="#slide4" class="btn btn-circle">❯</a>
        </div>
      </div>
      <div id="slide4" class="carousel-item relative w-full h-full">
        <img
          src="{{ asset('images/professor_dinner.jpg') }}"
          alt="Rope course"
          class="w-full h-full object-contain" />
        <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
          <a href="#slide3" class="btn btn-circle">❮</a>
          <a href="#slide1" class="btn btn-circle">❯</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Upcoming Events Section -->
  <div class="md:col-span-1">
    <div class="card bg-base-200 md:h-[calc(500px+theme(spacing.6)+180px)]" id="events-card">
      <div class="card-body flex flex-col h-full md:overflow-hidden">
        <h2 class="card-title text-2xl mb-4 mt-0 flex-shrink-0">Upcoming Events</h2>
        @if($upcomingEvents->isEmpty())
          <p class="text-base-content/70">No upcoming events in the next month. Check back soon!</p>
        @else
          <div class="space-y-4 flex-1 md:overflow-y-auto md:pr-2">
            @foreach($upcomingEvents as $event)
              @include('event_card_compact', ['event' => $event])
            @endforeach
          </div>
          <a href="{{ route('events') }}" class="btn btn-outline btn-sm mt-4 w-full flex-shrink-0">
            View All Events
          </a>
        @endif
      </div>
    </div>
  </div>
</div>

<style>
@media (min-width: 768px) {
  #home-grid {
    height: calc(100vh - var(--navbar-height, 64px) - var(--main-padding, 64px) - var(--footer-height, 120px));
    max-height: calc(100vh - var(--navbar-height, 64px) - var(--main-padding, 64px) - var(--footer-height, 120px));
  }
}
</style>

<script>
// Dynamically resize carousel and events card to fit viewport on medium+ screens
function resizeHomeContent() {
  // Only apply on medium and larger screens
  if (window.innerWidth < 768) return;

  const homeGrid = document.getElementById('home-grid');
  const carousel = document.getElementById('home-carousel');
  const eventsCard = document.getElementById('events-card');
  const header = document.getElementById('home-header');

  if (!carousel || !eventsCard || !header || !homeGrid) return;

  // Calculate actual heights
  const navbar = document.querySelector('.navbar');
  const navbarHeight = navbar ? navbar.offsetHeight : 64;
  const footer = document.querySelector('footer');
  const footerHeight = footer ? footer.offsetHeight : 120;
  const mainPadding = 64; // py-8 = 2rem top + 2rem bottom

  // Set CSS variables
  document.documentElement.style.setProperty('--navbar-height', `${navbarHeight}px`);
  document.documentElement.style.setProperty('--footer-height', `${footerHeight}px`);
  document.documentElement.style.setProperty('--main-padding', `${mainPadding}px`);

  const headerHeight = header.offsetHeight;
  const headerMargin = 24; // mb-6 = 1.5rem

  // Calculate carousel height based on grid height
  const gridHeight = homeGrid.offsetHeight;
  const carouselHeight = gridHeight - headerHeight - headerMargin;

  // Set minimum and maximum heights
  const minHeight = 300;
  const maxHeight = 1200;
  const finalHeight = Math.min(Math.max(carouselHeight, minHeight), maxHeight);

  // Apply heights
  carousel.style.height = `${finalHeight}px`;
  eventsCard.style.height = `${finalHeight + headerHeight + headerMargin}px`;
}

// Run on load and resize
window.addEventListener('load', resizeHomeContent);
window.addEventListener('resize', resizeHomeContent);
</script>
@endsection
