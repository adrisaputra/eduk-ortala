<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: Arial;
  font-size: 17px;
}

#myVideo {
  /* position: fixed; */
  right: 0;
  bottom: 0;
  min-width: 100%; 
  min-height: 100%;
}

</style>
</head>
<body>

<script>
  function videoEnded() {
      location.href="{{url('/dashboard')}}";
   }
</script>

<video id="myVideo" controls autoplay onended="videoEnded()">
  <source src="{{ asset('rpjmd2.mp4')}}" type="video/mp4">
    Your browser does not support the video tag.
</video>

</body>
</html>
