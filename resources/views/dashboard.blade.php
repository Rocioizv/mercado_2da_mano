@extends('layouts.app')

@section('content')
    <h1>Dashboard</h1>
    
    @if(auth()->check() && auth()->user()->isAdmin())
        <p>Bienvenido, administrador.</p>
    @else
        <p>Bienvenido, usuario.</p>
    @endif
@endsection