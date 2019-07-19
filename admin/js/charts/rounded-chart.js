(function ($) {
 "use strict";
 
	 /*----------------------------------------*/
	/*  1.  pie Chart
	/*----------------------------------------*/

	  $.ajax({
    url: "pie.php",
    method: "GET",
    success: function(data) {

      var dat= $.parseJSON(data);
      var catagory = [];
      var quantity = [];

      for(var i in dat) {
       catagory.push(dat[i].parent);
      
       quantity.push(dat[i].quantity);
      }
     
	var ctx = document.getElementById("stock-data");
	var piechart = new Chart(ctx, {
		type: 'pie',
		data: {
			labels: catagory,
			datasets: [{
				label: 'pie Chart',
                backgroundColor: [
					'rgb(25, 47, 132)',
					'rgb(77, 23, 132)',
					'rgb(255, 123, 32)',
					'rgb(2, 69, 12)',
					'rgb(55, 77, 32)',
					'rgb(25, 99, 12)',
					'rgb(255, 19, 164)',
					'rgb(25, 135, 86)',
					'rgb(0, 255, 0)',
					'rgb(0, 55, 25)'
				],
				data: quantity
            }]
		},
		options: {
			responsive: true
		}
	});

    },
    error: function(data) {
      console.log(data);
    }
  });


	 /*----------------------------------------*/
	/*  2.  polar Chart
	/*----------------------------------------*/
	var ctx = document.getElementById("polarchart");
	var polarchart = new Chart(ctx, {
		type: 'polarArea',
		data: {
			labels: ["Red", "Orange", "Yellow", "Green", "Blue"],
			datasets: [{
				label: 'pie Chart',
				data: [10, 20, 30, 40, 60],
                backgroundColor: [
					'rgb(255, 99, 132)',
					'rgb(255, 159, 64)',
					'rgb(255, 205, 86)',
					'#03a9f4',
					'rgb(201, 203, 207)'
				],
				
            }]
		},
		options: {
            responsive: true,
            legend: {
                 position: 'right',
            },
            title: {
                display: true,
                text: 'Polar Chart'
            },
            scale: {
              ticks: {
                beginAtZero: true
              },
              reverse: false
            },
            animation: {
                animateRotate: false,
                animateScale: true
            }
        }
	});
	
	 /*----------------------------------------*/
	/*  3.  radar Chart
	/*----------------------------------------*/
	var ctx = document.getElementById("radarchart");
	var radarchart = new Chart(ctx, {
		type: 'radar',
		data: {
			labels: ["Design", "Development", "Graphic", "Android", "Games"],
			datasets: [{
				label: "My First dataset",
				data: [90, 20, 30, 40, 10],
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                pointBackgroundColor: '#ff0000',
				
            },{
				label: "My Second dataset",
				data: [50, 20, 10, 30, 90],
                backgroundColor: 'rgb(255, 159, 64)',
                borderColor: 'rgb(255, 159, 64)',
                pointBackgroundColor: '#ff0000',
				
            }]
		},
		options: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Radar Chart'
            },
            scale: {
              ticks: {
                beginAtZero: true
              }
            }
        }
	});
	 /*----------------------------------------*/
	/*  3.  Doughnut Chart
	/*----------------------------------------*/
	var ctx = document.getElementById("Doughnutchart");
	var Doughnutchart = new Chart(ctx, {
		type: 'radar',
		data: {
			labels: ["Red", "Orange", "Yellow", "Green", "Blue"],
			datasets: [{
				label: 'Dataset 1',
				data: [10, 20, 30, 40, 90],
                backgroundColor: 'rgb(255, 99, 132)'
				
            }]
		},
		options: {
            responsive: true,
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Doughnut Chart'
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
	});
	
	

	 
		
})(jQuery); 