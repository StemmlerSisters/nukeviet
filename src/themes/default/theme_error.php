<?php

/**
 * NUKEVIET Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

function nv_error_theme($page_title, $info_title, $info_content, $error_code, $admin_link, $admin_title, $site_link, $site_title, $template)
{
    global $global_config, $nv_Lang;

    if (!file_exists(NV_ROOTDIR . '/themes/' . $template . '/system/info_die.tpl')) {
        trigger_error('Error template!!!', 256);
    }

    $xtpl = new XTemplate('info_die.tpl', NV_ROOTDIR . '/themes/' . $template . '/system');
    $xtpl->assign('SITE_CHARSET', $global_config['site_charset']);
    $xtpl->assign('PAGE_TITLE', $page_title);
    $xtpl->assign('HOME_LINK', $global_config['site_url']);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_global);
    $xtpl->assign('TEMPLATE', $template);
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);

    // Có trường hợp !isset site_name
    $xtpl->assign('SITE_NAME', empty($global_config['site_name']) ? '' : $global_config['site_name']);

    $site_favicon = NV_BASE_SITEURL . 'favicon.ico';
    if (!empty($global_config['site_favicon']) and file_exists(NV_ROOTDIR . '/' . $global_config['site_favicon'])) {
        $site_favicon = NV_BASE_SITEURL . $global_config['site_favicon'];
    }
    $xtpl->assign('SITE_FAVICON', $site_favicon);

    if (!empty($global_config['site_logo'])) {
        $xtpl->assign('LOGO', NV_BASE_SITEURL . $global_config['site_logo']);
        $xtpl->parse('main.logo');
    }

    $xtpl->assign('INFO_TITLE', $info_title);
    $xtpl->assign('INFO_CONTENT', $info_content);

    if (defined('NV_IS_ADMIN') and !empty($admin_link)) {
        $xtpl->assign('ADMIN_LINK', $admin_link);
        $xtpl->assign('GO_ADMINPAGE', empty($admin_title) ? $nv_Lang->getGlobal('admin_page') : $admin_title);
        $xtpl->parse('main.adminlink');
    }
    if (!empty($site_link)) {
        $xtpl->assign('SITE_LINK', $site_link);
        $xtpl->assign('GO_SITEPAGE', empty($site_title) ? $nv_Lang->getGlobal('go_homepage') : $site_title);
        $xtpl->parse('main.sitelink');
    }

    $xtpl->parse('main');

    return $xtpl->text('main');
}
