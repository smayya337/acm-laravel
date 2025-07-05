@extends('layouts.app')

@section('title', 'HSPC - ACM @ UVA')

@section('content')
	<h1>HSPC</h1>
    <p>Every year, the largest High School Programming Contest (HSPC) in the Mid-Atlantic region takes place here at UVA.</p>
    <div>
        <a href="https://docs.google.com/document/d/1nun41JuAuGIfOWPgurogTc4Stgb6uwwXXfQY84RPbHc/edit?usp=sharing" class="btn pt-auto me-3 btn-primary">
                            <i class="fa fa-info-circle me-2"></i>
            Information
        </a>
        <a href="https://uvahspc2024.eventbrite.com/" class="btn pt-auto me-3 btn-secondary">
                            <i class="fa fa-user-plus me-2"></i>
            Register
        </a>
        <a href="mailto:hspc@virginia.edu" class="btn pt-auto me-3 btn-accent">
                            <i class="fa fa-envelope me-2"></i>
            Contact Us
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
            <h2>Frequently Asked Questions</h2>
            <div class="join join-vertical bg-base-100">
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="hspc-faq-accordion" />
                    <div class="collapse-title font-semibold">What are the contest rules?</div>
                    <div class="collapse-content text-sm">
                        <p>Rules can be found in the Logistics section of <a href="https://docs.google.com/document/d/1nun41JuAuGIfOWPgurogTc4Stgb6uwwXXfQY84RPbHc/edit?usp=sharing">this document</a>.</p>
                        <p>For further comments or questions, please email <a href="mailto:hspc@virginia.edu">hspc@virginia.edu</a>.</p>
                    </div>
                </div>
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="hspc-faq-accordion" />
                    <div class="collapse-title font-semibold">What are the versions of software used?</div>
                    <div class="collapse-content text-sm">
                        <p>Competitors will be allowed to use any IDE they choose. Our judging software will use the following language versions:</p>
                        <ul>
                            <li><code>g++</code> 5.4.0</li>
                            <li>Python 3 version 3.5.2</li>
                            <li>Java 8 (OpenJDK version 1.8.0_21)</li>
                        </ul>
                        <p>We will be using DomJudge to submit and judge solutions.</p>
                    </div>
                </div>
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="hspc-faq-accordion" />
                    <div class="collapse-title font-semibold">Are there any sample problems available?</div>
                    <div class="collapse-content text-sm">
                        <p>You can read past problem sets (PDF) and see full solutions with sample and judge input/output (zip) here:</p>
                        <ul class="list-unstyled">
                            <li>2025 (zip coming soon)&nbsp;(<a href="/data/2025-contest.pdf">pdf</a>)</li>
                            <li>2024 (zip coming soon)&nbsp;(<a href="/data/2024-contest.pdf">pdf</a>)</li>
                            <li>2023 (zip coming soon)&nbsp;(<a href="/data/2023-contest.pdf">pdf</a>)</li>
                            <li>2019 (<a href="/data/2019-problems.zip">zip</a>)&nbsp;(<a href="/data/2019-contest.pdf">pdf</a>)</li>
                            <li>2018 (<a href="/data/2018-problems.zip">zip</a>)&nbsp;(<a href="/data/2018-contest.pdf">pdf</a>)</li>
                            <li>2017 (<a href="/data/2017-problems.zip">zip</a>)&nbsp;(<a href="/data/2017-contest.pdf">pdf</a>)</li>
                            <li>2016 (<a href="/data/2016-problems.zip">zip</a>)&nbsp;(<a href="/data/2016-contest.pdf">pdf</a>)</li>
                            <li>2015 (<a href="/data/2015-problems.zip">zip</a>)&nbsp;(<a href="/data/2015-contest.pdf">pdf</a>)</li>
                            <li>2014 (<a href="/data/2014-problems.zip">zip</a>)&nbsp;(<a href="/data/2014-contest.pdf">pdf</a>)</li>
                            <li>2013 (<a href="/data/2013-problems.zip">zip</a>)&nbsp;(<a href="/data/2013-contest.pdf">pdf</a>)</li>
                            <li>2012 (<a href="/data/2012-problems.zip">zip</a>)&nbsp;(<a href="/data/2012-contest.pdf">pdf</a>)</li>
                            <li>2011 (<a href="/data/2011-problems.zip">zip</a>)&nbsp;(<a href="/data/2011-contest.pdf">pdf</a>)</li>
                        </ul>
                    </div>
                </div>
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="hspc-faq-accordion" />
                    <div class="collapse-title font-semibold">What reference materials will be available?</div>
                    <div class="collapse-content text-sm">
                        <p>During the contest, the following will be available electronically:</p>
                        <ul>
                            <li><a href="http://docs.oracle.com/javase/8/docs/">Java JDK 8 Docs</a> (<a href="http://docs.oracle.com/javase/8/docs/api/">api</a>)</li>
                            <li><a href="http://www.sgi.com/tech/stl/download.html">SGI's C++ STL Reference</a></li>
                            <li><a href="https://acm.cs.virginia.edu/data/viunix.html"></a></li>
                            <li>Language "cheat sheets" for both C++ and Java</li>
                            <li>Python 3 reference</li>
                            <li>Instructions for printing out code to work on</li>
                        </ul>
                    </div>
                </div>
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="hspc-faq-accordion" />
                    <div class="collapse-title font-semibold">What are the prizes like?</div>
                    <div class="collapse-content text-sm">
                        <p>Prizes are likely to include Amazon gift cards, board games, drones, and other similarly useful items.</p>
                    </div>
                </div>
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="hspc-faq-accordion" />
                    <div class="collapse-title font-semibold">What are the past results?</div>
                    <div class="collapse-content text-sm">
                        <p>Past results are unavailable while we port all of our data over to a new website. We hope to have results back shortly.</p>
                    </div>
                </div>
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="hspc-faq-accordion" />
                    <div class="collapse-title font-semibold">What is the computer configuration for the contest?</div>
                    <div class="collapse-content text-sm">
                        <p>Each team will have access to a single Linux environment with common IDEs, compilers, and editors installed. This computer will be shared by all team members.</p>
                    </div>
                </div>
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="hspc-faq-accordion" />
                    <div class="collapse-title font-semibold">Who can I contact if I still have questions?</div>
                    <div class="collapse-content text-sm">
                        <p>If you have any questions, please contact the HSPC contest director (<a href="mailto:hspc@virginia.edu">hspc@virginia.edu</a>).</p>
                    </div>
                </div>
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="hspc-faq-accordion" />
                    <div class="collapse-title font-semibold">Where do the teams come from?</div>
                    <div class="collapse-content text-sm">
                        <p>Teams come from all over Virginia. Some even come from Maryland once in a while.</p>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <h2>Our Plan for 2024</h2>
            <p>This year, we plan to host HSPC in person at UVA! All the information needed for the event can be found in the packet linked <a href="https://docs.google.com/document/d/19odkSbUa6XsJ60uxfE6PVteG_Wqu1Su3yDoympKFjxI/edit">here</a>.</p>
            <h2>Want to help out?</h2>
            <p>HSPC is run by UVA students! If you are a current or graduated UVA student and want to help inspire high school students, let us know at <a href="mailto:hspc@virginia.edu">hspc@virginia.edu</a> or join our <a href="https://discord.gg/wxWgbVs">Discord server</a> and type <code>!hspc</code>. Thank you! </p>
        </div>
        <div>
            <h2>Sponsorship</h2>
            <p>
                If you are interested in sponsoring the contest, and encouraging high school students to pursue computing, please email <a href="mailto:hspc@virginia.edu">hspc@virginia.edu</a>.
            </p>
            <h2>Registration</h2>
            <div class="join join-vertical bg-base-100">
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="hspc-registration-accordion" />
                    <div class="collapse-title font-semibold">Where do I register?</div>
                    <div class="collapse-content text-sm">
                        <p>Previous year's coaches should receive an email from us asking about registration. If you do not receive an email or are a new team interested in participating, please register <a href="https://uvahspc2024.eventbrite.com/">here</a>.</p>
                    </div>
                </div>
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="hspc-registration-accordion" />
                    <div class="collapse-title font-semibold">What do I need to know about registration?</div>
                    <div class="collapse-content text-sm">
                        <p>Each team consists of up to three students and one coach. Registration costs $40 per team. Each school may register up to three teams.</p>
                    </div>
                </div>
                <div class="collapse collapse-arrow join-item border-base-300 border">
                    <input type="radio" name="hspc-registration-accordion" />
                    <div class="collapse-title font-semibold">Is financial assistance available?</div>
                    <div class="collapse-content text-sm">
                        <p>We know that the cost of attendance for our competition may be prohibitive for some schools. If your school is interested in participating but is prevented by the cost, please let our HSPC Contest Chair know by email at <a href="mailto:hspc@virginia.edu">hspc@virginia.edu</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 