/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2024 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

'use strict';

window.psToast = null;

// Hàm mở toast lên
const nvToast = (text, level, halign, valign) => {
    var toasts = $('#site-toasts');
    var id = nv_randomPassword(8);

    const tLevel = {
        'secondary': 'text-bg-secondary',
        'error': 'text-bg-danger',
        'danger': 'text-bg-danger',
        'primary': 'text-bg-primary',
        'success': 'text-bg-success',
        'info': 'text-bg-info',
        'warning': 'text-bg-warning',
        'light': 'text-bg-light',
        'dark': 'text-bg-dark',
    };
    const hAlign = {
        's': ' toast-start',
        'c': ' toast-center',
    };
    const vAlign = {
        't': ' toast-top',
        'm': ' toast-middle',
        'c': ' toast-middle',
    };
    level = tLevel[level] || ' ';
    halign = hAlign[halign] || '';
    valign = vAlign[valign] || '';
    var align = halign + valign;
    var allAlign = 'toast-top toast-start toast-center toast-middle';

    $('.toast-items', toasts).append(`
    <div data-id="` + id + `" id="toast-` + id + `" class="toast align-items-center ` + level + ` border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">` + text + `</div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="` + nv_close + `"></button>
        </div>
    </div>`);
    if (align != '') {
        toasts.removeClass(allAlign).addClass(align);
    }
    toasts.removeClass('d-none');
    $('.toast-lists', toasts)[0].scrollTop = $('.toast-lists', toasts)[0].scrollHeight;

    if (!psToast) {
        psToast = new PerfectScrollbar($('.toast-lists', toasts)[0], {
            wheelPropagation: false
        });
    } else {
        psToast.update();
    }

    // Show toast
    var toaster = $('#toast-' + id);
    (new bootstrap.Toast(toaster[0])).show();

    // Xử lý khi mỗi toast ẩn
    toaster.on('hidden.bs.toast', () => {
        toaster.remove();
        if ($('.toast-items>.toast', toasts).length < 1) {
            if (psToast) {
                psToast.destroy();
                psToast = null;
            }
            toasts.addClass('d-none').removeClass(allAlign);
        }
    });
}

// Độ rộng thanh cuộn
const nvGetScrollbarWidth = () => {
    const outer = document.createElement('div');
    outer.style.visibility = 'hidden';
    outer.style.overflow = 'scroll';
    outer.style.msOverflowStyle = 'scrollbar';
    outer.style.position = 'fixed';
    document.body.appendChild(outer);

    const inner = document.createElement('div');
    outer.appendChild(inner);

    const scrollbarWidth = outer.offsetWidth - inner.offsetWidth;

    outer.parentNode.removeChild(outer);

    return scrollbarWidth;
}

// Thay thế cho alert
const nvAlert = (message, callback) => {
    if (typeof callback == 'undefined') {
        callback = () => {};
    }
    nvConfirm(message, callback, () => {}, false);
}

