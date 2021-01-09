@extends('frontend.layouts.app')
@section('title', 'About Us')


@section('content')

    @include('frontend.layouts.header')

   <div class="main_section about_page">
        <div class="bk_image">
            <div class="container">
                <div class="row">
                    <div class="traning-txt">
                        <h2>Improving Lives Through Learning</h2>
                    </div>
                </div>
            </div>
        </div>


        <div class="exced-media">
            <div class="container">
                <div class="row">
                    <div class="col col-md-12">
                        <div class="about_learning">
                            <p>Exceed Media, established in 2010, is based in Toronto. Exceed Media offers Authorized
                                Training from Apple, Adobe, Avid and Autodesk in digital media content creation,
                                production and post production.</p>

                        </div>

                        <div class="exceed_bottom-txt">
                            <h3>Exceed Media services are available in the Middle East and North Africa (United Arab
                                Emirates, Dubai. Qatar, Doha. Turkey, Istanbul. Kingdom Of Saudi Arabia, Kuwait, Oman,
                                Bahrain, Jordan, Lebanon, Oman, Pakistan, Egypt, Algeria, Morocco and Tunisia ).</h3>
                        </div>

                    </div>
                    <div class="exceed-media">
                        <h2>Exceed Media is known for its high quality training, serving the following business sectors:
                        </h2>
                    </div>
                    <div class="col-md-4 col">
                        <div class="media-txt">
                            <p>Companies working in media content creation in ( video production TV Broadcast and
                                Cinema, Print media,Radio Broadcast and New media as of mobile applications and Apple &
                                Android operation system).</p>
                        </div>
                    </div>
                    <div class="col-md-4 col">
                        <div class="media-txt">
                            <p>Companies working in media content creation in ( video production TV Broadcast and
                                Cinema, Print media,Radio Broadcast and New media as of mobile applications and Apple &
                                Android operation system).</p>
                        </div>
                    </div>
                    <div class="col-md-4 col">
                        <div class="media-txt" style="min-height: 278px">
                            <p>io Broadcast and New media as of mobile applications and Apple & Android operation
                                system). &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br></p>
                        </div>
                    </div>

                    <div class="excedd-bottm-txt">
                        <p>by partnering with prominent training centres and freelance professionals from around the
                            world. Its focus is providing its clients with TRAINING FOR CHANGE, that helps organizations
                            and individuals improved efficiency and creativity within the job environment.</p>
                    </div>

                    <div class="both-exceed-part">
                        <div class="left-exceed-img">
                            <img src="{{asset('img/banner_bg.png')}}">
                        </div>



                        <div class="right-exceed-txt">
                            <p>Exceed Media team firmly believes that quality training has no limitations in terms of
                                location, time differences and distances. Our training and hands-on skills are designed
                                to empower our clients to achieve their business goals wherever they are.</p>
                        </div>
                    </div>

                    <div class="col col-md-12">
                        <div class="ul-exceed-par">
                            <h2>Exceed Media provides unique training solutions developed around clients’ training
                                needs:</h2>
                            <ul>
                                <li>• We employ the industry’s leading instructors </li>
                                <li>• Our Development department focuses on developing alliances and partnerships to
                                    continue to provide top quality training to our clients.</li>
                                <li>• We offer certified course material and Certified Instructors</li>
                                <li>• We offer training needs analysis and customized training content to meet training
                                    goals.</li>
                                <li>• Our training services are available onsite in 19 Arab countries</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col col-md-12">
                        <div class="ceo-section">
                            <p>Exceed Media is committed to develop training high quality solutions in Digital Media
                                content creation by offering training courses, training workshops and conferences in the
                                Middle East and North Africa.</p>

                            <p> Mohamad Khasraw, CEO of Exceed Media has over 15 years of training experience in the
                                Middle East. In 1999 he established a new branch for New Horizons learning center in Abu
                                Dhabi. In 2006 he established a new business venture “Applied Digital Media Services”
                                based in Knowledge Village in Dubai specialized in digital media content creation
                                training.</p>

                            <p>In 2015 Exceed Media has invested in acquisition the master franchise of Future Media
                                Concepts (www.FMCtraining.com) in the Middle East and North Africa for all their
                                business activities. FMC is Apple, Adobe, Avid, Autodesk and NewTek Authorized Training
                                Center established in 1994 with nine branches in USA and Canada.</p>
                        </div>
                    </div>

                    <div class="excedd-bottm-txt">
                        <p>Exceed Media plans are to start immediately offering training classes and events in United
                            Arab Emirates, Dubai city and to follow Qatar, Doha and Turkey, Istanbul.</p>
                    </div>


                </div>
            </div>
        </div>

    </div>
    @include('frontend.layouts.footer',['homeFooter'=>0])
    @include('frontend.includes.contact-us')
@endsection