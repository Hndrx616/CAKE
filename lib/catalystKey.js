<script>
/*SIDEBAR TRANSITION*/
function Hill(hillEl, overlayEl) {
          this.hill = $(hillEl);
          this.overlay = $(overlayEl);
          this.wWidth = $(window).width();
          this.wHeight = $(window).height();
          this.dHeight = $(document).height();
        }

        Hill.prototype = {
          init: function(){
            this.bindHandlers();
          },

          bindHandlers: function(){
            var self = this;

            $('#hill-link').on('click', function(){
              self.showHill();
            });

            $(window)
              .resize(function() {
                self.setWinSize($(this));
                self.setHillPosition();
             })
               .scroll(function() {
                self.setWinSize($(this));
                self.setHillPosition();
             });

            $('.close-button').click(function(){
              self.hideHill();
            });
          },

          showHill: function(){
            this.overlay.fadeIn();
            this.hill.fadeIn();
            this.setHillPosition();
          },

          hideHill: function(){
            this.overlay.fadeOut();
            this.hill.fadeOut();
          },

          setHillPosition: function(){
            var hillHeight = this.hill.outerHeight(),
                hillWidth = this.hill.outerWidth(),
                scrollTop = $(window).scrollTop();

            if(this.wHeight < hillHeight){
              this.hill.css('top', scrollTop);
            } else {
              this.hill.css('top', this.centerVertically(this.wHeight,hillHeight,scrollTop));
            }

            if(this.wWidth < hillWidth){
              this.hill.css('left', 0);
            } else {
              this.hill.css('left', this.centerHorizontally(this.wWidth,hillWidth));
            }
          },

          centerVertically: function(w, m, scroll){
            return ((w - m)/2 + scroll);
          },

          centerHorizontally: function(w, m){
            return (w - m)/2;
          },

          setWinSize:function(win){
            this.wWidth = win.width();
            this.wHeight = win.height();
          }
        }


      $(document).ready(function(){
        var hill = new Hill($('.hill-window'), $('.hill-overlay'));
        hill.init();
      });

function Hill2(hillE2,overlayE2){this.hill2=$(hillE2);this.overlay=$(overlayE2);this.wWidth=$(window).width();this.wHeight=$(window).height();this.dHeight=$(document).height();}
Hill2.prototype={init:function(){this.bindHandlers();},bindHandlers:function(){var self=this;$('#hill-link2').on('click',function(){self.showHill2();});$(window).resize(function(){self.setWinSize($(this));self.setHill2Position();}).scroll(function(){self.setWinSize($(this));self.setHill2Position();});$('.close-button2').click(function(){self.hideHill2();});},showHill2:function(){this.overlay.fadeIn();this.hill2.fadeIn();this.setHill2Position();},hideHill2:function(){this.overlay.fadeOut();this.hill2.fadeOut();},setHill2Position:function(){var hill2Height=this.hill2.outerHeight(),hill2Width=this.hill2.outerWidth(),scrollTop=$(window).scrollTop();if(this.wHeight<hill2Height){this.hill2.css('top',scrollTop);}else{this.hill2.css('top',this.centerVertically(this.wHeight,hill2Height,scrollTop));}
if(this.wWidth<hill2Width){this.hill2.css('left',0);}else{this.hill2.css('left',this.centerHorizontally(this.wWidth,hill2Width));}},centerVertically:function(w,m,scroll){return((w-m)/2+scroll);},centerHorizontally:function(w,m){return(w-m)/2;},setWinSize:function(win){this.wWidth=win.width();this.wHeight=win.height();}}
$(document).ready(function(){var hill2=new Hill2($('.hill-window2'),$('.hill-overlay2'));hill2.init();});

function Hill3(hillE3,overlayE3){this.hill3=$(hillE3);this.overlay=$(overlayE3);this.wWidth=$(window).width();this.wHeight=$(window).height();this.dHeight=$(document).height();}
Hill3.prototype={init:function(){this.bindHandlers();},bindHandlers:function(){var self=this;$('#hill-link3').on('click',function(){self.showHill3();});$(window).resize(function(){self.setWinSize($(this));self.setHill3Position();}).scroll(function(){self.setWinSize($(this));self.setHill3Position();});$('.close-button3').click(function(){self.hideHill3();});},showHill3:function(){this.overlay.fadeIn();this.hill3.fadeIn();this.setHill3Position();},hideHill3:function(){this.overlay.fadeOut();this.hill3.fadeOut();},setHill3Position:function(){var hill3Height=this.hill3.outerHeight(),hill3Width=this.hill3.outerWidth(),scrollTop=$(window).scrollTop();if(this.wHeight<hill3Height){this.hill3.css('top',scrollTop);}else{this.hill3.css('top',this.centerVertically(this.wHeight,hill3Height,scrollTop));}
if(this.wWidth<hill3Width){this.hill3.css('left',0);}else{this.hill3.css('left',this.centerHorizontally(this.wWidth,hill3Width));}},centerVertically:function(w,m,scroll){return((w-m)/2+scroll);},centerHorizontally:function(w,m){return(w-m)/2;},setWinSize:function(win){this.wWidth=win.width();this.wHeight=win.height();}}
$(document).ready(function(){var hill3=new Hill3($('.hill-window3'),$('.hill-overlay3'));hill3.init();});