// Thay chế cho confirm
const nvConfirm = (message, cbConfirm, cbCancel, cancelBtn) => {
    const body = document.getElementsByTagName('body')[0];

    if (body.classList.contains('alert-open')) {
        return;
    }
    if (typeof cancelBtn == 'undefined') {
        cancelBtn = true;
    }
    if (typeof cbConfirm == 'undefined') {
        cbConfirm = () => {};
    }
    if (typeof cbCancel == 'undefined') {
        cbCancel = () => {};
    }

    const id = 'alert-' + nv_randomPassword(8);
    const isModal = body.classList.contains('modal-open');

    // Đối tượng box
    const box = document.createElement('div');
    box.classList.add('modal', 'alert-box', 'fade');
    box.id = id;
    box.setAttribute('aria-labelledby', id + '-body');
    box.innerHTML = `<div class="modal-dialog alert-box-dialog modal-dialog-scrollable">
        <div class="modal-content alert-box-content">
            <div class="modal-body alert-box-body" id="` + id + `-body">
                ` + message + `
            </div>
            <div class="modal-footer alert-box-footer" id="` + id + `-footer">
                <button type="button" class="btn btn-primary" id="` + id + `-confirm"><i class="fa-solid fa-check"></i> ` + nv_confirm + `</button>
                ` + (cancelBtn ? `<button type="button" class="btn btn-secondary" id="` + id + `-close"><i class="fa-solid fa-xmark"></i> ` + nv_close + `</button>` : '') + `
            </div>
        </div>
    </div>`;

    // Đối tượng backdrop
    const backdrop = document.createElement('div');
    backdrop.classList.add('alert-backdrop', 'fade');

    body.append(box, backdrop);
    box.style.display = 'block';

    const cOverflow = body.style.overflow;
    const cPaddingRight = body.style.paddingRight;

    setTimeout(() => {
        box.classList.add('show');
        backdrop.classList.add('show');

        if (!isModal) {
            body.style.overflow = 'hidden';
            body.style.paddingRight = nvGetScrollbarWidth() + 'px';
        }
        body.classList.add('alert-open');
    }, 10);

    // Xử lý nút ấn
    const close = (event) => {
        ([...box.querySelectorAll('button')].map(ele => ele.setAttribute('disabled', 'disabled')));
        body.classList.remove('alert-open');
        if (!isModal) {
            if (cOverflow) {
                body.style.overflow = cOverflow;
            } else {
                body.style.removeProperty('overflow');
            }
            if (cPaddingRight) {
                body.style.paddingRight = paddingRight;
            } else {
                body.style.removeProperty('padding-right');
            }
        }
        box.classList.remove('show');
        backdrop.classList.remove('show');
        setTimeout(() => {
            box.style.display = 'none';
            body.removeChild(box);
            body.removeChild(backdrop);
            if (event == 'confirm') {
                cbConfirm();
            } else if (event == 'cancel') {
                cbCancel();
            }
        }, 150);
    }
    if (cancelBtn) {
        document.getElementById(id + '-close').addEventListener('click', () => {
            close('cancel');
        });
    }
    document.getElementById(id + '-confirm').addEventListener('click', () => {
        close('confirm');
    });
}

// Site modal
const siteMdEle = document.getElementById('site-modal');
const siteMd = bootstrap.Modal.getOrCreateInstance('#site-modal');
var siteMdCb = null;

siteMdEle.addEventListener('hidden.bs.modal', () => {
    $('.modal-body', siteMdEle).html('<div class="text-center"><i class="fa-solid fa-2x fa-spinner fa-spin-pulse"></i></div>');
    if (siteMdCb !== null) {
        siteMdEle.removeEventListener('shown.bs.modal', siteMdCb);
        siteMdCb = null;
    }
});

function modalShow(title, body, callback) {
    if (siteMdEle.classList.contains('show')) {
        return;
    }
    if (!title) {
        title = '&nbsp;';
    }
    $('.modal-title', siteMdEle).html(title);
    $('.modal-body', siteMdEle).html(body);

    if (typeof callback === "function") {
        siteMdEle.addEventListener('shown.bs.modal', callback);
        siteMdCb = callback;
    } else {
        siteMdCb = null;
    }

    siteMd.show();
}

function locationReplace(url) {
    var uri = window.location.href.substring(window.location.protocol.length + window.location.hostname.length + 2);
    if (url != uri && history.pushState) {
        history.pushState(null, null, url)
    }
}

function formXSSsanitize(form) {
    $(form).find("input, textarea").not(":submit, :reset, :image, :file, :disabled").not('[data-sanitize-ignore]').each(function() {
        $(this).val(DOMPurify.sanitize($(this).val(), {ALLOWED_TAGS: nv_whitelisted_tags, ADD_ATTR: nv_whitelisted_attr}));
    });
}

// checkAll
function checkAll(a, th) {
    th.is(":checked") ? ($("[data-toggle=checkAll], [data-toggle=checkSingle]", a).not(":disabled").each(function() {
        $(this).prop("checked", !0)
    }), $(".checkBtn", a).length && $(".checkBtn", a).prop("disabled", !1)) : ($("[data-toggle=checkAll], [data-toggle=checkSingle]", a).not(":disabled").each(function() {
        $(this).prop("checked", !1)
    }), $(".checkBtn", a).length && $(".checkBtn", a).prop("disabled", !0))
}

