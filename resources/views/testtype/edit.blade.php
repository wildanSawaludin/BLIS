@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
            <li><a href="{!! route('testtype.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.test-type', 2) !!}</a></li>
            <li class="active">{!! trans('action.edit').' '.trans_choice('menu.test-type', 1) !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-edit"></i> {!! trans('action.edit').' '.trans_choice('menu.test-type', 1) !!} 
		    <span>
				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
					<i class="fa fa-step-backward"></i>
					{!! trans('action.back') !!}
				</a>				
			</span>
		</div>
	  	<div class="card-block">	  		
			<!-- if there are creation errors, they will show here -->
			@if($errors->all())
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
            </div>
            @endif

			{!! Form::model($testtype, array('route' => array('testtype.update', $testtype->id), 
				'method' => 'PUT', 'id' => 'form-edit-test-type')) !!}
				<!-- CSRF Token -->
                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
                <!-- ./ csrf token -->
				<div class="form-group row">
					{!! Form::label('name', trans_choice('terms.name', 1), array('class' => 'col-sm-2 form-control-label')) !!}
					<div class="col-sm-6">
						{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('description', trans("terms.description"), array('class' => 'col-sm-2 form-control-label')) !!}</label>
					<div class="col-sm-6">
						{!! Form::textarea('description', old('description'), array('class' => 'form-control', 'rows' => '2')) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('test_category_id', trans_choice('menu.lab-section', 1), array('class' => 'col-sm-2 form-control-label')) !!}
					<div class="col-sm-6">
						{!! Form::select('test_category_id', $testcategories, old('testcategory') ? old('testcategory') : $testcategory, array('class' => 'form-control c-select')) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('specimen_types', trans_choice('menu.specimen-type', 2),  array('class' => 'col-sm-2 form-control-label')) !!}
				</div>					
				<div class="col-md-12 card card-block">
					@foreach($specimentypes as $key=>$value)
						<div class="col-md-3">
							<label  class="checkbox">
								<input type="checkbox" name="specimentypes[]" value="{!! $value->id!!}" 
									{!! in_array($value->id, $testtype->specimenTypes->lists('id')->toArray())?"checked":"" !!} />
									{!!$value->name !!}
							</label>
						</div>
					@endforeach
				</div>
				<div class="form-group row">
					{!! Form::label('measures', trans_choice('menu.measure', 2),  array('class' => 'col-sm-2 form-control-label')) !!}
				</div>
				<div class="form-group row">
					<div class="measure-container">
					@include("measure.edit")
					</div>
					<a class="btn btn-sm btn-belize-hole add-another-measure" href="javascript:void(0);" data-new-measure="1">
				        	<i class="fa fa-plus-circle"></i></i> {!! trans('action.new').' '.trans_choice('menu.measure', 1) !!}</a>
				</div>
				<div class="form-group row">
					{!! Form::label('targetTAT', trans('terms.target-tat'), array('class' => 'col-sm-2 form-control-label')) !!}
					<div class="col-sm-6">
						{!! Form::text('targetTAT', old('targetTAT'), array('class' => 'form-control')) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('prevalence_threshold', trans('terms.prevalence-threshold'), array('class' => 'col-sm-2 form-control-label')) !!}
					<div class="col-sm-6">
						{!! Form::text('prevalence_threshold', old('prevalence_threshold'), array('class' => 'form-control')) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('culture-worksheet', trans('terms.culture-worksheet'), array('class' => 'col-sm-2 form-control-label')) !!}
					<div class="col-sm-6">
						<?php if(count($testtype->organisms)>0){$checked=true;} else{$checked=false;} ?>
						{!! Form::checkbox(trans('terms.culture-worksheet'), "1", $checked, array('onclick'=>'toggle(".organismsClass", this)')) !!}
					</div>
				</div>
				<div class="form-group row organismsClass" <?php if($checked==true){ ?>style="dispaly:block;"<?php }else{ ?>style="display:none;"<?php } ?>>
					{!! Form::label('organisms', trans_choice('menu.organism', 2), array('class' => 'col-sm-2 form-control-label')) !!}
					<div class="col-sm-offset-2 col-sm-10 list-group list-group-flush">	
						<div class="row">
						@foreach($organisms as $key=>$val)
							<div class="col-md-3">
								<label  class="checkbox">
									<input type="checkbox" name="organisms[]" value="{!! $val->id!!}" 
										{!! in_array($val->id, $testtype->organisms->lists('id')->toArray())?"checked":"" !!} >
										{!! $val->name !!}
								</label>
							</div>
						@endforeach
						</div>
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('orderable_test', trans('terms.lab-ordered'), array('class' => 'col-sm-2 form-control-label')) !!}
					<div class="col-sm-6">	
						{!! Form::checkbox('orderable_test', 1, old('orderable_test'), array('class' => '')) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('accredited', trans('terms.accredited'), array('class' => 'col-sm-2 form-control-label')) !!}
					<div class="col-sm-6">
						{!! Form::checkbox('accredited', "1", $testtype->isAccredited(), array('class' => '')) !!}
					</div>
				</div>
				<div class="form-group row col-sm-offset-2">
					{!! Form::button("<i class='fa fa-check-circle'></i> ".trans('action.update'), 
						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
				</div>

			{!! Form::close() !!}
	  	</div>
	</div>
</div>
@include("measure.measureinput")
@endsection