function Hill4(hillE4,overlayE4){this.hill4=$(hillE4);this.overlay=$(overlayE4);this.wWidth=$(window).width();this.wHeight=$(window).height();this.dHeight=$(document).height();}
Hill4.prototype={init:function(){this.bindHandlers();},bindHandlers:function(){var self=this;$('#hill-link4').on('click',function(){self.showHill4();});$(window).resize(function(){self.setWinSize($(this));self.setHill4Position();}).scroll(function(){self.setWinSize($(this));self.setHill4Position();});$('.close-button4').click(function(){self.hideHill4();});},showHill4:function(){this.overlay.fadeIn();this.hill4.fadeIn();this.setHill4Position();},hideHill4:function(){this.overlay.fadeOut();this.hill4.fadeOut();},setHill4Position:function(){var hill4Height=this.hill4.outerHeight(),hill4Width=this.hill4.outerWidth(),scrollTop=$(window).scrollTop();if(this.wHeight<hill4Height){this.hill4.css('top',scrollTop);}else{this.hill4.css('top',this.centerVertically(this.wHeight,hill4Height,scrollTop));}
if(this.wWidth<hill4Width){this.hill4.css('left',0);}else{this.hill4.css('left',this.centerHorizontally(this.wWidth,hill4Width));}},centerVertically:function(w,m,scroll){return((w-m)/2+scroll);},centerHorizontally:function(w,m){return(w-m)/2;},setWinSize:function(win){this.wWidth=win.width();this.wHeight=win.height();}}
$(document).ready(function(){var hill4=new Hill4($('.hill-window4'),$('.hill-overlay4'));hill4.init();});

function Hill5(hillE5,overlayE5){this.hill5=$(hillE5);this.overlay=$(overlayE5);this.wWidth=$(window).width();this.wHeight=$(window).height();this.dHeight=$(document).height();}
Hill5.prototype={init:function(){this.bindHandlers();},bindHandlers:function(){var self=this;$('#hill-link5').on('click',function(){self.showHill5();});$(window).resize(function(){self.setWinSize($(this));self.setHill5Position();}).scroll(function(){self.setWinSize($(this));self.setHill5Position();});$('.close-button5').click(function(){self.hideHill5();});},showHill5:function(){this.overlay.fadeIn();this.hill5.fadeIn();this.setHill5Position();},hideHill5:function(){this.overlay.fadeOut();this.hill5.fadeOut();},setHill5Position:function(){var hill5Height=this.hill5.outerHeight(),hill5Width=this.hill5.outerWidth(),scrollTop=$(window).scrollTop();if(this.wHeight<hill5Height){this.hill5.css('top',scrollTop);}else{this.hill5.css('top',this.centerVertically(this.wHeight,hill5Height,scrollTop));}
if(this.wWidth<hill5Width){this.hill5.css('left',0);}else{this.hill5.css('left',this.centerHorizontally(this.wWidth,hill5Width));}},centerVertically:function(w,m,scroll){return((w-m)/2+scroll);},centerHorizontally:function(w,m){return(w-m)/2;},setWinSize:function(win){this.wWidth=win.width();this.wHeight=win.height();}}
$(document).ready(function(){var hill5=new Hill5($('.hill-window5'),$('.hill-overlay5'));hill5.init();});

