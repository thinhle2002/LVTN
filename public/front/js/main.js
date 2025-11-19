/*  ---------------------------------------------------
    Template Name: codelean
    Description: codelean eCommerce HTML Template
    Author: CodeLean
    Author URI: https://CodeLean.vn/
    Version: 1.0
    Created: CodeLean
---------------------------------------------------------  */

'use strict';

(function ($) {

    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");
    });

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    /*------------------
		Navigation
	--------------------*/
    $(".mobile-menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

    /*------------------
        Hero Slider
    --------------------*/
    $(".hero-items").owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        items: 1,
        dots: false,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
    });

    /*------------------
        Product Slider
    --------------------*/
   $(".product-slider").owlCarousel({
        loop: false,
        margin: 25,
        nav: true,
        items: 4,
        dots: true,
        navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {
            0: {
                items: 1,
            },
            576: {
                items: 2,
            },
            992: {
                items: 2,
            },
            1200: {
                items: 3,
            }
        }
    });

    /*------------------
       logo Carousel
    --------------------*/
    $(".logo-carousel").owlCarousel({
        loop: false,
        margin: 30,
        nav: false,
        items: 5,
        dots: false,
        navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        mouseDrag: false,
        autoplay: true,
        responsive: {
            0: {
                items: 3,
            },
            768: {
                items: 5,
            }
        }
    });

    /*-----------------------
       Product Single Slider
    -------------------------*/
    $(".ps-slider").owlCarousel({
        loop: false,
        margin: 10,
        nav: true,
        items: 3,
        dots: false,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
    });

    /*------------------
        CountDown
    --------------------*/
  
    console.log(timerdate);

    // Use this for real timer date
    var timerdate = "2026/01/01";

	$("#countdown").countdown(timerdate, function(event) {
        $(this).html(event.strftime("<div class='cd-item'><span>%D</span> <p>Days</p> </div>" + "<div class='cd-item'><span>%H</span> <p>Hrs</p> </div>" + "<div class='cd-item'><span>%M</span> <p>Mins</p> </div>" + "<div class='cd-item'><span>%S</span> <p>Secs</p> </div>"));
    });


    /*----------------------------------------------------
     Language Flag js
    ----------------------------------------------------*/
    $(document).ready(function(e) {
    //no use
    try {
        var pages = $("#pages").msDropdown({on:{change:function(data, ui) {
            var val = data.value;
            if(val!="")
                window.location = val;
        }}}).data("dd");

        var pagename = document.location.pathname.toString();
        pagename = pagename.split("/");
        pages.setIndexByValue(pagename[pagename.length-1]);
        $("#ver").html(msBeautify.version.msDropdown);
    } catch(e) {
        // console.log(e);
    }
    $("#ver").html(msBeautify.version.msDropdown);

    //convert
    $(".language_drop").msDropdown({roundedBorder:false});
        $("#tech").data("dd");
    });
    /*-------------------
		Range Slider
	--------------------- */
    function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    var rangeSlider = $(".price-range"),
        
        minamountDisplay = $("#minamount"), 
        maxamountDisplay = $("#maxamount"), 
        
        minamountHidden = $("#minamount_hidden"),
        maxamountHidden = $("#maxamount_hidden"),

        minPrice = rangeSlider.data('min'),
        maxPrice = rangeSlider.data('max'),
        minValue = rangeSlider.data('min-value') !== '' ? rangeSlider.data('min-value') : minPrice,
        maxValue = rangeSlider.data('max-value') !== '' ? rangeSlider.data('max-value') : maxPrice;

    
    function updatePriceInputs(values) {
        var minValRaw = values[0] * 1000;
        var maxValRaw = values[1] * 1000;

       
        minamountDisplay.val(formatNumber(minValRaw) + 'đ');
        maxamountDisplay.val(formatNumber(maxValRaw) + 'đ');
        
        minamountHidden.val(minValRaw);
        maxamountHidden.val(maxValRaw);
    }

    rangeSlider.slider({
        range: true,
        min: minPrice,
        max: maxPrice,
        values: [minValue, maxValue],
        slide: function (event, ui) {
            
            updatePriceInputs(ui.values);
        }
    });

    updatePriceInputs(rangeSlider.slider("values"));

    /*-------------------
		Radio Btn
	--------------------- */
    $(".fw-size-choose .sc-item label, .pd-size-choose .sc-item label").on('click', function () {
        $(".fw-size-choose .sc-item label, .pd-size-choose .sc-item label").removeClass('active');
        $(this).addClass('active');
    });
    /*-------------------
		Selected Color
	--------------------- */
    $(document).ready(function() {
    var colorInputs = $('.fw-color-choose input[type="radio"]');

    colorInputs.on('change', function() {
        $('.fw-color-choose .cs-item').removeClass('selected');
        $(this).closest('.cs-item').addClass('selected');
    });
    var checkedItem = colorInputs.filter(':checked');
    if (checkedItem.length) {
        checkedItem.closest('.cs-item').addClass('selected');
    }
    });
    /*-------------------
		Nice Select
    --------------------- */
    $('.sorting, .p-show').niceSelect();

    /*------------------
		Single Product
	--------------------*/
	$('.product-thumbs-track .pt').on('click', function(){
		$('.product-thumbs-track .pt').removeClass('active');
		$(this).addClass('active');
		var imgurl = $(this).data('imgbigurl');
		var bigImg = $('.product-big-img').attr('src');
		if(imgurl != bigImg) {
			$('.product-big-img').attr({src: imgurl});
			$('.zoomImg').attr({src: imgurl});
		}
	});

    // $('.product-pic-zoom').zoom();

    /*-------------------
		Quantity change
	--------------------- */
    var proQty = $('.pro-qty');
	proQty.prepend('<span class="dec qtybtn">-</span>');
	proQty.append('<span class="inc qtybtn">+</span>');
	proQty.on('click', '.qtybtn', function () {
		var $button = $(this);
		var oldValue = $button.parent().find('input').val();
		if ($button.hasClass('inc')) {
			var newVal = parseFloat(oldValue) + 1;
		} else {
			// Don't allow decrementing below zero
			if (oldValue > 0) {
				var newVal = parseFloat(oldValue) - 1;
			} else {
				newVal = 0;
			}
		}
		$button.parent().find('input').val(newVal);

        //Update Cart
        var rowId = $button.parent().find('input').data('rowid');
        updateCart(rowId, newVal);
	});

    /*-------------------
		Bộ lọc sản phẩm trang chủ
	--------------------- */

    const product_men = $(".product-slider.men");
    const product_women = $(".product-slider.women");

    $('.filter-control').on('click', '.item', function() {
        const $item = $(this);
        const filter = $item.data('tag');
        const category = $item.data('category');

        $item.siblings().removeClass('active');
        $item.addClass('active');

        if(category === "men"){
            product_men.owlcarousel2_filter(filter);
        }
        if(category === "women"){
            product_women.owlcarousel2_filter(filter);
        }
    })

})(jQuery);
    /*-------------------
		Add - Remove - Destroy - Update Cart
	--------------------- */
