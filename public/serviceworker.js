let version = 1
var myCacheName = "quran_cache" + version;



// call  install event
self.addEventListener("install", event => {
  console.log("service worker installed")  
  
});

// Clear cache on activate
self.addEventListener('activate', event => {
    console.log("service worker activated")  
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    //.filter(cacheName => (cacheName.startsWith("pwa-")))
                    .filter(cacheName => (cacheName !== myCacheName))
                    .map(cacheName => {caches.delete(cacheName) ;console.log("cache is deleted")})
            );
        })
    );
    
});
/*
self.addEventListener('message', (event) => {
        console.log('downloading' +event.data.download )
        async function download_chach(){
            for (let index = 1; index <115; index++) {
                //make fetch request then get the response and put it in chach 
                let res= await fetch('/surahs/'+index)
                let cache= await caches.open('quran_cache1')
                cache.put('/surahs/'+index,res)    
            }
        }
      if (event.data && event.data.download ==="yes") {
        download_chach()
      }     
})
*/

// Serve from Cache
self.addEventListener("fetch", event => {
    console.log('fetching '+event.request.url)
    if (event.request.url.includes('all')) {
        event.respondWith(caches.match(event.request.url).then((res)=>{
            console.log('from cache ')   
            return res}))
    }else{
        event.respondWith(
            fetch(event.request).then(
                res=>{
                    // make copy of respone  
                    const responClone = res.clone();
                    //open cash
                    caches.open(myCacheName).then(
                        //add clone respon to cache
                        cache=>{
                            console.log("save cach");
                            cache.put(event.request.url,responClone)
                            console.log('making cache for url '+event.request.url)
                            console.log(responClone)
                        });
                    return  res ;    
                } 
            // if no connection       
            ).catch(err=>caches.match(event.request.url)).then((res)=>{
                console.log( 'find cache for url '+event.request.url)
               console.log(res) 
              return  res})
        )
    }
   
});