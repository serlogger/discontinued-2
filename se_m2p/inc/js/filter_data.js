    //Filter data
    // function scrollToPos()
    // {
    // if (localStorage.getItem("my_app_name_here-quote-scroll") != null)
    //     {
    //         $(window).scrollTop(localStorage.getItem("my_app_name_here-quote-scroll"));
    //         console.log('koitettu kelausta kohtaan ' + localStorage.getItem("my_app_name_here-quote-scroll"));
    //     }        
    // }
    /*remember scroll position */
    // if (localStorage.getItem("my_app_name_here-quote-scroll") != null)
    // {
    //     $(window).scrollTop(localStorage.getItem("my_app_name_here-quote-scroll"));
    // }

    // $(window).on("scroll", function()
    // {
    //     localStorage.setItem("my_app_name_here-quote-scroll", $(window).scrollTop());
    // });
    /*EO remember scroll position */
    
    // document.getElementById('kelaa').addEventListener('click', scrollToPos());

    var start = 0;
    // if(localStorage.getItem('start_limit'))
    // {
    //     //var start = 0;
    //     var limit = localStorage.getItem('start_limit');
    // }
    // else
    // {
    //     var limit = 5;
    // }
    var limit = 5;
    var reachedMax = false;



    function filter_data()
    {
        if(reachedMax) 
        {
            return;
        }
        // var minimum_price = $('#hidden_minimum_price').val();
        // var maximum_price = $('#hidden_maximum_price').val();
        // var brand = get_filter('brand');
        // var ram = get_filter('ram');
        var ind_id = get_filter('ind_id');
        // var property;
        // var way;
        // var ss = document.getElementById('sort'); //sort selection
        // var sr = ss.options[ss.selectedIndex].value; // sort result
        // if(sr == 'product_ram_bf')
        // {
        //     property = "product_ram";
        //     way = "DESC";
        // }
        // else if (sr == 'product_ram_sf')
        // {
        //     property = "product_ram";
        //     way = "ASC";
        // }
        // else if (sr == 'product_price_bf')
        // {
        //     property = "product_price";
        //     way = "DESC";
        // }
        // else if (sr == 'product_price_sf')
        // {
        //     property = "product_price";
        //     way = "ASC";
        // }
        // else if (sr == 'product_ind_id_bf')
        // {
        //     property = "product_ind_id";
        //     way = "DESC";
        // }
        // else if (sr == 'product_ind_id_sf')
        // {
        //     property = "product_ind_id";
        //     way = "ASC";
        // }
        // else
        // {
        //     property = "product_ind_id";
        //     way = "ASC";
        // }
        // minimum_price:minimum_price, maximum_price:maximum_price, brand:brand, ram:ram, property:property, way:way
        
        $.ajax({
            url:"/data2.php",
            method:"POST",
            data:{ind_id:ind_id, filter_data:1, start:start, limit:limit},
            success:function(data){
                if (data == "reachedMax")
                    {
                        reachedMax = true;
                    }
                    else
                    {
						start += limit;
                        // if (localStorage.getItem('limit') !== null) {
                        //     limit = localStorage.getItem('limit');
                        // }
						$('.main_content').append(data);
						// localStorage.setItem('limit', start);
                    }
            }
        });
    }

    function get_filter(class_name)
    {
        var filter = [];
        // $('.'+class_name+':checked').each(function(){
        //     filter.push($(this).val());
        // });
		$('select option:selected').each(function(){
            if($(this).val() !== "")
            {
                filter.push($(this).val());
            }
        });
        return filter;
    }

    $('.common_selector').change(function(){
        $('.main_content').html('');
        start = 0;
        reachedMax = false;
        filter_data();
    });

    // $('#price_range').slider({
    //     range:true,
    //     min:1000,
    //     max:65000,
    //     values:[1000, 65000],
    //     step:500,
    //     stop:function(event, ui)
    //     {
    //         $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
    //         $('#hidden_minimum_price').val(ui.values[0]);
    //         $('#hidden_maximum_price').val(ui.values[1]);
    //         $('.filter_data').html('');
    //         start = 0;
    //         reachedMax = false;
    //         filter_data();
    //     }
    // });

// EO Filter data

		$(window).scroll(function() 
		{
			if($(window).scrollTop() > 0)
			{
				if($(window).scrollTop() == $(document).height() - $(window).height()) 
				{
					filter_data();
				}
			}
		});

    // function load_filters()
    // {
    //     $.ajax({
    //         method: "post",
    //         url: "/main/srv_crud/read/filters.php",
    //         success: function(result) {
    //                 $('.sidebar').html(result);
    //             }
    //     });
    // }
    // load_filters();