@extends('app')

@section('content')
    <h1>ICPC</h1>
    <p>The International Collegiate Programming Contest is a problem-solving competition for undergraduates.</p>
    <div class="grid grid-cols-3 gap-4">
        <div>
            <h2>World Finals Appearances</h2>
            <div class="join join-vertical bg-base-100">
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="my-accordion-4" checked="checked" />
                    <div class="collapse-title font-semibold">2024: Astana, Kazakhstan</div>
                    <div class="collapse-content text-sm">The team of Chase Hildebrand, Richard Wang, and Nicholas Winschel (with coach Charles Reiss) competed
                        in the world finals in Astana, Kazakhstan in September 2024.</div>
                </div>
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="my-accordion-4" />
                    <div class="collapse-title font-semibold">2023: Luxor, Egypt</div>
                    <div class="collapse-content text-sm">The team of Edward Lue, Richard Wang, and Nicholas Winschel (with coach Mark Floryan) advanced
                        to the world finals in Luxor, Egypt in April 2024.</div>
                </div>
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="my-accordion-4" />
                    <div class="collapse-title font-semibold">2016: Phuket, Thailand</div>
                    <div class="collapse-content text-sm">The team of Andrew Norton, Derek Morris, and Alec Grieser (with coaches Aaron Bloomfield and
                        Mark Floryan) earned first place in the mid-Atlantic region to automatically advance to the
                        world finals in Phuket, Thailand in June 2016.</div>
                </div>
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="my-accordion-4" />
                    <div class="collapse-title font-semibold">2014: Yekaterinburg, Russia</div>
                    <div class="collapse-content text-sm">The team of Kevin Zhang, Leiqing Cai, and Jinyan Liu (with coach Aaron Bloomfield) earned first
                        place in the mid-Atlantic region to automatically advance to the world finals in Yekaterinburg,
                        Russia, in June 2014.</div>
                </div>
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="my-accordion-4" />
                    <div class="collapse-title font-semibold">2013: St. Petersburg, Russia</div>
                    <div class="collapse-content text-sm">The team of Neal Milstein, Carson Wang, and Derek Morris (with coach Aaron Bloomfield) qualified
                        for the world finals in St. Petersburg, Russia, in July 2013.</div>
                </div>
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="my-accordion-4" />
                    <div class="collapse-title font-semibold">2011: Orlando, Florida, USA</div>
                    <div class="collapse-content text-sm">The team of Kristine Collins, Daniel Epstein, and Adelin Miloslavov (with coach Aaron
                        Bloomfield) qualified for the world finals in Orlando, Florida, in May 2011.</div>
                </div>
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="my-accordion-4" />
                    <div class="collapse-title font-semibold">2010: Harbin, China</div>
                    <div class="collapse-content text-sm">The team of Calvin Li, Briana Satchell, and George Washington (with coach Aaron Bloomfield)
                        qualified for the world finals in Harbin, China, in February 2010.</div>
                </div>
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="my-accordion-4" />
                    <div class="collapse-title font-semibold">2009: Stockholm, Sweden</div>
                    <div class="collapse-content text-sm">The team of Calvin Li, Briana Satchell, and George Washington (with coach Aaron Bloomfield)
                        qualified for the world finals in Stockholm, Sweden, in April, 2009.</div>
                </div>
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="my-accordion-4" />
                    <div class="collapse-title font-semibold">2003: Beverly Hills, California, USA</div>
                    <div class="collapse-content text-sm">A team qualified for the world finals in March 2003 in Beverly Hills, California.</div>
                </div>
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="my-accordion-4" />
                    <div class="collapse-title font-semibold">2001: Vancouver, Canada</div>
                    <div class="collapse-content text-sm">The team of Peff King, Brian Clarke, and Carsten Clark (and coach Jane Prey) qualified for the
                        world finals in March 2001 in Vancouver, Canada.</div>
                </div>
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="my-accordion-4" />
                    <div class="collapse-title font-semibold">1999: Eindhoven, The Netherlands</div>
                    <div class="collapse-content text-sm">The team of Patrick Reynolds, Peff King, and Dick Eppink qualified for the world finals in April
                        1999 in Eindhoven, the Netherlands.</div>
                </div>
            </div>
        </div>
        <div>
            <h2>What is ICPC?</h2>
            <p>
                The International Collegiate Programming Contest is the most well-known competitive programming contest
                in the world. Each year over 30,000 contestants, comprising more than 10,000 teams from thousands of
                institutions, compete in regional contests in the fall. The top 100 (or so) teams then advance to the
                world finals, which is held throughout the world in the spring or early summer.</p>
            <p>Over the past 25 years, UVA has qualified for the world finals ten times.</p>
            <p>
                You can read more about ICPC <a
                    href="https://en.wikipedia.org/wiki/International_Collegiate_Programming_Contest">here</a>.
            </p>
        </div>
        <div>
            <h2>Get Involved!</h2>
            <p>
                Each year, UVA sends ten teams (of three contestants each) to the regional contests, which are in late
                October or early November. Anybody may participate; undergraduate students of all levels and first year
                graduate students are allowed to compete. Teams start practicing as soon as the fall semester begins in
                late August. If you are interested in getting involved, you can contact Charles Reiss (cr4bd), the coach
                of UVA's ICPC teams.
            </p>
        </div>
    </div>
@endsection
