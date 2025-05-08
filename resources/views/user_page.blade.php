@extends('app')

{{-- Define a title for the page, if your base layout supports it --}}
@section('title', $req_user->first_name . ' ' . $req_user->last_name . ' - Profile')

@section('content')
    <div class="container mx-auto px-4 py-6 sm:py-8">
        <div class="flex flex-col md:flex-row gap-x-6 lg:gap-x-8 gap-y-5">
            {{-- Profile Image Column --}}
            {{-- TODO: make this image more mobile-friendly (Tailwind classes help, but content of partial matters) --}}
            <div class="w-full md:w-auto md:max-w-xs lg:max-w-sm flex-shrink-0 text-center md:text-left">
                {{--                 Pass the user object to the partial. Ensure this partial uses Tailwind.--}}
                @include('profile_image', ['user' => $req_user])
            </div>

            {{-- Profile Info Column --}}
            <div class="flex-grow">
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-3">
                    <h1 class="text-3xl lg:text-4xl font-bold">{{ $req_user->first_name }} {{ $req_user->last_name }}</h1>
                    <a href="mailto:{{ $req_user->email }}"
                       title="Email {{ $req_user->first_name }} {{ $req_user->last_name }}"
                       class="p-2.5 rounded-full border border-base-300 hover:bg-base-200 transition duration-150 ease-in-out self-start sm:self-center">
                        {{-- Using a common SVG icon for email (e.g., Heroicons MailIcon) --}}
                        {{-- TODO: replace with a font icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-neutral-content" viewBox="0 0 512 512"
                             fill="currentColor">
                            <path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48L48 64zM0 176L0 384c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-208L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/>
                        </svg>
                    </a>
                </div>

                {{-- Bio --}}
                @if($req_user->bio)
                    <div class="prose prose-sm sm:prose-base max-w-none mb-4 text-base-content/80">
                        {!! Str::markdown($req_user->bio, ['html_input' => 'escape', 'allow_unsafe_links' => false]) !!}
                    </div>
                @endif

                {{-- Edit Profile Button --}}
                {{-- Check if the authenticated user is viewing their own profile --}}
                @can('update', $req_user)
                    {{-- DaisyUI modal is triggered by a label pointing to a checkbox id --}}
                    <label for="profileModal" class="btn btn-primary">
                        Edit profile
                        {{-- Using a common SVG icon for edit (e.g., Heroicons PencilIcon) --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                             fill="currentColor">
                            <path
                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                        </svg>
                    </label>
                @endcan
            </div>
        </div>

        {{-- Achievements Section --}}
        {{--        @if($badges && count($badges) > 0)--}}
        {{--            <div class="pt-6 mt-6 border-t border-base-300">--}}
        {{--                <h2 class="text-2xl font-semibold mb-4">Achievements</h2>--}}
        {{--                <div class="flex flex-wrap gap-3 sm:gap-4">--}}
        {{--                    --}}{{-- Loop through badges and include the badge partial --}}
        {{--                    --}}{{-- Ensure 'partials.badge' is also converted to Tailwind/DaisyUI --}}
        {{--                    @foreach($badges as $badge)--}}
        {{--                        @include('partials.badge', ['badge' => $badge])--}}
        {{--                    @endforeach--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        @endif--}}

        {{-- Events Attended Section --}}
        {{--        @if($events_attended && count($events_attended) > 0)--}}
        {{--            <div class="pt-6 mt-6 border-t border-base-300">--}}
        {{--                <h2 class="text-2xl font-semibold mb-4">Events Attended</h2>--}}
        {{--                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6 pb-3">--}}
        {{--                    --}}{{-- Loop through events and include the event card partial --}}
        {{--                    --}}{{-- Ensure 'partials.profile_event_card' is converted --}}
        {{--                    @foreach($events_attended as $evt)--}}
        {{--                        @include('partials.profile_event_card', ['event' => $evt])--}}
        {{--                    @endforeach--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        @endif--}}
    </div>

    {{-- Modal for Editing Profile (DaisyUI) --}}
    @can('update', $req_user)
        <input type="checkbox" id="profileModal" class="modal-toggle"/>
        <div class="modal modal-bottom sm:modal-middle">
            <div class="modal-box">
                <form method="POST" action="{{ route('user_page.update', ['user' => $req_user]) }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="flex justify-between items-center pb-3 mb-4 border-b border-base-300">
                        <h3 class="font-bold text-xl" id="profileModalLabel">Edit Profile</h3>
                        <label for="profileModal"
                               class="btn btn-sm btn-circle btn-ghost absolute right-3 top-3">✕</label>
                    </div>

                    <div class="space-y-4">
                        <div class="form-control w-full">
                            <fieldset class="fieldset">
                                <legend class="fieldset-legend">Bio</legend>
                                <textarea name="bio" class="textarea h-32 w-full @error('bio') textarea-error @enderror"
                                          placeholder="Tell us about yourself...">{{ old('bio', $req_user->bio) }}</textarea>
                                <div class="label">Optional.</div>
                            </fieldset>
                            @error('bio')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                            @enderror
                        </div>
                        <div class="form-control w-full">
                            <fieldset class="fieldset">
                                <legend class="fieldset-legend">Profile Image</legend>
                                <input name="profile_image" type="file"
                                       class="file-input file-input-primary w-full @error('profile_image') file-input-error @enderror"/>
                                <label class="label">Optional. Max size 2MB.</label>
                            </fieldset>
                            @error('profile_image')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-action mt-6">
                        <label for="profileModal" class="btn btn-ghost">Cancel</label>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
            <label class="modal-backdrop" for="profileModal">Close</label>
        </div>
    @endcan

@endsection

{{--@push('scripts')--}}
{{--    --}}{{-- Add any page-specific JavaScript here if needed --}}
{{--    --}}{{-- For example, if you want to clear file input on modal close, or other enhancements. --}}
{{--    <script>--}}
{{--        // document.addEventListener('DOMContentLoaded', function () {--}}
{{--        //     const profileModalCheckbox = document.getElementById('profileModal');--}}
{{--        //     if (profileModalCheckbox) {--}}
{{--        //         // Example: Clear file input when modal is closed--}}
{{--        //         const fileInput = document.getElementById('profile_image_upload');--}}
{{--        //         profileModalCheckbox.addEventListener('change', function() {--}}
{{--        //             if (!this.checked && fileInput) {--}}
{{--        //                 // fileInput.value = ''; // This might not be straightforward for all browsers or desired--}}
{{--        //             }--}}
{{--        //         });--}}
{{--        //     }--}}
{{--        // });--}}
{{--    </script>--}}
{{--@endpush--}}
