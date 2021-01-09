<footer class="footer_section  home-page-footer">
    <div class="top-footer">
        <div class="container">
            <div class="row">
                <div class="col col-md-4">
                    <div class="logo_box">
                        <img src="{{asset('img/main_footer_logo.svg')}}">
                        <p>Beyond the branch offices, Exceed Media is a leading producer of educational conferences
                            for the film, television, video and web industries..
                        </p>
                        <h2 class="copy_right">Copyright © {{date('Y')}} All right Reserved - Exceed Media</h2>
                    </div>
                </div>
                <div class="col col-md-2">
                    <div>
                        <div class="div_left">
                            <h2>Links</h2>
                            <ul>
                                <li>
                                    @if(url()->current()==url('about-us'))
                                        <a href="{{url('about-us')}}" class="footerAnchor" style="color: #efa91e !important;">About Us</a>
                                    @else
                                        <a href="{{url('about-us')}}" class="footerAnchor">About Us</a>
                                    @endif 
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="showContactUsModal();" class="footerAnchor">Contact Us</a> 
                                   
                                </li>
                                <li>
                                    @if(url()->current()==url('gallery'))
                                        <a href="{{url('gallery')}}" class="footerAnchor" style="color: #efa91e !important;">Gallery</a>
                                    @else
                                        <a href="{{url('gallery')}}" class="footerAnchor">Gallery</a>
                                    @endif 
                                    
                                </li>
                                <li>
                                    @if(url()->current()==url('press-release'))
                                        <a href="{{url('press-release')}}" class="footerAnchor"  style="color: #efa91e !important;">Press Release</a>
                                    @else
                                        <a href="{{url('press-release')}}" class="footerAnchor">Press Release</a>
                                    @endif 
                                </li>
                                <li>
                                    @if(url()->current()==url('help'))
                                        <a href="{{url('help')}}" class="footerAnchor"  style="color: #efa91e !important;">Help</a>
                                    @else
                                        <a href="{{url('help')}}" class="footerAnchor">Help</a>
                                    @endif 
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col col-md-3">
                    <div class="div_left last">
                        <h2>Contact Us</h2>
                        <ul>
                            <li>
                            	<img src="{{asset('img/ic_call.svg')}}"><span>+1 (289) 799-9301</span>
                            </li>
                            <li>
                                <img src="{{asset('img/ic_email.svg')}}">
                                <span>
                                    <a href="mailto:media-training@exceed-media.com?subject=Exceed Media Course Enquiry" class="footerAnchor">media-training@exceed-media.com</a>
                                </span>
                            </li>
                            <li>
                            	<img src="{{asset('img/ic_location.svg')}}"><span>1 Yonge St. Suite 1801 Toronto Star Building
                                Toronto M5E 1W7 Ontario, Canada</span>
                            </li>
                            
                        </ul>
                    </div>
                </div>
                <div class="col col-md-3">
                    <div class="div_left last">
                        <h2>UAE Locations</h2>
                        <ul>
                            <li>
                                <img src="{{asset('img/ic_location.svg')}}">
                                <span>
                                    Locations UAE – Dubai, Concord Tower floor 22 office 2003 phone +9714 381 3926
                                </span>
                            </li>
                             <li>
                                <img src="{{asset('img/ic_location.svg')}}">
                                <span>
                                    UAE – Abu Dhabi Media Zone - Abu Dhabi twofour54 Office 502F Building 5
                                    P.O.Box 77915, Abu Dhabi, UAE
                                    Office: +9712 634 9121
                                    Cell Phone: + 97150 609 8484
                                    working hours from 8 am to 5pm Abu Dhabi time zone 
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p><a href="{{url('/terms')}}" style="color: #2C2C2C;">Terms & Conditions</a></p>
                    <p><a href="{{url('/privacy-policy')}}" style="color: #2C2C2C;">Privacy Policy</a> and <a href="{{url('/cookie-policy')}}" style="color: #2C2C2C;">Cookie Policy</a></p>
                </div>
                <div class="col-md-6 text-right">
                    <div class="footer_right-txt">
                        <h2><img src="">English</h2>
                        <div class="div_right social">
                            <ul>
                                <li><a href="https://www.facebook.com/exceed.media.training" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                <li><i class="fa fa-twitter" style="margin: 0 10px;"></i></li>
                                <li><i class="fa fa-linkedin"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
@include('frontend.layouts.bottom-fixed')