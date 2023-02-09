function se_translate_class_general(item, current_class) //Translating elements: getting language variables from localStorage to the current HTML elements
{
    var class_name = item.getElementsByClassName(current_class);
    if (class_name.length > 0) {
        var j;
        for (j = 0; j < class_name.length; j++) {
            class_name[j].innerHTML = localStorage.getItem(current_class);
        }
    }
}

function set_language(language) {
    if (language == "fi") {
        var lang_array = {
            'lng_created': "Luotu",
            'lng_delivery_time': "Toimitusaika",
            'lng_distance': "Etäisyys",
            'lng_edited': "Muokattu",
            'lng_email': "Sähköposti",
            'lng_id': "ID",
            'lng_locality': 'Saatavilla',
            'lng_location': 'Sijainti',
            'lng_maximize_filters_bar': "← ",
            'lng_menu': "Valikko",
            'lng_minimize_filters_bar': " →",
            'lng_no_entry': "(ei tietoa)",
            'lng_operating_radius': "Toimintasäde",
            'lng_price': 'Hinta',
            'lng_services': 'Palvelut',
            'lng_view_count': "Näyttökerrat",
            'lng_website': 'Verkkosivu'
        }
    } else { // English
        var lang_array = {
            'lng_created': "Created",
            'lng_delivery_time': "Delivery time",
            'lng_distance': "Distance",
            'lng_edited': "Edited",
            'lng_email': "Email",
            'lng_id': "ID",
            'lng_locality': 'Available',
            'lng_location': 'Location',
            'lng_maximize_filters_bar': "← ",
            'lng_menu': "Menu",
            'lng_minimize_filters_bar': " →",
            'lng_no_entry': "(n/a)",
            'lng_operating_radius': "Operating radius",
            'lng_price': 'Price',
            'lng_services': 'Services',
            'lng_view_count': "View count",
            'lng_website': 'Website'
        }
    }

    for (key in lang_array) { //setting the language variables from JS array to localStorage
        localStorage.setItem(key, lang_array[key]);
        se_translate_class_general(document, key);
    }

    // $.ajax({ // Setting PHP $_SESSION['language']
    //     url: "/dsb.php",
    //     method: "POST",
    //     data: {
    //         language: language
    //     }
    // });
}
// Directly print (write) words in HTML markup

function se_translate_id_case_1(property, id) {
    document.getElementById(property+"_"+id).innerHTML = localStorage.getItem("lng_"+property);
}

function se_translate_id_case_2(property, id) {
    document.getElementById(id).innerHTML = localStorage.getItem(property);
}

// se_translate equivalent for classes, use it e.g. to loop through n/a fields
function se_translate_class_after(id, current_class) {
    var item = document.getElementById(id);
    se_translate_class_general(item, current_class);
}