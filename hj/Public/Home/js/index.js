	
    $(function(){
    	$('.container .navbar-left li').click(function(){
			$(this).addClass('active').siblings().removeClass();
		})

	    $("a.close").click(function(){
	    	$("#myAlert").fadeOut(1000);
	    })

	    $('.pages .pagination .p').click(function(){
	    	$(this).addClass('active').siblings().removeClass();
	    })

	     
		 $.goup({
		    trigger: 50,
		    bottomOffset: 100,
		    locationOffset: 10,
		    titleAsText: true,
		    containerColor : '#f4645f'
		 });


    })