function addCart(productId, color = null, size = null, qty = 1)
{
    var color = $('input[name="color"]:checked').val();
    var size = $('input[name="product_size_radio"]:checked').val();
    var qty = $('#qty-input').val();

    if(!color) {
        Swal.fire({
            icon: 'warning',
            title: 'Chưa chọn màu sắc!',
            text: 'Vui lòng chọn màu sắc cho sản phẩm.'
        });
        return;
    }
    if(!size) {
        Swal.fire({
            icon: 'warning',
            title: 'Chưa chọn kích thước!',
            text: 'Vui lòng chọn kích thước cho sản phẩm.'
        });
        return;
    }
    
    $.ajax({
        type:"GET",
        url:"/cart/add",
        data:{
            productId: productId,
            color: color,
            size: size,
            qty: qty
        },
        success: function (reponse){
            $('.cart-count').text(reponse['count']);
            $('.cart-price').text(formatVND(reponse['total']));
            $('.select-total h5').text(formatVND(reponse['total']));

            var cartHover_tbody = $('.select-items tbody');
            var cartHover_existItem = cartHover_tbody.find("tr" + "[data-rowId='" + reponse['cart'].rowId + "']");

            if(cartHover_existItem.length){
                cartHover_existItem.find('.product-selected p').text(formatVND(reponse['cart'].price * 1000) + ' x ' + reponse['cart'].qty);
            }
            else{
                var convertedColor = convertColorNameJS(reponse['cart'].options.color);
                var productSize = reponse['cart'].options.size;

                var colorSizeDisplay = '';
                if (convertedColor || productSize) {
                     colorSizeDisplay = (convertedColor ? convertedColor : '') + (productSize ? ' / ' + productSize : '');
                }
                var newItem =
                    '<tr data-rowId="'+ reponse['cart'].rowId +'">\n' +
                    '    <td class="si-pic"><img style="height: 70px;" src="front/img/products/'+ reponse['cart'].options.images[0].path + '"></td>\n' +
                    '    <td class="si-text">\n' +
                    '        <div class="product-selected">\n' +
                    // '            <p>'+ formatVND(reponse['cart'].price * 1000) + ' x ' + reponse['cart'].qty + '</p>\n' +
                    '            <h6>'+ reponse['cart'].name + ' x ' + reponse['cart'].qty +'</h6>\n' +
                    '            <p>' + colorSizeDisplay + '</p>\n' +                
                    '        </div>\n' +
                    '    </td>\n' +
                    '    <td class="si-close" onclick="removeCart(\''+ reponse['cart'].rowId + '\')">\n' +
                    '        <i class="ti-trash remove-icon-red"></i>\n' +
                    '    </td>\n' +
                    '</tr>';

                cartHover_tbody.append(newItem);
            }
            var productName = (reponse.cart && reponse.cart.name) ? reponse.cart.name : 'Sản phẩm';

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: 'Thêm vào giỏ hàng thành công: ' + productName
            })

            console.log(reponse);
        },
        error: function(reponse){
            Swal.fire({
                icon: 'error',
                title: 'Thêm thất bại!',
                text: 'Đã xảy ra lỗi khi thêm sản phẩm vào giỏ hàng.'
            })
            console.log(reponse);
        }
    });
}
function removeCart(rowId)
{
    $.ajax({
        type:"GET",
        url:"/cart/delete",
        data:{rowId: rowId},
        success: function (reponse){
            $('.cart-count').text(reponse['count']);
            $('.cart-price').text(formatVND(reponse['total']));
            $('.select-total h5').text(formatVND(reponse['total']));

            var cartHover_tbody = $('.select-items tbody');
            var cartHover_existItem = cartHover_tbody.find("tr" + "[data-rowId='" + rowId + "']");
            cartHover_existItem.remove();

            var cart_tbody = $('.cart-table tbody');
            var cart_existItem = cart_tbody.find("tr" + "[data-rowId='" + rowId + "']");
            cart_existItem.remove();

            $('.subtotal span').text(formatVND(reponse['subtotal']));
            $('.cart-total span').text(formatVND(reponse['total']));

            var productName = (reponse.cart && reponse.cart.name) ? reponse.cart.name : 'Sản phẩm';

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'info',
                title: 'Đã xóa khỏi giỏ hàng: ' + productName
            })

            console.log(reponse);
        },
        error: function(reponse){
            Swal.fire({
                icon: 'error',
                title: 'Xóa thất bại!',
                text: 'Đã xảy ra lỗi khi xóa sản phẩm khỏi giỏ hàng.'
            })
            console.log(reponse);
        }
    });
}
function destroyCart()
{
    $.ajax({
        type:"GET",
        url:"/cart/destroy",
        data:{},
        success: function (reponse){
            $('.cart-count').text('0');
            $('.cart-price').text('0');
            $('.select-total h5').text('0');

            var cartHover_tbody = $('.select-items tbody');
            cartHover_tbody.children().remove();

            var cart_tbody = $('.cart-table tbody');
            cart_tbody.children().remove();

            $('.subtotal span').text('0');
            $('.cart-total span').text('0');

            alert('Delete successful!\nProduct:' + reponse['cart'].name);
            console.log(reponse);
        },
        error: function(reponse){
            alert('Deleted Failed!');
            console.log(reponse);
        }
    });
}
function updateCart (rowId, qty)
{
    $.ajax({
        type:"GET",
        url:"/cart/update", 
        data:{rowId: rowId, qty: qty},
        success: function (response){ 

            $('.cart-count').text(response['count']);
            $('.cart-price').text(formatVND(response['total'])) * 1000;
            $('.select-total h5').text(formatVND(response['total']));
            $('.subtotal span').text(formatVND(response['subtotal']));
            $('.cart-total span').text(formatVND(response['total'])); 

            var cartHover_tbody = $('.select-items tbody');
            var cartHover_existItem = cartHover_tbody.find("tr" + "[data-rowId='" + rowId + "']");
            if (qty === 0)
            {
                cartHover_existItem.remove();
            } else {
                
                var unitPrice = parseFloat(response['cart'].price);
                var newPriceDisplay = unitPrice.toFixed(2) + ' x ' + response['cart'].qty;
                cartHover_existItem.find('.product-selected p').text(newPriceDisplay);
            }

            var cart_tbody = $('.cart-table tbody');
            var cart_existItem = cart_tbody.find("tr" + "[data-rowId='" + rowId + "']");
            if (qty === 0)
            {
                cart_existItem.remove();
            } else {
                
                var itemTotalPrice = parseFloat(response['cart'].price) * parseFloat(response['cart'].qty) * 1000;
                           
                cart_existItem.find('.total-price').text(formatVND(itemTotalPrice));                
                cart_existItem.find('.pro-qty input').val(response['cart'].qty); 
            }

        },
        error: function(xhr, status, error) {
            console.error("Lỗi AJAX: " + status + " - " + error);
        }
    });
};

    /*-------------------
		Zoom Pic Products
	--------------------- */
