<h2>Leadership</h2>
<div class="mx-auto mt-8 flex w-full flex-wrap justify-center gap-8 bg-base-200 p-8 rounded-box">
    @foreach($officers as $officer)
        @include('officer_card', ['officer' => $officer])
    @endforeach
</div>