function Hill6(hillE6,overlayE6){this.hill6=$(hillE6);this.overlay=$(overlayE6);this.wWidth=$(window).width();this.wHeight=$(window).height();this.dHeight=$(document).height();}
Hill6.prototype={init:function(){this.bindHandlers();},bindHandlers:function(){var self=this;$('#hill-link6').on('click',function(){self.showHill6();});$(window).resize(function(){self.setWinSize($(this));self.setHill6Position();}).scroll(function(){self.setWinSize($(this));self.setHill6Position();});$('.close-button6').click(function(){self.hideHill6();});},showHill6:function(){this.overlay.fadeIn();this.hill6.fadeIn();this.setHill6Position();},hideHill6:function(){this.overlay.fadeOut();this.hill6.fadeOut();},setHill6Position:function(){var hill6Height=this.hill6.outerHeight(),hill6Width=this.hill6.outerWidth(),scrollTop=$(window).scrollTop();if(this.wHeight<hill6Height){this.hill6.css('top',scrollTop);}else{this.hill6.css('top',this.centerVertically(this.wHeight,hill6Height,scrollTop));}
if(this.wWidth<hill6Width){this.hill6.css('left',0);}else{this.hill6.css('left',this.centerHorizontally(this.wWidth,hill6Width));}},centerVertically:function(w,m,scroll){return((w-m)/2+scroll);},centerHorizontally:function(w,m){return(w-m)/2;},setWinSize:function(win){this.wWidth=win.width();this.wHeight=win.height();}}
$(document).ready(function(){var hill6=new Hill6($('.hill-window6'),$('.hill-overlay6'));hill6.init();});
/*PIZZA CHART*/
function sliceSize(dataNum, dataTotal) {
  return (dataNum / dataTotal) * 360;
}
function addSlice(sliceSize, pieElement, offset, sliceID, color) {
  $(pieElement).append("<div class='slice "+sliceID+"'><span></span></div>");
  var offset = offset - 1;
  var sizeRotation = -179 + sliceSize;
  $("."+sliceID).css({
    "transform": "rotate("+offset+"deg) translate3d(0,0,0)"
  });
  $("."+sliceID+" span").css({
    "transform"       : "rotate("+sizeRotation+"deg) translate3d(0,0,0)",
    "background-color": color
  });
}
function iterateSlices(sliceSize, pieElement, offset, dataCount, sliceCount, color) {
  var sliceID = "s"+dataCount+"-"+sliceCount;
  var maxSize = 179;
  if(sliceSize<=maxSize) {
    addSlice(sliceSize, pieElement, offset, sliceID, color);
  } else {
    addSlice(maxSize, pieElement, offset, sliceID, color);
    iterateSlices(sliceSize-maxSize, pieElement, offset+maxSize, dataCount, sliceCount+1, color);
  }
}
function createPie(dataElement, pieElement) {
  var listData = [];
  $(dataElement+" span").each(function() {
    listData.push(Number($(this).html()));
  });
  var listTotal = 0;
  for(var i=0; i<listData.length; i++) {
    listTotal += listData[i];
  }
  var offset = 0;
  var color = [
    "#5AB3D1", 
    "#1abc9c", 
    "#ffbb75", 
    "tomato"
  ];
  for(var i=0; i<listData.length; i++) {
    var size = sliceSize(listData[i], listTotal);
    iterateSlices(size, pieElement, offset, i, 0, color[i]);
    $(dataElement+" li:nth-child("+(i+1)+")").css("border-color", color[i]);
    offset += size;
  }
}
createPie(".pieID.legend", ".pieID.pie");
/*HORZ-BAR GRAPH*/
HorizontalBarGraph = function(el, series) {
  this.el = d3.select(el);
  this.series = series;
};

HorizontalBarGraph.prototype.draw = function() {
  var x = d3.scale.linear()
    .domain([0, d3.max(this.series, function(d) { return d.value })])
    .range([0, 100]);

  var segment = this.el
    .selectAll(".horizontal-bar-graph-segment")
      .data(this.series)
    .enter()
      .append("div").classed("horizontal-bar-graph-segment", true);

  segment
    .append("div").classed("horizontal-bar-graph-label", true)
      .text(function(d) { return d.label });

  segment
    .append("div").classed("horizontal-bar-graph-value", true)
      .append("div").classed("horizontal-bar-graph-value-bar", true)
        .style("background-color", function(d) { return d.color })
        .text(function(d) { return d.inner_label ? d.inner_label : "" })
        .transition()
          .duration(1000)
          .style("min-width", function(d) { return x(d.value) + "%" });

};

var graph = new HorizontalBarGraph('#my-graph', [
  {label: "Desktop", inner_label: "865 visits", value: 1167, color: "#1abc9c" },
  {label: "Mobile",  inner_label: "543 visits",   value: 543,  color: "#1abc9c" },
  {label: "Tablet",  inner_label: "224 visits",   value: 224,  color: "#1abc9c" }
]);
graph.draw();
/*PIE CHART*/
$(function() {
  $('.chartrotate').easyPieChart({
    scaleColor: "#ecf0f1",
    lineWidth: 20,
    lineCap: 'butt',
    barColor: '#1abc9c',
    trackColor:	"#ecf0f1",
    size: 160,
    animate: 500
  });
});
/*LINE-CHART*/
class TimeFormatter {

  static getDefault() {
    return d3.time.format.multi([
      // See https://github.com/mbostock/d3/wiki/Time-Formatting#format_multi
      // which is required for a time.scale()
      ['.%L', function(d) { return d.getMilliseconds(); }],
      [':%S', function(d) { return d.getSeconds(); }],
      ['%I:%M', function(d) { return d.getMinutes(); }],
      ['%I %p', function(d) { return d.getHours(); }],
      ['%a %d', function(d) { return d.getDay() && d.getDate() != 1; }],
      ['%b %d', function(d) { return d.getDate() != 1; }],
      ['%B', function(d) { return d.getMonth(); }],
      ['%Y', function() { return true; }]
    ]);
  }
}

