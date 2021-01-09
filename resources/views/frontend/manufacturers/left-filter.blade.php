<h2 style="padding: 12px;background: #efa91f2e;margin-bottom: 0;font-size: 20px;">
	Training Categories 
</h2>


@foreach(@$all_categories as $row)
	<h2 data-toggle="collapse" href="#collapseCategory{{$row->id}}" style="cursor: pointer; margin-bottom: 0px;border-bottom: 1px solid #ddd;" class="top_heading_class collapsed" aria-expanded="false">
		<strong style="font-size: 14px;">
			{{strtoupper($row->name)}}
		</strong>
		<span class="plus-sign float-right">^</span>
		<span class="minus-sign float-right">^</span>
	</h2>
	<div class="collapse" id="collapseCategory{{$row->id}}">
		<div>
		    @php
                $manufacturersAvail = \App\Models\Product::where('status', 1)->where('category_id', $row->id)->where('manufacturer_id', $manufacturerdata->id)->get(); 
            @endphp

            @if($manufacturersAvail->count())
                <ul class="pl-3">
                    @foreach($manufacturersAvail as $subrow)
                        <li>
                            <label style="cursor: pointer;">
                            	<input type="checkbox" 
                            	name="courses[]" 
                            	value="{{$subrow->id}}"
	                            data-categoryid="{{$row->id}}"
	                            class="mr-2 productLeftFilter leftFilter" >
                            	{{ucfirst($subrow->name)}}
                            </label>
                        </li>
                    @endforeach
                </ul>
            @endif
		</div>
	</div>
@endforeach