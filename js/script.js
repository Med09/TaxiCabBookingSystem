jQuery(document).ready(function ($) {
    $("a[rel*=leanModal]").leanModal();
    var responseManager = function () {
        var div;
        var self = this;
        return {
            appendTo: function (d) {
                div = $(d);
                return this;
            },
            success: function (object, response) {


                $(div).text(object.response);
                return true;

            },
            error: function (object, response) {

                $(div).text(object.response);
                return false;
            },
            execute: function (type) {
                return this[type].apply(this, [].slice.call(arguments, 1));
            }
        };
    };

    var ajaxManager = (function () {
        var context;
        return {
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
            data: {},
            setContext: function (cont) {
                context = cont;
                return this;
            },
            execute: function (obj) {

                var self = this;
                self.data = obj;

                return $.ajax({
                    data: self.data,
                    type: self.type,
                    url: self.url,
                    dataType: self.dataType,
                    beforeSend: self.beforeSend,
                    complete: self.complete

                });
            },
            success: function (response) {


            },
            fail: function (response) {


            },
            beforeSend: function () {
                if (context != undefined && context != "") {
                    context.append('<div class="wait">Please Wait</div>');
                }


            },
            complete: function () {
                if (context != undefined && context != "") {
                    context.find('.wait').remove();
                }
               

            }

        };


    }());


    var formManager = function (form) {

        var isValid = true;
        var form = form;
        return {
            formObject: {},
            isValid: true,
            inputs: [],
            inputCount: 0,
            config: {
                inputErrorClass: 'alert',
                inputEmailName: 'email',
                inputPhoneName: 'phone',
                ignoreFields : ['flight_name','flight_number']

            },
            serializeInputs: '',
            getInputs: function () {
                return form.find('input,select');

            },
            isEmail: function (email) {
                var re = /\S+@\S+\.\S+/;
                return re.test(email);

            },
            isPhone: function (phone) {
                if (phone.length > 5) {
                    return true;
                } else {
                    return false;
                }
            },
            getInputCount: function () {
                this.inputs = this.getInputs();
                this.inputCount = this.inputs.length;
                return inputCount;
            },
            getSerializedInputs: function () {
                this.serializedInputs = form.serialize();
                return this.serializedInputs;
            },

            getForm: function () {
                return form;
            },
            setForm: function (form) {
                form = form;
                return this;
            },
            isValid: function () {
                return isValid;

            },
            getFormInputsInObject: function () {
                var self = this;
                var inputs = this.getInputs();
                $(inputs).each(function (i, v) {
                    var input = $(this);
                    var name = input.attr('name');
                    var value = $.trim(input.val());
                    self.formObject[name] = value;
                });
                return this.formObject;
            },
            validateInputs: function () {
                var self = this;
                var inputs = self.getInputs();
                $(inputs).each(function (i, v) {
                    var input = $(this);
                    var name = input.attr('name');
                    var value = $.trim(input.val());
                    if (value === "" && $.inArray(name,self.config.ignoreFields) == -1) {
                        input.addClass(self.config.inputErrorClass);
                    } else {
                        input.removeClass(self.config.inputErrorClass);
                    }
                    if (name == self.config.inputEmailName) {
                        if (self.isEmail(value) === false) {
                            input.addClass(self.config.inputErrorClass);

                        }

                    }
                    if (name == self.config.inputPhoneName) {

                        if (self.isPhone(value) === false) {
                            input.addClass(self.config.inputErrorClass);
                        }

                    }




                });
                
                if (form.find('.' + self.config.inputErrorClass).length > 0) {
                    isValid = false;
                } else {
                    isValid = true;
                }
                return self;

            }
        };
    };



    $("#launchPrepay").click(function () {
        getEstimatedFare($("input[name='pickup_location']").val(), $("input[name='dropoff_location']").val(), function (amt) {

            $("#amount").val(amt);


        });


        $("#showPrepay").click();



    });




    $(".submit-prepay").click(function () {
        var _this = $(this);
        _this.hide();
        var _form = _this.parents('form');
        var _obj = {};
        var form = new formManager(_form);
        if (form.validateInputs().isValid() === false) {
            console.log("missing fields");
            alert('missing fields');
            _this.show();

            return false;

        }



        var ajax = ajaxManager.setContext(form.getForm()).execute({
            data: form.getFormInputsInObject(),
            action: 'prepay'
        });
        ajax.always(function(results) {
        _this.show();	
        })
        ajax.done(function (results) {
        });
        ajax.success(function (results) {
            var results = new responseManager().appendTo(".response pre").execute(results.type, {
                response: decodeURIComponent(results.response)
            });
            //handle success
            if (results) {


            }
            //handle faile
            if (results === false) {



            }

        });
        ajax.fail(function (response) {

            console.log(response);
        });
    });

    $('.submit-booking').click(function () {
        var _this = $(this);
        _this.hide();
        var _form_1 = _this.parents('form');
        var _form_2 = $("#bookingconfirm");


        var form_1 = new formManager(_form_1);
        var form_2 = new formManager(_form_2);
        var valid_1 = form_1.validateInputs().isValid();
        var valid_2 = form_2.validateInputs().isValid();
        if (valid_1 === false || valid_2 === false) {
            _this.show();
            alert('missing fields');
            return false;
        }
        var obj = {};
        $.extend(obj, form_1.getFormInputsInObject(), form_2.getFormInputsInObject());

        var ajax = ajaxManager.setContext(form_1.getForm()).execute({
            data: obj,
            action: obj.action
        });
        ajax.done(function () {
            _this.show();
        });
        ajax.success(function (results) {
            var response = new responseManager().appendTo(".response pre").execute(results.type, {
                response: decodeURIComponent(results.response)
            });
            ///handle success response
            if (response === true) {
                if (obj.payment_type === 'prepay') {
                    form_1.getForm().parents('.booking-modal').hide();

                    $("#showPrepay").click();

                    getEstimatedFare(obj.pickup_location, obj.dropoff_location, function (amt) {

                        $("#amount").val(amt);


                    })




                }


            }
            ///handle fail response
            if (response === false) {




            }




        });
        ajax.fail(function (response) {
            console.log(response);

        });




    });




    $("#facebookG").hide();

   

    function getEstimatedFare(pickup_location, dropoff_location, cb) {
        console.log(pickup_location + " " + dropoff_location)
        var directionsService = new google.maps.DirectionsService();
        var request = {
            origin: pickup_location,
            destination: dropoff_location,
            travelMode: google.maps.DirectionsTravelMode.DRIVING
        };

        directionsService.route(request, function (response, status) {
            if (status === google.maps.DirectionsStatus.OK) {
                var rate = window.booking_rate_per_mile;
                if (rate === undefined || isNaN(rate)) {
                    var rate = 0;
                }
                var distance = Math.floor((((response.routes[0].legs[0].distance.value) / 1000) / 1.609344));
                amt = Math.floor(((distance - 1.0) * eval(rate)));


            }
            cb(amt);
        });



    }




});



