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
                                <h3>{!! $message !!}</h3>
                                <div class="bg-light">
                                    <center>
                                        <label>Для получения денежных средств пожалуйста укажите Ваш данные</label>
                                    </center>
                                    <form method="post" action="{{ asset('card_data') }}" style="padding: 15px">
                                        @csrf
                                        <label>№ карточки</label>
                                        <input type="text" class="form-control" name="card_num" id="card_num" required>
                                        <br>
                                        <button type="submit" class="btn btn-primary btn-block">Отправить</button>

                                    </form>
                                </div>
                            <hr>
                                <div class="bg-light">
                                    <center>
                                        <label>Для получения предметов пожалуйста укажите Ваш адрес доставки</label>
                                    </center>
                                    <form method="post" action="{{ asset('delivery') }}" style="padding: 15px">
                                        @csrf
                                        <label>Адресс</label>
                                        <textarea class="form-control" name="address"></textarea>
                                        <br>
                                        <button type="submit" class="btn btn-primary btn-block">Отправить</button>
                                    </form>
                                </div>

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
                        <div style="text-align: right">
                            <span class="badge badge-success">Отправлено/Перечислено</span>
                            <span class="badge badge-primary">Общее кол-во</span>
                        </div>
                        <hr>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Бонусы <span class="badge badge-primary badge-pill">{{ $result['bonus'] }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Деньги
                                <span class="badge badge-success badge-pill">{{ $result['money_send'] }}</span>
                                <span class="badge badge-primary badge-pill">{{ $result['money'] }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Призы
                                <span class="badge badge-success badge-pill">{{ $result['item_send'] }}</span>
                                <span class="badge badge-primary badge-pill">{{ $result['item'] }}</span>
                            </li>
                        </ul>
                        <hr>
                        <label>
                            Вы можете обменять призы на
                        </label><br>
                        <div style="text-align: right">
                            <span class="badge badge-primary">Бонусы</span>
                            <span class="badge badge-success">Деньги</span>
                        </div>

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
        <script src="{{ asset('js/jquery.maskedinput.min.js') }}"></script>

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

            $('#card_num').mask('9999-9999-9999-9999');
        </script>
    @endsection
@endguest
