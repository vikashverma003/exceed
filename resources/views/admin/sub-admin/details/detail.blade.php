<div class="row">
    <div class="col-md-12">
        <div class="portlet box blue" id="stage_show">
            <div class="portlet-title">
                <div class="caption ">
                    Status
                </div>
            </div>
            <div class="portlet-body stage-col-main">
                <div class="col-md-3">
                    <div class="general-item-list">
                        <div class="item">
                            <div class="item-head">
                                <div class="item-details">
                                    User Role
                                </div>
                            </div>
                            <div class="item-body">
                                <span class="badge badge-success">{{$user->role_name}}</span></div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet box blue">

            <div class="portlet-title">
                <div class="caption">User Information</div>
            </div>

            <div class="portlet-body">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tbody>
                        <tr>
                            <td>
                                <strong>Name:</strong>
                            </td>
                            <td>
                                {{ $user->name ?? 'N/A'}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Email:</strong>
                            </td>
                            <td>
                                {{ $user->email ?? 'N/A'}}
                            </td>
                        </tr>
                        
                        </tbody>
                    </table>
                </div>
                
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>

        </div>

    </div>
</div>

<div class="clearfix"></div>