// checkSingle
function checkSingle(a) {
    var checked = 0,
        unchecked = 0;
    $("[data-toggle=checkSingle]", a).not(":disabled").each(function() {
        $(this).is(":checked") ? checked++ : unchecked++
    });
    0 != checked && 0 == unchecked ? $("[data-toggle=checkAll]", a).prop("checked", !0) : $("[data-toggle=checkAll]", a).prop("checked", !1);
    $(".checkBtn", a).length && (checked ? $(".checkBtn", a).prop("disabled", !1) : $(".checkBtn", a).prop("disabled", !0))
}

$(document).ready(function() {
    // Hàm lưu config tùy chỉnh của giao diện
    function storeThemeConfig(configName, configValue, callbackSuccess, callbackError) {
        if (typeof callbackSuccess == 'undefined') {
            callbackSuccess = (data) => {
                if (data.error) {
                    nvToast(data.message, 'danger');
                }
            };
        }
        if (typeof callbackError == 'undefined') {
            callbackError = (xhr, text, error) => {
                console.log(xhr, text, error);
                nvToast(text, 'danger');
            };
        }
        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=siteinfo&nocache=' + new Date().getTime(),
            data: {
                store_theme_config: $('body').data('checksess'),
                config_name: configName,
                config_value: configValue
            },
            dataType: 'json',
            error: callbackError,
            success: callbackSuccess
        });
    }

    // Đếm ngược phiên đăng nhập của quản trị
    if ($('#countdown').length) {
        var countdown = $('#countdown'),
            distance = parseInt(countdown.data('duration')),
            countdownObj = setInterval(function() {
                distance = distance - 1000;

                var hours = Math.floor(distance / (1000 * 60 * 60)),
                    minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)),
                    seconds = Math.floor((distance % (1000 * 60)) / 1000);
                if (minutes < 10) {
                    minutes = '0' + minutes
                };
                if (seconds < 10) {
                    seconds = '0' + seconds
                };
                countdown.text(hours + ':' + minutes + ':' + seconds)

                if (distance <= 0) {
                    clearInterval(countdownObj);
                    window.location.reload()
                }
            }, 1000);
    };

    // Quản trị thoát
    $('[data-toggle="admin-logout"]').on('click', function(e) {
        e.preventDefault();
        nv_admin_logout();
    });

    // Đóng mở thanh menu phải nếu nó có
    var rBar = $('#right-sidebar');
    if (rBar.length) {
        $('[data-toggle="right-sidebar"]').on('click', function(e) {
            e.preventDefault();
            $('body').toggleClass('open-right-sidebar');
        });
        $(document).on('click', function(e) {
            if ($(e.target).is('[data-toggle="right-sidebar"]') || $(e.target).closest('[data-toggle="right-sidebar"]').length) {
                return;
            }
            if ($(e.target).is('.right-sidebar') || $(e.target).closest('.right-sidebar').length) {
                return;
            }
            if ($(e.target).is('#site-toasts') || $(e.target).closest('#site-toasts').length) {
                return;
            }
            if ($('body').is('.open-right-sidebar')) {
                $('body').removeClass('open-right-sidebar');
            }
        });
        new PerfectScrollbar($('.right-sidebar-inner', rBar)[0], {
            wheelPropagation: false
        });
    }

    // Đóng mở thanh breadcrumb
    $('[data-toggle="breadcrumb"]').on('click', function(e) {
        e.preventDefault();
        $('body').toggleClass('open-breadcrumb');
    });

    // Menu các module admin
    var menuSys = $('#menu-sys'), psMsys;
    $('[data-bs-toggle="dropdown"]', menuSys).on('show.bs.dropdown', function() {
        if (psMsys) {
            return;
        }
        psMsys = new PerfectScrollbar($('.menu-sys-inner', menuSys)[0], {
            wheelPropagation: false
        });
    });

    // Xử lý đổi ngôn ngữ
    $('[name="gsitelanginterface"]').on('change', function() {
        window.location = script_name + '?langinterface=' + $(this).val() + '&' + nv_lang_variable +  '=' + nv_lang_data;
    });
    $('[name="gsitelangdata"]').on('change', function() {
        window.location = script_name + '?langinterface=' + nv_lang_interface + '&' + nv_lang_variable +  '=' + $(this).val();
    });

    /**
     * Điều khiển menu trái
     */
    var lBar = $('#left-sidebar'), nvLBarSubsScroller = {}, nvLBarScroller, lBarTips = [];
    var nvLBarScroll = $('.left-sidebar-scroll', lBar);

    // Menu trái thu gọn hay không?
    function isCollapsibleLeftSidebar() {
        return $('body').is('.collapsed-left-sidebar');
    }

    // Xóa các thanh cuộn trong menu phụ
    function destroyLBarSubsScroller() {
        $.each(nvLBarSubsScroller, function(k) {
            nvLBarSubsScroller[k].destroy();
        });
        nvLBarSubsScroller = {};
    }

    // Cập nhật thanh cuộn chính của menu trái
    function updateLeftSidebarScrollbar() {
        if (!$.isSm()) {
            nvLBarScroller.update();
        }
    }

    // Cập nhật thanh cuộn menu con
    function updateLBarSubsScroller() {
        $.each(nvLBarSubsScroller, function(k) {
            nvLBarSubsScroller[k].update();
        });
    }

    // Xóa tooltip ở menu thu gọn
    function setLbarTip() {
        if (lBarTips.length > 0) {
            return;
        }
        $('.icon', lBar).each(function(k) {
            lBarTips[k] = new bootstrap.Tooltip(this);
        });
    }

    // Set tooltip ở menu thu gọn
    function removeLbarTip() {
        if (lBarTips.length <= 0) {
            return;
        }
        for (var i = 0; i < lBarTips.length; i++) {
            lBarTips[i].dispose();
        }
        lBarTips = [];
    }

    // Điều khiển mở menu cấp 2,3 ở dạng thu gọn
    function openLeftSidebarSub(menu) {
        var li = $(menu).parent(), // Li item
            subMenu = $(menu).next(),
            speed = 200,
            isLev1 = menu.parents().eq(1).hasClass('sidebar-elements'), // Xác định có phải menu cấp 1 không
            menuOpened = li.siblings('.open'); // Các menu cùng cấp khác đang mở

        // Đóng các menu cùng cấp đang mở
        if (menuOpened) {
            closeLeftSidebarSub($('> ul', menuOpened), menu);
        }

        if (!$.isSm() && isCollapsibleLeftSidebar() && isLev1) {
            // Mở menu dạng thu gọn
            destroyLBarSubsScroller();
            li.addClass('open');
            subMenu.addClass('visible');

            var scroller = li.find('.nv-left-sidebar-scroller');
            scroller.each(function(k, v) {
                nvLBarSubsScroller[k] = new PerfectScrollbar(v, {
                    wheelPropagation: false
                });
            });
        } else {
            // Mở menu dạng đầy đủ
            subMenu.slideDown({
                duration: speed,
                complete: function() {
                    li.addClass("open");
                    $(this).removeAttr("style");
                    updateLeftSidebarScrollbar();
                    updateLBarSubsScroller();
                }
            });
        }
    }

    // Điều khiển đóng menu cấp 2,3 ở dạng thu gọn
    function closeLeftSidebarSub(subMenu, menu) {
        var li = $(subMenu).parent(),
            subMenuOpened = $("li.open", li), // Các menu con đang mở
            notInMenu = !menu.closest(lBar).length,
            speed = 200,
            isLev1 = menu.parents().eq(1).hasClass("sidebar-elements"); // Xác định có phải menu cấp 1 không

        if (!$.isSm() && isCollapsibleLeftSidebar() && (isLev1 || notInMenu)) {
            // Đóng menu dạng thu gọn
            li.removeClass("open");
            subMenu.removeClass("visible");
            subMenuOpened.removeClass("open").removeAttr("style");
            updateLBarSubsScroller();
        } else {
            // Đóng menu dạng đầy đủ
            subMenu.slideUp({
                duration: speed,
                complete: function() {
                    li.removeClass("open");
                    $(this).removeAttr("style");
                    subMenuOpened.removeClass("open").removeAttr("style");
                    updateLeftSidebarScrollbar();
                    updateLBarSubsScroller();
                }
            });
        }
    }

    // Thanh cuộn menu trái nếu màn hình lớn
    if (!$.isSm()) {
        nvLBarScroller = new PerfectScrollbar(nvLBarScroll[0], {
            wheelPropagation: false
        });
    }

    // Tip menu trái ở chế độ thu gọn
    if (isCollapsibleLeftSidebar() && !$.isSm()) {
        setLbarTip();
    }

    var lBarTimer;
    $(window).resize(function() {
        if (lBarTimer) {
            clearTimeout(lBarTimer);
        }
        lBarTimer = setTimeout(() => {
            if (isCollapsibleLeftSidebar() && !$.isSm()) {
                setLbarTip();
            } else {
                removeLbarTip();
            }
            if ($.isSm()) {
                if (nvLBarScroller) {
                    nvLBarScroller.destroy();
                }
                return;
            }
            if (nvLBarScroll.hasClass('ps')) {
                nvLBarScroller.update();
            } else {
                nvLBarScroller = new PerfectScrollbar(nvLBarScroll[0], {
                    wheelPropagation: false
                });
            }
        }, 100);
    });

    // Click vào nút mở rộng menu con ở menu trái ở chế độ đầy đủ
    $('span.toggle', lBar).on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var menu = $(this).parent();
        var li = menu.parent();
        var subMenu = menu.next();

        if (li.hasClass('open')) {
            closeLeftSidebarSub(subMenu, menu);
        } else {
            openLeftSidebarSub(menu);
        }
    });

    // Click vào link menu trái > xử lý ở chế độ thu gọn. Chế độ đầy đủ xem như link thường
    $('.sidebar-elements li a', lBar).on('click', function(e) {
        var menu = $(this);
        var li = menu.parent();
        var subMenu = menu.next();
        if ((isCollapsibleLeftSidebar() && menu.parent().parent().is('.sidebar-elements') && li.is('.parent')) || menu.attr('href') == '#') {
            e.preventDefault();
            if (subMenu.length && subMenu.hasClass('visible')) {
                closeLeftSidebarSub(subMenu, menu);
            } else {
                openLeftSidebarSub(menu);
            }
        }
    });

    // Xử lý đóng menu trái cấp 2 ở chế độ thu gọn
    $(document).on('click', function(e) {
        if (!$(e.target).closest(lBar).length && !$.isSm()) {
            closeLeftSidebarSub($('ul.visible', lBar), $(e.currentTarget));
        }
    });

    // Mở rộng/thu gọn menu trái
    $('[data-toggle="left-sidebar"]').on('click', function(e) {
        e.preventDefault();
        var collapsed = $('body').is('.collapsed-left-sidebar');
        if (collapsed) {
            // Mở rộng
            $('ul.sub-menu.visible', lBar).removeClass('visible');
            // Xóa bỏ các thanh cuộn ở menu con
            destroyLBarSubsScroller();
            removeLbarTip();
        } else {
            // Thu gọn
            setLbarTip();
        }
        $('body').toggleClass('collapsed-left-sidebar');
        storeThemeConfig('collapsed_left_sidebar', collapsed ? 0 : 1);
    });

    // Đóng mở thanh menu trái ở dạng mobile
    $('[data-toggle="left-sidebar-sm"]', lBar).on('click', function(e) {
        e.preventDefault();
        $('body').toggleClass('left-sidebar-open-sm');
        $('.left-sidebar-spacer', lBar).slideToggle(300, function() {
            $(this).removeAttr('style').toggleClass('open');
        });
    });

    // Chỉnh chế độ màu
    var mColor = $('#site-color-mode');
    $('a', mColor).on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        if ($this.is('.active') || mColor.data('busy')) {
            return;
        }
        var icon = $('i', $this);
        icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
        mColor.data('busy', 1);

        storeThemeConfig('color_mode', $this.data('mode'), () => {
            mColor.data('busy', 0);
            $('a', mColor).removeClass('active');
            $this.addClass('active');
            icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));

            $('html').data('theme', $this.data('mode')).attr('data-theme', $this.data('mode'));
            nvSetThemeMode($this.data('mode'));
        }, (xhr, text, err) => {
            console.log(xhr, text, err);
            icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
            mColor.data('busy', 0);
            nvToast(text, 'danger');
        });
    });

    // Chỉnh hướng lrt, rtl
    $('[name="g_themedir"]').on('change', function() {
        var dir = $(this).val();
        var ctn = $('#site-text-direction');
        var $this = $(this).next();
        var icon = $('i', $this);
        if (ctn.data('busy') || icon.is('.fa-spinner')) {
            return;
        }

        $('[name="g_themedir"]').prop('disabled', true);
        icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
        ctn.data('busy', 1);

        storeThemeConfig('dir', dir, () => {
            location.reload();
        }, (xhr, text, err) => {
            console.log(xhr, text, err);
            nvToast(text, 'danger');
            $('[name="g_themedir"][value="' + $('html').attr('dir') + '"]').prop('checked', true);
            $('[name="g_themedir"]').prop('disabled', false);
            icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
            ctn.data('busy', 0);
        });
    });

    // Xử lý khi click trong điều kiện alertbox đang mở
    $(document).on('click', function(e) {
        if (!$('body').is('.alert-open') || $(e.target).is('.alert-box-content') || $(e.target).closest('.alert-box-content').length) {
            return;
        }
        const al = document.getElementsByClassName('alert-box')[0];
        if (al.classList.contains('modal-static')) {
            return;
        }
        al.classList.add('modal-static');
        setTimeout(() => {
            al.classList.remove('modal-static');
        }, 150);
    });

    // Xử lý hết phiên đăng nhập của admin
    var adTimer, adInterval, adOffcanvas = $('#admin-session-timeout'), sysNoti = $('#main-notifications');

    const timeoutsessrun = () => {
        clearInterval(adTimer);
        var Timeout = 60;
        $('[data-toggle="sec"]', adOffcanvas).text(Timeout);
        adOffcanvas.addClass('show');
        var msBegin = new Date().getTime();

        // Dừng ajax thông báo
        if (sysNoti.length) {
            sysNoti.data('enable', false);
        }

        adInterval = setInterval(() => {
            var msCurrent = new Date().getTime();
            var ms = Timeout - Math.round((msCurrent - msBegin) / 1000);
            if (ms >= 0) {
                $('[data-toggle="sec"]', adOffcanvas).text(ms);
                return;
            }

            clearInterval(adInterval);
            adOffcanvas.removeClass('show');
            $.getJSON(nv_base_siteurl + "index.php", {
                second: "time_login",
                nocache: (new Date).getTime()
            }).done(function(json) {
                if (json.showtimeoutsess == 1) {
                    $.get(nv_base_siteurl + "index.php?second=admin_logout&js=1&system=1&nocache=" + (new Date).getTime(), function() {
                        window.location.reload();
                    });
                } else {
                    // Chạy lại
                    if (sysNoti.length) {
                        sysNoti.data('enable', false);
                    }
                    adTimer = setTimeout(() => {
                        timeoutsessrun();
                    }, json.check_pass_time);
                }
            });
        }, 1000);
    }

    const timeoutsesscancel = () => {
        clearInterval(adInterval);
        $.ajax({
            url: nv_base_siteurl + 'index.php?second=statimg',
            cache: false
        }).done(function() {
            adOffcanvas.removeClass('show');

            // Chạy lại ajax thông báo
            if (sysNoti.length) {
                sysNoti.data('enable', true);
            }
            adTimer = setTimeout(() => {
                timeoutsessrun();
            }, nv_check_pass_mstime);
        });
    }

    adTimer = setTimeout(() => {
        timeoutsessrun();
    }, nv_check_pass_mstime);
    $('[data-toggle="cancel"]', adOffcanvas).on('click', function(e) {
        e.preventDefault();
        timeoutsesscancel();
    });

    // Add rel="noopener noreferrer nofollow" to all external links
    $('a[href^="http"]').not('a[href*="' + location.hostname + '"]').not('[rel*=dofollow]').attr({
        target: "_blank",
        rel: "noopener noreferrer nofollow"
    });

    // Prevent empty link click
    $('a[href="#"]').on('click', function(e) {
        e.preventDefault();
    });

    // Change Localtion
    $("a[data-location]").on("click", function() {
        locationReplace($(this).data("location"));
    });

    // XSSsanitize
    $('body').on('click', '[type=submit]:not([name],.ck-button-save)', function(e) {
        var form = $(this).parents('form');
        if (XSSsanitize && !$('[name=submit]', form).length) {
            // Khi không xử lý XSS thì trình submit mặc định sẽ thực hiện
            e.preventDefault();

            // Đưa CKEditor 5 trình soạn thảo vào textarea trước khi submit
            $(form).find("textarea").each(function() {
                if (this.dataset.editorname && window.nveditor && window.nveditor[this.dataset.editorname]) {
                    $(this).val(window.nveditor[this.dataset.editorname].getData());
                }
            });

            formXSSsanitize(form);
            $(form).submit();
        }
    });

    // checkAll
    $('body').on('click', '[data-toggle=checkAll]', function() {
        checkAll($(this).parents('form'), $(this));
    });

    // checkSingle
    $('body').on('click', '[data-toggle=checkSingle]', function() {
        checkSingle($(this).parents('form'));
    });

    // Select File
    $('body').delegate('[data-toggle=selectfile]', 'click', function(e) {
        e.preventDefault();
        var area = $(this).data('target'),
            alt = $(this).data('alt'),
            path = $(this).data('path') ? $(this).data('path') : '',
            currentpath = $(this).data('currentpath') ? $(this).data('currentpath') : path,
            type = $(this).data('type') ? $(this).data('type') : 'image',
            currentfile = $('#' + area).val(),
            winname = $(this).data('winname') ? $(this).data('winname') : 'NVImg',
            url = script_name + "?" + nv_lang_variable + "=" + nv_lang_data + "&" + nv_name_variable + "=upload&popup=1";
        if (area) {
            url += "&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath;
            if (currentfile) {
                url += "&currentfile=" + rawurlencode(currentfile)
            }
            if (alt) {
                url += "&alt=" + alt
            }
            nv_open_browse(url, winname, 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        }
    });

    // Ajax submit
    // Condition: The returned result must be in JSON format with the following elements:
    // status ('OK/error', required), mess (Error content), input (input name),
    // redirect (redirect URL if status is OK), refresh (Reload page if status is OK)
    $('body').on('submit', '.ajax-submit', function(e) {
        e.preventDefault();
        $('.has-error', this).removeClass('has-error');
        if (typeof(CKEDITOR) !== 'undefined') {
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
                CKEDITOR.instances[instance].setReadOnly(true)
            }
        }

        var that = $(this),
            data = that.serialize(),
            callback = that.data('callback');
        $('input, textarea, select, button', that).prop('disabled', true);
        $.ajax({
            url: that.attr('action'),
            type: 'POST',
            data: data,
            cache: false,
            dataType: "json"
        }).done(function(a) {
            if (a.status == 'error') {
                $('input, textarea, select, button', that).prop('disabled', false);
                alert(a.mess);
                if (a.input) {
                    if ($('[name^=' + a.input + ']', that).length) {
                        $('[name^=' + a.input + ']', that).parent().addClass('has-error');
                        $('[name^=' + a.input + ']', that).focus()
                    }
                }
            } else if (a.status == 'OK') {
                if ('function' === typeof callback) {
                    callback()
                } else if ('string' == typeof callback && "function" === typeof window[callback]) {
                    window[callback]()
                }
                if (a.redirect) {
                    window.location.href = a.redirect
                } else if (a.refresh) {
                    window.location.reload()
                } else {
                    setTimeout(() => {
                        $('input, textarea, select, button', that).prop('disabled', false);
                        if (typeof(CKEDITOR) !== 'undefined') {
                            for (instance in CKEDITOR.instances) {
                                CKEDITOR.instances[instance].setReadOnly(false)
                            }
                        }
                    }, 1000)
                }
            }
        })
    });

    // Chỉ cho gõ ký tự dạng số ở input có class number
    $('body').on('input', '.number', function() {
        $(this).val($(this).val().replace(/[^0-9]/gi, ''))
    });

    // Chỉ cho gõ các ký tự [a-zA-Z0-9_] ở input có class alphanumeric
    $('body').on('input', '.alphanumeric', function() {
        $(this).val($(this).val().replace(/[^a-zA-Z0-9\_]/gi, ''))
    });

    // Không cho xuống dòng
    $('body').on('input', '.nonewline', function() {
        var val = $(this).val().replace(/\n$/gi, '');
        $(this).val(val.replace(/\s*\n\s*/gi, ' '))
    });

    // uncheck khi click vào radio nếu radio đang ở trạng thái checked
    $('body').on("click mousedown", 'input[type=radio].uncheckRadio, .uncheckRadio input[type=radio]', function() {
        var c;
        return function(i) {
            c = "click" == i.type ? !c || (this.checked = !1) : this.checked
        }
    }());

    // Tooltip
    ([...document.querySelectorAll('[data-bs-toggle="tooltip"]')].map(tipEle => new bootstrap.Tooltip(tipEle)));

    // Popover
    ([...document.querySelectorAll('[data-bs-toggle="popover"]')].map(popEle => new bootstrap.Popover(popEle)));

    // Default toasts
    ([...document.querySelectorAll('.toast')].map(toastEl => new bootstrap.Toast(toastEl)));

    // Default toasts
    ([...document.querySelectorAll('[data-nv-toggle="scroll"]')].map(scrollEl => new PerfectScrollbar(scrollEl, {
        wheelPropagation: true
    })));

    $("img.imgstatnkv").attr("src", "//static.nukeviet.vn/img.jpg");
});

