$(document).ready(function() {
    if($('#weekchart').length > 0){
      $.ajax({
        url: base+"rest/get_room_week_report",
        method: "GET",
        dataType: "json",
        success: function(response) {
          Morris.Bar({
            element: 'weekchart',
            data: response.weekdata,
            xkey: 'date',
            ykeys: ['booking'],
            labels: ['booking'],
            barRatio: 0.4,
            xLabelAngle: 35,
            pointSize: 1,
            barOpacity: 1,
            pointStrokeColors:['#ff6028'],
            behaveLikeLine: true,
            grid: true,
            gridTextColor:'#878787',
            hideHover: 'auto',
            smooth: true,
            barColors: ['#3324f5'],
            resize: true,
            gridTextFamily:"Roboto"
          });  
        }
      });
    }

    if($('#monthchart').length > 0){
      $.ajax({
        url: base+"rest/get_room_month_report",
        method: "GET",
        dataType: "json",
        success: function(response) {
          Morris.Bar({
            element: 'monthchart',
            data: response.message.monthdata,
            xkey: 'date',
            ykeys: ['booking'],
            labels: ['booking'],
            barRatio: 0.4,
            xLabelAngle: 35,
            pointSize: 1,
            barOpacity: 1,
            pointStrokeColors:['#ff6028'],
            behaveLikeLine: true,
            grid: true,
            gridTextColor:'#878787',
            hideHover: 'auto',
            smooth: true,
            barColors: ['#3324f5'],
            resize: true,
            gridTextFamily:"Roboto"
          });  
        }
      });
    }
    
    if($('#yearchart').length > 0){
      $.ajax({
        url: base+"rest/get_room_year_report",
        method: "GET",
        dataType: "json",
        success: function(response) {
          Morris.Bar({
            element: 'yearchart',
            data: response.message.yeardata,
            xkey: 'date',
            ykeys: ['booking'],
            labels: ['booking'],
            barRatio: 0.4,
            xLabelAngle: 35,
            pointSize: 1,
            barOpacity: 1,
            pointStrokeColors:['#ff6028'],
            behaveLikeLine: true,
            grid: true,
            gridTextColor:'#878787',
            hideHover: 'auto',
            smooth: true,
            barColors: ['#3324f5'],
            resize: true,
            gridTextFamily:"Roboto"
          });  
        }
      });
    }

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      var target = $(e.target).attr("href");
      switch (target) {
        case "#week":        
          $(window).trigger('resize');
          break;
        case "#month":         
          $(window).trigger('resize');
          break;
        case "#yearly":         
          $(window).trigger('resize');
          break;
      }
    })

    if($('#financial_weekchart').length > 0){
      $.ajax({
        url: base+"rest/get_financial_week_report",
        method: "GET",
        dataType: "json",
        success: function(response) {
          Morris.Bar({
            element: 'financial_weekchart',
            data: response.message.weekdata,
            xkey: 'date',
            ykeys: ['total'],
            labels: ['total'],
            barRatio: 0.4,
            xLabelAngle: 35,
            pointSize: 1,
            barOpacity: 1,
            pointStrokeColors:['#ff6028'],
            behaveLikeLine: true,
            grid: true,
            gridTextColor:'#878787',
            hideHover: 'auto',
            smooth: true,
            barColors: ['#3324f5'],
            resize: true,
            gridTextFamily:"Roboto"
          });  
        }
      });
    }

    if($('#financial_monthchart').length > 0){
      $.ajax({
        url: base+"rest/get_financial_month_report",
        method: "GET",
        dataType: "json",
        success: function(response) {
          Morris.Bar({
            element: 'financial_monthchart',
            data: response.message.monthdata,
            xkey: 'date',
            ykeys: ['total'],
            labels: ['total'],
            barRatio: 0.4,
            xLabelAngle: 35,
            pointSize: 1,
            barOpacity: 1,
            pointStrokeColors:['#ff6028'],
            behaveLikeLine: true,
            grid: true,
            gridTextColor:'#878787',
            hideHover: 'auto',
            smooth: true,
            barColors: ['#3324f5'],
            resize: true,
            gridTextFamily:"Roboto"
          });  
        }
      });
    }

    if($('#financial_yearchart').length > 0){
      $.ajax({
        url: base+"rest/get_financial_year_report",
        method: "GET",
        dataType: "json",
        success: function(response) {
          Morris.Bar({
            element: 'financial_yearchart',
            data: response.message.yeardata,
            xkey: 'date',
            ykeys: ['total'],
            labels: ['total'],
            barRatio: 0.4,
            xLabelAngle: 35,
            pointSize: 1,
            barOpacity: 1,
            pointStrokeColors:['#ff6028'],
            behaveLikeLine: true,
            grid: true,
            gridTextColor:'#878787',
            hideHover: 'auto',
            smooth: true,
            barColors: ['#3324f5'],
            resize: true,
            gridTextFamily:"Roboto"
          });  
        }
      });
    }

    if($('#weeklyrevenuechart').length > 0){
      $.ajax({
        url: base+"rest/get_weekly_revenue_report",
        method: "GET",
        dataType: "json",
        success: function(response) {
          Morris.Bar({
            element: 'weeklyrevenuechart',
            data: response.message.weekdata,
            xkey: 'date',
            ykeys: ['total'],
            labels: ['total'],
            barRatio: 0.4,
            xLabelAngle: 35,
            pointSize: 1,
            barOpacity: 1,
            pointStrokeColors:['#ff6028'],
            behaveLikeLine: true,
            grid: true,
            gridTextColor:'#878787',
            hideHover: 'auto',
            smooth: true,
            barColors: ['#3324f5'],
            resize: true,
            gridTextFamily:"Roboto"
          });  
        }
      });
    }
});