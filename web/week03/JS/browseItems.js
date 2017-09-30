
$(document).ready(function () {
    var jsonURL = "DATA/items.json";
    $.getJSON(jsonURL, function (data) {
        var items = [];
        console.log(data);
        $.each(data, function (key, val) {

            items.push("<div onclick='expandItem(this)' class='item-box col-sm justify-content-md-center' id='" + val.id + "'><img  onclick='shrinkItem(this)' class='close' src='DATA/close.png'><img src='" + val.photoURL + "'><h3>" + val.name + "</h3><div class='row'> <div class='col-sm-9'>" + val.description + "</div><div class='col-sm-3'><img class='icon' onlclick='addToCart' src='DATA/cart.png'></div></div></div>");
            console.log(val);
        });
        $("<div/>", {
            "class": "row"
            , html: items.join("")
        }).appendTo("#browseItems");
    });
    var cart = {};
    cart = JSON.stringify(cart);
    sessionStorage.cart = cart;
});


function expandItem(item){
    window.location.href = "#" +item.id;
    console.log(item);
    item.onclick = "";
    item.classList.remove("col-sm");
    item.classList.add("large");
    item.firstChild.style.display = "block";
}

function shrinkItem(item){
    item.style.display = "none";
   var large = document.getElementsByClassName("large");
    large.item(0).onclick = "expandItem(this)";
    large.item(0).className = "item-box col-sm justify-content-center";
//    for(var i = 0; i < large.length; i ++){
//    
//        large[i].onclick = 
//        large[i].className = 
//    }
}

//function addToCart(item){
//    var parentID = $(item).parent.id
//    var cart=sessionStorage.getItem("cart");
//    cart = JSON.parse(cart);
//    cart.push({item.id})
//}