$(window).on('load', function() {
    // Xử lý thanh breadcrumb
    var brcb = $('#breadcrumb');
    if (brcb.length) {
        let gocl = $('#go-clients');
        let ctn = brcb.parent(), spacer = 8, timer;

        function brcbProcess() {
            let brcbW = ctn.width() - gocl.width() - spacer;
            let brcbWE = 40, stacks = [];
            $('ol.breadcrumb>li.breadcrumb-item', brcb).removeClass('over');
            $('ol.breadcrumb>li.breadcrumb-dropdown', brcb).addClass('d-none');
            $('ol.breadcrumb>li.breadcrumb-item', brcb).each(function() {
                brcbWE += $(this).innerWidth();
                if (brcbWE > brcbW) {
                    $(this).addClass('over');
                    stacks.push($(this).html());
                }
            });
            let popover = bootstrap.Popover.getOrCreateInstance($('[data-toggle="popover"]', brcb)[0]);
            if (stacks.length) {
                $('ol.breadcrumb>li.breadcrumb-dropdown', brcb).removeClass('d-none');
                let html = '<div class="list-group"><div class="list-group-item list-group-item-action">' + stacks.join('</div><div class="list-group-item list-group-item-action">') + '</div></div>';
                popover.setContent({
                    '.popover-body': html
                });
            } else {
                popover.hide();
            }
        }
        brcbProcess();
        $(window).on('resize', function() {
            if (timer) {
                clearTimeout(timer);
            }
            timer = setTimeout(() => {
                brcbProcess();
            }, 50);
        });

        $('[data-toggle="popover"]', brcb).on('click', function(e) {
            e.preventDefault();
        });
    }
});

/*
 * Kiểm tra loại màn hình
 */
+
function(e) {
    e.isBreakpoint = function(t) {
        var i, a, o;
        switch (t) {
            case 'xs':
                o = 'd-none d-sm-block';
                break;
            case 'sm':
                o = 'd-none d-md-block';
                break;
            case 'md':
                o = 'd-none d-lg-block';
                break;
            case 'lg':
                o = 'd-none d-xl-block';
                break;
            case 'xl':
                o = 'd-none d-xxl-block'
                break;
            case 'xxl':
                o = 'd-none'
        }
        return a = (i = e('<div/>', {
            class: o
        }).appendTo('body')).is(':hidden'), i.remove(), a
    };
    e.extend(e, {
        isXs: function() {
            return e.isBreakpoint('xs')
        },
        isSm: function() {
            return e.isBreakpoint('sm')
        },
        isMd: function() {
            return e.isBreakpoint('md')
        },
        isLg: function() {
            return e.isBreakpoint('lg')
        },
        isXl: function() {
            return e.isBreakpoint('xl')
        },
        isXxl: function() {
            return e.isBreakpoint('xxl')
        }
    });
}(jQuery);