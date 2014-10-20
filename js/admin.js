jQuery(document).ready(function($){
  
  var closed = $("#toplist_cz_dashboard").hasClass("closed");
  var inside = $("#toplist_cz_dashboard .inside");

  function array2flot(arr, jitter) {
    jitter = jitter || 0;
    var data = [];
    for (var key in arr) {
      data.push([parseInt(key) + jitter, parseInt(arr[key])]);
    }
    return data;
  }
  
  function flot_navstevy_graph(data, selector, barWidth) {
    barWidth = barWidth || 0.35;
    var dataSets = [{
            data: array2flot(data["navstevy"], -barWidth),
            label: "Návštěvy",
            color: "#994c4c"
          }, {
            data: array2flot(data["zhlednuti"]),
            label: "Zhlédnutí",
            color: "#404080"
          }];
    var options = {
          bars: {
            show: true,
            lineWidth: 1,
            barWidth: barWidth
          },
          xaxis: {
            ticks: Object.keys(data["navstevy"]).length,
            minTickSize: 1,
            tickDecimals: 0,
            tickLength:0
          }, 
          yaxis: {
            min: 0
          },
          grid: {
            hoverable: true,
            borderWidth: 1,
            borderColor: "LightGray"
          }
    }
    var plot = $.plot(selector, dataSets, options);
    
/* this should add labels on top of bars 
    var ctx = plot.getCanvas().getContext("2d"); // get the context
    var ddata = plot.getData()[0].data;  // get your series data
    var xaxis = plot.getXAxes()[0]; // xAxis
    var yaxis = plot.getYAxes()[0]; // yAxis
    var offset = plot.getPlotOffset(); // plots offset
    ctx.font = "16px 'Arial'"; // set a pretty label font
    ctx.fillStyle = "black";
    for (var i = 0; i < ddata.length; i++){
        var text = ddata[i][1] + '';
        var metrics = ctx.measureText(text);
        console.log(metrics.width);
        var xPos = (xaxis.p2c(ddata[i][0])+offset.left) - metrics.width/2; // place it in the middle of the bar
        var yPos = yaxis.p2c(ddata[i][2]) + offset.top - 5; // place at top of bar, slightly up
        ctx.fillText(text, xPos, yPos);
    }
*/
    selector.attr("data", JSON.stringify(data));
    
    $(window).resize(function() {
      $.plot(selector, dataSets, options);
    });
    
    $('body').on('click', '#toplist_cz_dashboard .handlediv', function () {
      if (!$('#toplist_cz_dashboard').hasClass("closed")) {
        $.plot(selector, dataSets, options);
      }
    });
  }

  function showTooltip(x, y, contents, z) {
      $('<div id="flot-tooltip">' + contents + '</div>').css({
          top: y - 20,
          left: x < 100 ? x + 25 : x - 95,
          'border-color': z
      }).appendTo("body").show();
  }

  $('body').on('mouseenter', '#toplist_cz_dashboard .inside table tr td', function (event, pos, item) {
    var $this = $(this);
    if(this.offsetWidth < this.scrollWidth && !$this.attr('title')){
      $this.attr('title', $this.text());
    }
  });

  $('body').on('plothover', '#toplist_cz_dashboard .inside div.graph', function (event, pos, item) {
    if (item) {
      if (previousPoint != item.datapoint) {
        previousPoint = item.datapoint;
        $("#flot-tooltip").remove();

        var data = JSON.parse($(this).attr("data"));
        var index = Math.round(item.datapoint[0]);
        var caption = index;
        if ($(this).parent().attr("id").indexOf("za-den") >= 0)
          caption = index + "<sup>00</sup> &ndash; " + (index+1) + "<sup>00</sup>";
        else if ($(this).parent().attr("id").indexOf("za-mesic") >= 0) {
          var sdata = JSON.parse(window.atob($("#toplist_cz_dashboard #toplist_stats").attr("value")));
          caption = index + ". " + sdata.navstevy_za_mesic.mesic.toLowerCase();
        }
        showTooltip(item.pageX, item.pageY,
            "<strong>" + caption + "</strong>"
            + "<br />Návštěvy: <strong>" + data.navstevy[index] + "</strong>"
            + "<br />Zhlédnutí: <strong>" + data.zhlednuti[index] + "</strong>"
            );
      }
    } else {
      $("#flot-tooltip").remove();
      previousPoint = null;
    }
  });
/*
  function table_2_columns(data, selector, rows) {
    rows = rows || 5;
    var tbody = "";
    for (var key in data) {
      tbody = tbody + "<tr><td>" + data[key] + "</td><td>" + key + "</td></tr>";
      if (--rows == 0) break;
    }
    selector.find("tbody").html(tbody);
  }
*/

  var data = {
		'action'   : 'toplist_cz_dashboard_content',
		'_wpnonce' : $("#toplist_cz_dashboard .inside #toplist_nonce").attr("value")
	};

  function draw_graphs() {
    var data = JSON.parse(window.atob($("#toplist_cz_dashboard #toplist_stats").attr("value")));
    flot_navstevy_graph(data.navstevy_za_den, $("#navstevy-za-den .graph"));
    flot_navstevy_graph(data.navstevy_za_mesic, $("#navstevy-za-mesic .graph"));
    //table_2_columns(response.vstupni_stranky, $("#vstupni-stranky table"));
    //table_2_columns(response.domeny, $("#navstevy-podle-domen table"));
  }

  $('body').on('click', '#toplist_cz_dashboard #toplist_password_form #toplist_password_submit', function() {
	  inside.removeClass("toplist_error_pulsate");
    var pwd = $(this).parents("form").find("#toplist_password");
    if (pwd.val() == '') {
      pwd.css('background-color', 'LightPink');
      alert('Please fill-in the password.');
      return;
    }
    $("#toplist_cz_dashboard .inside #toplist_password_form .spinner").css("display", "inline-block");
    var data = {
  		'action'   : 'toplist_cz_save_password',
  		'_wpnonce' : $(this).parents("form").find("#toplist_password_nonce").val(),
  		'password' : pwd.val()
  	};
    $("form#toplist_password_form input").attr("disabled", true);
    $.post(ajaxurl, data, function(response) {
      if (response.success) {
        inside.removeClass("error");
    	  inside.slideUp('fast').html(response.html).slideDown('fast');
        draw_graphs();
      } else {
    	  inside.html(response.html);
    	  inside.addClass("toplist_error_pulsate");
    	}
  	})
  	.fail(function() {
  	  inside.html("fail");
  	  inside.addClass("toplist_error_pulsate");
  	});    

  });

  if (inside.text().trim() == "") {  // content not in the widget (not retrieved from cache), we need to get it via ajax
  	$.post(ajaxurl, data, function(response) {
  	  if (!closed) inside.hide()
  	  inside.html(response.html);
  	  if (!closed) inside.slideDown('fast', function() { inside.removeAttr("style"); });

  	  if (!response.success) {
  	    inside.addClass("error");
  	    return;
  	  }
      inside.removeClass("error");
  	  draw_graphs();
  	})
  	.fail(function() {
  	  if (!closed) inside.hide()
  	  inside.html("fail").addClass("error");
  	  if (!closed) inside.slideDown('fast', function() { inside.removeAttr("style"); });
  	  return;
  	});

  } else {
    draw_graphs();
  }
  
});