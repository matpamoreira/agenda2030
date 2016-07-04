function gerarSunburst(){
    $('#grafico_menu').addClass('carregando');
    $("#explanation").css("visibility", "hidden");

    var cores = {
        '0': '#FFFFFF',
        '1': '#ED3A4B',
        '2': '#E5B54F',
        '3': '#50AB4D',
        '4': '#D72E3A',
        '5': '#EF5536',
        '6': '#2BC1E2',
        '7': '#FFCF26',
        '8': '#B62B53',
        '9': '#F37F3D',
        '10': '#EB2779',
        '11': '#FAAC3C',
        '12': '#CD9C40',
        '13': '#458F5A',
        '14': '#06A6DE',
        '15': '#66BC48',
        '16': '#077BAC',
        '17': '#1D5A7C'
    };

    var width       = 450,
        height      = 450,
        radius      = Math.min(width, height) / 2;

    var x = d3.scale.linear()
        .range([0, 2 * Math.PI]);

    var y = d3.scale.sqrt()
        .range([0, radius]);

    var root = {
        'name':'0',
        'size':17,
        'children':[
            {'name':'1','size':'1'},
            {'name':'2','size':'1'},
            {'name':'3','size':'1'},
            {'name':'4','size':'1'},
            {'name':'5','size':'1'},
            {'name':'6','size':'1'},
            {'name':'7','size':'1'},
            {'name':'8','size':'1'},
            {'name':'9','size':'1'},
            {'name':'10','size':'1'},
            {'name':'11','size':'1'},
            {'name':'12','size':'1'},
            {'name':'13','size':'1'},
            {'name':'14','size':'1'},
            {'name':'15','size':'1'},
            {'name':'16','size':'1'},
            {'name':'17','size':'1'}
        ]
    };

    var svg = d3.select("#grafico_menu").append("svg")
        .attr("width", width)
        .attr("height", height)
        .append("g")
        .attr("id", "container")
        .attr("transform", "translate(" + width / 2 + "," + (height / 2) + ")");

    var partition = d3.layout.partition()
        .sort(null)
        .value(function(d) { return d.size; });

    var arc = d3.svg.arc()
        .startAngle(function(d) { return Math.max(0, Math.min(2 * Math.PI, x(d.x))); })
        .endAngle(function(d) { return Math.max(0, Math.min(2 * Math.PI, x(d.x + d.dx))); })
        .innerRadius(function(d) { return Math.max(0, y(d.y)); })
        .outerRadius(function(d) { return Math.max(0, y(d.y + d.dy)); });

    function arcTween(d) {
        var xd = d3.interpolate(x.domain(), [d.x, d.x + d.dx]),
            yd = d3.interpolate(y.domain(), [d.y, 1]),
            yr = d3.interpolate(y.range(), [d.y ? 20 : 0, radius]);
        return function(d, i) {
            return i
                ? function(t) { return arc(d); }
                : function(t) { x.domain(xd(t)); y.domain(yd(t)).range(yr(t)); return arc(d); };
        };
    }

    function fill(d) {
        if( !d.parent ){
            return 'transparent';
        }
        if( !d.parent || !d.parent.parent ){
            return cores[d.name];
        }
        c = d3.rgb(cores[d.parent.name]);
        return c.brighter(0.5 * (d.parent.children.indexOf(d) + 1));
    }

    var path = svg.selectAll("path")
        .data(partition.nodes(root))
        .enter().append("path")
        .attr('d', arc)
        .style('fill', function(d){ return fill(d); } )
        .style('opacity', 1)
        .on('mouseover', over)
        .on("click", click);

    d3.select("#container").on("mouseleave", out);
    totalSize = path.node().__data__.value;

    var semAcao = false;
    function over(d){
        if(semAcao){
            return;
        }
        var percentage = (100 * d.value / totalSize).toPrecision(3);
        var percentageString = percentage.replace('.', ',') + '%';

        d3.select("#percentage").text(percentageString);
        d3.select("#grupo").text(d.name);
        d3.select("#explanation")
            .style("visibility", "");

        var sequenceArray = getAncestors(d);

        d3.selectAll("path").style("opacity", 0.3);

        // Then highlight only those that are an ancestor of the current segment.
        svg.selectAll("path")
            .filter(function(node) {
                return (sequenceArray.indexOf(node) >= 0);
            })
            .style("opacity", 1);
    }

    function getAncestors(node) {
        var path = [];
        var current = node;
        while (current) {
            path.unshift(current);
            current = current.parent;
        }
        return path;
    }

    var ultimoD = undefined;

    function out(){
        if(semAcao){
            return;
        }
        if( ultimoD != undefined ){
            over(ultimoD);
            return;
        }

        // Deactivate all segments during transition.
        d3.selectAll("path").on("mouseover", null);

        // Transition each segment to full opacity and then reactivate it.
        d3.selectAll("path")
            .transition()
            .duration(300)
            .style("opacity", 1)
            .each("end", function() {
                d3.select(this).on("mouseover", over);
            });

        d3.select("#explanation")
            .transition()
            .duration(500)
            .style("visibility", "hidden");
    }

    function click(d){
        $.fn.fullpage.moveTo(2, d.name);
    }

    d3.select(self.frameElement).style("height", height + "px");
}