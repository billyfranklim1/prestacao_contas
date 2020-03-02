/*=========================================================================================
    File Name: donut.js
    Description: Morris donut chart
    ----------------------------------------------------------------------------------------
    Item Name: Stack - Responsive Admin Theme
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Donut chart
// ------------------------------
$(window).on("load", function(){

    Morris.Donut({
        element: 'donut-chart',
        data: [{
            label: "Usado",
            value: 80
        }, {
            label: "Disponível",
            value: 20
        },
        ],
        resize: true,
        // colors: ['#00A5A8', '#FF7D4D', '#FF4558','#626E82']
        colors: ['#FF4558', '#a7ceff']

    });
});
