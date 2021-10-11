@extends('Layouts.app')

@section('Content')
@auth
    {{ $CurrentUserPermissions }}
@endauth
@endsection
