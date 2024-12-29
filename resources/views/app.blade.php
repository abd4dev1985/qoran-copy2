<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <script src="{{ mix('/js/app.js') }}" defer></script>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @routes
    @inertiaHead
    @laravelPWA
  </head>
  <body class="relative scroll-smooth">
  
   <div   class="" >
     @inertia
   </div>
   <div id="sound_area" class=" w-full  fixed top-40  z-30" ></div>
   <div id="intro" class="text-6xl w-full text-center text-rose-500 " >القران الكريم </div>
   <div id=tool_bar  class="w-full fixed top-0 z-40" >  </div>
  </body>

  <script>

    if (localStorage.theme==='dark') {
          document.documentElement.classList.add('dark');
    }else{
        localStorage.theme='light'
        document.documentElement.classList.remove('dark'); 
    }
    window.addEventListener('load',()=>{
      document.getElementById('intro').style.display='none'
    })
  </script>


</html>