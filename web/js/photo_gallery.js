//Reference http://www.jssor.com/development/slider-with-caption.html
//Reference http://www.jssor.com/development/reference-ui-definition.html#captiondefinition
//Reference http://www.jssor.com/development/tool-caption-transition-viewer.html

jQuery(document).ready(function ($) {
    var _CaptionTransitions = [];
    _CaptionTransitions["L"] = { $Duration: 800, $FlyDirection: 1, $Easing: $JssorEasing$.$EaseInCubic };
    _CaptionTransitions["R"] = { $Duration: 800, $FlyDirection: 2, $Easing: $JssorEasing$.$EaseInCubic };
    _CaptionTransitions["T"] = { $Duration: 800, $FlyDirection: 4, $Easing: $JssorEasing$.$EaseInCubic };
    _CaptionTransitions["B"] = { $Duration: 800, $FlyDirection: 8, $Easing: $JssorEasing$.$EaseInCubic };
    _CaptionTransitions["TL"] = { $Duration: 800, $FlyDirection: 5, $Easing: $JssorEasing$.$EaseInCubic };
    _CaptionTransitions["TR"] = { $Duration: 800, $FlyDirection: 6, $Easing: $JssorEasing$.$EaseInCubic };
    _CaptionTransitions["BL"] = { $Duration: 800, $FlyDirection: 9, $Easing: $JssorEasing$.$EaseInCubic };
    _CaptionTransitions["BR"] = { $Duration: 800, $FlyDirection: 10, $Easing: $JssorEasing$.$EaseInCubic };

    _CaptionTransitions["WAVE|L"] = { $Duration: 1500, $FlyDirection: 5, $Easing: { $Left: $JssorEasing$.$EaseLinear, $Top: $JssorEasing$.$EaseOutWave }, $ScaleVertical: 0.4, $Round: { $Top: 2.5} };
    _CaptionTransitions["MCLIP|B"] = { $Duration: 600, $Clip: 8, $Move: true, $Easing: $JssorEasing$.$EaseOutExpo };

    var options = {
        $FillMode: 1,
        $AutoPlay: false,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
        $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
        $CaptionSliderOptions: {                            //[Optional] Options which specifies how to animate caption
            $Class: $JssorCaptionSlider$,                   //[Required] Class to create instance to animate caption
            $CaptionTransitions: _CaptionTransitions,       //[Required] An array of caption transitions to play caption, see caption transition section at jssor slideshow transition builder
            $PlayInMode: 3,                                 //[Optional] 0 None (no play), 1 Chain (goes after main slide), 3 Chain Flatten (goes after main slide and flatten all caption animations), default value is 1
            $PlayOutMode: 3                                 //[Optional] 0 None (no play), 1 Chain (goes before main slide), 3 Chain Flatten (goes before main slide and flatten all caption animations), default value is 1
        },
        $ArrowNavigatorOptions: {                       //[Optional] Options to specify and enable arrow navigator or not
            $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
            $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
            $AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
            $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
        }
    };

    var jssor_slider1 = new $JssorSlider$("photo_gallery", options);
   
    //responsive code begin
    //you can remove responsive code if you don't want the slider scales while window resizes
    function ScaleSlider() {

        //reserve blank width for margin+padding: margin+padding-left (10) + margin+padding-right (10)
        var paddingWidth = 20;

        //minimum width should reserve for text
        var minReserveWidth = 225;

        var parentElement = jssor_slider1.$Elmt.parentNode;

        //evaluate parent container width
        var parentWidth = parentElement.clientWidth;

        if (parentWidth) {

            //exclude blank width
            var availableWidth = parentWidth - paddingWidth;

            //calculate slider width as 70% of available width
            var sliderWidth = availableWidth * 0.7;

            //slider width is maximum 600
            sliderWidth = Math.min(sliderWidth, 900);

            //slider width is minimum 200
            sliderWidth = Math.max(sliderWidth, 200);
            var clearFix = "none";

            //evaluate free width for text, if the width is less than minReserveWidth then fill parent container
            if (availableWidth - sliderWidth < minReserveWidth) {

                //set slider width to available width
                sliderWidth = availableWidth;

                //slider width is minimum 200
                sliderWidth = Math.max(sliderWidth, 200);

                clearFix = "both";
            }

            //clear fix for safari 3.1, chrome 3
            $('#clearFixDiv').css('clear', clearFix);

            jssor_slider1.$SetScaleWidth(sliderWidth);
        }
        else
            window.setTimeout(ScaleSlider, 30);
    }

    ScaleSlider();

    if (!navigator.userAgent.match(/(iPhone|iPod|iPad|BlackBerry|IEMobile)/)) {
        $(window).bind('resize', ScaleSlider);
    }
});