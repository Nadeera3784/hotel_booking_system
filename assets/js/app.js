
$(document).ready(function () {

    $(window).on('scroll', function () {
        var scroll = $(window).scrollTop();
        if (scroll < 100) {
            $("#header").removeClass("sticky");
        } else {
            $("#header").addClass("sticky");
        }
    });


    if($("#check_in").length > 0){
        var picker = new Lightpick({
            field: document.getElementById('check_in'),
            secondField: document.getElementById('check_out'),
            singleDate: false,
            format : "MM-DD-YYYY"
        });
    }

    $(document).on('click', '#calcheck', function(){
        var roomtype_id = $(this).attr('data-rtype');
        var capacity_id = $(this).attr('data-cid');
        var check_in_date = $('#checkInDate').val();
        $.ajax({
            type: 'POST',
            cache: false,
            url: base +'api/get_available_calendar',
            data: {roomtype_id : roomtype_id, capacity_id : capacity_id},
            dataType  : 'json',
            beforeSend: function() {
                $(".page-overlay").addClass('is-loading');
            },
            success: function(response){
                $(".page-overlay").removeClass('is-loading');
                $('#amodal').modal('show');
                $('#calendar').fullCalendar({
                    themeSystem: 'bootstrap4',
                    header: {
                        left: 'prev title next',
                        //center: 'prev title next',
                        right: 'month,basicWeek,basicDay'                
                    },
                    titleRangeSeparator: "-", 
                    buttonText: {
                    prev: "<",
                    next: ">",
                    month: 'Month',
                    week: 'Week',
                    day: 'Day'
                    },
                    firstDay: 1,
                    month : check_in_date,
                    buttonIcons: false,
                    events: response,
                    eventMouseover:function (calEvent){
                        $(this).popover({
                            trigger:'hover',
                            title:calEvent.title,
                            container:"body",
                            placement:'auto',
                            animation: true,
                            html: true,  
                            content: function () {
                                return '<div class="col-xs-3"><h5 class="popover-content-date-month">'+moment(calEvent.start).format('MMM')+'</h5><p class="popover-content-description text-success">'+moment(calEvent.start).format('DD')+'</p><h5 class="popover-content-date-month"><p class="popover-content-description text-warning"></div><div class="col-xs-9 pb-10"></div>';
                            }
                        });
                    }  
                });
            }
        }); 
    });

    $('.modal').on('hidden.bs.modal', function (e) {
        $(this).removeData();
        //$("#demo-1").html("");
        $('#calendar').fullCalendar('destroy');
    });
    
    if($('#searchresult').length > 0){
        $('#searchresult').on('submit', function(e) {
            //e.preventDefault();  //prevent form from submitting
            var rmsavailable  = document.getElementsByName('svars_selectedrooms[]');	
            for(var i = 0; i < rmsavailable.length; i++){
                if(rmsavailable[i].value > 0){
                    //return true;
                    $(this).submit();
                }
            }		
            lnv.alert({
                      title: 'Hold on!',
                      alertBtnText: 'Ok',
                      content: 'Please select atleast one room'
            });
            return false;	
        });
    }

    if(typeof(AOS) !== 'undefined'){
       AOS.init();
    }

    $('.slider').slick({
        responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
          ],
        slidesToShow: 1,
        arrows : false,
        autoplay : true,
        adaptiveHeight: false
    });

     var offset = 300,
     offset_opacity = 1200,
     scroll_top_duration = 700,
     $back_to_top = $('.back-to-top');

    $(window).scroll(function() {
        ($(this).scrollTop() > offset) ? $back_to_top.addClass('back-to-top-is-visible'): $back_to_top.removeClass('back-to-top-is-visible cd-fade-out');
        if ($(this).scrollTop() > offset_opacity) {
            $back_to_top.addClass('back-to-top-fade-out');
        }
    });

    $back_to_top.on('click', function(event) {
        event.preventDefault();
        $('body, html').animate({
            scrollTop: 0,
        }, scroll_top_duration);
    });

    if($('#search_form').length > 0){
        $("#search_form").validate();
    }

    if($('#payment_form').length > 0){
        $("#payment_form").validate();
    }
    

	$(window).on('load resize', function () {
		var width = $(window).width();
		if ($(this).width() < 575) {
			$(".collapse_bt_mobile").attr("data-toggle", "collapse");
			$('footer .collapse.show').removeClass('show');
			$('.collapse_bt_mobile').on('click', function () {
				$(this).find(".circle-plus").toggleClass('opened');
			})
			$('.collapse_bt_mobile').on('click', function () {
				$(this).find(".circle-plus").toggleClass('closed');
			})
		} else {
			$('footer .collapse').addClass('show');
			$("footer .collapse_bt_mobile").attr("data-toggle", "");
		};
	});
	
});