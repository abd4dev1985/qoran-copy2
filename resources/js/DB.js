const { result } = require("lodash");



let set_Dtabbase_Version =  function (DataBase) {
   
}

let db_version=localStorage.db_version;


exports.store =function (data,DataBase,ObjectStore)  {
  
//prefixes of implementation that we want to test
window._indexedDB=  window._indexedDB || window._mozIndexedDB ;  

if (!window.indexedDB) {
    window.alert(
      "Your browser doesn't support a stable version of IndexedDB "+"\n"+
      "  المتصفح لديك لا يدعم تخزين قواعد البيانات"
      )
    };
          
// make request_db 
let request_db=window.indexedDB.open(DataBase);

// show the error log when request_db  failed
request_db.onerror= function(event){ console.log(this.error);};

// get and show existed  database (db) when request_db success 
// our transaction here is add
request_db.onsuccess= function(event){
   let db =event.target.result;
   //console.log(db);
   // check if data base contian the ObjectStore then
   if (Array.from(db.objectStoreNames).includes(ObjectStore)) {
      // open transaction and select ObjectStore and type of  transaction
      var transaction =db.transaction([ObjectStore],"readwrite");
      // access ObjectStore (table )
      let table = transaction.objectStore(ObjectStore)
      //here  you can do  any crud operation (add, get, delete) on ObjectStore (table)
      // here we have create operation (add)  
      data.forEach(element => {
         let request =table.add(element)
         request.onsuccess = event => {
            console.log(event.target.result)  
            console.log("new recored is saved in ObjectStore ") 
         };
      request.onerror=event=>{  console.log(event.target)  }
      }); 
        
   }
   else{ // if DB did not contain ObjectStore then  update data base version and creat new ObjectStore

      console.log("making new  ObjectStore (table) ")
      let new_version = db.version+1
      console.log( "database version is update to "+ new_version)
      db.close();
      let  new_request_db=window.indexedDB.open(DataBase,new_version
         );  
      new_request_db.onerror = function(event){ console.log(this.error);};   
      new_request_db.onupgradeneeded=event =>{
         let new_db  =event.target.result;
         console.log(new_db)  
         console.log('database is upgraded ')
         let new_ObjectStore = new_db.createObjectStore(ObjectStore, {keyPath: "id"});  
         console.log(' new ObjectStore (table) is created') 
         console.log(data) 
         for (var record in data)
         {  
            let record_request= new_ObjectStore.add(data[record]);
            // record_request.onerror= function(event){ console.log(this.error);}
         }  
         new_db.close()
         
      }
     
   }
 
}

};






     exports.read_data =   function read_data (DataBase,ObjectStore,id)  {
          
            // make request_db  
            var request_db= window.indexedDB.open(DataBase);
            // get database (db) when request_db success
            request_db.onsuccess= function(event){
               var db =event.target.result;
               console.log(db);
               //define transaction
               var transaction =db.transaction([ObjectStore]);
               //implement transaction on employee data object and read data frome it 
               var read_request =transaction.objectStore(ObjectStore).get(id);
              
               //when db_read_request onsuccess 
               read_request.onsuccess =function(event){
                var  name =event.target.result.name;
                   console.log(name);
                   return name;
               }      
            }     
     }  

     exports.find =   function find (DataBase,ObjectStore,id)  {
      let data=[] ; 
         // make request_db  
         var request_db= window.indexedDB.open(DataBase);
         // get database (db) when request_db success
         request_db.onsuccess= function(event){
            var db =event.target.result;
            //define transaction
            var transaction =db.transaction([ObjectStore]);
            //implement transaction on employee data object and read data frome it 
            var read_request =transaction.objectStore(ObjectStore).get(id);
            //when db_read_request onsuccess 
            read_request.onsuccess =function(event){
               data.push(event.target.result) ;
            }   
         } 
         console.log("data is")  
         console.log(data)  
         return data;  
         
   }  

     exports.get= (DataBase,ObjectStore,callback)=>{  
        
            let data=[] ;
            // make request_db  
            var request_db= window.indexedDB.open(DataBase);
            // get database (db) when request_db success
            request_db.onsuccess= function(event){
               var db =event.target.result;
               console.log(db);

               request_db.onerror=function(event){console.log(this.error)}

            if(Array.from(db.objectStoreNames).includes(ObjectStore)==false) {
               db.close()
               console.log("ObjectStore not founded check again or create new one")
               //let vrsion=(localStorage.version)? localStorage.version:localStorage.setItem("version", 2);
               if (typeof  callback==='function') {
                  callback(data)
               }
               return data
            } else{

               //define transaction
               var transaction =db.transaction([ObjectStore]);
               //implement transaction method openCursor()
               var read_request =transaction.objectStore(ObjectStore).openCursor();
            
               //when db_read_request onsuccess 
               read_request.onsuccess =function(event){
                  const cursor =event.target.result;
                  if(cursor){
                  // console.log(cursor);
                  // console.log("key of cursor "+cursor.key);
                  let obj={}  
                  //console.log("key of cursor"+cursor.value);
                  for (const key in cursor.value) {
                     if (Object.hasOwnProperty.call(cursor.value, key)) {
                        const element = cursor.value[key];
                        //console.log(key+" is "+element)
                        obj[key]=element
                     }
                  }
                  //console.log(obj)
                  data.push(obj)
                  cursor.continue();}
                  else{
                     console.log("cursor stoped")
                     if (typeof  callback==='function') {
                        callback(data)
                     }


                     //console.log(data)
                  }
                  db.close()
               }
            }      
            }   
            return data                  
            
     }

   exports.destroy=function  destroy(DataBase,ObjectStore,id){
      // make request_db  
      var request_db= window.indexedDB.open(DataBase);
      // get database (db) when request_db success
      request_db.onsuccess= function(event){
         var db =event.target.result;
         //define transaction
         var transaction =db.transaction([ObjectStore],"readwrite");
         //implement transaction method openCursor() 
         var delete_request =transaction.objectStore(ObjectStore).delete(id); 
         delete_request.onsuccess =(event)=>{console.log(event)}  

      }
   } 

     exports.test =function(){return "test"}
     exports.test2= (DataBase,ObjectStore)=>{  
      
         let data=[{name:'roby',age:77}] ;
         
         // make request_db  
         var request_db= window.indexedDB.open(DataBase);
         // get database (db) when request_db success
         request_db.onsuccess= function(event){
            var db =event.target.result;
            console.log(db);

            request_db.onerror=function(event){console.log(this.error)}

         if(Array.from(db.objectStoreNames).includes(ObjectStore)==false) {
            db.close()
            console.log("ObjectStore not founded check again or create new one")
            //let vrsion=(localStorage.version)? localStorage.version:localStorage.setItem("version", 2);

            return false
         } 

            //define transaction
            var transaction =db.transaction([ObjectStore]);
            //implement transaction method openCursor()
            var read_request =transaction.objectStore(ObjectStore).openCursor();
         
            //when db_read_request onsuccess 
            read_request.onsuccess =function(event){
               const cursor =event.target.result;
               if(cursor){
               // console.log(cursor);
               // console.log("key of cursor "+cursor.key);
               let obj={}  
               //console.log("key of cursor"+cursor.value);
               for (const key in cursor.value) {
                  if (Object.hasOwnProperty.call(cursor.value, key)) {
                     const element = cursor.value[key];
                     //console.log(key+" is "+element)
                     obj[key]=element
                  }
               }
               //console.log(obj)
               data.push(obj)
               cursor.continue();}
               else{
                  console.log("cursor stoped")
                  //console.log(data)
               }
               db.close()
            }      
         }   
         return data
     
}