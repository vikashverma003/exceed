<?php

function helperCheckPermission(string $permission){
	if(Auth::guard('admin')->user()->isAdmin()){
		return true;
	}else
	{
		$permission_id = \App\Models\Permission::where('title', $permission)->value('id');
		$permissions = Auth::guard('admin')->user()->permissions()->pluck('permission_id')->toArray();
		if(in_array($permission_id, $permissions)){
			return true;
        }else{
        	return false;
        }
	}
}