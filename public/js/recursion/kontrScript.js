function get_results(str, max_x) {
    function S(x){return x+1;}
    function U(n, m, args){return args[n-1];}
    function C(q, n, args){return q;}
    function sum(){
        s=0;
        for ( var i = 0; i < arguments.length; i++) {
            s+=arguments[i];
        }
        return s;
    }

    function prod(){
        p = 1
        for ( var i = 0; i < arguments.length; i++) {
            p*=arguments[i];
        }
        return p;
    }
    function split_args(str) {
        res = [];
        deep = 0;
        buff = '';
        for ( var i  = 0; i < str.length; i++){
            if ( str[i] == '(' ) {
                deep++;
            }
            if ( str[i] == ')' ) {
                deep--;
            }
            if ( deep === 0 && str[i] == ',' ) {
                res.push(buff);
                buff = '';
            } else {
                buff += str[i];
            }
        }
        res.push(buff);
        return res;
    }

    function rebuild(func, args) {
        re = /S\_\d+\^\d+/;
        cmd = func.split('(')[0];
        if ( re.test(cmd) ) {
            func = func.substr(func.indexOf('('));
            func = func.substr(1, func.length-2);
            dat = split_args(func);
            return  dat[0] + '(' + dat.slice(1).map(s=>rebuild(s, args)).join(',') + ')' ;
        }
        if (func[0] == 'U' || func[0] == 'C' ) {
            dat = func.split('_');
            nm = dat[1].split('^');
            if (func[0] == 'U') {
                return args[nm[0]-1];
            }
            if (func[0] == 'C') {
                return nm[0];
            }
        }
        return func + args;
    }

    base = str.split('(')[0].split('_')[1];
    cache = [parseInt(base)]
    str = str.substr(str.indexOf('('));
    str = str.substr(1, str.length-2);
    body = rebuild(str, ['cache[i]','i']);
    for (var i = 0; i < max_x; i++) {
        cache.push(eval(body));
    }
    return cache;
}

function run_test(basic_function, rf) {
   /* function disableFunction() {
        document.getElementById("onerun").disabled = 'true';
        document.getElementById("onerun2").disabled = 'true';
        document.getElementById("rec_func").disabled = 'true';
        document.getElementById("rec_func2").disabled = 'true';
    }

    setTimeout(disableFunction, 200);*/

    $('input[id=disabled6]').val("Ошибка!");
    // var rf = $('input[name=rec_func]').val();
    var rf = $('input[id=rec_func]').attr('data-reversed');
    if (rf === undefined) rf = $('input[id=rec_func]').val();
    var basic_function = $('input[name=func]').val();
    nroll = 10;
    diff = []
    rec_res = get_results(rf, nroll)
    for ( var x = 0; x < nroll; x++ ) {
        cls_res = eval(basic_function);
        if (cls_res != rec_res[x]) {
            diff.push([x, cls_res, rec_res[x]])
        }
    }
   // return diff;
    function syntax(text){
        var i, l=text.length, char, last, stack=[];

        for(i=0; i<l; i++){
            char=text[i];
            if(char=="("){
                stack.push(char);
                last=char;
            }else if(char == ")"){
                if(last){
                    if((char == ')' && last == '('))
                    {
                        stack.pop();
                        last = stack.length > 0 ? stack[stack.length - 1] : undefined;
                    }
                }else{
                    return false;
                }
            }
        }
        return stack.length==0;
    }
    // проверка верхних индексов
    function srch(str){
        alert(4);
        var poisk="^";
        var i=0;
        var idx =[];
        do {
            var x = str.indexOf(poisk,i);
            i=x+1;
            if (x != -1 && str.charAt(x+1)!='2'){
                return false;
            }
            if (x == -1) return true;
        } while (x!=-1);


    }
    var score;
    if (diff.length == 0) {
        score = 1;
    }
    else {score = 0;}
    if (syntax(rf) == true) {
        score= score * 1.5;
    }
    if (srch(rf) == true) {
        score = score * 4 /3 ;
    }

    $('input[id=disabled6]').val(score);
    $('input[id=mark1]').val(score);
    $('form[id=easyform]').submit();
    protocol_rec();
}
function run_test2(basic_function, rf) {
    /*function disableFunction() {

        document.getElementById("onerun").disabled = 'true';
        document.getElementById("onerun2").disabled = 'true';
        document.getElementById("rec_func").disabled = 'true';
        document.getElementById("rec_func2").disabled = 'true';
    }

    setTimeout(disableFunction, 200);*/

    $('input[id=disabled1]').val("Ошибка!");
    // var rf = $('input[name=rec_func]').val();
    var rf = $('input[id=rec_func2]').attr('data-reversed');
    if (rf === undefined) rf = $('input[id=rec_func2]').val();
    var basic_function = $('input[name=func2]').val();
    nroll = 10;
    diff = []
    rec_res = get_results(rf, nroll)
    for (var x = 0; x < nroll; x++) {
        cls_res = eval(basic_function);
        if (cls_res != rec_res[x]) {
            diff.push([x, cls_res, rec_res[x]])
        }
    }
    // return diff;
    function syntax(text) {
        var i, l = text.length, char, last, stack = [];

        for (i = 0; i < l; i++) {
            char = text[i];
            if (char == "(") {
                stack.push(char);
                last = char;
            } else if (char == ")") {
                if (last) {
                    if ((char == ')' && last == '(')) {
                        stack.pop();
                        last = stack.length > 0 ? stack[stack.length - 1] : undefined;
                    }
                } else {
                    return false;
                }
            }
        }
        return stack.length == 0;
    }

    // проверка верхних индексов
    function srch(str) {
        var poisk = "^";
        var i = 0;
        var idx = [];
        do {
            var x = str.indexOf(poisk, i);
            i = x + 1;
            if (x != -1 && str.charAt(x + 1) != '2') {
                return false;
            }
            if (x == -1) return true;
        } while (x != -1);


    }
    var score;
    if (diff.length == 0) {
        score = 1.5;
    }
    else {score = 0;}
    if (syntax(rf) == true) {
        score= score * 4/3;
    }
    if (srch(rf) == true) {
        score = score * 3/2 ;
    }
    $('input[id=disabled1]').val(score);
    $('input[id=mark2]').val(score);
    $('form[id=hardform]').submit();
    protocol_rec();
}

function protocol_rec(){
    html_text = html();
    token = $('#forma').children().eq(0).val();
    alert(token);
    $.ajax({
        cache: false,
        type: 'POST',
        url: '/uir/public/get_rec_protocol',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { html_text: html_text, token: 'token' },
        success: function(data){

        }
    });
    return false;

}

//rf = "R_1(S_3^2(sum,U_1^2,S_2^2(prod,C_2^2,U_2^2),C_4^2))"
//bf = "x*x+3*x+1"
//bf="3*x+1"
//rf="R_1(S_2^2(sum,U_1^2,C_3^2))"

//run_test(bf, rf);
