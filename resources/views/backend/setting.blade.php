@extends('backend.layouts.app')

@section('content')
	<div class="container">
		@if(Session::has('status'))
				<div class="alert alert-info">
					<span>{{Session::get('status')}}</span>
				</div>
		@endif
		<form method="post" action="{{route('admin.setting.store')}}">
			{{csrf_field()}}
			<div class="form-group">
				<label>
					URL callback for TelegramBot
				</label>
				<div class="input-group">
{{--					todo--}}
					<div class="input-group-btn dropdown">
						<button type="button" class="btn btn-default dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Действие
						</button>
						<ul class="dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuButton">
							<li class="dropdown-item"><a href="#" onclick="document.getElementById('url_callback_bot').value = '{{url("")}}'">Вставить url</a></li>
							<li class="dropdown-item"><a href="#" onclick="event.preventDefault(); document.getElementById('setwebhook').submit();">Отправить url</a></li>
							<li class="dropdown-item"><a href="#" onclick="event.preventDefault(); document.getElementById('getwebhookinfo').submit();">Получить информацию</a></li>
						</ul>
					</div>
					<input type="url" class="form-control" id="url_callback_bot" name="url_callback_bot" value="{{$url_callback_bot ?? ''}}">
				</div>
			</div>
			<button type="submit" class="btn btn-primary mt-2">Сохранить</button>
		</form>
		<form id="setwebhook" action="{{route('admin.setting.setwebhook')}}" method="POST" style="display:none;">
			{{csrf_field()}}
			<input type="hidden" name="url" value="{{$url_callback_bot ?? ''}}">
		</form>
		<form id="getwebhookinfo" action="{{route('admin.setting.getwebhookinfo')}}" method="POST" style="display:none;">
			{{csrf_field()}}
		</form>
	</div>
@endsection