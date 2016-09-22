@extends('layouts.main')

@section('title','商城')

@section('dialog')
@endsection

@section('content')

@if (Auth::guest())
		<div class="container-fluid">
			<br>
			@include('layouts.partials.dialog',['dialogs' => $dialogs])
		</div>
	@elseif (Auth::user()->activation == 'false')
		<div class="alert alert-danger">
			唔喔！還沒完成「認證」的話，無法使用完整的Mission Life喔！點擊<a href="{{ url('/active') }}">這裡</a>完成認證吧！
		</div>
	@else
		<div class="container">
			<div class="row">
				<ol class="breadcrumb">
					<li><a href="{{ url('/') }}">首頁</a></li>
					<li class="active">任務大廳</li>
				</ol>
			</div>
		</div>
	@endif


@endsection

