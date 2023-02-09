//Process tabs, language and colors
window.addEventListener('popstate', e => {
    processUrl();
});

function processUrl() { // Splitting URL and checking if it contains "srv" or "tab" --> acting accordingly
    console.log('executing processUrl()...');
    urlParam = window.location.toString();
    console.log("processUrl() is now using string: " + urlParam);
    const urlArray = urlParam.split("/", 5);
    var urlArr4 = urlArray[4];
    console.log("processUrl() urlArray[4] has value " + urlArr4);
    if (urlArr4.substring(0, 3) == "srv") {
        open_service_view_tab(urlArr4, "popstate");
    }
    // if(urlArr4.substring(0,3) == "upd")
    // {
    // 	open_service_update_tab(urlArr4, "popstate");
    // } 
    if (urlArr4.substring(0, 3) == "tab") {
        open_static_tab(urlArr4, "popstate");
    }
}

function open_static_tab(id, source) {
    if (document.getElementById(id + "_content")) {
        openGeneral(id, source, "static");
        document.getElementById(id + "_content").style.display = "block";
        // $("#"+id + "_content").show(300);
        document.getElementById(id).style.border = "7px solid lightblue";
        document.getElementById(id).style.borderBottom = "none";
        scrollToPos(id);
    } else {
        console.log(id + "_content" + ' not found');
    }
}

function open_service_view_tab(id, source) {
    openGeneral(id, source, "service");
    var name = "'name'";
    if (!document.getElementById("tab_" + id)) {
        document.getElementById('tabs').innerHTML += '<div id="tab_' + id + '" class="tab" name="' + id + '" onclick="open_service_view_tab(this.attributes[' + name + '].value)">' + id + '</div><button id="button_' + id + '" name="' + id + '" style="cursor:pointer; display:inline; padding:10px; border: 1px solid black;" onclick="close_service(this.attributes[' + name + '].value)">X</button>';
    }
    if (!document.getElementById(id + '_content')) {
        document.getElementById('grid_container_content').innerHTML += '<div id="' + id + '_content" class="tab_content" style="display:block;">' + id + ' content</div>';
    } else {
        document.getElementById(id + '_content').style.display = "block";
    }
    scrollToPos(id);
    // setScrollPos(id);
    document.getElementById("tab_" + id).style.border = "7px solid lightblue";
    document.getElementById("tab_" + id).style.borderBottom = "none";

}

function openGeneral(id, source, type) {
    console.log(' ');
    console.log('Opening ' + type + ' tab: ' + id + ', source: ' + source);
    if (source !== "popstate") {
        history.pushState(null, null, id);
    } else {
        history.replaceState(null, null, id);
    }
    // Close the current content (display none)
    if (localStorage.getItem("current_tab") && document.getElementsByClassName(localStorage.getItem("current_tab")).length !== 0 && document.getElementById(localStorage.getItem("current_tab"))) {
        var x = document.getElementsByClassName(localStorage.getItem("current_tab"))[0];
        // se_curr_tab = localStorage.getItem("current_tab");
        // var x = $("."+se_curr_tab+":first");
        var y = document.getElementById(localStorage.getItem("current_tab"));
        x.style.display = "none";
        // x.fadeOut(200);
        y.style.border = "3px solid lightblue";
    } else {
        tab_content = document.getElementsByClassName('tab_content');
        var i;
        for (i = 0; i < tab_content.length; i++) {
            if (document.getElementsByClassName("tab_content")) {
                console.log('Tabcontent ' + i + ' found, making sure it is closed before showing the current one...')
                document.getElementsByClassName("tab_content")[i].style.display = "none";
                //document.getElementsByClassName(localStorage.getItem("current_tab")).style.display = "none";
                document.getElementsByClassName('tab')[i].style.border = "3px solid lightblue";
            }
        }
    }
    localStorage.setItem('current_tab', id);
    // openTabAppend(id);
}

function close_service(id) {
    // //Remove closed tab from opened tabs history by replacing id with ''
    // localStorage.setItem('openTab', localStorage.getItem('openTab').replaceAll(id+',',''));
    // //Remove duplicates so that user doesn't have to keep clicking the back button
    // let tabsString = localStorage.getItem('openTab');
    // const tabArray = tabsString.split(',');
    // duplicates = 1;
    // k = 0;
    // max_loops = 50;
    // while(duplicates > 0 && k < max_loops)
    // {
    // 	duplicates = 0;
    // 	console.log('Searching for duplicates...');
    // 	for(i=0; i<tabArray.length; i++)
    // 	{
    // 		j = i+1;
    // 		if(tabArray[i] == tabArray[j])
    // 		{
    // 			console.log('Duplicates found. '+tabArray[i]+' = '+tabArray[j]+' Table length before: '+tabArray.length);
    // 			tabArray.splice(i, 1);
    // 			console.log('Table length after: '+tabArray.length);
    // 			duplicates = 1;
    // 		}
    // 	}
    // 	k++;
    // }

    // localStorage.setItem('openTab', tabArray);

    document.getElementById('button_' + id).remove();
    document.getElementById("tab_" + id).remove();
    document.getElementById(id + "_content").remove();
}


	//EO Process tabs, language and colors