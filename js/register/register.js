function Validator(options){
    var selectorRule = {};


    function validate(inputElement , rule){
        var errorMessage;
        var errorElement = inputElement.parentElement.querySelector('.form-message');
        // lấy các rule của selector
        var rules = selectorRule[rule.selector];
        // lặp rule để check
        for ( var i=0 ; i< rules.length;i++){
            errorMessage = rules[i](inputElement.value);
            if(errorMessage) break; // nếu có lỗi dừng
        }
        if(errorMessage){
            errorElement.innerText = errorMessage;
            inputElement.classList.add('is-invalid');
        }
        else{
            errorElement.innerText = '';
            inputElement.classList.remove('is-invalid');
        }

        //return ! errorMessage;
    }

    //the from
    var formElement = document.querySelector(options.form);
    var continueBtn = formElement.querySelector(".btn-success");
    if(formElement){
        //khi submit form
        formElement.onsubmit = function (e){
            e.preventDefault();

            var isFromInvalid = true;
            //lặp qua từng rule và validate 
            options.rules.forEach(function(rule) {
                var inputElement = formElement.querySelector(rule.selector);
                var isIvalid = validate(inputElement,rule);
                if(!isIvalid){
                    isFromInvalid = false;
                }
            });

            //console.log(formValues);

            if(isFromInvalid){
                if(typeof options.onSubmit === 'function'){
                    var formEnableInputs =formElement.querySelectorAll('[name]');
                    //lấy value từ các thẻ input
                        var formValues = Array.from(formEnableInputs).reduce(function(values , input){
                        values[input.name] = input.value;
                        return values ; // lúc nào cũng sẽ return ra toán tử cuối cùng
                    },{});
                    options.onSubmit(formValues);
                }
                else {//trường hợp submit mặc định 
                    formElement.submit();

                }
            }
        }
        // dùng ajax
        const inputcheck = formElement.querySelector("#email");
        continueBtn.onclick= () =>{
            let xhr = new XMLHttpRequest();// tạo sml object
            xhr.open("POST","register/ajaxregister.php?action=register",true),
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        console.log(data);
                        if(data == "success"){
                            location.href = "register/confirm.php";
                        }else {
                        $('#checkemail').html(data);
                        inputcheck.classList.add('is-invalid');
                        }
                        
                    }
                }
            }
            let formData = new FormData(formElement);
            xhr.send(formData);
        }

        


        // xử lý lặp qua mỗi rule rồi xử lý ( blur , input )
        options.rules.forEach(function(rule) {
            if(Array.isArray(selectorRule[rule.selector])){
                selectorRule[rule.selector].push(rule.test);
            }
            else{
                selectorRule[rule.selector] = [rule.test];
            }
            var inputElement = formElement.querySelector(rule.selector);
            if(inputElement){
                inputElement.onblur = function(){
                    validate(inputElement,rule);
                }
                inputElement.oninput = function(){
                    var errorElement = inputElement.parentElement.querySelector('.form-message');
                    errorElement.innerText = '';
                    inputElement.classList.remove('is-invalid');
                }
            }
        });
    }
}
Validator.isRequired = function(selector , name){
    return {
        selector : selector, 
        test: function(value){
            return !value.trim() && name == 'fn' ?  'Vui lòng nhập firstname' : 
            !value.trim() && name == 'ln' ?  'Vui lòng nhập lastname' : 
            !value.trim() && name == 'email' ?  'Vui lòng nhập email' : 
            !value.trim() && name == 'pw' ?  'Vui lòng nhập password' : 
            undefined;
            // return value.trim() ? undefined : 'Vui lòng nhập firstname or lastname';
        }
    }
}

Validator.maxDate = function(selector , name){
    return {
        selector : selector, 
        test: function(value){
            var d = new Date();
            
        }
    }
}


Validator.minLength = function(selector,min){
    return{
        selector : selector,
        test: function (value){
            return value.length >= min ? undefined : `Vui lòng nhập tối thiểu ${min} ký tự`;
        }
    }

}

Validator.isPassword = function(selector) {
    return {
        selector : selector, 
        test: function(value){
            var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{6,})/;
            return regex.test(value) ? undefined : 'Password không đúng vui lòng nhập lại';
        }
    }
}

Validator.isEmail = function(selector) {
    return {
        selector : selector, 
        test: function(value){
            var regex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            return regex.test(value) ? undefined : 'Email không đúng vui lòng nhập lại';
        }
    }
}
// dùng ajax
// const form = document.querySelector("#signup"),
// continueBtn = form.querySelector(".btn");

// form.onsubmit = (e)=>{
//     e.preventDefault(); // dừng hành động submit của form

// }
// continueBtn.onclick = () => { 
    
//     let xhr = new XMLHttpRequest(); //tạo xml
//     xhr.open("POST","register/ajax.php");
//     xhr.onload=()=>{
//         if(xhr.readyState === XMLHttpRequest.DONE){
//             if(xhr.status === 200){
//                 let data = xhr.response;
//                 console.log(data);
//             }
//         }
//     }
//     xhr.send();
// }