@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
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
            <div class="col-md-6">
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
                        <label>
                            Вы можете обменять призы на
                        </label><br>
                        <center>
                            <span class="badge badge-primary">Бонусы</span>
                            <span class="badge badge-success">Деньги</span>
                        </center>

                        <hr>
                        <ul class="list-group">
                            @if(isset($result['user_items']))
                                @foreach($result['user_items'] as $ui)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $ui->name }}
                                    <span class="badge badge-primary badge-pill rate_bonus" id="{{ $ui->prize_id }}">{{ $ui->bonus_rate }}</span>
                                    <span class="badge badge-success badge-pill rate_money" id="{{ $ui->prize_id }}">{{ $ui->money_rate }}</span>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                        <hr>
                        <label class="text-muted">Кликните на нужный цвет и Ваш призовой предмет автоматически переведет в выбранный формат</label>
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
            $.ajaxSetup({
                global: true,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#start').click(function(){
                $.get("{{ asset('startgame') }}", function(data){
                    $('#card-body').html(data.result);
                })
            });
            $('.rate_bonus').click(function (){
                if(confirm('Подтвердите обмен предмета на бонусы')) {
                    var id = $(this).attr('id');
                    $.post("{{ asset('/exchange') }}", {"rate_bonus": id}, function (data) {
                        alert(data.result);
                        window.location.reload();
                    });
                }
            });

            $('.rate_money').click(function (){
                if(confirm('Подтвердите обмен предмета на деньги')) {
                    var id = $(this).attr('id');
                    $.post("{{ asset('/exchange') }}", {"rate_money": id}, function (data) {
                        console.log(data);
                        alert(data.result);
                        window.location.reload();
                    });
                }
            });
        </script>
    @endsection
@endguest
