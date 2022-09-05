$(document).ready(function(){

    //plus button click
    $('.btn-plus').click(function(){
        $parentNode = $(this).parents('tr');
        $price = $parentNode.find('#price').val();
        $quantity = Number($parentNode.find('#quantity').val());

        $total = $price * $quantity;
        $parentNode.find('#total').html($total+" kyats");

        summaryCalculation();
    })

    //minus button click
    $('.btn-minus').click(function(){
        $parentNode = $(this).parents('tr');
        $price = $parentNode.find('#price').val();
        $quantity = Number($parentNode.find('#quantity').val());

        $total = $price * $quantity;
        $parentNode.find('#total').html($total+" kyats");

        summaryCalculation();
    })

    //remove button click
    $('.btnRemove').click(function(){
        $parentNode = $(this).parents('tr');
        $parentNode.remove();

        summaryCalculation();
    })

    // calculate final price
    function summaryCalculation(){
        $totalPrice = 0;
        $('#dataTable tr').each(function(index,row){
            $totalPrice += Number($(row).find('#total').text().replace('kyats',''));
        });

        $('#subTotalPrice').html(`${$totalPrice} kyats`);
        $('#finalPrice').html(`${$totalPrice + 3000} kyats`);
    }
})
