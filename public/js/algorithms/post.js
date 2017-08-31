// public methods : 
// GetNextMove(state) => {-1, 0, 1}
// GetNextState(state) => {0, 1}
// GetNextRuleId(state) => RuleId
function Rule(rawText, comment) {
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
}


function GetResult(rules, state, position = 0, initialRule = 1) {
    algo = new PostMachine(state, rules, position, initialRule);

    for (var i = 0; i < 10000; i++) {
        res = algo.UpdateState();
        if (res) {
            return res;
        }
    }
    throw Error("ToManySteps");
}


function GetRules() {
    result = {}
    validTypes = "<>01?!";
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
    return result;
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

function RunPost() {
    rules = GetRules();
    input  = GetInput();
    $("#result_word").val(GetResult(rules, input));
}
