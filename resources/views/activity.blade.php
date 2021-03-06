@extends('layouts.main')

@section('title','任務大廳 - 活動')

@section('dialog')
@endsection

@section('content')
	
	@if (Auth::guest())
		<div class="container-fluid">
			<!--<img class="img-responsive center-block" style="width:100%" alt="Responsive image" src="http://i.imgur.com/WL6lmMz.jpg"></img>-->
			<br>
			@include('layouts.partials.dialog',['dialogs' => $dialogs])
		</div>
	@elseif (Auth::user()->activation == 'false')
		<div class="alert alert-danger">
			唔喔！還沒完成「認證」的話，無法使用完整的Mission Life喔！點擊<a href="{{ url('/active') }}">這裡</a>完成認證吧！
		</div>
	@else
		@for($i=0; $i < count($quests); $i++)
		<div class="modal fade" id="quest{{$i}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        				<h3 class="modal-title text-center" id="myModalLabel">任務詳細資訊</h3>
      				</div>
      				<div class="modal-body">	
      					<table class="table ">
      						<tr>
      							<td class="col-md-3">任務標題</td>
      							<td>{{ $quests[$i]->name }}</td>
      						</tr>
      						<tr>
      							<td>發佈單位</td>
      							<td>{{ $quests[$i]->creator }}</td>
      						</tr>
      						<tr>
      							<td>執行開始時間</td>
      							<td>{{ $quests[$i]->execute_start_at }}</td>
      						</tr>
      						<tr>
      							<td>執行結束時間</td>
      							<td>{{ $quests[$i]->execute_end_at }}</td>
      						</tr>
      						<tr>
      							<td>任務描述</td>
      							<td>{{ $quests[$i]->description }}</td>
      						</tr>
      						<tr>
      							<td>參加費用</td>
      							<td>{{ $quests[$i]->admission_fee }}</td>
      						</tr>
                  <tr>
                    <td>其他事項</td>
                    <td>{{ $quests[$i]->other_description}}</td>
                  </tr>
      						<tr>
      							<td>獎勵點數</td>
      							<td>{{ $quests[$i]->point }}點</td>
      						</tr>
      					</table>
      				</div>
      				<div class="modal-footer">
                @for($j=0; $j < count($ums) && $ums[$j]->quest_id != $quests[$i]->id; $j++)
                @endfor
                @if($j < count($ums))
                  @if($ums[$j]->status == 1)
                    <button type="button" class="btn btn-info">已完成此任務</button>
                  @else
                    <a href="/activity/cancel/{{$quests[$i]->id}}"><button type="button" class="btn btn-danger">放棄此任務</button></a>
                  @endif
                @else
                  <a href="/activity/get/{{$quests[$i]->id}}"><button type="button" class="btn btn-danger">接下此任務</button></a>
                @endif
                <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
    				</div>
   				</div>
			</div>
		</div>
		@endfor

		<div class="container">
			<ol class="breadcrumb">
				<li><a href="{{ url('/') }}">首頁</a></li>
				<li><a href="{{ url('/quest') }}">任務大廳</a></li>
				<li class="active">活動任務</li>
			</ol>

      {{ $quests->links()}}
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th class="text-center">任務標題</th>
						<th class="text-center">申請截止時間</th>
						<th class="text-center">開始時間 ~ 結束時間</th>
            <th class="text-center">任務地點</th>
						<th class="text-center">獎勵冒險點數</th>
					</tr>
				</thead>
				<tbody>
  				@for($i=0; $i < count($quests); $i++)
  					<tr data-toggle="modal" data-target="#quest{{$i}}">
  						<td>{{ $quests[$i]->name }}</td>
  						<td class="text-center">{{ $quests[$i]->apply_end_at }}</td>
  						<td class="text-center">{{ $quests[$i]->execute_start_at }} ~ {{ $quests[$i]->execute_end_at }}</td>
              <td class="text-center">{{ $quests[$i]->place}}</td>
  						<td class="text-center">{{ $quests[$i]->point }}</td>
  					</tr>
				@endfor
				</tbody>
			</table>
      {{ $quests->links()}}

  			

			

		</div>

	@endif


@endsection