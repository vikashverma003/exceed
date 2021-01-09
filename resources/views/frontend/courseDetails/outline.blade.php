<div class="accordion" id="accordionExample">
    @php
        $outline = 1;
    @endphp
    @foreach(@$course->outlines as $row)
        @if($outline==1)
            <div class="card">
                <div class="card-header" id="heading{{$outline}}" data-toggle="collapse" data-target="#collapse{{$outline}}" aria-expanded="true" aria-controls="collapse{{$outline}}">
                    <h5 class="mb-0" style="text-align: center;">
                        <button class="btn btn-link stleClassColor" type="button">
                            {{$row->title}}
                        </button>
                    </h5>
                </div>

                <div id="collapse{{$outline}}" class="collapse show" aria-labelledby="heading{{$outline}}" data-parent="#accordionExample">
                    <div class="card-body">
                        {!! $row->description!!}
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        @else
            <div class="card">
                <div class="card-header" id="heading{{$outline}}" data-toggle="collapse" data-target="#collapse{{$outline}}" aria-expanded="false" aria-controls="collapse{{$outline}}">
                    <h5 class="mb-0" style="text-align: center;">
                        <button class="btn btn-link collapsed stleClassColor" type="button">
                         {{$row->title}}
                        </button>
                    </h5>
                </div>
                <div id="collapse{{$outline}}" class="collapse" aria-labelledby="heading{{$outline}}" data-parent="#accordionExample">
                    <div class="card-body">
                        {!! $row->description!!}
                    </div>
                </div>
            </div>
        @endif
        @php
            $outline++;
        @endphp
    @endforeach
</div>