

		load_navbar();
		//Mobile layout JS
		function clickToShowOrHide($id) {
			if ($(window).width() < 1200)
			{
				var z = document.getElementById($id);
				if (z.style.display === "block") {
					z.style.display = "none";
				} else {
					z.style.display = "block";
				}
			}
		}

		function clicktoHide($id) {
			if ($(window).width() < 1200)
			{	
				document.getElementById($id).style.display = "none";
			}
		}

		function clicktoHideAll() {
			clicktoHide('c1');
			clicktoHide('c3');
		}

		function showOrHide13BasedOnWidth(x) {
		// var y = document.getElementById("c1");
		// var w = document.getElementById("c3");
		// if (x.matches) { // If media query matches
		// 	y.style.display = "none";
		// 	w.style.display = "none";
		// } else {
		// 	y.style.display = "block";
		// 	w.style.display = "block";
		// }
		}
		var x = window.matchMedia("(max-width: 1200px)")
		showOrHide13BasedOnWidth(x) // Call listener function at run time
		//x.addListener(showOrHide13BasedOnWidth) // Attach listener function on state changes

	
		jQuery(function($) { // DOM ready

			$('form').on('keydown', function(ev) {
				if (ev.key === "Enter" && !$(ev.target).is('textarea')) {
				ev.preventDefault();
				}
			});

		});

	$(document).ready(function(){
		$('.main').height($(window).height() - 110);
		$(window).on("resize", function(){
			$('.main').height($(window).height() - 110);
		});
	});
	
    function load_navbar() 
	{
        $.ajax({
            method: "post",
            url:"/inc/navtop.php",
            success: function(result) {
                $(".navmenu").html(result); //printing navbar
            }
        });

    }

	// function sleep(ms) {
	// return new Promise(resolve => setTimeout(resolve, ms));
	// }

	// // async function demo() {
	// async function demo() {
	// // console.log('Taking a break...');
	// await sleep(2000);
	// //var test32 = document.getElementById("463").id;
	// // console.log(document.getElementById("463").id);
	// }

	// demo();






	//Categorization: get saved values if they're in localstorage



	if (getSavedValue("industries_dropdown")){
		var ind_id = getSavedValue("industries_dropdown");
		$.ajax({
			url: "get_cats_in_use.php",
			method: "POST",
			data: {
				ind_id: ind_id
			},
			cache: false,
			success: function(result) {
				$("#categories_dropdown").html(result);
				_("categories_dropdown").value = getSavedValue("categories_dropdown");
			}
		});
	}


		$('#industries_dropdown').on('change', function() {
			var ind_id = this.value;
			$.ajax({
				url: "get_cats_in_use.php",
				method: "POST",
				data: {
					ind_id: ind_id
				},
				cache: false,
				success: function(result) {
					$("#categories_dropdown").html(result);
				}
			});
		});
			
		$('#categories_dropdown, #industries_dropdown').on('change', function() {
			var cat_id = this.value;
			$.ajax({
				url: "get_sub_cats_in_use.php",
				method: "POST",
				data: {
					cat_id: cat_id
				},
				cache: false,
				success: function(result) {
					$("#subcat_dropdown").html(result);
				}
			});
		});

		if (getSavedValue("categories_dropdown")){
			var cat_id = getSavedValue("categories_dropdown");
			$.ajax({
				url: "get_sub_cats_in_use.php",
				method: "POST",
				data: {
					cat_id: cat_id
				},
				cache: false,
				success: function(result) {
					$("#subcat_dropdown").html(result);
					_("subcat_dropdown").value = getSavedValue("subcat_dropdown");
				}
			});
		}

	//Categorization: Make multi-level dropdowns work

		if (getSavedValue("industries_dropdown")){
			var ind_id = getSavedValue("industries_dropdown");
			$.ajax({
				url: "get_cats_in_use.php", //routes needed for new files!
				method: "POST",
				data: {
					ind_id: ind_id
				},
				cache: false,
				success: function(result) {
					$("#categories_dropdown").html(result);
					_("categories_dropdown").value = getSavedValue("categories_dropdown");
				}
			});
		}

		$('#industries_dropdown').on('change', function() {
			var ind_id = this.value;
			$.ajax({
				url: "get_cats_in_use.php",
				method: "POST",
				data: {
					ind_id: ind_id
				},
				cache: false,
				success: function(result) {
					$("#categories_dropdown").html(result);
				}
			});
		});
			
		$('#categories_dropdown, #industries_dropdown').on('change', function() {
			var cat_id = this.value;
			$.ajax({
				url: "get_sub_cats_in_use.php",
				method: "POST",
				data: {
					cat_id: cat_id
				},
				cache: false,
				success: function(result) {
					$("#subcat_dropdown").html(result);
				}
			});
		});

		if (getSavedValue("categories_dropdown")){
			var cat_id = getSavedValue("categories_dropdown");
			$.ajax({
				url: "get_sub_cats_in_use.php",
				method: "POST",
				data: {
					cat_id: cat_id
				},
				cache: false,
				success: function(result) {
					$("#subcat_dropdown").html(result);
					_("subcat_dropdown").value = getSavedValue("subcat_dropdown");
				}
			});
		}
			



	//Deal with localstorage (categorization and others)

	if(document.getElementById('industries_dropdown') !== null)
	{
		_("industries_dropdown").value  = getSavedValue("industries_dropdown");
	}

    //Save the value function - save it to localStorage as (ID, VALUE)
    function saveValue(e){
        obj = document.getElementById('industries_dropdown');
        //console.log(obj.value);
        var id = e.id;  // get the sender's id so we know what to save
        var val = e.value; // get the value. 
        localStorage.setItem(id, val);// On each input, the localStorage's value will override
        if (id == 'industries_dropdown') {localStorage.removeItem('categories_dropdown');}
        if (id == 'industries_dropdown') {localStorage.removeItem('subcat_dropdown');}
        if (id == 'categories_dropdown') {localStorage.removeItem('subcat_dropdown');}
    }

    //get the saved value function - return the value of "v" from localStorage. 
    function getSavedValue(v){
        if (!localStorage.getItem(v)) {
            return ""; //You can change this to your defualt value. 
        } else { 
            return localStorage.getItem(v);
        }
    }

