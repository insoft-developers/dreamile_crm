/*
Template Name: Urbix - Admin & Dashboard Template
Author: Pixeleyez
Website: https://pixeleyez.com/
File: E-Commerce init js
*/
function renderCharts() {
  // Average line
  

  // Average bar
  var options = {
    series: [{
      name: 'Current Year',
      data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
    }, {
      name: 'Prior Year',
      data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
    }],
    chart: {
      type: 'bar',
      height: 350
    },
    colors: ["#5b66eb", "#ffc107"],
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '55%',
        borderRadius: 5,
        borderRadiusApplication: 'end'
      },
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      show: true,
      width: 2,
      colors: ['transparent']
    },
    xaxis: {
      categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
    },
    fill: {
      opacity: 1
    },
  };

  var chart = new ApexCharts(document.querySelector("#average-bar"), options);
  chart.render();

  if (document.getElementById("gridjs_sort-table")) {
    new gridjs.Grid({
      columns: [
        { name: 'Date', formatter: (cell) => gridjs.html(`<span class="text-muted">${cell}</span>`) },
        { name: 'Name', formatter: (cell) => gridjs.html(`<span class="text-muted">${cell}</span>`) },
        { name: 'Amount', formatter: (cell) => gridjs.html(`<span class="text-muted">${cell}</span>`) }
      ],
      sort: true,
      data: [
        ["01 Feb 2024", "Robert", "$50.86"],
        ["03 Feb 2024", "Smith", "$76.53"],
        ["07 Feb 2024", "Adam", "$48.65"],
        ["08 Feb 2024", "Teff", "$100.00"],
        ["09 Feb 2024", "John", "$895.4"],
        ["01 Mar 2024", "Lucy", "$59.36"],
        ["02 Mar 2024", "Daniel", "$50.86"],
      ]
    }).render(document.getElementById("gridjs_sort-table"));
  }

  // product-statistics
  var options = {
    series: [76, 67, 61],
    chart: {
      height: 330,
      type: 'radialBar',
    },
    plotOptions: {
      radialBar: {
        offsetY: 0,
        startAngle: 0,
        endAngle: 270,
        hollow: {
          margin: 5,
          size: '30%',
          background: 'transparent',
          image: undefined,
        },
        track: {
          margin: 10,
        },
        dataLabels: {
          name: {
            show: false,
          },
          value: {
            show: false,
          }
        },
        barLabels: {
          enabled: true,
          useSeriesColors: true,
          offsetX: -8,
          fontSize: '16px',
          formatter: function (seriesName, opts) {
            return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
          },
        },
      }
    },
    colors: ['#5b66eb', '#ffc107', '#dc3545'],
    responsive: [{
      breakpoint: 480,
      options: {
        legend: {
          show: false
        }
      }
    }]
  };

  var chart = new ApexCharts(document.querySelector("#product-statistics"), options);
  chart.render();

}

setTimeout(() => {
  renderCharts();
}, 250);