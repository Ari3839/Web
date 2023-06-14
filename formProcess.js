/*A. Ariadna Lazaro Mtz*/
/*w22034009*/
/*KF5002: Web programming final Assignment*/

window.addEventListener('load', function () {
    "use strict";

    /*Defining constants for elements of the page*/ 
    const oForm = document.getElementById("orderForm");
    const termsBox = document.getElementsByName("termsChkbx");
    const terms = document.getElementById("termsText");

    /*Disabling the submit button*/
    oForm.submit.disabled=true;

    /*Function trigger for the terms and conditions*/ 
    termsBox[0].addEventListener("click", termsCond);
    let alteredTerms = false;

    /*Changing the CSS of the terms and conditions according to the checked box*/ 
    function termsCond() {
        alteredTerms = !alteredTerms;
        if(alteredTerms){
            terms.style.color = "black";
            terms.style.fontWeight = "";
            oForm.submit.disabled=false;
        }else{
            terms.style.color = "red";
            terms.style.fontWeight = "bold";
            oForm.submit.disabled=true;
        }
    }

    /*Function trigger for calculating the total when checked box item selected*/ 
    const buttons1=document.getElementsByName('record[]');
    const long1=buttons1.length;
    for (let k = 0; k < long1; k++){
        buttons1[k].addEventListener("click", calculateTotal);
    }

    /*Function trigger for calculating the total when delivery method selected*/ 
    const buttons2=document.getElementsByName('deliveryType');
    const long2=buttons2.length;
    for (let l = 0; l < long2; l++){
        buttons2[l].addEventListener("click", calculateTotal);
    }

    /*Initializing variables used inside and outside of the function*/
    let orderTotal=0;
    let delivery=0;

    /*Calculate total of items and delivery*/ 
    function calculateTotal() {
        orderTotal = 0;
        delivery=0;
        
        /*Selecting items with checkboxes*/
        const boxes = oForm.querySelectorAll('input[data-price][type=checkbox]');
        const boxesCount = boxes.length;
        
        /*Iterating items*/
        for (let i = 0; i < boxesCount; i++) {
            let box = boxes[i];
            
            /*Adding to the total price if selected*/
            if (box.checked){
                orderTotal+=parseFloat(box.dataset.price);
            }
            
        }//for
        
        /*Selecting delivery options with radio buttons*/
        const itemsPrice = oForm.querySelectorAll('input[name=deliveryType]')
        const itemsCount = itemsPrice.length;
        
        /*Iterating items*/
        for (let j = 0; j < itemsCount; j++) {
            let itemBox = itemsPrice[j];
            
            /*Adding to the delivery price if selected*/
            if (itemBox.checked){
                delivery+=parseFloat(itemBox.dataset.price);
            }
            
        }//for

        //Ading delivery to total price and showing it in the page.
        orderTotal+=delivery;
        oForm.total.value = orderTotal.toFixed(4);
        
    }//Calculate total function

    /*Trigger for submit button clicked*/
    oForm.submit.addEventListener("click", checkForm);

    /*Function to validate the submission of the form*/
    function checkForm(evt){
        let valFailed = false;
        let itemSelected = false;

        /*Selecting items with checkboxes*/
        //Radio buttons are not considered because at least one is always selected
        const checkBoxes = oForm.querySelectorAll("input[data-price][type=checkbox]");
        const long = checkBoxes.length;

        /*iterating items*/
        for(let i=0; i<long; i++){
            const checkBoxItem = checkBoxes[i];
            /*Auxiliar boolean to validate if at least one item selected*/
            if(checkBoxItem.checked){
                itemSelected = true;
            }

        }

        /*Validating surname or forenamed not entered*/
        if (oForm.surname.value==null || oForm.surname.value==''){
            valFailed = true;
        }else if (oForm.forename.value==null || oForm.forename.value==''){
            valFailed = true;
        /*Validating if items selected*/
        }else if(itemSelected==false){
            valFailed = true;
        }else if (orderTotal == 0.0000){
        /*Validating if not items nor delivery method selected*/
            valFailed = true;
        /*Form completed correctly*/
        }else{
            valFailed = false;
        }

        /*Alerting of an error if some condition was not respected.*/
        if(valFailed){
            alert("An error occurred, please try again");
            evt.preventDefault();
        }
    }//checkForm()

});