const formatDate = d3.time.format('%Y-%m-%d');

function drawLineGraph (options, data) {
  const description = '';

  /** Make it less verbose to access default margin values */
  const margin = Object.assign(options.chart.margin);
  const width = options.chart.width - margin.left - margin.right;
  const height = options.chart.height - margin.top - margin.bottom;

  const allDates = [];
  const allValues = [];

  let xScale;
  let yScale;
  let xAxis;
  let yAxis;
  let lineData;

  function prepareData(data) {
    data.forEach((entry) => {
      allDates.push(formatDate.parse(entry[0]));
      allValues.push(entry[1]);
    });
  }

  function defineScales() {
    xScale = d3.time.scale().range([0, width]);
    yScale = d3.scale.linear().range([height, 0]);
  }

  function defineAxes() {
    xAxis = d3.svg.axis()
      .scale(xScale)
      .orient('bottom')
      .tickPadding(10) // move tick text further away from tick lines
      .tickSize(10, 0)
      .ticks(5)
      .tickFormat(TimeFormatter.getDefault());
    yAxis = d3.svg.axis()
      .scale(yScale)
      .orient('left')
      .tickPadding(10) // move tick text further away from tick lines
      .tickSize(20, 0) // add space to the right of the y axis grid line (before the first marker)
      .ticks(6)
      .tickFormat((d) => { return `${d}%`; });
  }

  function defineLineData() {
    lineData = d3.svg.line()
      .x((d) => {
        let date = formatDate.parse(d[0]);
        return xScale(date);
      })
      .y((d) => {
        return yScale(d[1]);
      });
  }

  function defineScaleDomains(x, y) {
    /** Set the domain of the axes using min/max values */
    x.domain(d3.extent(allDates));
    /** Given it's a percentage value from 0% to 100%, we can directly set min/max */
    y.domain([0, 100]);
  }

  function renderGraph(options, data) {
    /**
     * Start rendering to the view
     * Note:
     *  - The styles set below are set as default. Styles should live in the graph stylesheet
     *  - Visual order is determined by the order an element gets drawn to the 'canvas'
     */
    const svg = d3.select(`#${options.chart.id}`)
      .append('svg')
      .attr({
        'width': options.chart.width,
        'height': options.chart.height,
        'xmlns': 'http://www.w3.org/2000/svg',
        'version': '1.1','fill': '#eee','fontcolor': '#eee'
      });

    /** Roll the credits */
    svg.append('desc').html(description);

    const visualisation = svg.append('g')
      .attr({
        'id': 'visualisation',
        'transform': `translate(${margin.left}, ${margin.top})`
      });

    const xAxisGroup = visualisation.append('g')
      .attr({
        'class': 'axis x',
        'transform': `translate(0, ${height})`
      })
      .call(xAxis);

    xAxisGroup.selectAll('line')
      .attr({'stroke': '#eee'});

    visualisation.append('g')
      .attr({'class': 'axis y'})
      .call(yAxis);

    /** Add horizontal lines to the graph as reference points */
    visualisation.append('g')
      .attr({'class': 'grid'})
      .call(yAxis.tickSize(-width - margin.right, 0, 0).tickFormat(''))
      .selectAll('line')
      .attr({'stroke': '#eee'});

    visualisation.append('path')
      .datum(data)
      .attr({
        'id': 'visualisation-line',
        'stroke-linejoin': 'round',
        'fill': 'none',
        'fontcolor': '#eee',
        'stroke-width': '1px',
        'stroke': '#eee',
        'd': lineData,
      });

    visualisation.selectAll('circle')
      .data(data)
      .enter()
      .append('circle')
      .attr({
        'class': 'marker',
        'r': options.chart.markerRadius,
        'cx': (d) => {
          let date = formatDate.parse(d[0]);
          return xScale(date);
        },
        'cy': (d) => {
          return yScale(d[1]);
        }
      });
  }

  prepareData(data);
  defineScales();
  defineAxes();
  defineLineData();
  defineScaleDomains(xScale, yScale);
  renderGraph(options, data);
}
function drawSecondGraph(options,data){const description='';const margin=Object.assign(options.chart.margin);const width=options.chart.width-margin.left-margin.right;const height=options.chart.height-margin.top-margin.bottom;const allDates=[];const allValues=[];let xScale;let yScale;let xAxis;let yAxis;let lineData;function prepareData(data){data.forEach((entry)=>{allDates.push(formatDate.parse(entry[0]));allValues.push(entry[1]);});}
function defineScales(){xScale=d3.time.scale().range([0,width]);yScale=d3.scale.linear().range([height,0]);}
  function defineAxes(){xAxis=d3.svg.axis().scale(xScale).orient('bottom').tickPadding(10).tickSize(10,0).ticks(5).tickFormat(TimeFormatter.getDefault());yAxis=d3.svg.axis().scale(yScale).orient('left').tickPadding(10).tickSize(20,0).ticks(6).tickFormat((d)=>{return`${d}%`;});}
  function defineLineData(){lineData=d3.svg.line().x((d)=>{let date=formatDate.parse(d[0]);return xScale(date);}).y((d)=>{return yScale(d[1]);});}
  function defineScaleDomains(n,a){n.domain(d3.extent(allDates)),a.domain([0,100])}
  function renderGraph(options,data){const svg=d3.select(`#${options.chart.id}`).append('svg').attr({'width':options.chart.width,'height':options.chart.height,'xmlns':'http://www.w3.org/2000/svg','version':'1.1','fill':'#eee','fontcolor':'#eee'});svg.append('desc').html(description);const visualisation=svg.append('g').attr({'id':'visualisation','transform':`translate(${margin.left},${margin.top})`});const xAxisGroup=visualisation.append('g').attr({'class':'axis x','transform':`translate(0,${height})`}).call(xAxis);xAxisGroup.selectAll('line').attr({'stroke':'#eee'});visualisation.append('g').attr({'class':'axis y'}).call(yAxis);visualisation.append('g').attr({'class':'grid'}).call(yAxis.tickSize(-width-margin.right,0,0).tickFormat('')).selectAll('line').attr({'stroke':'#eee'});visualisation.append('path').datum(data).attr({'id':'visualisation-line','stroke-linejoin':'round','fill':'none','fontcolor':'#eee','stroke-width':'1px','stroke':'#eee','d':lineData,});visualisation.selectAll('circle').data(data).enter().append('circle').attr({'class':'marker','r':options.chart.markerRadius,'cx':(d)=>{let date=formatDate.parse(d[0]);return xScale(date);},'cy':(d)=>{return yScale(d[1]);}});}
  prepareData(data),defineScales(),defineAxes(),defineLineData(),defineScaleDomains(xScale,yScale),renderGraph(options,data);
}
function drawThirdGraph(options,data){const description='';const margin=Object.assign(options.chart.margin);const width=options.chart.width-margin.left-margin.right;const height=options.chart.height-margin.top-margin.bottom;const allDates=[];const allValues=[];let xScale;let yScale;let xAxis;let yAxis;let lineData;function prepareData(data){data.forEach((entry)=>{allDates.push(formatDate.parse(entry[0]));allValues.push(entry[1]);});}
function defineScales(){xScale=d3.time.scale().range([0,width]);yScale=d3.scale.linear().range([height,0]);}
  function defineAxes(){xAxis=d3.svg.axis().scale(xScale).orient('bottom').tickPadding(10).tickSize(10,0).ticks(5).tickFormat(TimeFormatter.getDefault());yAxis=d3.svg.axis().scale(yScale).orient('left').tickPadding(10).tickSize(20,0).ticks(6).tickFormat((d)=>{return`${d}%`;});}
  function defineLineData(){lineData=d3.svg.line().x((d)=>{let date=formatDate.parse(d[0]);return xScale(date);}).y((d)=>{return yScale(d[1]);});}
  function defineScaleDomains(n,a){n.domain(d3.extent(allDates)),a.domain([0,100])}
  function renderGraph(options,data){const svg=d3.select(`#${options.chart.id}`).append('svg').attr({'width':options.chart.width,'height':options.chart.height,'xmlns':'http://www.w3.org/2000/svg','version':'1.1','fill':'#eee','fontcolor':'#eee'});svg.append('desc').html(description);const visualisation=svg.append('g').attr({'id':'visualisation','transform':`translate(${margin.left},${margin.top})`});const xAxisGroup=visualisation.append('g').attr({'class':'axis x','transform':`translate(0,${height})`}).call(xAxis);xAxisGroup.selectAll('line').attr({'stroke':'#eee'});visualisation.append('g').attr({'class':'axis y'}).call(yAxis);visualisation.append('g').attr({'class':'grid'}).call(yAxis.tickSize(-width-margin.right,0,0).tickFormat('')).selectAll('line').attr({'stroke':'#eee'});visualisation.append('path').datum(data).attr({'id':'visualisation-line','stroke-linejoin':'round','fill':'none','fontcolor':'#eee','stroke-width':'1px','stroke':'#eee','d':lineData,});visualisation.selectAll('circle').data(data).enter().append('circle').attr({'class':'marker','r':options.chart.markerRadius,'cx':(d)=>{let date=formatDate.parse(d[0]);return xScale(date);},'cy':(d)=>{return yScale(d[1]);}});}
  prepareData(data),defineScales(),defineAxes(),defineLineData(),defineScaleDomains(xScale,yScale),renderGraph(options,data);
}
function drawFourthGraph(options,data){const description='';const margin=Object.assign(options.chart.margin);const width=options.chart.width-margin.left-margin.right;const height=options.chart.height-margin.top-margin.bottom;const allDates=[];const allValues=[];let xScale;let yScale;let xAxis;let yAxis;let lineData;function prepareData(data){data.forEach((entry)=>{allDates.push(formatDate.parse(entry[0]));allValues.push(entry[1]);});}
function defineScales(){xScale=d3.time.scale().range([0,width]);yScale=d3.scale.linear().range([height,0]);}
  function defineAxes(){xAxis=d3.svg.axis().scale(xScale).orient('bottom').tickPadding(10).tickSize(10,0).ticks(5).tickFormat(TimeFormatter.getDefault());yAxis=d3.svg.axis().scale(yScale).orient('left').tickPadding(10).tickSize(20,0).ticks(6).tickFormat((d)=>{return`${d}%`;});}
  function defineLineData(){lineData=d3.svg.line().x((d)=>{let date=formatDate.parse(d[0]);return xScale(date);}).y((d)=>{return yScale(d[1]);});}
  function defineScaleDomains(n,a){n.domain(d3.extent(allDates)),a.domain([0,100])}
  function renderGraph(options,data){const svg=d3.select(`#${options.chart.id}`).append('svg').attr({'width':options.chart.width,'height':options.chart.height,'xmlns':'http://www.w3.org/2000/svg','version':'1.1','fill':'#eee','fontcolor':'#eee'});svg.append('desc').html(description);const visualisation=svg.append('g').attr({'id':'visualisation','transform':`translate(${margin.left},${margin.top})`});const xAxisGroup=visualisation.append('g').attr({'class':'axis x','transform':`translate(0,${height})`}).call(xAxis);xAxisGroup.selectAll('line').attr({'stroke':'#eee'});visualisation.append('g').attr({'class':'axis y'}).call(yAxis);visualisation.append('g').attr({'class':'grid'}).call(yAxis.tickSize(-width-margin.right,0,0).tickFormat('')).selectAll('line').attr({'stroke':'#eee'});visualisation.append('path').datum(data).attr({'id':'visualisation-line','stroke-linejoin':'round','fill':'none','fontcolor':'#eee','stroke-width':'1px','stroke':'#eee','d':lineData,});visualisation.selectAll('circle').data(data).enter().append('circle').attr({'class':'marker','r':options.chart.markerRadius,'cx':(d)=>{let date=formatDate.parse(d[0]);return xScale(date);},'cy':(d)=>{return yScale(d[1]);}});}
  prepareData(data),defineScales(),defineAxes(),defineLineData(),defineScaleDomains(xScale,yScale),renderGraph(options,data);
}
function drawFifthGraph(options,data){const description='';const margin=Object.assign(options.chart.margin);const width=options.chart.width-margin.left-margin.right;const height=options.chart.height-margin.top-margin.bottom;const allDates=[];const allValues=[];let xScale;let yScale;let xAxis;let yAxis;let lineData;function prepareData(data){data.forEach((entry)=>{allDates.push(formatDate.parse(entry[0]));allValues.push(entry[1]);});}
function defineScales(){xScale=d3.time.scale().range([0,width]);yScale=d3.scale.linear().range([height,0]);}
  function defineAxes(){xAxis=d3.svg.axis().scale(xScale).orient('bottom').tickPadding(10).tickSize(10,0).ticks(5).tickFormat(TimeFormatter.getDefault());yAxis=d3.svg.axis().scale(yScale).orient('left').tickPadding(10).tickSize(20,0).ticks(6).tickFormat((d)=>{return`${d}%`;});}
  function defineLineData(){lineData=d3.svg.line().x((d)=>{let date=formatDate.parse(d[0]);return xScale(date);}).y((d)=>{return yScale(d[1]);});}
  function defineScaleDomains(n,a){n.domain(d3.extent(allDates)),a.domain([0,100])}
  function renderGraph(options,data){const svg=d3.select(`#${options.chart.id}`).append('svg').attr({'width':options.chart.width,'height':options.chart.height,'xmlns':'http://www.w3.org/2000/svg','version':'1.1','fill':'#eee','fontcolor':'#eee'});svg.append('desc').html(description);const visualisation=svg.append('g').attr({'id':'visualisation','transform':`translate(${margin.left},${margin.top})`});const xAxisGroup=visualisation.append('g').attr({'class':'axis x','transform':`translate(0,${height})`}).call(xAxis);xAxisGroup.selectAll('line').attr({'stroke':'#eee'});visualisation.append('g').attr({'class':'axis y'}).call(yAxis);visualisation.append('g').attr({'class':'grid'}).call(yAxis.tickSize(-width-margin.right,0,0).tickFormat('')).selectAll('line').attr({'stroke':'#eee'});visualisation.append('path').datum(data).attr({'id':'visualisation-line','stroke-linejoin':'round','fill':'none','fontcolor':'#eee','stroke-width':'1px','stroke':'#eee','d':lineData,});visualisation.selectAll('circle').data(data).enter().append('circle').attr({'class':'marker','r':options.chart.markerRadius,'cx':(d)=>{let date=formatDate.parse(d[0]);return xScale(date);},'cy':(d)=>{return yScale(d[1]);}});}
  prepareData(data),defineScales(),defineAxes(),defineLineData(),defineScaleDomains(xScale,yScale),renderGraph(options,data);
}
const graphOptions = {
  chart: {
    margin: {
      top: 20,
      right: 30,
      bottom: 30,
      left: 70
    },
    width: 620,
    height: 280,
    id: 'Graph',
    markerRadius: 5
  },
};
const graphSecondOptions = {
  chart: {
    margin: {
      top: 20,
      right: 30,
      bottom: 30,
      left: 70
    },
    width: 620,
    height: 280,
    id: 'Graph2',
    markerRadius: 5
  },
};
const graphThirdOptions = {
  chart: {
    margin: {
      top: 20,
      right: 30,
      bottom: 30,
      left: 70
    },
    width: 620,
    height: 280,
    id: 'Graph3',
    markerRadius: 5
  },
};
const graphFourthOptions = {
  chart: {
    margin: {
      top: 20,
      right: 30,
      bottom: 30,
      left: 70
    },
    width: 620,
    height: 280,
    id: 'Graph4',
    markerRadius: 5
  },
};
const graphFifthOptions = {
  chart: {
    margin: {
      top: 20,
      right: 30,
      bottom: 30,
      left: 70
    },
    width: 620,
    height: 280,
    id: 'Graph5',
    markerRadius: 5
  },
};

const graphData = new Array();
for (let i = 0; i < 1; i++) {
  for (let y = 0; y < 7; y++) {
    graphData.push([`2016-${i+1}-${y+1}`, Math.round(Math.random() * 100 / 10) * 10]);
  }
}
const graphSecondData = new Array();
for (let i = 0; i < 1; i++) {
  for (let y = 0; y < 7; y++) {
    graphSecondData.push([`2016-${i+1}-${y+1}`, Math.round(Math.random() * 100 / 10) * 10]);
  }
}
const graphThirdData = new Array();
for (let i = 0; i < 1; i++) {
  for (let y = 0; y < 7; y++) {
    graphThirdData.push([`2016-${i+1}-${y+1}`, Math.round(Math.random() * 100 / 10) * 10]);
  }
}
const graphFourthData = new Array();
for (let i = 0; i < 1; i++) {
  for (let y = 0; y < 7; y++) {
    graphFourthData.push([`2016-${i+1}-${y+1}`, Math.round(Math.random() * 100 / 10) * 10]);
  }
}
const graphFifthData = new Array();
for (let i = 0; i < 1; i++) {
  for (let y = 0; y < 7; y++) {
    graphFifthData.push([`2016-${i+1}-${y+1}`, Math.round(Math.random() * 100 / 10) * 10]);
  }
}
drawLineGraph(graphOptions, graphData);
drawSecondGraph(graphSecondOptions, graphSecondData);
drawThirdGraph(graphThirdOptions, graphThirdData);
drawFourthGraph(graphFourthOptions, graphFourthData);
drawFifthGraph(graphFifthOptions, graphFifthData);

