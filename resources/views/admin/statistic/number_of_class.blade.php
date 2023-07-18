@extends('admin/layout')
@section('konten')

<!-- Styles -->
<!-- Styles -->
<style>
#chartdiv {
  width: 100%;
  height: 500px;
}

#chartdiv2 {
  width: 100%;
  height: 500px;
}

</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_material);
am4core.useTheme(am4themes_animated);
am4core.addLicense("ch-custom-attribution");
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart);

// Add data
chart.data = [ {
  "country": "Golongan I",
  "visits": {{ $class_1 }},
  "color": am4core.color("#f44336")
}, {
  "country": "Golongan II",
  "visits": {{ $class_2 }},
  "color": am4core.color("#4caf50"),
}, {
  "country": "Golongan III",
  "visits": {{ $class_3 }},
  "color": am4core.color("#2196f3"),
}, {
  "country": "Golongan IV",
  "visits": {{ $class_4 }},
  "color": am4core.color("#ffc107"),
}
];

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "country";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;
categoryAxis.renderer.labels.template.horizontalCenter = "middle";
categoryAxis.renderer.labels.template.verticalCenter = "middle";
categoryAxis.renderer.labels.template.rotation = 0;
categoryAxis.tooltip.disabled = true;
// categoryAxis.renderer.minHeight = 110;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.renderer.minWidth = 50;
valueAxis.title.text = "Jumlah Pegawai";
valueAxis.title.fontWeight = 400;
valueAxis.min = 0;
valueAxis.max = {{ $max_value + 40 }};

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.sequencedInterpolation = true;
series.dataFields.valueY = "visits";
series.dataFields.categoryX = "country";
series.tooltipText = "[bold]{valueY}[/] Orang";
series.columns.template.strokeWidth = 0;

series.tooltip.pointerOrientation = "vertical";

series.columns.template.column.cornerRadiusTopLeft = 10;
series.columns.template.column.cornerRadiusTopRight = 10;
series.columns.template.column.fillOpacity = 0.8;
// series.columns.template.width = am4core.percent(50);

var labelBullet = series.bullets.push(new am4charts.LabelBullet());
labelBullet.label.verticalCenter = "bottom";
labelBullet.label.dy = -10;
labelBullet.label.text = "{values.valueY.workingValue.formatNumber('#.')}";


// on hover, make corner radiuses bigger
var hoverState = series.columns.template.column.states.create("hover");
hoverState.properties.cornerRadiusTopLeft = 0;
hoverState.properties.cornerRadiusTopRight = 0;
hoverState.properties.fillOpacity = 1;

series.columns.template.adapter.add("fill", function(fill, target) {
  return chart.colors.getIndex(target.dataItem.index);
});

// Cursor
chart.cursor = new am4charts.XYCursor();

chart.colors.list = [
  am4core.color("#f44336"),
  am4core.color("#4caf50"),
  am4core.color("#2196f3"),
  am4core.color("#ffc107")
];

var legend = new am4charts.Legend();
legend.parent = chart.chartContainer;
//legend.itemContainers.template.togglable = false;
legend.marginTop = 20;

series.events.on("ready", function(ev) {
  var legenddata = [];
  series.columns.each(function(column) {
    legenddata.push({
      name: column.dataItem.categoryX,
      fill: column.fill,
      columnDataItem: column.dataItem
    });
  });
  legend.data = legenddata;
});

legend.itemContainers.template.events.on("hit", function(ev) {
  //console.log("Clicked on ", ev.target.dataItem.className);
  if (!ev.target.isActive) {
    ev.target.dataItem.dataContext.columnDataItem.hide();
  }
  else {
    ev.target.dataItem.dataContext.columnDataItem.show();
  }
});

legend.itemContainers.template.events.on("over", function(ev) {
  ev.target.dataItem.dataContext.columnDataItem.column.isHover = true;
  ev.target.dataItem.dataContext.columnDataItem.column.showTooltip();
});

legend.itemContainers.template.events.on("out", function(ev) {
  ev.target.dataItem.dataContext.columnDataItem.column.isHover = false;
  ev.target.dataItem.dataContext.columnDataItem.column.hideTooltip();
});

}); // end am4core.ready()
</script>

## Grafik Pie
<script>
    am4core.ready(function() {

    // Themes begin
    am4core.useTheme(am4themes_material);
    am4core.useTheme(am4themes_animated);
    am4core.addLicense("ch-custom-attribution");

    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end

    // Create chart instance
    var chart = am4core.create("chartdiv2", am4charts.PieChart);

    // Add data
    chart.data = [ {
      "country": "Golongan I",
      "litres": {{ $class_1 }},
      "color": am4core.color("#f44336")
    }, {
      "country": "Golongan II",
      "litres": {{ $class_2 }},
      "color": am4core.color("#4caf50"),
    }, {
      "country": "Golongan III",
      "litres": {{ $class_3 }},
      "color": am4core.color("#2196f3"),
    }, {
      "country": "Golongan IV",
      "litres": {{ $class_4 }},
      "color": am4core.color("#ffc107"),
    }
    ];

    // Add and configure Series
    var pieSeries = chart.series.push(new am4charts.PieSeries());
    pieSeries.dataFields.value = "litres";
    pieSeries.dataFields.category = "country";
    pieSeries.slices.template.stroke = am4core.color("#fff");
    pieSeries.slices.template.propertyFields.fill = "color";
    pieSeries.slices.template.strokeOpacity = 1;

    // This creates initial animation
    pieSeries.hiddenState.properties.opacity = 1;
    pieSeries.hiddenState.properties.endAngle = -90;
    pieSeries.hiddenState.properties.startAngle = -90;

    chart.hiddenState.properties.radius = am4core.percent(0);

    chart.legend = new am4charts.Legend();

    }); // end am4core.ready()
</script>

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">
                    <div id="tableHover" class="col-lg-12 col-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content widget-content-area" style="padding-top: 0px;">
                              <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                  <h4><center>{{ __($title) }}</center></h4>
                                </div>
                              </div>
                              <div class="row" style="margin-top:20px">
                                <div class="col-xl-6 col-md-12 col-sm-12 col-12">
                                  <div id="chartdiv"></div>
                                </div>
                                <div class="col-xl-6 col-md-12 col-sm-12 col-12">
                                  <div id="chartdiv2"></div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection