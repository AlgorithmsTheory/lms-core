// public methods : 
// GetNextMove(state) => {-1, 0, 1}
// GetNextState(state) => {0, 1}
// GetNextRuleId(state) => RuleId
function Rule(rawText, comment) {
	this.Raw = rawText;
    this.Type = rawText[0];
    this.Comment = comment;
    
    // default
    this.GetNextState = function(state) {
        return state;
    };

    this.GetNextMove = function(state) {
        return 0;
    };

    this.GetNextRuleId = function(state) {
        return this.NextPosition;
    };
    
    switch (this.Type) {
        // move operator
        case ">":
        case "<":
            this.NextPosition = parseInt(rawText.split(':')[1]);
            this.GetNextMove = function(state) {
                if (this.Type == ">") {
                    return 1;
                }
                return -1;
            };
            break;
        
        // update operator
        case "0":
        case "1":
            this.NextPosition = parseInt(rawText.split(':')[1]);
            this.GetNextState = function(state) {
                if (state == this.Type) {
                    throw new Error('UpdateError');
                }
                return this.Type;
            };
            break;
        
        // if operator
        case "?":
            this.NextPosition = {
                '0': parseInt(rawText.split(':')[1]),
                '1': parseInt(rawText.split(':')[2])
            };
            this.GetNextRuleId = function(state) {
                return this.NextPosition[state];
            };
            break;
        case "!":
            this.GetNextRuleId = function(state) {
                return -1;
            }
            break;
        default:
            throw new Error("Unknown type : " + this.Type);
            
    }
}

function PostMachine(state, rules, position, ruleId) {
    this.State = state;
    this.Rules = rules;
    this.Position = position;
    this.CurrentRuleId = ruleId;
    this.UpdateState = function() {
        rule = this.Rules[this.CurrentRuleId];
        flag = this.State[this.Position];
        this.State = this.State.substr(0, this.Position) + rule.GetNextState(flag) + this.State.substr(this.Position + 1);
        this.Position += rule.GetNextMove(flag);
        this.CurrentRuleId = rule.GetNextRuleId(flag);

        // extend State
        if (this.Position == this.State.length) {
                this.State += "0";
        }
        if (this.Position == -1) {
            this.State = "0" + this.State;
            this.Position = 0;
        }

        // check RuleId
        if (this.CurrentRuleId == -1) {
            return this.State;
        }
        if (!(this.CurrentRuleId in this.Rules)) {
            throw Error("Unknown rule");
        }
    }

    this.GetStateWithPosition = function () {
        return this.State.substr(0, this.Position) + 
            "[" + 
            this.State[this.Position] + 
            "]" + 
            this.State.substr(this.Position+1);
    }
}


function GetResult(rules, state, position = 0, initialRule = 1) {
    algo = new PostMachine(state, rules, position, initialRule);
    log = [];
    log.push(algo.GetStateWithPosition());
    for (var i = 0; i < 10000; i++) {
        res = algo.UpdateState();
        log.push(algo.GetStateWithPosition());
        if (res) {
            return log;
        }
    }
    throw Error("ToManySteps");
}


function GetRules() {
    result = {};
    validTypes = ["<", ">", "0", "1", "?", "!"];
    lines = $('#p_scents > li');
    for (var i = 0; i < lines.length; i++) {
        ruleId = parseInt(lines[i].querySelector('span.input-group-addon > b').textContent);
        ruleType = lines[i].querySelector('select').value;
        inputs = lines[i].querySelectorAll('input');

        nextRuleId = inputs[0].value;
        alterNextRuleId = inputs[1].value;
        comment = inputs[2].value;

        if (validTypes.includes(ruleType)) {
            result[ruleId] = new Rule(ruleType + ":" + nextRuleId + ":" + alterNextRuleId, comment);
        }
    }
	result.length = lines.length;
    return result;
}

function SetRules(rules) {
	lines = $('#p_scents > li');
	for(i in rules){
		if(i == "length") continue;
		rule = rules[i];
		if(typeof(rule) != "undefined"){
			lines[i - 1].querySelector('select').value = rule.Raw[0];
			inputs = lines[i - 1].querySelectorAll('input');
			inputs[0].value = rule.Raw.split(':')[1];
			inputs[1].value = rule.Raw.split(':')[2];
			inputs[2].value = rule.Comment;
		}
		else{
			lines[i - 1].querySelector('select').value = " ";
			inputs = lines[i - 1].querySelectorAll('input');
			inputs[0].value = " ";
			inputs[1].value = " ";
			inputs[2].value = " ";
		}
	}
}

function GetInput() {
    input = $("#input_word").val();
    validator = /[01]+/;
    if (validator.test(input)) {
        return input;
    } else {
        throw Error("InvalidInput");
    
    }
}

function SetInput(value) {
	$("#input_word").val(value);
}

function RunPost(withDebug=false) {
    rules = GetRules();
    input = GetInput();
    result = GetResult(rules, input)
    
    var logTable = document.getElementById("debug");
    logTable.innerHTML = "";

    $("#result_word").val(result[result.length - 1]);
    if (withDebug) {
        for (var i = 0; i < result.length; i++) {
            var row = logTable.insertRow(i);
            cellNumer = row.insertCell(0);
            cellState = row.insertCell(1);

            cellNumer.innerText = i + 1;
            cellState.innerText = result[i];
        }
    }
}