/*BODY TRANSITIONS*/
	$(".tab__content").hide();
	$(".tab__content:first").hide();
	$("#tab1").show();
	$(".tab__head li").removeClass("active");
	$("#t1").addClass("active");
	$(".tab__head li").click(function() {
	$(".tab__content").hide();
	var activeTab = $(this).attr("rel"); 
	$("#"+activeTab).show();
	$(".tab__head li").removeClass("active");
	$(this).addClass("active");
});
/*CDN SEARCH*/
	var searchIndex = ["404 Error","Address Bar","Ajax","Apache","Autoresponder","BitTorrent","Blog","Bookmark","Bot","Broadband","Captcha","Certificate","Client","Cloud","Cloud Computing","CMS","Cookie","CSS","Cyberspace","Denial of Service","DHCP","Dial-up","DNS Record","Domain Name","Download","E-mail","Facebook","FiOS","Firewall","FTP","Gateway","Google","Google Drive","Gopher","Hashtag","Hit","Home Page","HTML","HTTP","HTTPS","Hyperlink","Hypertext","ICANN","Inbox","Internet","InterNIC","IP","IP Address","IPv4","IPv6","IRC","iSCSI","ISDN","ISP","JavaScript","jQuery","Meta Search Engine","Meta Tag","Minisite","Mirror","Name Server","Packet","Page View","Payload","Phishing","POP3","Protocol","Scraping","Search Engine","Social Networking","Socket","Spam","Spider","Spoofing","SSH","SSL","Static Website","Twitter","XHTML"];

