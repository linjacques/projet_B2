document.addEventListener("avis").addEventListener("submit"), function(test) {
    test.preventDefault();

    //appel async 
    var xhr =  new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        console.log(this);
    };
    xhr.open("POST", "/async/detailPublication.php", true);
    return false;
}