$(document).ready(function() {
    // 1. Phóng to ảnh khi di chuột vào
    $('.product-pic-zoom').on('mouseenter', function() {
        $(this).addClass('zoomed');
    }).on('mouseleave', function() {
        $(this).removeClass('zoomed');
    });

    // 2. Di chuyển ảnh theo con trỏ chuột (Hiệu ứng Lens/Zoom)
    $('.product-pic-zoom').on('mousemove', function(e) {
        if ($(this).hasClass('zoomed')) {
            var $img = $(this).find('.product-big-img');
            var imgWidth = $img.width();
            var imgHeight = $img.height();
            
            // Lấy vị trí chuột trong phần tử .product-pic-zoom
            var posX = e.pageX - $(this).offset().left;
            var posY = e.pageY - $(this).offset().top;
            
            // Tính phần trăm vị trí chuột (0 đến 1)
            var percentX = posX / $(this).width();
            var percentY = posY / $(this).height();

            // Tính toán vị trí dịch chuyển (translate) để ảnh phóng to lấy chuột làm trung tâm
            // Giá trị 1.5 là mức scale đã đặt trong CSS
            var translateX = (percentX - 0.5) * (imgWidth * 1.5 - imgWidth);
            var translateY = (percentY - 0.5) * (imgHeight * 1.5 - imgHeight);

            // Áp dụng dịch chuyển cùng với scale
            $img.css({
                'transform': 'scale(1.5) translate(' + (-translateX) + 'px, ' + (-translateY) + 'px)'
            });
        }
    });
    
    // 3. Reset transform khi di chuột ra
    $('.product-pic-zoom').on('mouseleave', function() {
        // Đảm bảo ảnh trở lại vị trí và kích thước ban đầu
        $(this).find('.product-big-img').css({
            'transform': 'scale(1) translate(0, 0)'
        });
        $(this).removeClass('zoomed'); // Xóa class 'zoomed' để đảm bảo CSS được reset
    });
});
function formatVND(amount) {
    var numericAmount = parseFloat(amount);
    return numericAmount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + 'đ';
}

    