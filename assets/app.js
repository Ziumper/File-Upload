/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import $ from 'jquery';

$(function() {
    const me = this;
    me.elements = {
        form : "#uploadForm",
        success: '#success',
        error: "#error",
        info: "#info",
        name: "#name",
        surname: "#surname",
        file: "#formFile"
    };

    me.hideElement = function(selector) {
        $(selector).addClass("hide");
    };

    me.showElement = function(selector) {
        $(selector).removeClass("hide");
    };

    $(me.elements.form).submit(function(e) {
        me.hideElement(me.elements.success);
        me.hideElement(me.elements.error);

        //prevent Default functionality
        e.preventDefault();
        
        //get the action-url of the form
        var actionurl = e.currentTarget.action;
        me.showElement(me.elements.info);

        var dataForm = new FormData();
        dataForm.append("name", $(me.elements.name).val());
        dataForm.append("surname", $(me.elements.surname).val());
        dataForm.append("file",$(me.elements.file)[0].files[0]); 
        
        $.ajax({
                url: actionurl,
                type: 'post',
                cache: false,
                async: true,
                data: dataForm,
                processData: false,
                contentType: false,
                success: function() {
                    me.hideElement(me.elements.info);
                    me.showElement(me.elements.success);
                },
                error: function(error) {
                    me.hideElement(me.elements.info);
                    me.showElement(me.elements.error);
                    console.error(error);
                }
        });
    });
});