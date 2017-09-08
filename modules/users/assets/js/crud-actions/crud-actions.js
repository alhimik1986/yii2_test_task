var CrudActions = function(selectors) {
    var selectorList = [
        'id', // Любой уникальный идентификатов для этого объекта
        'errorSelector',
        'modalSelector',
        'modalHeaderTitleSelector',
        'modalContentSelector',
        'pjaxSelector'
    ];
    var selector;
    for(var i in selectorList) {
        selector = selectorList[i];
        if (typeof selectors[selector] === 'undefined') {
            console.error('Selector ' + selector + ' is undefined. Please pass the selector throw the constructor "var myActions = new CrudActions({' + selector + ': \'#myselector\'});');
            return;
        }
        this[selector] = selectors[selector];
    }
};
CrudActions.prototype.formView = function(url, formTitle) {
    formTitle = formTitle ? formTitle : 'Просмотр';
    this.modalForm(url, formTitle);
};
CrudActions.prototype.formCreate = function(url, formTitle) {
    formTitle = formTitle ? formTitle : 'Создать';
    this.modalForm(url, formTitle);
};
CrudActions.prototype.formUpdate = function(url, formTitle) {
    formTitle = formTitle ? formTitle : 'Редактирование';
    this.modalForm(url, formTitle);
};
CrudActions.prototype.delete = function(url) {
    if ( ! window.confirm('Вы действительно хотите удалить?'))
        return;
    jQuery.post(url, (function(data) {
            this.close();
            this.reloadTable();
        }).bind(this))
        .fail((function(xhr) {
            this.alertError(xhr);
        }).bind(this));
};
CrudActions.prototype.save = function(url, formSelector) {
    var data = jQuery(formSelector).serializeArray();
    jQuery.post(url, data, (function(data) {
            if (data == 'ok') {
                this.close();
                this.reloadTable();
            } else {
                jQuery(this.modalContentSelector).html(data);
            }
        }).bind(this))
        .fail((function(xhr) {
            this.alertError(xhr);
        }).bind(this));
};
CrudActions.prototype.close = function() {
    jQuery(this.modalSelector).modal('hide');
    jQuery(this.modalHeaderTitleSelector).html('');
    jQuery(this.modalContentSelector).html('');
};

CrudActions.prototype.modalForm = function(url, formTitle) {
    jQuery(this.modalSelector).modal('show')
    jQuery(this.modalContentSelector).load(url, (function(response, status, xhr) {
            if (status == 'error') {
                this.alertError(xhr);
            }
            if (status == 'success') {
                jQuery(this.modalHeaderTitleSelector).html(
                    '<div style=\"font-size: 1.6rem; font-weight:bold; text-align:center;\">' + formTitle + '</div>'
                );
            }
        }).bind(this));
};

CrudActions.prototype.alertError = function(xhr) {
    var text = 'Ошибка: ' + xhr.status + ' ' + xhr.statusText;
    var textAlert = '\
    <div id=\"alert-' + this.id + '\" class=\"alert-danger alert fade in\">\
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>\
        ' + text + '\
    </div>';
    $(this.errorSelector).html(textAlert);
    $('#alert-' + this.id).alert();
};

CrudActions.prototype.reloadTable = function() {
    $.pjax.reload({container: this.pjaxSelector});
};












/*
    var userActions = {};
    userActions.formView = function(url, formTitle) {
        formTitle = formTitle ? formTitle : 'Просмотр';
        this.modalForm(url, formTitle);
    };
    userActions.formCreate = function(url, formTitle) {
        formTitle = formTitle ? formTitle : 'Создать';
        this.modalForm(url, formTitle);
    };
    userActions.formUpdate = function(url, formTitle) {
        formTitle = formTitle ? formTitle : 'Редактирование';
        this.modalForm(url, formTitle);
    };
    userActions.delete = function(url) {
        if ( ! window.confirm('Вы действительно хотите удалить?'))
            return;
        jQuery.post(url, (function(data) {
                this.close();
                this.reloadTable();
            }).bind(this))
            .fail((function(xhr) {
                this.alertError(xhr);
            }).bind(this));
    };
    userActions.save = function(url, formSelector) {
        var data = jQuery(formSelector).serializeArray();
        jQuery.post(url, data, (function(data) {
                if (data == 'ok') {
                    this.close();
                    this.reloadTable();
                } else {
                    jQuery('#modal-content-user').html(data);
                }
            }).bind(this))
            .fail((function(xhr) {
                this.alertError(xhr);
            }).bind(this));
    };
    userActions.close = function() {
        jQuery('#modal-user').modal('hide');
        jQuery('#modal-header-title').html('');
        jQuery('#modal-content-user').html('');
    };

    userActions.modalForm = function(url, formTitle) {
        jQuery('#modal-user').modal('show')
            .find('#modal-content-user')
            .load(url, (function(response, status, xhr) {
                if (status == 'error') {
                    this.alertError(xhr);
                }
                if (status == 'success') {
                    jQuery('#modal-header-title').html(
                        '<div style=\"font-size: 1.6rem; font-weight:bold; text-align:center;\">' + formTitle + '</div>'
                    );
                }
            }).bind(this));
    };

    userActions.alertError = function(xhr) {
        var text = 'Ошибка: ' + xhr.status + ' ' + xhr.statusText;
        var textAlert = '\
        <div id=\"alert-user\" class=\"alert-danger alert fade in\">\
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>\
            ' + text + '\
        </div>';
        $('#user-errors').html(textAlert);
        $('#alert-user').alert();
    };

    userActions.reloadTable = function() {
        $.pjax.reload({container:'#pjax-grid-view-user'});
    };
    */