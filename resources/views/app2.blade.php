<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <script src="{{ mix('/js/app.js') }}" defer></script>
   
    @laravelPWA
  </head>
  <body class="relative">
  
   
   
   <div id="intro" class="text-6xl w-full text-center text-rose-500 " >القران الكريم </div>
  </body>

  <script>

    if (localStorage.theme==='dark') {
          document.documentElement.classList.add('dark');
    }else{
        localStorage.theme='light'
        document.documentElement.classList.remove('dark'); 
    }
   
  </script>


</html>