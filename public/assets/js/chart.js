
function horizontalBarChart(labels,count,colors){
   // Horizontal bar chart
   var ctx2 = document.getElementById('chartBar2').getContext('2d');
   new Chart(ctx2, {
     type: 'horizontalBar',
     data: {
       labels: labels,
       datasets: [{
         data:count,
         backgroundColor:colors
       }]
     },
     options: {
       maintainAspectRatio: false,
       responsive: true,
       legend: {
         display: false,
         labels: {
           display: false
         }
       },
       scales: {
         yAxes: [{
           gridLines: {
             display: false
           },
           ticks: {
             beginAtZero:true,
             fontSize: 10,
             fontColor: '#182b49'
           }
         }],
         xAxes: [{
           gridLines: {
             color: '#e5e9f2'
           },
           barPercentage: 0.6,
           ticks: {
             beginAtZero:true,
             fontSize: 11,
             fontColor: '#182b49',
          
           }
         }]
       }
     }
   });

}
function verticalBarChart(labels, count, colors) {
  var ctx1 = document.getElementById('chartBar1').getContext('2d');
  new Chart(ctx1, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        data: count,
        backgroundColor: colors
      }]
    },
    options: {
      maintainAspectRatio: true, // Ensures the aspect ratio is maintained
      responsive: true, // Makes the chart responsive
      legend: {
        display: false,
      },
      scales: {
        yAxes: [{
          gridLines: {
            color: '#e5e9f2',
          },
          ticks: {
            beginAtZero: true,
            fontSize: 10,
            fontColor: '#182b49',
          }
        }],
        xAxes: [{
          gridLines: {
            display: false,
          },
          barPercentage: 0.8, // Adjusted bar width
          ticks: {
            beginAtZero: true,
            fontSize: 8, // Adjusted font size for better readability
            fontColor: '#182b49',
          }
        }]
      }
    }
  });
}
function horizontalchartBarFunction(route){
  $.ajax({
    url: route,
    method: 'GET',
    success: function(response) {
        let labels = response.labels;
        let count = response.userCount;
        let colors = ['#001737', '#1ce1ac'];
        horizontalBarChart(labels, count, colors);
    },
    error: function(xhr, status, error) {
        console.error("An error occurred: " + status + " " + error);
    }
});
}
function verticalBarChartFunction(route){
  $.ajax({
    url: route,
    method: 'GET',
    success: function(response) {
      console.log(response);
        let labels = response.labels;
        let count = response.count;
        let colors = ['#001737', '#1ce1ac'];
        verticalBarChart(labels, count, colors);
    },
    error: function(xhr, status, error) {
        console.error("An error occurred: " + status + " " + error);
    }
});
}