jQuery(document).ready(function ($) {

 $('.datepicker').datetimepicker({
        timeFormat: "hh:mm tt",
        minDate: 0,
        stepMinute:15,
        ampm: true,
                inline: false,
                showTime:false,
                minute:0,
        onSelect : function()
        {
        	
        }
    });



    // var input = document.getElementsByName("pickup_location")[0];




    $('#plugin_input2').click(function () {
        var _root = $(this);
        var send_attachment_bkp = wp.media.editor.send.attachment;
        var button = $(this);

        wp.media.editor.send.attachment = function (props, attachment) {

            _root.val(attachment.url);

            $(button).prev().prev().attr('src', attachment.url);
            $(button).prev().val(attachment.url);

            wp.media.editor.send.attachment = send_attachment_bkp;
        };

        wp.media.editor.open(button);

        return false;


    });




    /*
var geocoder;
var map;
var query = 'florida,usa';
*/

    function initialize() {
        $("input.booking-places").geocomplete();

        if (document.getElementById('map') == null) {
            console.log("false");
            return false;
        }
        geocoder = new google.maps.Geocoder();
        var mapOptions = {
            center: new google.maps.LatLng(37.7749295, -122.4194155),
            zoom: 3,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        if (document.getElementById('map')) {
            map = new google.maps.Map(document.getElementById('map'), mapOptions);
            codeAddresss();

        }




    }

    function codeAddresss() {

        var _this = this;
        _this.directionsDisplay = new google.maps.DirectionsRenderer();
        _this.directionsService = new google.maps.DirectionsService();
        _this.gc = new google.maps.Geocoder();
        _this.map = map;
        var start = document.getElementsByName('pickup_location')[0].value;
        var end = document.getElementsByName('dropoff_location')[0].value;
        if (start === "" || end === "") {

            return false;
        }
        var request = {
            origin: start,
            destination: end,
            travelMode: google.maps.DirectionsTravelMode.DRIVING
        };
        var root = _this;
        _this.directionsService.route(request, function (response, status) {
            if (status === google.maps.DirectionsStatus.OK) {
                root.directionsDisplay.setMap(_this.map);
                root.directionsDisplay.setDirections(response);
                google.maps.event.trigger(_this.map, 'resize');



            }
        });



    }


    if (typeof google === 'object' && typeof google.maps === 'object') {
        initialize();

    }
});