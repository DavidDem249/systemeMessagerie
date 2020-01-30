@extends('layouts.app')

@section('content')
	<div class="container">
		@include('conversation.users',['users' => $users, 'unread' => $unread])
	</div>

@stop