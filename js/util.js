function replaceAll(s, m, r, p) {
	if(!('contains' in String.prototype)) {
		String.prototype.contains = function(str, startIndex) {
			return -1 !== String.prototype.indexOf.call(this, str, startIndex);
		};
	}

	return s === p || r.contains(m) ? s : replaceAll(s.replace(m, r), m, r, s);
}

function currencyFormatDE (num) {
    return num
       .toFixed(2) // always two decimal digits
       .replace(".", ",") // replace decimal point character with ,
       .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.") + " ,"; // use . as a separator
}

function getStyleRuleValue(style, selector, titleArquivo) {
    for (var i = 0; i < document.styleSheets.length; i++) {
        var mysheet = document.styleSheets[i];
		if(mysheet.title != titleArquivo){
			continue;
		}
        var myrules = mysheet.cssRules ? mysheet.cssRules : mysheet.rules;
        for (var j = 0; j < myrules.length; j++) {
            if (myrules[j].selectorText && myrules[j].selectorText.toLowerCase() === selector) {
                return myrules[j].style[style];
            }
        }
    }
}

function wrap(text, width) {
	text.each(function() {
		var text = d3.select(this),
		words = text.text().split(/\s+/).reverse(),
		word,
		line = [],
		y = 0,
		tspan = text.text(null).append("tspan").attr("x", 0).attr("y", y + 'em');
		var lineNumber = 0;
		var margin = 0.1;// ems
		while (word = words.pop()) {
			line.push(word);
			tspan.text(line.join(" "));
			if (tspan.node().getComputedTextLength() > width) {
				lineNumber++;
				line.pop();
				tspan.text(line.join(" "));
				line = [word];
				tspan = text.append("tspan").attr("x", 0).attr("y", (lineNumber + margin) + "em").text(word);
			}
		}
	});
}


function wrap2(text, width) {
	text.each(function() {
		var text = d3.select(this),
			words = text.text().split(/\s+/).reverse(),
			word,
			line = [],
			y = 0,
			tspan = text.text(null).append("tspan").attr("x", 0).attr("y", y + 'em');
		var lineNumber = 0;
		var margin = 0.1;// ems
		while (word = words.pop()) {
			line.push(word);
			tspan.text(line.join(" "));
			if (tspan.node().getComputedTextLength() > width) {
				lineNumber++;
				line.pop();
				tspan.text(line.join(" "));
				line = [word];
				tspan = text.append("tspan").attr("x", 0).attr("y", (lineNumber + margin) + "em").text(word);
			}
		}
	});
}