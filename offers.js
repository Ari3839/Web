/*A. Ariadna Lazaro Mtz*/
/*w22034009*/
/*KF5002: Web programming final Assignment*/

window.addEventListener('load', function () {
    "use strict";
 
    /*File proportioned to query a random record*/
    const URL = 'getOffers.php';    
    
    /*Using fetch inside a function to used the function later*/
    const fetchData = function() {
        
        fetch(URL)
        .then(

            // Step 1. function needed here to process the response into JSON data
            function (response) {
                return response.json();
            }

        )
        .then( 

            // Step 2. function needed here to do something with the JSON data
            function (json) {
                document.getElementById('offers').innerHTML = "<div><h2>"+json.recordTitle+"</h2></div>";
                document.getElementById('offers').innerHTML += "<div><h3>"+json.catDesc+"</h3></div>";
                document.getElementById('offers').innerHTML += "<div>"+json.recordPrice+"</div>";
            }

        )
        .catch(

            // Step 3. function needed here to do something if there is an error
            function (err) {
                console.log("Something went wrong!", err);
            }

        ); // end of fetch request
        
    } //end of function fetchData
                
    /*Calling the function every 5 seconds*/
    setInterval(fetchData, 5000);
 
});