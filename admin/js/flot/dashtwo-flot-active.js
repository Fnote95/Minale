(function ($) {
 "use strict";
 
////////////////////////////

  $.ajax({
    url: "api/graph.php",
    method: "POST",
    success: function(data) {

  
      var dat= $.parseJSON(data);
     

      var salesA = [];
      var monthA = [];

      for(var i in dat) {
       salesA.push(dat[i].paid);
      
       monthA.push(dat[i].order_date);
      }

      var ctx = document.getElementById('myChartsrs').getContext("2d");
 var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
gradientStroke.addColorStop(0, '#80b6f4');

gradientStroke.addColorStop(1, '#f49080');
    
      var myChartsrs = new Chart(ctx, {
    type: 'line',
    data: {
        labels: monthA, //["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL"],
        datasets: [{
            label: "Sales",
            borderColor: gradientStroke,
            pointBorderColor: gradientStroke,
            pointBackgroundColor: gradientStroke,
            pointHoverBackgroundColor: gradientStroke,
            pointHoverBorderColor: gradientStroke,
            pointBorderWidth: 10,
            pointHoverRadius: 10,
            pointHoverBorderWidth: 1,
            pointRadius: 3,
            fill: false,
            borderWidth: 4,
            data: salesA, //[0, 60, 120, 170, 0, 170, 190]
        }]
    },
    options: {
        legend: {
            position: "bottom"
        },
        scales: {
            yAxes: [{
                ticks: {
                    fontColor: "rgba(0,0,0,0.5)",
                    fontStyle: "bold",
                    beginAtZero: true,
                    maxTicksLimit: 5,
                    padding: 20
                },
                gridLines: {
                    drawTicks: false,
                    display: false
                }
}],
            xAxes: [{
                gridLines: {
                    zeroLineColor: "transparent"
},
                ticks: {
                    padding: 20,
                    fontColor: "rgba(0,0,0,0.5)",
                    fontStyle: "bold"
                }
            }]
        }
    }
});


 
    },
    error: function(data) {
      console.log(data);
    }
  });



////////////////////////////




		
			
  })(jQuery);          