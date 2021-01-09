<div id="demo1" class="collapse search_filter home_page_filter">
    <div class="container serch_filtss">
        <form name="advance_search_form" method="get" action="{{url('/products')}}">
            <div class="row">
                <div class="col col-md-6">
                    <div class="search_part filter_search">
                        <input type="search" class="search" placeholder="Search Course by name" name="course_name">
                    </div>
                </div>
                <div class="col col-md-3">
                    <div class="search_part filter_search celender_img">
                        <img src="{{asset('img/ic_calender.svg')}}">
                        <input type="text" class="search start-date" placeholder="From" name="start_date" readonly="true">
                    </div>
                </div>
                <div class="col col-md-3">
                    <div class="search_part filter_search celender_img">
                        <img src="{{asset('img/ic_calender.svg')}}">
                        <input type="text" class="search end-date" placeholder="To" name="end_date" readonly="true">
                    </div>
                </div>
                <div class="col col-md-12">
                    <div class="search_txt">
                        <p> You can make multiple selections by clicking on multiple entries in any selection list. Click again any of them to remove it from your selection.
                        </p>
                    </div>
                </div>
               <div class="col col-md-3 advanceFilter advance_filter_manufacturers">
                    <div class="manufacture_search-txt">
                        <h2>Manufacturers</h2>
                        <ul class="advance_filter_manufacturers_ul">
                            @foreach($manufacturers as $row)
                                <li data-id="{{$row->id}}" data-name="{{str_slug($row->name)}}" class="customhoverclass advanceFilterLi advance_filter_manufacturers_li" style="cursor: pointer;">{{ucfirst($row->name)}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col col-md-3 advanceFilter advance_filter_categories">
                    <div class="manufacture_search-txt">
                        <h2>Training Categories</h2>
                        <ul class="advance_filter_categories_ul">
                            @foreach($categories as $row)
                                <li data-id="{{$row->id}}" data-name="{{str_slug($row->name)}}" class="customhoverclass advanceFilterLi advance_filter_categories_li" style="cursor: pointer;">{{ucfirst($row->name)}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col col-md-3 advanceFilter advance_filter_courses">
                    <div class="manufacture_search-txt">
                        <h2>Courses</h2>
                        <ul class="advance_filter_courses_ul">
                            @foreach($courses as $row)
                                <li data-id="{{$row->id}}" data-name="{{str_slug($row->name)}}" class="customhoverclass advanceFilterLi advance_filter_courses_li" style="cursor: pointer;">{{ucfirst($row->name)}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col col-md-3 advanceFilter advance_filter_locations">
                    <div class="manufacture_search-txt">
                        <h2>Training Locations</h2>
                        <ul class="advance_filter_locations_ul">
                            @foreach($locations as $row)
                                <li data-name="{{$row->id}}" class="customhoverclass advanceFilterLi advance_filter_locations_li" style="cursor: pointer;">{{ucfirst($row->name)}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col col-md-12 text-right">
                    <div class="btn_filed">
                        <button type="button" class="btn btn-large clear_fild" data-toggle="collapse" class="advance_serch" data-target="#demo1">Hide</button>

                        <button type="button" class="btn btn-large clear_fild clear_advance_filter">Clear Fields</button>
                        
                        <button type="submit" class="btn btn-large clear_fild color_fill home_advance_filter_submit">Search</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
