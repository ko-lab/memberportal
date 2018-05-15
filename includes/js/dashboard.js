$(document).ready(function() {
  $.ajax({
    url: "http://10.90.154.40/last/1"
  }).then(function(data) {
     $('#power').html(parseInt(data.Power.L1 + data.Power.L2 + data.Power.L3));
	 console.log(data.Power.L1);
  });
  setTimeout(arguments.callee, 1000);
});