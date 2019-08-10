function drawer() {
  //"use strict";
 
////////////////////////////
        
var start=jQuery('#start').val();
var end=jQuery('#end').val();

//heading_data='<h4 class="text-center"><b>Sales report of the past 7 days</b></h4>'


  $.ajax({
    url: "api/graph.php",
    method: "GET",
    data: {start : start, end : end},
    success: function(data) {
      heading_data='<h4 class="text-center"><b>Sales report from '+start+' to '+end+'</b></h4>'
      jQuery('#heading').html(heading_data);
      var dat= $.parseJSON(data);
     

      var salesA = [];
      var monthA = [];

      for(var i in dat) {
       salesA.push(dat[i].paid);
      
       monthA.push(dat[i].order_date);
      }


      var ctx = document.getElementById('myChartsrs_range').getContext("2d");
      var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
      gradientStroke.addColorStop(0, '#80b6f4');

      gradientStroke.addColorStop(1, '#f49080');
    
      var myChartsrs = new Chart(ctx, {
    type: 'line',
    data: {
        labels: monthA,
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
            data: salesA, 
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
}         