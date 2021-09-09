function Validator(formSelector){
    var formRules = { };
    var validatorRules = {
        required: function(value){
            return !value.trim() && name == 'fn' ?  'Vui lòng nhập firstname' : 
            !value.trim() && name == 'ln' ?  'Vui lòng nhập lastname' : 
            !value.trim() && name == 'email' ?  'Vui lòng nhập email' : 
            !value.trim() && name == 'pw' ?  'Vui lòng nhập password' : 
            undefined;
        },
        email: function(value){
            var regex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            return regex.test(value) ? undefined : 'Email không đúng vui lòng nhập lại';
        },
        password: function(value){
            var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{6,})/;
            return regex.test(value) ? undefined : 'Password không đúng vui lòng nhập lại';
        },
        min : function(min){
            return function(value){
                return value.length >= min ? undefined : `Vui lòng nhập tối thiểu ${min} ký tự`;
            }
        },
        max : function(max){
            return function(value){
                return value.length <= max ? undefined : `Vui lòng nhập tối thiểu ${max} ký tự`;
            }
        },
    }

    var formElement = document.querySelector(formSelector);

    if(formSelector){
        var inputs = formElement.querySelectorAll('[name][rules]');
        for(var input of inputs){
            var rules = input.getAttribute('rules').split('|');
            for(var rule of rules){
                var ruleInfo;
                var isRuleHasValue = rule.includes(':');
                if(isRuleHasValue){
                    ruleInfo = rule.split(':');
                    rule = ruleInfo[0];
                    
                }
                var ruleFunc = validatorRules[rule];
                if(isRuleHasValue){
                    ruleFunc = ruleFunc(ruleInfo[1]);
                }
                if(Array.isArray(formRules[input.name])){
                    formRules[input.name].push(ruleFunc);
                }else{
                    formRules[input.name] = [ruleFunc];
                }
            }

            input.onblur = handleValidate;
        }
        function handleValidate(event){
            var rules = formRules[event.target.name];
            var errorMessage = rules.find(function(rule){
                for(var rule of rules){
                    errorMessage = rule(event.target.value);
                    return errorMessage;
                }
                if(errorMessage){
                    var formMessage = event.target.parentElement.querySelector('.form-message');
                    formMessage.innerText = errorMessage;
                }
            });
        }
    }
}