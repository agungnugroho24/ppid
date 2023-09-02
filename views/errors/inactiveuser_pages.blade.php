<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  
  <title>Exception Inactive User</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  
<style type="text/css">
@import url('https://fonts.googleapis.com/css?family=Merriweather');

body{
  padding: 0;
  padding-top: 100px;
  margin: 0;
  font-family: 'Merriweather', Sans-serif;
  display: flex;
  flex-direction: column;
  justify-content: start;
  align-items: center;
  height: 100vh;
  overflow: hidden;
  background-image: linear-gradient(to right top, #0d0015, #0c0017, #0c0019, #0a001b, #08001d, #0c0823, #0d0f29, #0d1530, #131f3d, #18294a, #1d3357, #223e65);
}
.star{
  position: absolute;
  right: 0px;
  width: 3px;
  height: 3px;
  border-radius: 50%;
  animation: animationStarBlur 2s infinite linear;
}

.iron-man img{
  width: 150px;
  transform: scaleX(1) rotate(-10deg);
  position: absolute;
  top: 55%;
  animation: animationFlying 6s infinite linear;
 }
.notify{
  color: #fff; 
  text-align: center;
}
.notify h3{
  font-size: 110px;
  margin: 30px 0;
}
.notify p{
  font-size: 18px;
}

.notify button{
  padding: 10px 30px;
  border: 0;
  background: #880000;
  font-size: 18px;
  border-radius: 5px;
  color: white; 
  outline:none;
}
.notify button:hover{
  cursor: pointer;
  background: #660000;
}
.notify button:active{
  transform: translate(-5px,-5px);
}

@keyframes animationFlying {
  0%{
    left: -150px;
  }
  100%{
    left: 110%;
  }
}

@keyframes animationStarBlur{
  0%{
      box-shadow: 0 0 5px rgba(255,255,255,.4);
  }
  25%{
    box-shadow: 0 0 15px rgba(255,255,255,.4);
  }
  50%{
    box-shadow: 0 0 5px rgba(255,255,255,.4);
  }
  75%{
    box-shadow: 0 0 15px rgba(255,255,255,.4);
  }
  100%{
    box-shadow: 0 0 5px rgba(255,255,255,.4);
  }
}  
</style>
</head>
<body>

<div class="iron-man">
  <img src="{{ asset('img/general/nenek-sihir.png')}}" alt="ỉronman">
  <!-- <img src="http://www.feralinteractive.com/data/games/legomarvelsavengers/images/characters/full/iron_man.png" alt="ỉronman"> -->
</div>

<div class="notify">
  <h3>Oops.!</h3>
  <p style="font-size:2em;">Akun anda telah di nonaktifkan.</p>
  <a href="{{ route('front-office')}}"><button><i class="fa fa-arrow-circle-left"></i> &nbsp;Kembali ke Halaman Index</button></a>
</div>



<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function() {
    var body = document.body;
    var arrayColor = [
      "#ff6600",
      "#ff0000",
      "#880000",
      "#ff9933",
      "#ff3300",
      "yellow"
    ];
    setInterval(createStar, 50);
    //createStar();
    function createStar() {
      var right = Math.floor(Math.random() * 500);
      var top = Math.floor(Math.random() * screen.height);
      var star = document.createElement("div");
      star.classList.add("star");
      body.appendChild(star);
      star.style.top = top + "px";
      star.style.background =
        arrayColor[Math.floor(Math.random() * arrayColor.length)];
      setInterval(runStar, 20);
      function runStar(top) {
        if (right >= screen.width) {
          star.remove();
        } else {
          right += 3;
          star.style.right = right + "px";
        }
        setTimeout(function(){
          star.remove();
        },6000);
      }
    }
});
</script>
</body>
</html>