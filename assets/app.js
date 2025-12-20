import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

$.LoadingOverlaySetup({
    background: "rgba(218, 223, 225, 0.8)",
    fontawesome: "bi bi-cup-hot-fill",
    image: "",
    fontawesomeAnimation: "2000ms pulse",
    fontawesomeAutoResize: true,
});

$(document).ajaxStart(function () {
    $.LoadingOverlay("show");
});

$(document).ajaxStop(function () {
    $.LoadingOverlay("hide");
});

$('a[data-loading],button[data-loading]').each(function () {
    $(this).click(function () {
        $.LoadingOverlay("show");
    });
});

function urlParamUpdate(url, param, value, clearParams = false) {
    let newUrl = new URL(url);

    if (clearParams) {
        newUrl.searchParams.forEach((value, key, object) => object.delete(key));
    }

    if (!!value) {
        newUrl.searchParams.set(param, value);
    } else {
        newUrl.searchParams.delete(param);
    }

    return newUrl.href;
}

function redirectUrl(url, param = null, value = null, clearParams = false) {
    let newUrl = url;

    $.LoadingOverlay('show');

    if (!!param) {
        newUrl = urlParamUpdate(url, param, value, clearParams);
    }

    $(location).attr('href', newUrl);
    $(window).attr('location', newUrl);
    $(location).prop('href', newUrl);

    $.LoadingOverlay('hide');
}

function redirectParamsUrl(url, params, clearParams = false) {
    let newUrl = url;
    
    console.log(url,params);

    $.LoadingOverlay('show');

    if (params.length > 0) {
        params.forEach(function (param, index) {
            newUrl = urlParamUpdate(newUrl, param[0], param[1], (0 == index && clearParams) ? true : false);
        });
    } else {
        newUrl = urlParamUpdate(newUrl, null, null, true);
    }

    $(location).attr('href', newUrl);
    $(window).attr('location', newUrl);
    $(location).prop('href', newUrl);

    $.LoadingOverlay('hide');
}