var input = document.getElementById("searchBox"),
    ul = document.getElementById("searchResults"),
    inputTerms, termsArray, prefix, terms, results, sortedResults;


var search = function() {
  inputTerms = input.value.toLowerCase();
  results = [];
  termsArray = inputTerms.split(' ');
  prefix = termsArray.length === 1 ? '' : termsArray.slice(0, -1).join(' ') + ' ';
  terms = termsArray[termsArray.length -1].toLowerCase();
  
  for (var i = 0; i < searchIndex.length; i++) {
    var a = searchIndex[i].toLowerCase(),
        t = a.indexOf(terms);
    
    if (t > -1) {
      results.push(a);
    }
  }
  
  evaluateResults();
};

var evaluateResults = function() {
  if (results.length > 0 && inputTerms.length > 0 && terms.length !== 0) {
    sortedResults = results.sort(sortResults);
    appendResults();
  } 
  else if (inputTerms.length > 0 && terms.length !== 0) {
    ul.innerHTML = '<li>Whoah! <strong>' 
      + inputTerms 
      + '</strong> is not in the index. <br><small><a onclick="myFunction()" href="?q=' 
      + encodeURIComponent(inputTerms) + '">Index Now</a></small></li>';
    
  }
  else if (inputTerms.length !== 0 && terms.length === 0) {
    return;
  }
  else {
    clearResults();
  }
};

