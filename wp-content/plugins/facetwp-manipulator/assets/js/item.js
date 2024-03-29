var fwpmanip_item_control_modal, fwpmanip_item_control_modal_handler;
(function ($) {

    var current_items = {}
    flush_current = false;

    fwpmanip_item_control_modal = function (obj) {

        var template_ele = $('#' + obj.modal + '-tmpl'),
            template = Handlebars.compile(template_ele.html()),
            data = {},
            state,
            html;

        if ( current_items[ obj.modal ] && flush_current === false) {
            data = {config: current_items[ obj.modal ].data('config')};
            state = 'add';
        } else {
            current_items[ obj.modal ] = null;
            flush_current = false;
            state = 'update';
            data = obj.trigger.data('default');
        }

        html = $(template(data));
        html.find('[data-default]').each(function () {
            var field = $(this);
            field.val(field.data('default'));
        });
        $('#' + obj.modal + '_fwpmanipModal .fwpmanip-modal-footer [data-state="' + state + '"]').remove();

        return html;
    }

    fwpmanip_item_control_modal_handler = function (data, obj) {
        var item = create_item(obj.params.requestData.control, data.data),
            target;

        if ( current_items[ obj.params.requestData.control + '-config' ] ) {
            target = current_items[ obj.params.requestData.control + '-config' ];
            current_items[ obj.params.requestData.control + '-config' ] = null;
            target.replaceWith(item);
        } else {
            target = $('#' + obj.params.requestData.control);
            item.appendTo(target);
        }

        save_current_edit($('#' + obj.params.requestData.control));
    }

    var create_item = function (target, data) {

        var template_ele = $('#' + target + '-tmpl'),
            template = Handlebars.compile(template_ele.html()),
            item = $(template(data));
        item.data('config', data);
        $(document).trigger('fwpmanip.init');
        return item;
    }

    var save_current_edit = function (parent) {
        var holders;
        if (parent) {
            holders = $(parent);
        } else {
            holders = $('.fwpmanip-control-item');
        }

        for (var i = 0; i < holders.length; i++) {

            var holder = $(holders[i]),
                input = $('#' + holder.prop('id') + '-control'),
                items = holder.find('.fwpmanip-item'),
                configs = [];

            for (var c = 0; c < items.length; c++) {
                var item = $(items[c]);
                configs.push(item.data('config'));
            }
            input.val(JSON.stringify(configs)).trigger('change');
        }
        $(document).trigger('fwpmanip.save');
    }

    $(document).on('click', '.fwpmanip-item-edit', function () {
        var clicked = $(this),
            control = clicked.closest('.fwpmanip-control-item'),
            id = control.prop('id') + '-config',
            trigger = $('button[data-modal="' + id + '"]');


        current_items[ id ] = clicked.closest('.fwpmanip-item');
        flush_current = false;

        trigger.trigger('click');
    });

    $(document).on('click', '.fwpmanip-item-remove', function () {
        var clicked = $(this),
            control = clicked.closest('.fwpmanip-control-item'),
            id = control.prop('id') + '-config',
            trigger = $('button[data-modal="' + id + '"]'),
            item = clicked.closest('.fwpmanip-item');

        if (clicked.data('confirm')) {
            if (!confirm(clicked.data('confirm'))) {
                return;
            }
        }

        current_items[ id ] = null;

        item.fadeOut(200, function () {
            item.remove();
            save_current_edit(control);
        });
    });

    // clear edit
    $(window).on('modals.closed', function () {
        flush_current = true;
    });

    // init
    $(window).load(function () {
        $(document).on('fwpmanip.init', function () {
            $('.fwpmanip-control-item').not('._fwpmanip_item_init').each(function () {

                var holder = $(this),
                    input = $('#' + holder.prop('id') + '-control'),
                    data;
                if( holder.hasClass('_fwpmanip_item_init') ){
                    return;
                }
                holder.addClass('_fwpmanip_item_init');
                try {
                    data = JSON.parse(input.val());

                } catch (err) {

                }
                holder.addClass('_fwpmanip_item_init');

                if (typeof data === 'object' && data.length) {
                    for (var i = 0; i < data.length; i++) {
                        var item = create_item(holder.prop('id'), data[i]);
                        item.appendTo(holder);
                    }
                }
                holder.removeClass('processing');
            });
        });
    });
})(jQuery);
