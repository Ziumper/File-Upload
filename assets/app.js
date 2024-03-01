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
        file: "#formFile",
        notValidFileElement: "#fileInvalidMessage"
    };

    me.allowedExtensions = [
        "jpg","gif","png","jpeg"
    ]

    me.hideElement = function(selector) {
        $(selector).addClass("hide");
    };

    me.showElement = function(selector) {
        $(selector).removeClass("hide");
    };

    me.getFileExtenison = function(fileName) {
        var extension = fileName.split(".");
        if( extension.length === 1 || ( extension[0] === "" && extension.length === 2 ) ) {
            return "";
        }
        return extension.pop(); 
    }

    me.validateFileInput = function() {
        //custom file validation
        const fileInput = $(me.elements.file)[0];
        if(fileInput.files.length) {
            const file = fileInput.files[0];
            if(file.size > 1024*1024) {
                $(me.elements.notValidFileElement).html("The file is too big!");
                fileInput.setCustomValidity("The file is too big!");
                return false;
            }

            var extension = me.getFileExtenison(file.name);
            if(!me.allowedExtensions.includes(extension)) {
                fileInput.setCustomValidity("Not valid extension");
                $(me.elements.notValidFileElement).html("Not valid extension");
                return false;
            }
        }

        fileInput.setCustomValidity("");
        return true;
    }

    $(me.elements.form).submit(function(event) {
        me.hideElement(me.elements.success);
        me.hideElement(me.elements.error);

        event.preventDefault();

        var form = document.querySelector('.need-validation');

        if (!form.checkValidity()) {
            event.stopPropagation()
            me.validateFileInput();
            form.classList.add('was-validated')
            return;
        }

        if(!me.validateFileInput())
        { 
            event.stopPropagation();
            form.classList.add('was-validated')
            return;
        }
        
        //get the action-url of the form
        var actionurl = event.currentTarget.action;
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