/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


var margin = {
    top: 10,
    right: 10,
    bottom: 100,
    left: 40
},
margin2 = {
    top: 430,
    right: 10,
    bottom: 20,
    left: 40
},
width = 960 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom,
    height2 = 500 - margin2.top - margin2.bottom;


var parseDate = d3.time.format("%Y-%m-%d").parse;

var x = d3.time.scale().range([0, width]),
    x2 = d3.time.scale().range([0, width]),
    y = d3.scale.linear().range([height, 0]),
    y2 = d3.scale.linear().range([height2, 0]);

var color = d3.scale.category20();

var xAxis = d3.svg.axis().scale(x).orient("bottom"),
    xAxis2 = d3.svg.axis().scale(x2).orient("bottom"),
    yAxis = d3.svg.axis().scale(y).orient("left");

var brush = d3.svg.brush()
    .x(x2)
    .on("brush", brushed);

var area = d3.svg.area()
    .interpolate("basis")
    .x(function (d) {
    return x(d.date);
})
    .y0(function (d) {
    return y(d.y0);
})
    .y1(function (d) {
    return y(d.y0 + d.y);
});

var area2 = d3.svg.area()
    .interpolate("basis")
    .x(function (d) {
    return x2(d.date);
})
    .y0(function (d) {
    return y2(d.y0);
})
    .y1(function (d) {
    return y2(d.y0 + d.y);
});

var stack = d3.layout.stack()
    .values(function (d) {
    return d.values;
});

var oRequest = new XMLHttpRequest();
var sURL = "http://www.corsproxy.com/mypage.iu.edu/~jlorince/debug/data100.tsv";
oRequest.open("GET", sURL, false);
oRequest.setRequestHeader("User-Agent", navigator.userAgent);
oRequest.send(null)
var data = oRequest.responseText;

var data = d3.tsv.parse(data);

data.forEach(function (d) {
    d.date = parseDate(d.date);
});

color.domain(d3.keys(data[0]).filter(function (key) {
    return key !== "date";
}));
var allTags = stack(color.domain().map(function (name) {
    return {
        name: name,
        values: data.map(function (d) {
            return {
                date: d.date,
                y: +d[name]
            };
        })
    };
}));

var focus, svg;
     svg = d3.select("body").append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom);

  focus = svg.append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

function updateData() {


    var nTags = document.getElementById('nTags_select').value;
    tags = allTags.slice(0, nTags);

    x.domain(d3.extent(data, function (d) {
        return d.date;
    }));
    y.domain([0, d3.max(tags, function (d) {
        return d3.max(d.values, function (d) {
            return d.y + d.y0;
        });
    })]);
    x2.domain(x.domain());
    y2.domain(y.domain());

    svg.append("defs").append("clipPath")
        .attr("id", "clip")
        .append("rect")
        .attr("width", width)
        .attr("height", height);

    var context = svg.append("g")
        .attr("transform", "translate(" + margin2.left + "," + margin2.top + ")");

    focus.selectAll('path')
        .data(tags)
        .enter()
        .append('path')
        .attr('clip-path', 'url(#clip)')
        .attr("d", function (d) {
        return area(d.values);
    })
        .attr('class', 'focus')
        .style("fill", function (d) {
        return color(d.name);
    });

    focus.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + height + ")")
        .call(xAxis);

    focus.append("g")
        .attr("class", "y axis")
        .call(yAxis);


    context.selectAll('path')
        .data(tags)
        .enter()
        .append('path')
        .attr('class', 'context')
        .attr("d", function (d) {
        return area2(d.values);
    })
        .style("fill", function (d) {
        return color(d.name);
    });


    context.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + height2 + ")")
        .call(xAxis2);

    context.append("g")
        .attr("class", "x brush")
        .call(brush)
        .selectAll("rect")
        .attr("y", -6)
        .attr("height", height2 + 7);
};

function brushed() {
    console.log(brush.extent() )
    
    x.domain(brush.empty() ? x2.domain() : brush.extent());
    focus.selectAll("path.focus").attr("d", function(d){return area(d.values)});
    focus.select(".x.axis").call(xAxis);
}

updateData();