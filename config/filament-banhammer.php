<?php

return [

    /*
     * The name of the resource which the plugin should use.
     */
    'resource' => \Gerenuk\FilamentBanhammer\Resources\BanhammerResource::class,

    'navigation_group' => 'Admin'

    /*
     * Whether an export action should be included on the resource.
     */
    'show_export' => true,

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
            'label' => 'ban',

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
            'notifications' => [

                /*
                 * Whether a notification should be shown for the ban action.
                 */
                'show' => true,

                /*
                 * Success options for the ban action notifications.
                 */
                'success' => [

                    /*
                    * The title of the success notification for the ban action.
                    */
                    'title' => 'Banned',

                ],

                /*
                 * Error options for the ban action notifications.
                 */
                'error' => [

                    /*
                    * The title of the error notification for the ban action.
                    */
                    'title' => 'Failed',

                ],

            ],

        ],

        /*
         * Options for the edit ban action.
         */
        'edit_ban' => [

            /*
             * The title of the edit ban action.
             */
            'label' => 'edit ban',

            /*
             * The colour of the edit ban action.
             */
            'colour' => 'warning',

            /*
             * The symbol of the edit ban action.
             */
            'icon' => 'heroicon-o-pencil-square',

            /*
             * Whether confirming is required when using the edit ban action.
             */
            'require_confirmation' => true,

            /*
             * Notification options for the edit ban action.
             */
            'notifications' => [

                /*
                 * Whether a notification should be shown for the edit ban action.
                 */
                'show' => true,

                /*
                 * Success options for the edit ban action notifications.
                 */
                'success' => [

                    /*
                    * The title of the success notification for the edit ban action.
                    */
                    'title' => 'Saved',

                ],

                /*
                 * Error options for the edit ban action notifications.
                 */
                'error' => [

                    /*
                    * The title of the error notification for the edit ban action.
                    */
                    'title' => 'Failed',

                ],

            ],

        ],

        /*
         * Options for the unban action.
         */
        'unban' => [

            /*
             * The title of the unban action.
             */
            'label' => 'unban',

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
            'notifications' => [

                /*
                 * Whether a notification should be shown for the unban action.
                 */
                'show' => true,

                /*
                 * Success options for the unban action notifications.
                 */
                'success' => [

                    /*
                    * The title of the success notification for the unban action.
                    */
                    'title' => 'Unbanned',

                ],

                /*
                 * Error options for the unban action notifications.
                 */
                'error' => [

                    /*
                    * The title of the error notification for the unban action.
                    */
                    'title' => 'Failed',

                ],

            ],

        ],

        /*
         * Options for the ban bulk action.
         */
        'ban_bulk' => [

            /*
             * The title of the ban bulk action.
             */
            'label' => 'ban',

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
            'notifications' => [

                /*
                 * Whether a notification should be shown for the ban bulk action.
                 */
                'show' => true,

                /*
                 * Success options for the ban bulk action notifications.
                 */
                'success' => [

                    /*
                    * The title of the success notification for the ban bulk action.
                    */
                    'title' => 'Banned',

                ],

                /*
                 * Error options for the ban bulk action notifications.
                 */
                'error' => [

                    /*
                    * The title of the error notification for the ban bulk action.
                    */
                    'title' => 'Failures',

                ],

            ],

        ],

        /*
         * Options for the edit ban bulk action.
         */
        'edit_ban_bulk' => [

            /*
             * The title of the edit ban bulk action.
             */
            'label' => 'edit ban',

            /*
             * The colour of the edit ban bulk action.
             */
            'colour' => 'warning',

            /*
             * The symbol of the edit ban bulk action.
             */
            'icon' => 'heroicon-o-pencil-square',

            /*
             * Whether confirming is required when using the edit ban bulk action.
             */
            'require_confirmation' => true,

            /*
             * Notification options for the edit ban bulk action.
             */
            'notifications' => [

                /*
                 * Whether a notification should be shown for the edit ban bulk action.
                 */
                'show' => true,

                /*
                 * Success options for the edit ban bulk action notifications.
                 */
                'success' => [

                    /*
                    * The title of the success notification for the edit ban bulk action.
                    */
                    'title' => 'Saved',

                ],

                /*
                 * Error options for the edit ban bulk action notifications.
                 */
                'error' => [

                    /*
                    * The title of the error notification for the edit ban bulk action.
                    */
                    'title' => 'Failures',

                ],

            ],

        ],

        /*
         * Options for the unban bulk action.
         */
        'unban_bulk' => [

            /*
             * The title of the unban bulk action.
             */
            'label' => 'unban',

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
            'notifications' => [

                /*
                 * Whether a notification should be shown for the unban bulk action.
                 */
                'show' => true,

                /*
                 * Success options for the unban bulk action notifications.
                 */
                'success' => [

                    /*
                    * The title of the success notification for the unban bulk action.
                    */
                    'title' => 'Unbanned',

                ],

                /*
                 * Error options for the unban bulk action notifications.
                 */
                'error' => [

                    /*
                    * The title of the error notification for the unban bulk action.
                    */
                    'title' => 'Failures',

                ],

            ],

        ],

    ],

];
