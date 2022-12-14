<div class="row" id="edit" style="display:none">
  <div class="col-md-12">
    <!--begin::Portlet-->
    <div class="kt-portlet">
      {{ Form::open(array('method'=>'PATCH','url' => route('unit.update',0), 'id'=>'form-update' )) }}
        <div class="kt-form kt-form--label-right">
          <div class="kt-portlet__body ">
            <div class="row">
              <div class="form-group row col-md-12">
                <label for="c_slug" class="col-2 col-form-label">Unit Name</label>
                <div class="col-10">
                  <input class="form-control" name="name" type="text" value="" id="e_name">
                  @error('name')
                    <div class="form-text text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="text-center">
              <button onclick="$('#edit').hide('500');" type="button" class="btn btn-default">@lang('global.app_cancel')</button>
              <button class="btn btn-success" type="submit">@lang('global.app_update')</button>
            </div>
          </div>
        </div>
      {{ Form::close() }}
    </div>
    <!--end::Portlet-->
  </div>
</div>
