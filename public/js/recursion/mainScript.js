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
   // var rf = $('input[name=rec_func]').val();
    var rf = $('input[name=rec_func]').attr('data-reversed');
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
    //str="^3232745093^275^2809umf;cl;nnfv[";
    //srch(str);
    if(diff.length>0 && (syntax(rf)==false) && (srch(rf)==false)) {
        $('input[id=disabled6]').val("Вычислимость: 0%");
        $('input[id=disabled5]').val("Синтаксис:0%");
        $('input[id=disabled4]').val("Индексы:0%");

    }
    if(diff.length>0 && (syntax(rf)==false) && (srch(rf)==true)) {
        $('input[id=disabled6]').val("Вычислимость: 0%");
        $('input[id=disabled5]').val("Синтаксис:0%");
        $('input[id=disabled4]').val("Индексы:100%");

    }
    if(diff.length>0 && (syntax(rf)==true) && (srch(rf)==false)) {
        $('input[id=disabled6]').val("Вычислимость: 0%");
        $('input[id=disabled5]').val("Синтаксис:100%");
        $('input[id=disabled4]').val("Индексы:0%");

    }
    if(diff.length==0 && (syntax(rf)==false) && (srch(rf)==false)) {
        $('input[id=disabled6]').val("Вычислимость: 100%");
        $('input[id=disabled5]').val("Синтаксис:0%");
        $('input[id=disabled4]').val("Индексы:0%");
    }
    if(diff.length>0 && (syntax(rf)==true) && (srch(rf)==true)) {
        $('input[id=disabled6]').val("Вычислимость: 0%");
        $('input[id=disabled5]').val("Синтаксис:100%");
        $('input[id=disabled4]').val("Индексы:100%");
    }
    if(diff.length==0 && (syntax(rf)==false) && (srch(rf)==true)) {
        $('input[id=disabled6]').val("Вычислимость: 100%");
        $('input[id=disabled5]').val("Синтаксис:0%");
        $('input[id=disabled4]').val("Индексы:100%");
    }
    if(diff.length==0 && (syntax(rf)==true) && (srch(rf)==false)) {
        $('input[id=disabled6]').val("Вычислимость: 100%");
        $('input[id=disabled5]').val("Синтаксис:100%");
        $('input[id=disabled4]').val("Индексы:0%");
    }
    if(diff.length==0 && (syntax(rf)==true) && (srch(rf)==true)) {
        $('input[id=disabled6]').val("Вычислимость: 100%");
        $('input[id=disabled5]').val("Синтаксис:100%");
        $('input[id=disabled4]').val("Индексы:100%");
    }
}


//rf = "R_1(S_3^2(sum,U_1^2,S_2^2(prod,C_2^2,U_2^2),C_4^2))"
//bf = "x*x+3*x+1"

//run_test(bf, rf);
