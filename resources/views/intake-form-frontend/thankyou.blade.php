@extends('layouts.public')
@section('content')
<div class="success-div">
  <div class="success-msg">
    <div class="set-z-index">
      <img src="{{asset('images/frontend/success-icon-01.svg')}}" alt="">
        <h1 class="green-text">Thank You</h1>
        <h4>Data Successfully Submitted, We Review Your Details and Contact Back Soon.</h4>
    </div>
  </div>
</div>
@endsection