
function disableFunction1() {
document.getElementById("onerun").onclick = function () {
    //disable
    
    this.disabled = true;

	}
}

setTimeout(disableFunction1, 20);

function disableFunction2() {
document.getElementById("onerun2").onclick = function () {
    //disable
    
    this.disabled = true;

    //do some validation stuff
	}
}
setTimeout(disableFunction2, 20);