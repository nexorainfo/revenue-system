(function ($) {
    "use strict";
    const data = {
        csrf: $('meta[name="csrf-token"]').attr("content"),
        checkPinUrl: $('meta[name="check-pin-url"]').attr("content"),
    };
    const plugins = {
        selectInit: function () {
            $('[data-toggle="select2"]').select2({
                width: '100%'
            })
        },
        fooTable: function (){
            if ($("#demo-foo-accordion").length) {
                $("#demo-foo-accordion").footable().on("footable_row_expanded", function(o) {
                    $("#demo-foo-accordion tbody tr.footable-detail-show").not(o.row).each(function() {
                        $("#demo-foo-accordion").data("footable").toggleDetail(this);
                    });
                });
            }
            }
    }
    const extra = {
        addMore: function () {
            $('[data-toggle="add-more"]').each(function () {
                const target_element = $(this).data("target-element");
                $(this).on("click", function (e) {
                    e.preventDefault();
                    const row_element = $(`#${target_element}`).children().first().clone();
                    const row_index = $(`#${target_element}`).children().length;
                    row_element.find('input, textarea, select, label').each(function (col_key, col) {
                        if ($(col).is('label')) {
                            const forAttr = $(col).attr('for');
                            if (forAttr) {
                                const new_for = `${forAttr}_${row_index}`;
                                $(col).attr('for', new_for);
                            }
                        }  else {
                            const name = $(col).attr('name');
                            const array_name = name.split(/\[([^\[\]]*)\]/).filter(d => d.length > 1);
                            const key_name = array_name.pop();
                            let new_name = `${array_name.shift()}[${row_index}][${key_name}]`;
                            if (name.endsWith('[]')) {
                                new_name += '[]';
                            }
                            $(col).attr('name', new_name);
                            $(col).attr('id', `${key_name}_${row_index}`);
                            $(col).val('');
                        }
                    });
                    $(`#${target_element}`).append(row_element);
                });
            });
        },
        scrollToBottom: function () {
            $(".scroll-to-btm").each(function (i, el) {
                el.scrollTop = el.scrollHeight;
            });
        },
        removeParent: function () {
            $(document).on("click", '[data-toggle="remove-parent"]', function () {
                const $this = $(this);
                const parent = $this.data("parent");
                const target_element = $(this).data("target-element");
                const element_length = $(`#${target_element}`).children().length;
                if (element_length > 1) {
                    $this.closest(parent).remove();
                }
            });
        },
        cacheClear: function () {
            $('.cacheButton').on('click', function (e) {
                const cacheButton = $("#cacheBtn");
                e.preventDefault()
                $.ajax({
                    method: "GET",
                    url: $(this).attr("data"),
                    beforeSend: function () {
                        cacheButton.attr('disabled', true);
                        cacheButton.html("<i class='fa fa-spinner fa-spin'></i>");
                    },
                    success: function (response) {
                        toastmessage(response.message,'success')
                        cacheButton.attr('disabled', false);
                        cacheButton.html("<i class='fas fa-brush'></i>");
                    }, error: function () {
                        cacheButton.attr('disabled', false);
                        cacheButton.html("<i class='fas fa-brush'></i>");
                    }
                });
            })
        },
        deleteConfirm: function () {
            $('.show_confirm').click(function (event) {
                const form = $(this).closest("form");
                event.preventDefault();
                swal.fire({
                    title: "के तपाइँ मेटाउन निश्चित हुनुहुन्छ ?",
                    text: "यदि तपाईंले यसलाई मेटाउनुभयो भने, यो सदाको लागि हट्नेछ।",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: 'red',
                    confirmButtonText: "Delete",

                })
                    .then((willDelete) => {
                        if (willDelete.isConfirmed) {
                            form.submit();
                        }
                    });
            });
        },
        confirmPin: function () {
            $('.confirm_pin').click(function (event) {
                event.preventDefault();
                swal.fire({
                    title: 'प्रविष्ट कोड',
                    input: 'password',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    cancelButtonText: 'रद्द गर्नुहोस्',
                    confirmButtonText: 'पेश गर्नुहोस्',
                    showLoaderOnConfirm: true,
                    preConfirm: (pin) => {
                        return new Promise((resolve, reject) => {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': data.csrf
                                }
                            });
                            $.ajax({
                                url: data.checkPinUrl,
                                type: 'POST',
                                data: {pin: pin},
                                success: function (response) {
                                    if (response.status === true) {
                                        resolve();
                                    } else {
                                        extra.invalidPin()
                                    }
                                },
                                error: function () {
                                    extra.invalidPin()
                                }
                            });
                        });
                    },
                    allowOutsideClick: () => !swal.isLoading(),
                    backdrop: true
                }).then((result) => {
                    console.log(result)
                    if (result.value) {
                        const type = $(this).data('bs-type');
                        console.log(type);
                        if (type === 'delete') {
                            $(this).closest('form').submit();
                        } else if (type === 'edit') {
                            window.location.href = $(this).attr('href');
                        }
                    }
                });
            });
        },
        invalidPin: function () {
            let timerInterval
            Swal.fire({
                title: 'पुन: प्रयास गर्नुहोस्',
                html: 'कृपया मान्य कोड प्रविष्ट गर्नुहोस्',
                timer: 2000,
                timerProgressBar: true,

                willClose: () => {
                    clearInterval(timerInterval)
                }
            })
        },
        searchFocusOut: function () {
            $('.filter-form').focusout(function () {
                $(this).closest('form').submit();
            });
        },
        browserBack: function () {
            const previousUrl = document.referrer;
            const currentUrl = window.location.href;
            history.pushState({url: currentUrl}, '', currentUrl);
            $(window).on('popstate', function () {
                window.location.href = previousUrl;
            });
        },
        formFillAlert: function () {
            let unsavedChanges = false;
            $('form input').blur(function () {
                if ($(this).val() !== '') {
                    unsavedChanges = true;
                }
            });
            $(window).on('beforeunload', function (event) {
                if (unsavedChanges) {
                    event.preventDefault();
                }
            });
            $('form').submit(function () {
                unsavedChanges = false;
            });
        },
        listenLivewireEvent:function (){
            window.addEventListener('toast_message', event => {
                toastmessage(event.detail.title,event.detail.type)
            })
        },
    };
    $(document).ready(function () {
        // plugins
        plugins.selectInit();
        plugins.fooTable()
        // extra
        extra.addMore();
        extra.removeParent();
        extra.confirmPin();
        extra.deleteConfirm();
        extra.cacheClear();
        extra.searchFocusOut();
        extra.browserBack();
        // extra.formFillAlert();
        extra.listenLivewireEvent();
    });
})(jQuery);
function toastmessage(message, type) {
    swal.fire({
        title: message,
        toast: true,
        position: 'top-right',
        timer: 3000,
        showConfirmButton: false,
        timerProgressBar: true,
        width: 400,
        icon: type,
    });
}
function copyText(el) {
    try {
        navigator.clipboard.writeText(el);
        toastmessage('Copied to clipboard', 'success')
    } catch (err) {
        toastmessage('Unable to copy', 'error')
    }
}
function openFileModal(title, extension, url) {
    $('#file-offcanvas').offcanvas('show');
    $('#file-offcanvas-label').html(title + '.' + extension);
    if (extension === 'pdf') {
        $('#file-iframe').show();
        $('#file-img').hide();
        $('#file-iframe').attr('src', url);
        $('#file-iframe').attr('width', '100%');
        $('#file-iframe').attr('height', '100%');
    } else if (['jpg', 'jpeg', 'png'].includes(extension)) {
        $('#file-img').show();
        $('#file-iframe').hide();
        $('#file-img').attr('src', url);
    } else {
        $('#file-iframe').hide();
        $('#file-img').hide();
        $('#file-icon').show();
        $('#file-icon').attr('class', 'fa fa-file');
    }
}
