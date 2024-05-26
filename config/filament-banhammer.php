<?php

return [

    /*
     * The name of the resource which the plugin should use.
     */
    'resource' => \Gerenuk\FilamentBanhammer\Resources\BanhammerResource::class,

    /*
     * Whether a banner should be shown on resources which have been banned.
     */
    'show_banner' => true,

    /*
     * Options for the actions.
     */
    'actions' => [

        /*
         * Options for the ban action.
         */
        'ban' => [

            /*
             * The title of the ban action.
             */
            'title' => 'ban',

            /*
             * The colour of the ban action.
             */
            'colour' => 'warning',

            /*
             * The symbol of the ban action.
             */
            'icon' => 'heroicon-o-no-symbol',

            /*
             * Whether confirming is required when using the ban action.
             */
            'require_confirmation' => true,

            /*
             * Notification options for the ban action.
             */
            'notification' => [

                /*
                 * Whether a notification should be shown for the ban action.
                 */
                'show' => true,

                /*
                 * The title of the notification for the ban action.
                 */
                'title' => 'Banned',

            ],

        ],

        /*
         * Options for the unban action.
         */
        'unban' => [

            /*
             * The title of the unban action.
             */
            'title' => 'unban',

            /*
             * The colour of the unban action.
             */
            'colour' => 'warning',

            /*
             * The symbol of the unban action.
             */
            'icon' => 'heroicon-o-no-symbol',

            /*
             * Whether confirming is required when using the unban action.
             */
            'require_confirmation' => true,

            /*
             * Notification options for the unban action.
             */
            'notification' => [

                /*
                 * Whether a notification should be shown for the unban action.
                 */
                'show' => true,

                /*
                 * The title of the notification for the unban action.
                 */
                'title' => 'Unbanned',

            ],

        ],

        /*
         * Options for the ban bulk action.
         */
        'ban_bulk' => [

            /*
             * The title of the ban bulk action.
             */
            'title' => 'ban',

            /*
             * The colour of the ban bulk action.
             */
            'colour' => 'warning',

            /*
             * The symbol of the ban bulk action.
             */
            'icon' => 'heroicon-o-no-symbol',

            /*
             * Whether confirming is required when using the ban bulk action.
             */
            'require_confirmation' => true,

            /*
             * Notification options for the ban bulk action.
             */
            'notification' => [

                /*
                 * Whether a notification should be shown for the ban bulk action.
                 */
                'show' => true,

                /*
                 * The title of the notification for the ban bulk action.
                 */
                'title' => 'Banned',

            ],

        ],

        /*
         * Options for the unban bulk action.
         */
        'unban_bulk' => [

            /*
             * The title of the unban bulk action.
             */
            'title' => 'unban',

            /*
             * The colour of the unban bulk action.
             */
            'colour' => 'warning',

            /*
             * The symbol of the unban bulk action.
             */
            'icon' => 'heroicon-o-no-symbol',

            /*
             * Whether confirming is required when using the unban bulk action.
             */
            'require_confirmation' => true,

            /*
             * Notification options for the unban bulk action.
             */
            'notification' => [

                /*
                 * Whether a notification should be shown for the unban bulk action.
                 */
                'show' => true,

                /*
                 * The title of the notification for the unban bulk action.
                 */
                'title' => 'Unbanned',

            ],

        ],

    ],

];
