class RegisterManager_ {
	constructor(){
		this.index_registers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];
	}
	
	show_registers(){
		$("#registerContainer").html("");
		for(var i = 0; i < this.index_registers.length; i++){
			$("#registerContainer").html($("#registerContainer").html() + "\n" +
			"<div class = \"input-group\">" + "\n" +
			"<span class=\"input-group-addon\"><b>R" + this.index_registers[i] + "</b></span>" + "\n" +
			"<input type = \"number\" class = \"form-control\" value = \"0\" id = \"r" + this.index_registers[i] + "\">" + "\n" +
			"</div>" + "\n")
		}
	}
	
	add_register(num_register){
		if(num_register < 1){
			//TODO error
		}
		else if(this.index_registers.indexOf(num_register) == -1){
			this.index_registers.push(num_register);
			this.index_registers.sort(function CompareForSort(first, second)
										{
											if (first * 1 == second * 1)
												return 0;
											if (first * 1 < second * 1)
												return -1;
											else
												return 1; 
										}); // slow but enough
			this.show_registers();
		}
	}
	
	del_register(num_register){
		var pos = this.index_registers.indexOf(num_register);
		if(pos != -1){
			this.index_registers.splice(pos, 1);
			this.show_registers();
		}
	}
	
	reset_values(){
		$("#r0").val(0);
		for(var i = 0; i < this.index_registers.length; i++){
			$("#r" + this.index_registers[i]).val(0);
		}
	}
	
	reset(){
		this.index_registers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];
		this.show_registers();
	}
}

let RegisterManager = new RegisterManager_();
RegisterManager.show_registers();