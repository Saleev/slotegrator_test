@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @guest
                    <h1>Для началы игры авторизуйтесь или зарегистрируйтесь</h1>
                @else
                    <div class="card">
                        <div class="card-header">Кол-во попыток выйграть {{ $result['attempt'] }} раз(а).</div>
                        <div class="card-body" id="card-body">
                            @if($message)
                                <center><h1>{!! $message !!}</h1></center>
                            @else
                                <center>
                                    <span class="btn btn-primary btn" id="start">Начать</span>
                                </center>
                            @endif
                        </div>
                    </div>
                @endguest
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Призовая статистика</div>
                    <div class="card-body">
                        <span class="badge badge-primary">Общее кол-во</span> <span class="badge badge-success float-right">Отправлено/Перечислено</span>
                        <hr>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Бонусы <span class="badge badge-primary badge-pill">{{ $result['bonus'] }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Деньги
                                <span class="badge badge-primary badge-pill">{{ $result['money'] }}</span>
                                <span class="badge badge-success badge-pill">{{ $result['money_send'] }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Призы
                                <span class="badge badge-primary badge-pill">{{ $result['item'] }}</span>
                                <span class="badge badge-success badge-pill">{{ $result['item_send'] }}</span>
                            </li>
                        </ul>
                        <hr>

                        <ul class="list-group">
                            @foreach($result['user_items'] as $ui)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $ui->name }} <span class="badge badge-primary badge-pill">{{ $ui->onsend }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@guest

@else
    @section('js')
        <script>
            $('#start').click(function(){
                $.get("{{ asset('startgame') }}", function(data){
                    $('#card-body').html(data.result);
                })
            });
        </script>
    @endsection
@endguest
