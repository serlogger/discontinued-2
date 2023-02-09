var js_config_array = {
    'cfg_services_tab': "tab_2",
    'cfg_login_tab': "tab_0"
}

for (key in js_config_array) { //setting the config variables from JS array to localStorage
    localStorage.setItem(key, js_config_array[key]);
}