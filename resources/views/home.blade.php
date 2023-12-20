@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    <?php
        $clients = new \App\Models\Client;
        $users = new \App\Models\User;
    ?>
        <!-- Small boxes (Stat box) -->
    <div class="row">
        <!-- ./col -->
        <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $users->getTotalUsers() }}</h3>

                    <p> Users Registrations</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="/users" class="small-box-footer">More info<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $clients->getTotalClients() }}</h3>

                    <p>Clients Registrations</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-stalker"></i>
                </div>
                <a href="/clients" class="small-box-footer">More info<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $clients->getTotalClientsArrears() }}</h3>

                    <p>Clients Debtors</p>
                </div>
                <div class="icon">
                    <i class="ion ion-thumbsdown"></i>
                </div>
                <a href="/clients" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <?php $loans = \App\Models\Loan::where('status', 'Aberto')->get(); ?>
                    <h3>{{count($loans)}}</h3>

                    <p>Loans</p>
                </div>
                <div class="icon">
                    <i class="ion ion-cash"></i>
                </div>
                <a href="/loans" class="small-box-footer">More info<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>

@stop

@section('css')
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@stop

@section('js')

@stop
