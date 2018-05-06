ace.define("ace/mode/ram_highlight_rules",["require","exports","module","ace/lib/oop","ace/mode/text_highlight_rules"], function(require, exports, module) {
"use strict";

var oop = require("../lib/oop");
var TextHighlightRules = require("./text_highlight_rules").TextHighlightRules;

var RamHighlightRules = function() {
    this.$rules = {
        "start" : [
            {
                token : "comment.line",
                regex : /\/\/.*$/
            }, {
				token : "string",
				regex : /^\s*\w+:/
			}, {
                token : "keyword.operator",
                regex : /(READ|WRITE|HALT)\b/
            }, {
				token : ["keyword.operator", "text"],
				regex : /(STORE)(\s*(?:\[[0-9]+\]|\[\[[0-9]+\]\]))/
			}, {
				token : ["keyword.operator", "text"],
				regex : /(LOAD|ADD|SUB|MULT|DIV)(\s*(?:[0-9]+|\[[0-9]+\]|\[\[[0-9]+\]\]))/
			}, {
				token: ["keyword.operator", "text"],
				regex: /(JUMP|JGTZ|JZERO)\b(\s*\w+)/
			}, {
				token : "text",
				regex: /\S+/,
				next: "error"
			}
        ],
		"error" : [
			{
				token: "text",
				regex: /.*/
			}
		]
		
    };
    
    this.normalizeRules();
};

RamHighlightRules.metaData = {
    fileTypes: ['ram'],
    name: 'Ram'
};

oop.inherits(RamHighlightRules, TextHighlightRules);

exports.RamHighlightRules = RamHighlightRules;
});

ace.define("ace/mode/ram",["require","exports","module","ace/lib/oop","ace/mode/text","ace/mode/ram_highlight_rules"], function(require, exports, module) {
"use strict";

var oop = require("../lib/oop");
var TextMode = require("./text").Mode;
var RamHighlightRules = require("./ram_highlight_rules").RamHighlightRules;

var Mode = function() {
    this.HighlightRules = RamHighlightRules;
    this.$behaviour = this.$defaultBehaviour;
};
oop.inherits(Mode, TextMode);

(function() {
    this.lineCommentStart = "//";
    this.$id = "ace/mode/ram";
}).call(Mode.prototype);

exports.Mode = Mode;
});
