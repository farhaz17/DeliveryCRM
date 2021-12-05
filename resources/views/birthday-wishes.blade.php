
{{-- @extends('admin-panel.base.main') --}}
{{-- @section('css') --}}
<style>
	body {
	  display: flex;
	  align-items: center;
	  justify-content: center;
	  height:100vh;
	  background-color: #880c0c;
	}

	.birthdayCard {
	  position: relative;
	  width: 350px;
	  height:450px;
	  cursor: pointer;
	  transform-style: preserve-3d;
		transform: perspective(2500px);
	  transition: 1s;
	}
	.cardFront {
	  position: relative;
	  background-color: #fff;
	  width: 100%;
	  height:100%;
	  overflow: hidden;
	  transform-origin: left;
	  box-shadow: inset 100px 20px 100px rgba(0,0,0,.2), 30px 0 50px rgba(0,0,0,0.4);
	  transition: .6s;
	}

	.happy {
	  font-family: Tahoma, sans-serif;
	  text-align: center;
	  margin:30px;
	  background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%);
	  transition: .1s;
	}

	.balloons {
	  position: absolute;
	}

	.balloonOne, .balloonTwo, .balloonThree, .balloonFour {
	  position: absolute;
	  width: 85px;
	  height:95px;
	  border-radius:50%;
	}

	.balloonOne {
	  background-color: rgb(239, 71, 111, 0.7);
	  left:30px;
	  top:50px;
	}

	.balloonTwo {
	  background-color: rgb(6, 214, 160, 0.7);
	  left:95px;
	  top:20px;
	}

	.balloonThree {
	  background-color: rgb(255, 209, 102, 0.7);
	  left:150px;
	  top:50px;
	}

	.balloonFour {
	  background-color: rgb(17, 138, 178, 0.7);
	  left:220px;
	  top:20px;
	}

	.balloonOne:before, .balloonTwo:before, .balloonThree:before, .balloonFour:before {
	  content:"";
	  position: absolute;
	  width:1px;
	  height: 155px;
	  background-color: #ffd166;
	  top:95px;
	  left:43px;
	}

	.balloonOne:after, .balloonTwo:after, .balloonThree:after, .balloonFour:after {
	  content:"";
	  position: absolute;
	  border-right: 7px solid transparent;
	  border-left: 7px solid transparent;
	  top:94px;
	  left:37px;
	}

	.balloonOne:after {
	  border-bottom: 10px solid #ef476f;
	}

	.balloonTwo:after {
	  border-bottom: 10px solid #06d6a0;
	}

	.balloonThree:after {
	  border-bottom: 10px solid #ffd166;
	}

	.balloonFour:after {
	  border-bottom: 10px solid #118ab2;
	}
	.cardInside {
	  position: absolute;
	  background-color: #fff;
	  width: 100%;
	  height:100%;
	  z-index:-1;
	  left:0;
	  top:0;
	  box-shadow: inset 100px 20px 100px rgba(0,0,0,0.2);
	}

	p {
	  font-family: 'Script MT', cursive;
	  margin: 45px;
	  color: #333;
	}

	.name {
	  position: absolute;
	  left:150px;
	  top:200px;
	  color: #333;
	}

	.back {
	  font-family: Tahoma, sans-serif;
	  color: #333;
	  text-align: center;
	  margin:30px;
	  outline-color:#333;
	  outline-style: dotted;
	}

	.birthdayCard:hover {
		transform: perspective(2500px) rotate(5deg);
		box-shadow: inset 100px 20px 100px rgba(0,0,0,.2), 0 10px 100px rgba(0,0,0,0.5);
	}

	.birthdayCard:hover .cardFront {
	  transform: rotateY(-160deg);
	}

	.birthdayCard:hover .happy {
	  visibility:hidden;
	}
</style>
{{-- @endsection --}}
@section('content')
<div class="container">
<div class="birthdayCard">
<div class="cardFront"><h3 class="happy">HAPPY BIRTHDAY!</h3>
	<div class="balloons">
	  <div class="balloonOne"></div>
	  <div class="balloonTwo"></div>
	  <div class="balloonThree"></div>
	  <div class="balloonFour"></div>
	</div>
</div>
 <div class="cardInside">
    <h3 class="back">HAPPY BIRTHDAY!</h3>
    <p>Dear {{ $birthday['name'] }}, </p>
    <p>Happy birthday!! {{ $birthday['message'] }}.</p>
<br>
<br>
<br>
    <p class="name" style="margin-top: 110px;">{{ $birthday['wishers'] }}</p>
  </div>
</div>
</div>
{{-- @endsection --}}
