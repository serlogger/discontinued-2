// Process URL and find and open content
processUrl();

//Set and retrieve scroll position
function setScrollPos(id) { // id = tab id
    $(window).on("scroll", function () {
        console.log('Setting scroll value to localStorage...');
        if (!id) {
            var id = currentTab();
        }
        // console.log('Setting scroll position for tab ' + id + ' using scroll value ' + $(window).scrollTop());
        localStorage.setItem("scrollPos_" + id, $(window).scrollTop());
    });
}

function scrollToPos(id) { //get value from localStorage, if any (and scroll to it)
    console.log("Executing scrollToPos()");
    // $(window).on("scroll", function() {
    // if (!id) {
    // 	var id = currentTab();
    // 	console.log("Tab id: " + id);
    // }
    var scrollPositionValue;
    if (localStorage.getItem("scrollPos_" + id)) {
        scrollPositionValue = localStorage.getItem("scrollPos_" + id);
        console.log("scrollPositionValue: " + scrollPositionValue);
    }
    if (scrollPositionValue) { // If it has value...
        // $(window).scrollTop(scrollPositionValue, );
        window.scrollTo({ top: scrollPositionValue, left: 0, behavior: "instant" })
        console.log("Scrolling to position: " + scrollPositionValue);
    } else {
        console.log('No value to scroll to')
    }
    // });
}

function currentTab() {
    return localStorage.getItem("current_tab");
}

setScrollPos();

		//EO Set and retrieve scroll position