var sortResults = function (a,b) {
  if (a.indexOf(terms) < b.indexOf(terms)) return -1;
  if (a.indexOf(terms) > b.indexOf(terms)) return 1;
  return 0;
}

var appendResults = function () {
  clearResults();
  
  for (var i=0; i < sortedResults.length && i < 5; i++) {
    var li = document.createElement("li"),
        result = prefix 
          + sortedResults[i].toLowerCase().replace(terms, '<strong>' 
          + terms 
          +'</strong>');
    
    li.innerHTML = result;
    ul.appendChild(li);
  }
  
  if ( ul.className !== "term-list") {
    ul.className = "term-list";
  }
};

var clearResults = function() {
  ul.className = "term-list hidden";
  ul.innerHTML = '';
};
function myFunction() {
	confirm("Changes Indexed").reset();
	button.getElementById("submitButton").reset();
}
input.addEventListener("keyup", search, false);
/*MONITOR*/
var frm_elements = oForm.elements;
/*ORDER SCROLL SCRIPT*/
var orderItemH = document.getElementById('order-item').clientHeight;
console.log(orderItemH);
var orderContainer = document.getElementById('order-container');
var statsElementH = document.getElementById('stats-element').clientHeight;
var initialAmount = Math.floor((statsElementH - 150) / orderItemH);
var totalAmount = document.getElementsByClassName('order-item').length + 1;
console.log(initialAmount + ' items can be displayed');
orderContainer.style.height = (initialAmount * (orderItemH + 10)) + 'px';

document.getElementById('order-scrolldown').addEventListener('click', function() {
  scrollOrder(orderContainer.scrollTop + orderItemH + 14);
});
document.getElementById('order-scrollup').addEventListener('click', function() {
  scrollOrderUp(orderContainer.scrollTop - orderItemH - 14);
});

window.onresize = function() {
  orderItemH = document.getElementById('order-item').clientHeight;
  statsElementH = document.getElementById('stats-element').clientHeight;
  initialAmount = Math.floor((statsElementH) / orderItemH);
  totalAmount = document.getElementsByClassName('order-item').length + 1;
  orderContainer.style.height = (initialAmount * (orderItemH + 15)) + 'px';
}

function scrollOrder(max) {
  if (orderContainer.scrollTop <= max && max < (totalAmount - initialAmount) * orderItemH) {
    console.log(orderItemH)
    window.setTimeout(function() {
      orderContainer.scrollTop += 5;
      scrollOrder(max);
    }, 2)
  }
}

function scrollOrderUp(goal) {
  if (orderContainer.scrollTop >= goal && orderContainer.scrollTop > 0) {
    orderContainer.scrollTop -= 5;
    window.setTimeout(function() {
      scrollOrderUp(goal);
    }, 2)
  }
}
</script>