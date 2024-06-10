<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_SITEINFO')) {
    exit('Stop!!!');
}

$widget_info = [
    'id' => 'cmttotal',
    'name' => $nv_Lang->getModule('siteinfo_all'),
    'note' => '',
    'func' => function () {
        global $global_config, $module_file, $module_name, $module_data, $nv_Lang, $db, $nv_Cache;

        $template = get_tpl_dir([$global_config['module_theme'], $global_config['admin_theme']], 'admin_default', '/modules/' . $module_file . '/widget_contacttotal.tpl');
        $tpl = new \NukeViet\Template\NVSmarty();
        $tpl->setTemplateDir(NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_file);
        $tpl->assign('LANG', $nv_Lang);

        $_arr_siteinfo = [];
        $cacheFile = 'widget_contacttotal_' . NV_CACHE_PREFIX . '.cache';
        $cacheTTL = 1800;

        if (($cache = $nv_Cache->getItem($module_name, $cacheFile, $cacheTTL)) != false) {
            $_arr_siteinfo = unserialize($cache);
        } else {
            $_arr_siteinfo['total_contacts'] = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_send')->fetchColumn();

            $nv_Cache->setItem($module_name, $cacheFile, serialize($_arr_siteinfo), $cacheTTL);
        }

        $tpl->assign('NUM', number_format($_arr_siteinfo['total_contacts']));

        return $tpl->fetch('widget_contacttotal.tpl');
    }
];