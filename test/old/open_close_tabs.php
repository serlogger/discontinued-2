<script>
// get_last_opened_tab_id 
function get_last_opened_tab_id ()
{
	var arr = [];
	for (var i = 0; i < localStorage.length; i++)
	{
		var beginning = 'opened';
		var whole = localStorage.getItem(localStorage.key(i)); // get value of i:th key
		var check_opened = whole.substring(whole.indexOf('_') + 1, whole.lastIndexOf('_'));
		if(check_opened == beginning) //if value begins with "opened_"
		{
				arr.push(localStorage.getItem(localStorage.key(i))); // add to the end of array
		}
	}
	
	arr.sort(); // sort array
	last_bunch = arr.at(-2);
	last_id = last_bunch.substring(last_bunch.lastIndexOf('_') + 1);
	return last_id;
}
 // EO get_last_opened_tab_id 


// Open and close tabs
	function close_tab(iiree) {
	$.ajax({
		type: "post",
		url:"/se/"+iiree,
		success: function() {
			//$('.main_content').html('');
			//window.history.back(); //would be perfect but reopens closed tabs
			open_tab(get_last_opened_tab_id());
			//console.log(iiree.substr(iiree.indexOf("/") + 1));
			localStorage.removeItem(iiree.substr(iiree.indexOf("/") + 1)+"_opened_tab");
			}
		});
	}

	function close_tab_in_the_background(iiree) {
	$.ajax({
		method: "post",
		url:"/se/"+iiree,
		success: function() {
			console.log('closing tab success');
				$.ajax({
					method: "post",
					url:"/se/inc/navtop.php",
					success: function(result) {
						$(".navmenu").html(result); //printing navbar 
						//history.pushState({},"",'/se/browse');
						localStorage.removeItem(iiree.substr(iiree.indexOf("/") + 1)+"_opened_tab");
					}
					
				});
			}
		});
	}

	function open_tab(iidee) {
		$.ajax({
			method: "post",
			url:"/se/"+iidee,
			success: function(result) {
				// $("#wrapper").html('');
				$.ajax({
					method: "post",
					url:"/se/inc/navtop.php",
					success: function(result) {
						$(".navmenu").html(result); //printing navbar 
					}
				});
				$(".main_content").html(result);
				history.pushState({},"",'/se/'+iidee);
				localStorage.setItem(iidee+"_opened_tab", Date.now()+'_opened_'+iidee);
			}
		});
		}
// EO Open and close tabs


</script>