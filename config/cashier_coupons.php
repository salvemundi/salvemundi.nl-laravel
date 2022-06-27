<?php

return [

    /** Settings applied to every coupon. Can be overridden per coupon. */
    'defaults' => [

        /**
         * The class responsible for validating and applying the coupon discount.
         * Must extend \Cashier\Discount\BaseCouponHandler
         */
        //'handler' => '\SomeHandler',

        /**
         * The number of times this coupon will be applied. I.e. If you'd like to prove 6 months discount on a
         * monthly subscription:
         *
         * @example 6
         */
        'times' => 1,

        /** Any context you want to pass to the handler */
        'context' => [],
    ],

    /** Available coupons */
    'coupons' => [

        /** The coupon code. Must be unique (case insensitive). */
        // env("COUPON_18_EURO") => [

        //     /**
        //      * The class responsible for validating and applying the coupon discount.
        //      * Must extend \Cashier\Discount\BaseCouponHandler
        //      */
        //     'handler' => \Laravel\Cashier\Coupon\FixedDiscountHandler::class,

        //     /** Any context you want to pass to the handler */
        //     'context' => [
        //         'description' => 'Coupon code 18 euro korting ' . config('app.name'),
        //         'discount' => [
        //             'currency' => 'EUR', // Make sure the currency matches the subscription plan it's being applied to
        //             'value' => '18.00',
        //         ],

        //         /** Add credit to the customer's balance if discount results in a negative amount. */
        //         'allow_surplus' => false,
        //     ],
        // ],
        // env("COUPON_15_EURO") => [

        //     /**
        //      * The class responsible for validating and applying the coupon discount.
        //      * Must extend \Cashier\Discount\BaseCouponHandler
        //      */
        //     'handler' => \Laravel\Cashier\Coupon\FixedDiscountHandler::class,

        //     /** Any context you want to pass to the handler */
        //     'context' => [
        //         'description' => 'Coupon code 15 euro korting  ' . config('app.name'),
        //         'discount' => [
        //             'currency' => 'EUR', // Make sure the currency matches the subscription plan it's being applied to
        //             'value' => '15.00',
        //         ],

        //         /** Add credit to the customer's balance if discount results in a negative amount. */
        //         'allow_surplus' => false,
        //     ],
        // ],
        // env("COUPON_10_EURO") => [

        //     /**
        //      * The class responsible for validating and applying the coupon discount.
        //      * Must extend \Cashier\Discount\BaseCouponHandler
        //      */
        //     'handler' => \Laravel\Cashier\Coupon\FixedDiscountHandler::class,

        //     /** Any context you want to pass to the handler */
        //     'context' => [
        //         'description' => 'Coupon code 10 euro korting  ' . config('app.name'),
        //         'discount' => [
        //             'currency' => 'EUR', // Make sure the currency matches the subscription plan it's being applied to
        //             'value' => '10.00',
        //         ],

        //         /** Add credit to the customer's balance if discount results in a negative amount. */
        //         'allow_surplus' => false,
        //     ],
        // ],
        // env("COUPON_8_EURO") => [

        //     /**
        //      * The class responsible for validating and applying the coupon discount.
        //      * Must extend \Cashier\Discount\BaseCouponHandler
        //      */
        //     'handler' => \Laravel\Cashier\Coupon\FixedDiscountHandler::class,

        //     /** Any context you want to pass to the handler */
        //     'context' => [
        //         'description' => 'Coupon code 8 euro korting  ' . config('app.name'),
        //         'discount' => [
        //             'currency' => 'EUR', // Make sure the currency matches the subscription plan it's being applied to
        //             'value' => '8.00',
        //         ],

        //         /** Add credit to the customer's balance if discount results in a negative amount. */
        //         'allow_surplus' => false,
        //     ],
        // ],
        // env("COUPON_7_EURO") => [

        //     /**
        //      * The class responsible for validating and applying the coupon discount.
        //      * Must extend \Cashier\Discount\BaseCouponHandler
        //      */
        //     'handler' => \Laravel\Cashier\Coupon\FixedDiscountHandler::class,

        //     /** Any context you want to pass to the handler */
        //     'context' => [
        //         'description' => 'Coupon code 7 euro korting ' . config('app.name'),
        //         'discount' => [
        //             'currency' => 'EUR', // Make sure the currency matches the subscription plan it's being applied to
        //             'value' => '7.00',
        //         ],

        //         /** Add credit to the customer's balance if discount results in a negative amount. */
        //         'allow_surplus' => false,
        //     ],
        // ],
        // env("COUPON_5_EURO") => [

        //     /**
        //      * The class responsible for validating and applying the coupon discount.
        //      * Must extend \Cashier\Discount\BaseCouponHandler
        //      */
        //     'handler' => \Laravel\Cashier\Coupon\FixedDiscountHandler::class,

        //     /** Any context you want to pass to the handler */
        //     'context' => [
        //         'description' => 'Coupon code 5 euro korting ' . config('app.name'),
        //         'discount' => [
        //             'currency' => 'EUR', // Make sure the currency matches the subscription plan it's being applied to
        //             'value' => '5.00',
        //         ],

        //         /** Add credit to the customer's balance if discount results in a negative amount. */
        //         'allow_surplus' => false,
        //     ],
        // ],
        // env("COUPON_4_EURO") => [

        //     /**
        //      * The class responsible for validating and applying the coupon discount.
        //      * Must extend \Cashier\Discount\BaseCouponHandler
        //      */
        //     'handler' => \Laravel\Cashier\Coupon\FixedDiscountHandler::class,

        //     /** Any context you want to pass to the handler */
        //     'context' => [
        //         'description' => 'Coupon code 4 euro korting ' . config('app.name'),
        //         'discount' => [
        //             'currency' => 'EUR', // Make sure the currency matches the subscription plan it's being applied to
        //             'value' => '4.00',
        //         ],

        //         /** Add credit to the customer's balance if discount results in a negative amount. */
        //         'allow_surplus' => false,
        //     ],
        // ],
        // env("COUPON_3_EURO") => [

        //     /**
        //      * The class responsible for validating and applying the coupon discount.
        //      * Must extend \Cashier\Discount\BaseCouponHandler
        //      */
        //     'handler' => \Laravel\Cashier\Coupon\FixedDiscountHandler::class,

        //     /** Any context you want to pass to the handler */
        //     'context' => [
        //         'description' => 'Coupon code 3 euro korting ' . config('app.name'),
        //         'discount' => [
        //             'currency' => 'EUR', // Make sure the currency matches the subscription plan it's being applied to
        //             'value' => '3.00',
        //         ],

        //         /** Add credit to the customer's balance if discount results in a negative amount. */
        //         'allow_surplus' => false,
        //     ],
        // ],
        env("COUPON_1_CENT") => [

            /**
             * The class responsible for validating and applying the coupon discount.
             * Must extend \Cashier\Discount\BaseCouponHandler
             */
            'handler' => \Laravel\Cashier\Coupon\FixedDiscountHandler::class,

            /** Any context you want to pass to the handler */
            'context' => [
                'description' => 'Coupon code veel euro korting ' . config('app.name'),
                'discount' => [
                    'currency' => 'EUR', // Make sure the currency matches the subscription plan it's being applied to
                    'value' => '9.99',
                ],

                /** Add credit to the customer's balance if discount results in a negative amount. */
                'allow_surplus' => false,
            ],
        ],
    ],
];
