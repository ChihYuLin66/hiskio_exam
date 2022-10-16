@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>

                <div class="card-body">
                    <div class="row">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">用戶ID</th>
                                    <th scope="col">帳號</th>
                                    <th scope="col">存款金額</th>
                                    <th scope="col">詳細資料</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->account }}</td>
                                    <td>$ {{ $user->balance }}</td>
                                    <td>
                                        <a href="{{ Route('accounts.show', $user->id) }}">
                                            <button
                                                type="button" 
                                                class="btn btn-primary mr-2"
                                            >
                                                detail
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
