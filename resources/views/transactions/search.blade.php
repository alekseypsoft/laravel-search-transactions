@php
    $date = "2024-01" //Первоначальное значение даты
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Месячный баланс
        </h2>
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-md-3 mt-3">
                <label for="user" class="form-label">Пользователь</label>
                <select id="user" class="form-select form-control" onchange="getBalance()">
                    @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mt-3 border p-2 rounded">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="searchBy" id="searchByMonth" value="month" onchange="getBalance()">
                    <label class="form-check-label" for="searchByMonth">Поиск по месяцам</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="searchBy" id="searchByYear" checked value="year" onchange="getBalance()">
                    <label class="form-check-label" for="searchByYear">Поиск по годам</label>
                </div>
                <div id="byMonth" class="mt-3" style="display:none">
                    <label for="month" class="form-label">Дата</label>
                    <input class="form-control" id="month" type="month" value="{{$date}}" onchange="getBalance()" min="1900-01"/>
                </div>
                <div id="byYear" class="mt-3">
                    <label for="year" class="form-label">Год</label>
                    <select id="year" class="form-select form-control" onchange="getBalance()">
                        @foreach(range(2025, 2000) as $year)
                            <option value="{{$year}}"  {{ $year == "2024" ? "selected": "" }}>{{$year}}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="col-md-6">
                <div class="container">
                    <div class="row">
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title">Пользователь</h5>
                                <div class="card-text">
                                    <table class="table balances-table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Месяц</th>
                                            <th scope="col">Баланс</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th scope="row"></th>
                                            <td id="balance"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function getBalance() {
            var userId = $('#user').val();
            var data = {userId: userId};
            var val = $("input[type=radio][name=searchBy]:checked").val();

            if(val === "month") {
                data.month = $('#month').val();
            }
            else{
                data.year = $('#year').val();
                $('#month').val(data.year + "-01");
            }

            $.ajax({
                url: '/get-user-balance',
                method: 'get',
                dataType: 'json',
                data: data,
                success: function (data) {
                        const arr = Object.entries(data);
                        //balances-table
                        $(".balances-table tbody").empty();
                        arr.forEach(function(val){
                            $(".balances-table tbody").append('<tr><th scope="row">' + val[0] +'</th> <td id="balance">' + val[1] +'</td></tr>');
                        })
                    }
            })
        }

        $("input[name=searchBy]").on("change", function(){
            var val = $("input[type=radio][name=searchBy]:checked").val();

            if(val === "month") {
                $("#byMonth").show();
                $("#byYear").hide();
            }
            else{
                $("#byYear").show();
                $("#byMonth").hide();
            }
        })

        $(document).ready(function(){
            getBalance();
        })
    </script>
</x-app-layout>

