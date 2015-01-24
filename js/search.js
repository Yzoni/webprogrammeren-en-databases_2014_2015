function showResult(str) {
    if (str.length < 2) {
        document.getElementById("searchdropdown").innerHTML = "";
        document.getElementById("searchdropdown").style.visibility = "hidden";
        return;
    }
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("searchdropdown").innerHTML = xmlhttp.responseText;
            document.getElementById("searchdropdown").style.visibility = "visible";
        }
    }
    xmlhttp.open("GET", "searchdropdown.php?q=" + str, true);
    xmlhttp.send();
}