const chars = '0123456789'
const upper = '⁰¹²³⁴⁵⁶⁷⁸⁹';
const lower = '₀₁₂₃₄₅₆₇₈₉';

superScript = function(e) {
    e.value = e.value.replace(/_\d{1}/g, function(txt) {
        var str = '';
        for (var i=1; i<txt.length; i++) {
            var n = chars.indexOf(txt[i]);
            str += (n!=-1 ? lower[n] : txt[i]);
        }
        return str;
    })

    e.setAttribute('data-reversed', reverseIndexes(e.value));
}

puperScript = function(e) {
    e.value = e.value.replace(/\^\d{1}/g, function(txt) {
        var str = '';
        for (var i=1; i<txt.length; i++) {
            var n = chars.indexOf(txt[i]);
            str += (n!=-1 ? upper[n] : txt[i]);
        }
        return str;
    })

    e.setAttribute('data-reversed', reverseIndexes(e.value));
}

reverseIndexes = function(str) {
    return str
        .replace(new RegExp('[' + lower + ']{1}', "g"), function (lowerIndex) {
            var number = '';
            for (var i = 0; i < lowerIndex.length; i++) {
                number += chars[lower.indexOf(lowerIndex[i])];
            }
            return '_' + number;
        }).replace(new RegExp('[' + upper + ']{1}', "g"), function (upperIndex) {
            var number = '';
            for (var i = 0; i < upperIndex.length; i++) {
                number += chars[upper.indexOf(upperIndex[i])];
            }
            return '^' + number;
        });
}

setTimeout(function(){
    $('input[name=start]').each(function(){this.setAttribute('onchange', 'superScript(this); puperScript(this)')})
    $('input[name=end]').each(function(){this.setAttribute('onchange', 'superScript(this); puperScript(this)')})
}, 500);