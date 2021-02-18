$(document).ready(function () {
    //on click for dd product to card using ajax
    $(".addToCart").click(function () {
        var id = $(this).attr("data-id");
        var amount = document.getElementById("count").value;
        var size = getRadioValue();
        var element = document.getElementById("colors");
        var color = element.options[element.selectedIndex].text
        $.post("/SafeRideStore/cart/addAjax/" + color + "/" + size + "/" + amount + "/" + id, {}, function (data) {
            $("#cartCount").html(data);
        });
        return false;
    });
    //on click for change passworn using ajax
    $('#changePassClick').click(function () {
        var currPass = $('#currentPassword').val();
        var newPass = $('#newPassword').val();
        var confPass = $('#confirmPassword').val();
        if (currPass.length > 0 && newPass.length > 0 && confPass.length > 0) {
            $.post('/SafeRideStore/account/changePassword ', {
                'currentPass': currPass,
                'newPass': newPass,
                'confirmPass': confPass,
            }, function (data) {
                var obj = JSON.parse(data);
                $("#verifyMassage").html(obj.verify);
                $("#confirmMassage").html(obj.confirm);
                if (obj.success)
                    resetChangePass(obj.success);
            });
            return false;
        }
    });
    //on ckick reet pass
    $('.resetChangePass').click(function () {
        resetChangePass()
    });
    //on click reduse amount of product in cart 
    $(".minus").click(function () {
        var id = $(this).attr("data-id");
        if (document.getElementById("countCart" + id).value > 1) {
            this.parentNode.querySelector('input[type=number]').stepDown()
            $.post("/SafeRideStore/cart/decAjax/" + id, {}, function (data) {
                updateCartHtml(data);

            });
            $.post("/SafeRideStore/cart/total", {}, function (data) {
                console.log(data)
                $("#totalPrice").val(data)
            });
        }
        return false;
    });
    //on click increase amount of product in card 
    $(".plus").click(function () {
        var id = $(this).attr("data-id");
        if (document.getElementById("countCart" + id).value < 99) {
            this.parentNode.querySelector('input[type=number]').stepUp()
            $.post("/SafeRideStore/cart/incAjax/" + id, {}, function (data) {
                updateCartHtml(data)
            });
            $.post("/SafeRideStore/cart/total", {}, function (data) {
                console.log(data)
                $("#totalPrice").val(data)
            });
        }
        return false;

    });
    //on click for order details
    $(".collapsed").click(function () {
        var id = $(this).attr("data-id");
        $.post("/SafeRideStore/order/products/" + id, {}, function (data) {
            $("#orderData" + id).html(data);
        });
    });
    //on click for pay now 
    $("#pay_now").click(function (e) {
        $.post("/SafeRideStore/order/proceedOrder", {}, function (data) {
            if (data == "") {
                $("#payForm").submit();
            } else {
                alert(data);
            }
        });
        e.preventDefault();

    });

    
});


//function resets change password form
function resetChangePass(massage = "") {
    $("#successMassage").html(massage);
    $("#verifyMassage").html("");
    $("#confirmMassage").html("");
    $('#currentPassword').val("");
    $('#newPassword').val("");
    $('#confirmPassword').val("");
}
// funcion gets radio for size button value
function getRadioValue() {
    var element = document.getElementsByName('sizes');
    for (i = 0; i < element.length; i++) {
        if (element[i].checked)
            return element[i].value;
    }
}
//function updates cart when amount of products changes
function updateCartHtml(data) {
    var obj = JSON.parse(data);
    $("#subTotalPrice").html('$' + obj.subTotal);
    $("#TotalPrice").html('$' + obj.totalPrice);
    $("#cartCount").html(' (' + obj.totalItems + ')');
    $("#vat").html('$' + obj.vat);
    $("#itemsCount").html('Cart (' + obj.totalItems + ' items)');
}
$(document).ready(function () {
    loadSizes()
    $("#colors").change(function () {
        loadSizes()

    });
});
//loads availebel sizes for choosen color 
function loadSizes() {
    var id = $("#colors").attr("data-id");
    var element = document.getElementById("colors");
    var color = element.options[element.selectedIndex].text
    $.post("/SafeRideStore/products/sizesAjax/" + color + "/" + id, {}, function (data) {
        $(".sizes").html(data);
    });
    return false;

}
//on click cart
function cartClick() {
    window.alert('Please log-in to view your cart');
}