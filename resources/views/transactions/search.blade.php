@inject('transactionService', 'App\Services\TransactionService')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Месячный баланс
        </h2>
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-3">
                <label for="user" class="form-label">Пользователь</label>
                <select id="user" class="form-select form-control">
                    @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-3">
                <label for="trdate" class="form-label">Дата</label>
                <input class="form-control" id="trdate" type="month" value="{{date('Y-m')}}"/>
            </div>
                <div class="col-6">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="card" >
                                    <div class="card-body">
                                        <h5 class="card-title">Пользователь</h5>
                                        <p class="card-text">Месячный баланс: {{$transactionService->getMonthBalance($users[0])}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</x-app-layout>

