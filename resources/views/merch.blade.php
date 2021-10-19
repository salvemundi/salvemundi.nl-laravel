@extends('layouts.app')
@section('title', 'Merchandise – ' . config('app.name'))
@section('content')
    <script src="js/scrollonload.js"></script>
    <div class="overlap">
        <div id="myShop">
            <a href="https://shop.spreadshirt.nl/salvemundi">Salve Mundi merchandise</a>
        </div>

        <script>
            var spread_shop_config = {
                shopName: 'salvemundi',
                locale:   'nl_NL',
                prefix:   'https://shop.spreadshirt.nl',
                baseId:   'myShop'
            };
        </script>

    <script type="text/javascript" src="https://shop.spreadshirt.nl/shopfiles/shopclient/shopclient.nocache.js">
    </script>
</div>
@endsection
