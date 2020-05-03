// fra santiago's side (https://filesdb.com/)
function fnbIsFormValid(oForm){
    fvDo( oForm.querySelectorAll('input[data-type]'), function(oElement){
      oElement.classList.remove('error')
    })
    fvDo( oForm.querySelectorAll('input[data-type]'), function(oElement){
      var sValue = oElement.value
      var sDataType = oElement.getAttribute('data-type') // $(oInput).attr('data-type')
      //console.log(sDataType)
      var iMin = oElement.getAttribute('data-min') //$(oInput).attr('data-min')
      var iMax = oElement.getAttribute('data-max') // $(oInput).attr('data-max')  
      switch(sDataType){
        case 'onlyLetters':
          if( sValue.length < iMin || sValue.length > iMax || sValue != sValue.match(/^[A-Za-z]+$/)){ 
            oElement.classList.add('error')
          }
        break
        case 'string':
          if( sValue.length < iMin || sValue.length > iMax ){ 
            oElement.classList.add('error')
          }
        break
        case 'integer':
          //if( !parseInt(sValue) || parseInt(sValue) < parseInt(iMin) || parseInt(sValue) > parseInt(iMax) ){ 
            if( isNaN(sValue) || sValue.length < iMin || sValue.length > iMax){
            oElement.classList.add('error')
          }
        case 'optional-integer':
          if(sValue.length != 0){
            if( isNaN(sValue) || sValue.length < iMin || sValue.length > iMax){
              oElement.classList.add('error')
            }
          }
        break
        case 'image':
              if(!sValue){
              console.log(sValue)
              oElement.classList.add('error') // fix visual feedback
            }
          break
        case 'email':
          var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          if( re.test(String(sValue).toLowerCase()) == false ){ 
            oElement.classList.add('error')
          }
        break      
        default:        
      }
    })  
  
    if( oForm.querySelectorAll('input.error').length ){ return false }
    return true;
}

/*************************************** */

function formValidate(selectedForm){
  console.log('clicked')
  var thisForm = document.querySelector(selectedForm) // apply to all other forms // form:not(#imgForm)
  console.log(fnbIsFormValid(thisForm))
  //var bIsValid = fnbIsFormValid(thisForm)
  /* if(bIsValid == true){
  oBtn = document.getElementById("btnSignup")
  oBtn.innerText = oBtn.getAttribute('data-wait')
  oBtn.disabled = true} */
  return fnbIsFormValid(thisForm) // true false
}

function fvDo( aElements, fvCallback ){
for(var i = 0; i < aElements.length; i++){
    fvCallback( aElements[i] )
    }
}
