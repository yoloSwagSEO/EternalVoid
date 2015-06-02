$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    bootbox.setDefaults({
        locale: "de",
        show: true,
        backdrop: true,
        closeButton: false,
        animate: true,
        className: "my-modal"
    });

    var $interval               = 0;
    var $gamespeed              = Number($("#gamespeed").data("speed"));

    var $aluminium_element      = $("#aluminium");
    var $aluminium_amount       = Number($aluminium_element.data("amount"));
    var $aluminium_production   = Number($aluminium_element.data("production"));

    var $titan_element          = $("#titan");
    var $titan_amount           = Number($titan_element.data("amount"));
    var $titan_production       = Number($titan_element.data("production"));

    var $silizium_element       = $("#silizium");
    var $silizium_amount        = Number($silizium_element.data("amount"));
    var $silizium_production    = Number($silizium_element.data("production"));

    var $arsen_element          = $("#arsen");
    var $arsen_amount           = Number($arsen_element.data("amount"));
    var $arsen_production       = Number($arsen_element.data("production"));

    var $wasserstoff_element    = $("#wasserstoff");
    var $wasserstoff_amount     = Number($wasserstoff_element.data("amount"));
    var $wasserstoff_production = Number($wasserstoff_element.data("production"));

    var $antimaterie_element    = $("#antimaterie");
    var $antimaterie_amount     = Number($antimaterie_element.data("amount"));
    var $antimaterie_production = Number($antimaterie_element.data("production"));

    var $lager_element          = $("#lager");
    //var $lager_int              = Number($lager_element.data("int"));
    var $lager_storage          = Number($lager_element.data("storage"));

    var $speziallager_element   = $("#speziallager");
    //var $speziallager_int       = Number($speziallager_element.data("int"));
    var $speziallager_storage   = Number($speziallager_element.data("storage"));

    var $tanks_element          = $("#tanks");
    //var $tanks_int              = Number($tanks_element.data("int"));
    var $tanks_storage          = Number($tanks_element.data("storage"));

    var $servertime             = Number($("#time").data("servertime"));
    var $lastupdate             = Number($("#time").data("lastupdate"));

    $.fn.nf = function(number,length,decimal_separator,thousands_separator) {
        number = Math.round(number * Math.pow(10, length)) / Math.pow(10, length);

        var arr_int=String(number).split(".");
        if(!arr_int[0]) arr_int[0] = "0";
        if(!arr_int[1]) arr_int[1] = "";
        if(arr_int[1].length < length) {
            var decimal = arr_int[1];
            for(var i = arr_int[1].length + 1;i <= length; i++) {
                decimal += "0";
            }

            arr_int[1] = decimal;
        }

        if(thousands_separator != "" && arr_int[0].length > 3) {
            var thousands = arr_int[0];
            arr_int[0] = "";
            for(var j = 3;j < thousands.length;j += 3) {
                var part = thousands.slice(thousands.length - j, thousands.length - j + 3);
                arr_int[0] = String(thousands_separator + part + arr_int[0]);
            }

            var str_first = thousands.substr(0, (thousands.length % 3 == 0) ? 3 : (thousands.length % 3));
            arr_int[0] = str_first+arr_int[0];
        }

        return arr_int[0] + decimal_separator + arr_int[1];
    };

    $.fn.htime = function($sec) {

        var $sec_rest;
        var $weeks;
        var $days;
        var $hours;
        var $mins;
        var $time;

        // Wochen
        $sec_rest = $sec % 604800;
        $weeks    = ($sec - $sec_rest) / 604800;
        $sec      = $sec_rest;

        // Tage
        $sec_rest = $sec % 86400;
        $days	  = ($sec - $sec_rest) / 86400;
        $sec	  = $sec_rest;

        // Stunden
        $sec_rest = $sec % 3600;
        $hours	  = ($sec - $sec_rest) / 3600;
        $sec	  = $sec_rest;

        // Minuten & Sekunden
        $sec_rest = $sec % 60;
        $mins	  = ($sec - $sec_rest) / 60;
        $sec	  = $sec_rest;

        $weeks = $weeks > 0 ? ($weeks > 1 ? $weeks+'w ' : $weeks+'w ') : '';
        $days  = $days > 0 ? ($days > 1 ? $days+'d ' : $days+'d ') : '';
        $hours = $hours < 10 ? "0"+$hours : $hours;
        $mins  = $mins < 10 ? "0"+$mins : $mins;
        $sec   = $sec < 10 ? "0"+$sec : $sec;
        $time  = $weeks+$days+$hours+':'+$mins+':'+$sec;

        return $time;
    };

    $.fn.isoDate = function($seconds) {
        var $date    = new Date(($servertime + $interval + $seconds) * 1000);
        var $day     = $date.getDate();
        var $month   = $date.getMonth()+1;
        var $year    = $date.getFullYear();
        var $hours   = $date.getHours();
        var $mins    = $date.getMinutes();
        var $secs    = $date.getSeconds();
        var $return;

        $return  = $day < 10 ? '0'+$day : $day;
        $return += '.'+($month < 10 ? '0'+$month : $month);
        $return += '.'+$year+' - ';
        $return += $hours < 10 ? '0'+$hours : $hours;
        $return += ':'+($mins < 10 ? '0'+$mins : $mins);
        $return += ':'+($secs < 10 ? '0'+$secs : $secs);

        return $return;
    };

    $.fn.countResources = function() {

        // Mengen
        var $aluminium   = ($aluminium_amount + ($interval * $aluminium_production));
        var $titan       = ($titan_amount + ($interval * $titan_production));
        var $silizium    = ($silizium_amount + ($interval * $silizium_production));
        var $arsen       = ($arsen_amount + ($interval * $arsen_production));
        var $wasserstoff = ($wasserstoff_amount + ($interval * $wasserstoff_production));
        var $antimaterie = ($antimaterie_amount + ($interval * $antimaterie_production));

        // Lagerfuellstand
        var $lager        = (($aluminium + $titan + $silizium) / $lager_storage) * 100;
        var $speziallager = (($arsen + $wasserstoff) / $speziallager_storage) * 100;
        var $tanks        = ($antimaterie / $tanks_storage) * 100;

        if($lager < 100) {
            $aluminium_element.html($(this).nf($aluminium,0,'','.'));
            $titan_element.html($(this).nf($titan,0,'','.'));
            $silizium_element.html($(this).nf($silizium,0,'','.'));
            $lager_element.html($(this).nf($lager,2,',','')+'%');

            if($("#resources").length > 0) {
                $("#res-aluminium").html($(this).nf($aluminium,0,'','.'));
                $("#res-titan").html($(this).nf($titan,0,'','.'));
                $("#res-silizium").html($(this).nf($silizium,0,'','.'));
                $("#lager-resources").html($(this).nf(($aluminium+$titan+$silizium),0,'','.'));
                $("#lager-int").html($(this).nf($lager,2,',','')+'%');
            }

        }

        if($speziallager < 100) {
            $arsen_element.html($(this).nf($arsen,0,'','.'));
            $wasserstoff_element.html($(this).nf($wasserstoff,0,'','.'));
            $speziallager_element.html($(this).nf($speziallager,2,',','')+'%');

            if($("#resources").length > 0) {
                $("#res-arsen").html($(this).nf($arsen,0,'','.'));
                $("#res-wasserstoff").html($(this).nf($wasserstoff,0,'','.'));
                $("#speziallager-resources").html($(this).nf(($arsen+$wasserstoff),0,'','.'));
                $("#spezaillager-int").html($(this).nf($speziallager,2,',','')+'%');
            }
        }

        if($tanks < 100) {
            $antimaterie_element.html($(this).nf($antimaterie,0,'','.'));
            $tanks_element.html($(this).nf($tanks,2,',','')+'%');

            if($("#resources").length > 0) {
                $("#res-antimaterie").html($(this).nf($antimaterie,0,'','.'));
                $("#tanks-resources").html($(this).nf($antimaterie,0,'','.'));
                $("#tanks-int").html($(this).nf($tanks,2,',','')+'%');
            }
        }

        $interval++;
    };

    $.fn.resprod = function() {
        var $seconds  = 0;
        var $amount   = Number($("#resprod-amount").val());
        var $resource = $("#resprod-resource").val();
        var $useres   = $("#resprod-useres").is(':checked');

        switch($resource) {
            case 'aluminium':
                $amount  = $useres ? $amount - $aluminium_amount : $amount;
                $seconds = Math.floor($amount / $aluminium_production);
                break;
            case 'titan':
                $amount  = $useres ? $amount - $titan_amount : $amount;
                $seconds = Math.floor($amount / $titan_production);
                break;
            case 'silizium':
                $amount  = $useres ? $amount - $silizium_amount : $amount;
                $seconds = Math.floor($amount / $silizium_production);
                break;
            case 'arsen':
                $amount  = $useres ? $amount - $arsen_amount : $amount;
                $seconds = $arsen_production > 0 ? Math.floor($amount / $arsen_production) : 0;
                break;
            case 'wasserstoff':
                $amount  = $useres ? $amount - $wasserstoff_amount : $amount;
                $seconds = $wasserstoff_production > 0 ? Math.floor($amount / $wasserstoff_production) : 0;
                break;
            case 'antimaterie':
                $amount  = $useres ? $amount - $antimaterie_amount : $amount;
                $seconds = $antimaterie_production > 0 ? Math.floor($amount / $antimaterie_production) : 0;
                break;
        }

        $("#resprod-htime").val($seconds > 0 ? $(this).htime($seconds) : ($seconds < 0 ? 'Sofort verfügbar' : '-'));
        $("#resprod-date").val($seconds > 0 ? $(this).isoDate($seconds) : ($seconds < 0 ? 'Sofort verfügbar' : '-'));
    };

    $.fn.restime = function() {
        var $hours   = Number($("#restime-hours").val());
        var $resource = $("#restime-resource").val();
        var $seconds = $hours * 3600;
        var $useres  = $("#restime-useres").is(':checked');
        var $prod    = 0;

        switch($resource) {
            case 'aluminium':   $prod = ($seconds * $aluminium_production) + ($useres ? $aluminium_amount : 0); break;
            case 'titan':       $prod = ($seconds * $titan_production) + ($useres ? $titan_amount : 0); break;
            case 'silizium':    $prod = ($seconds * $silizium_production) + ($useres ? $silizium_amount : 0); break;
            case 'arsen':       $prod = ($seconds * $arsen_production) + ($useres ? $arsen_amount : 0); break;
            case 'wasserstoff':	$prod = ($seconds * $wasserstoff_production) + ($useres ? $wasserstoff_amount : 0); break;
            case 'antimaterie': $prod = ($seconds * $antimaterie_production) + ($useres ? $antimaterie_amount : 0); break;
        }

        $("#restime-prod").val($prod > 0 ? $(this).nf($prod,0,'','.') : '-');
        $("#restime-date").val($seconds > 0 ? $(this).isoDate($seconds) : '-');
    };

    $.fn.desintegrate = function() {
        var $type      = $("#resdesint-resource").val();
        var $type_text = $("#resdesint-resource option:selected").text();
        var $amount    = Number($("#resdesint-amount").val());
        if($amount > 0) {
            bootbox.confirm({
                title:"Willst du wirklich "+$(this).nf($amount,0,'','.')+" "+$type_text+" vernichten?",
                message:'&nbsp;',
                callback:function($result) {
                    if($result) {
                        $.ajax({
                            url:'/resources/desintegrate/'+$type+'/'+$amount
                        }).done(function($return) {
                            switch($type) {
                                case 'aluminium': $aluminium_amount -= $amount; break;
                                case 'titan': $titan_amount -= $amount; break;
                                case 'silizium': $silizium_amount -= $amount; break;
                                case 'arsen': $arsen_amount -= $amount; break;
                                case 'wasserstoff': $wasserstoff_amount -= $amount; break;
                                case 'antimatereie': $antimaterie_amount -= $amount; break;
                            }

                            bootbox.alert({
                                title:$(this).nf($return,0,'','.')+" "+$type_text+" wurden vernichtet.",
                                message:'&nbsp;'
                            });
                        });
                    }
                }
            });
        }
    };

    $.fn.percentage_cnt = function() {
        if($(".progress").length > 0) {
            var $timespan = ($servertime + $interval) - $servertime;

            $(".progress").each(function() {
                if($(this).data("time") != undefined && $(this).data("remaining") != undefined) {
                    var $time      = $(this).data("time");
                    var $remaining = $(this).data("remaining") - $timespan;


                    var $percent   = Math.round((100 - ($remaining / $time) * 100)*100)/100;
                    if($percent < 100) {
                        $(this).children(".progress-bar").html($percent+"%");
                        $(this).children(".progress-bar").css("width",$percent+"%");
                    } else {
                        setTimeout(function() {
                            window.location.reload();
                        },1000);
                    }
                }
            });
        }
    }

    $.fn.deleteConfirm = function($element) {
        $href    = $element.attr("href");
        $message = $element.data("message");
        bootbox.confirm({
            title:$message,
            message:'&nbsp;',
            callback:function($result) {
                if($result) document.location.href = $href;
            }
        });
    };

    // Message Receivers autocomplete
    $("#receiver").bind("keydown", function($event) {
        if($event.keyCode === $.ui.keyCode.TAB && $(this).autocomplete("instance").menu.active ) {
            $event.preventDefault();
        }
    }).autocomplete({
        source: function($request, $response ) {
            $.getJSON( "/json/receivers", {
                term: $request.term.split(/,\s*/).pop()
            }, $response);
        },
        search: function() {
            var $term = this.value.split(/,\s*/).pop();
            if($term.length < 1 ) {
                return false;
            }
        },
        focus: function() {
            return false;
        },
        select: function($event, $ui ) {
            var $terms = this.value.split(/,\s*/);
            $terms.pop();
            $terms.push($ui.item.value);
            $terms.push('');
            this.value = $terms.join(", ");
            return false;
        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });

    // Confirmation box for deleting items (Messages, Notes, etc. pp)
    $(".dellink").on('click',function($e) { $(this).deleteConfirm($(this)); $e.preventDefault(); });

    // Edit Link for Alliance Messages
    $(".editlink").on('click', function($e) {
        $id = $(this).data("messageid");
        $(".sceditor").val(($("#message-"+$id).text()));
        $("#messageform").attr("action","/alliance/message-edit/"+$id);

        $e.preventDefault();
    });

    // If there are popovers, trigger them
    $(".btn-group a").popover({
        trigger  : 'hover',
        container: 'body'
    });

    // IF there are tooltips, trigger them
    $(".tt").tooltip({
        trigger   : 'hover',
        container : 'body',
        html      : true,
        placement : 'top auto'
    });

    // Activate ScrollToFixed top Navigation
    $("#topbar").scrollToFixed();

    // Trigger resources per production
    $("#resprod-amount").keyup(function() { $(this).resprod() });
    $("#resprod-resource").change(function() { $(this).resprod() });
    $("#resprod-useres").click(function() { $(this).resprod() });

    // Trigger resouces by time
    $("#restime-hours").keyup(function() { $(this).restime() });
    $("#restime-resource").change(function() { $(this).restime() });
    $("#restime-useres").click(function() { $(this).restime() });

    // Desintegrator
    $("#desintegrate").click(function() { $(this).desintegrate() });

    // Initiate resource counter
    window.setInterval("$(this).countResources()",1000);
    window.setInterval("$(this).percentage_cnt()",1000);

    // If there are countdowns on a page, start them
    if($(".countdown").length > 0) {
        $(".countdown").each(function() {
            $("#"+$(this).attr("id")).countdown({ until:+$(this).data("until"),compact: true});
        });
    }

    $(document).on('keyup', function($e) {
        if($("#galaxyform").length > 0) {
            if($e.keyCode == 37 || $e.keyCode == 39) {
                var $form   = $("#galaxyform");
                var $galaxy = Number($("#galaxy").val());
                var $system = Number($("#system").val());

                if($e.keyCode == 37) $system--;
                if($e.keyCode == 39) $system++;

                if($system > 255) {
                    $galaxy++
                    $system = 1;
                }

                if($system < 1) {
                    $galaxy--
                    $system = 255;
                }

                $galaxy = $galaxy > 4 ? 1 : ($galaxy < 1 ? 4 : $galaxy);

                $("#galaxy").val($galaxy);
                $("#system").val($system);

                $form.submit();
            }
        }
    });

    // If there are any sceditor containers, equip them with sceditor
    if($(".sceditor").length > 0) {
        $(".sceditor").sceditor({
            plugins: "bbcode",
            style: "/css/sceditor.default-theme.css",
            toolbar: "bold,italic,underline,strike,subscript,superscript|left,right,center,justify,bulletlist,orderedlist|font,size,color|emoticon,code,quote,image,link,unlink,youtube|removeformat,source",
            width : "98%"
        });

        $("#preview").on('click', function($e) { $("#preview-modal .modal-body").html($(".sceditor").sceditor('instance').getBody().html()); });
    }
});