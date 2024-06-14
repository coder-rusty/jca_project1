@extends('layout.eventLayout')

@section('eventContent')
<div class="d-column">
    <div class="d-flex w-100 subHeader">
        <h4>Judges List</h4>
    </div>
    @if (session('eventCreated'))
    <div class="alert alert-success" role="alert">
        {{session('eventCreated')}}
      </div>
    @endif
        <div class="container mt-5">
            <div class="judgesContainer">
                @include('facilitator.singleEvent.judges.byCategory.preliminary')
                @include('facilitator.singleEvent.judges.byCategory.final')
            </div>
        </div>
@endsection

<style>
    .subHeader{
        border-bottom: 2px solid #2F2F2F;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 51px;
    }
    .judgesContainer{
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 90%;
        margin: auto;
    }
</style>
