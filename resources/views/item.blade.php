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
					<li class="active">商店</li>
				</ol>
			</div>
		</div>
	@endif
		<div class="container">
			<h1>Test Lab</h1>
			<ul class="nav nav-tabs nav-justified">
				<li class="active"><a data-toggle = "tab" href="#item1">item1</a></li>
				<li><a data-toggle = "tab" href="#item2">item2</a></li>
				<li><a data-toggle = "tab" href="#item3">item3</a></li>
			</ul>
			<div class="tab-content">
				<div id="item1" class="tab-pane fade">
					<h3>item1</h3>
					<p>I'm item1</p>
				</div>
				<div id="item2" class="tab-pane fade">
					<h3>item2</h3>
					<p>Hello world!</p>
				</div>
				<div id="item3" class="tab-pane fade">
					<h3>item3</h3>
					<p>Are you?</p>
				</div>
			</div>
		</div>


@endsection

