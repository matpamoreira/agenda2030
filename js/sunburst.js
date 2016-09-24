function gerarSunburst(){
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

    var width  = Math.floor($( document ).width() * 0.8),
        height = Math.floor($( document ).height() * 0.8),
        radius = Math.min(width, height) / 2;

    $('#explanation').css('height', height - 20);
    $('#ex_wp').css('width', radius);
    $('#ex_wp').css('left', Math.floor(($( document ).width() / 2) - (radius / 2)) + 10);
    var x = d3.scale.linear()
        .range([0, 2 * Math.PI]);

    var y = d3.scale.sqrt()
        .range([0, radius]);

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
            return cores[d.chave];
        }
        c = d3.rgb(cores[d.parent.chave]);
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

    function over(d){
        if(d.parent == undefined){
            d3.select("#explanation").style("visibility", "hidden");
            return;
        }
        $("#ex_wp").removeClass();
        $("#ex_wp").addClass('c' + d.chave);
        d3.select("#explanation").html('Objetivo ' + d.chave + ':<br/>' + d.name);
        d3.select("#explanation").style("visibility", "");

        var sequenceArray = getAncestors(d);

        d3.selectAll("path").style("opacity", 0.3);

        // Then highlight only those that are an ancestor of the current segment.
        svg.selectAll("path")
            .filter(function(node) {
                return (sequenceArray.indexOf(node) >= 0);
            })
            .style("opacity", 1);
    }

    function getAncestors(node){
        var path = [];
        var current = node;
        while (current) {
            path.unshift(current);
            current = current.parent;
        }
        return path;
    }

    function out(){
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
        $.fn.fullpage.moveTo(2, d.chave);
    }

    d3.select(self.frameElement).style("height", height + "px");
}