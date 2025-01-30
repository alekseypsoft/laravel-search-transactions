@inject('transactionService', 'App\Services\TransactionService')
@php
    $date = date('Y-m') //Первоначальное значение даты
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
                <select id="user" class="form-select form-control">
                    @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mt-3">
                <label for="trdate" class="form-label">Дата</label>
                <input class="form-control" id="trdate" type="month" value="{{$date}}"/>
            </div>
            <div class="col-md-6">
                <div class="container">
                    <div class="row">
                            <div class="card mt-3">
                                <div class="card-body">
                                    <h5 class="card-title">Пользователь</h5>
                                    <div class="card-text">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col">Месяц</th>
                                                <th scope="col">Баланс</th>
                                            </tr>
                                            </thead>
                                        <tbody>
                                        <tr>
                                            <th scope="row">{{$date}}</th>
                                            <td>{{$transactionService->getMonthBalance($users[0], $date)}}</td>
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
</x-app-layout>

