<div class="service_sction">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="service_txt">
                    <h2>
                        {{$cmsContent->services_title ?? 'Services'}}
                    </h2>
                    <p>
                        {{$cmsContent->services_sub_title ?? 'Browse Exceed Media Services'}}
                    </p>
                </div>
            </div>
            @php
                if($cmsContent->service_card_2==1 && $cmsContent->service_card_3==1){
                    $width = 'col-md-4';
                }
                else if($cmsContent->service_card_2==1 && $cmsContent->service_card_3!=1){
                    $width = 'col-md-6';
                }
                else if($cmsContent->service_card_2!=1 && $cmsContent->service_card_3==1){
                    $width = 'col-md-6';
                }
                else{
                    $width = 'col-md-12';
                }
            @endphp
            <div class="col wow zoomIn {{$width}}">
                <div class="orange_box orange_box_service">
                    <img src="{{asset('img/ic_training_1.svg')}}">
                    <span>{{$cmsContent->service_card_1_title ?? 'Training'}}</span>
                    @php
                        $first = 0;
                    @endphp
                    @foreach($cards as $row)
                        @if($row->card_number==1)
                            @if($first==0)
                                <div class="btn-type first-botto">
                                    <h2>
                                        <a href="{{url('/services/'.str_slug($row->title))}}" class="whiteColorAnchor">{{$row->title}}</a>
                                    </h2>
                                </div>
                            @else
                                <div class="btn-type">
                                    <h2>
                                        <a href="{{url('/services/'.str_slug($row->title))}}" class="whiteColorAnchor">{{$row->title}}</a>
                                    </h2>
                                </div>
                            @endif
                            @php $first++; @endphp
                        @endif
                    @endforeach
                </div>
            </div>
            @if($cmsContent->service_card_2==1)
                @php
                    if($cmsContent->service_card_3==1){
                        $width2 = 'col-md-4';
                    }
                    else{
                        $width2 = 'col-md-6';
                    }
                @endphp
                <div class="col wow zoomIn {{$width2}}">
                    <div class="orange_box orange_box_service green_light">
                        <img src="{{asset('img/ic_productions_2.svg')}}">
                        <span>{{$cmsContent->service_card_2_title ?? 'Productions'}}</span>
                        @php
                            $second = 0;
                        @endphp

                        @foreach($cards as $row)
                            @if($row->card_number==2)
                                @if($second==0)
                                    <div class="btn-type first-botto">
                                       <h2>
                                            <a href="{{url('/services/'.str_slug($row->title))}}" class="whiteColorAnchor">{{$row->title}}</a>
                                        </h2>
                                    </div>
                                @else
                                    <div class="btn-type">
                                        <h2>
                                        <a href="{{url('/services/'.str_slug($row->title))}}" class="whiteColorAnchor">{{$row->title}}</a>
                                    </h2>
                                    </div>
                                @endif
                                @php $second++; @endphp
                            @endif
                            
                        @endforeach
                    </div>
                </div>
            @endif

            @if($cmsContent->service_card_3==1)
                @php
                    if($cmsContent->service_card_2==1){
                        $width3 = 'col-md-4';
                    }
                    else{
                        $width3 = 'col-md-6';
                    }
                @endphp
                <div class="col wow zoomIn {{$width3}}">
                    <div class="orange_box orange_box_service blue-light">
                        <img src="{{asset('img/ic_consulting.svg')}}">
                        <span>{{$cmsContent->service_card_3_title ?? 'Consulting'}}</span>
                        @php
                            $third = 0;
                        @endphp
                        
                        @foreach($cards as $row)
                            @if($row->card_number==3)
                                @if($third==0)
                                    <div class="btn-type first-botto">
                                        <h2>
                                        <a href="{{url('/services/'.str_slug($row->title))}}" class="whiteColorAnchor">{{$row->title}}</a>
                                    </h2>
                                    </div>
                                @else
                                    <div class="btn-type">
                                       <h2>
                                        <a href="{{url('/services/'.str_slug($row->title))}}" class="whiteColorAnchor">{{$row->title}}</a>
                                    </h2>
                                    </div>
                                @endif
                                @php $third++; @endphp
                            @endif
                            
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
