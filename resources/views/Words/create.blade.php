@extends('layouts.app')

@section('content')
    <div class="container" style="text-align: center; ">
        <form name="newWord" method="post" action="{{ route('words.store') }}">
            <label for="word">Word: </label><input type="text" name="word" id="word" /><br/>
            <input type="submit" class="btn btn-primary"/>
        </form>
    </div>
@endsection