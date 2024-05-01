<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$userid = $nv_Request->get_int('userid', 'get', 0);

$sql = 'SELECT * FROM ' . NV_MOD_TABLE . ' WHERE userid=' . $userid;
$row = $db->query($sql)->fetch();
if (empty($row)) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

$page_title = $nv_Lang->getModule('user_2step_of') . ' ' . $row['username'];

$allow = false;

$sql = 'SELECT lev FROM ' . NV_AUTHORS_GLOBALTABLE . ' WHERE admin_id=' . $userid;
$rowlev = $db->query($sql)->fetch();
if (empty($rowlev)) {
    $allow = true;
} else {
    if ($admin_info['admin_id'] == $userid or $admin_info['level'] < $rowlev['lev']) {
        $allow = true;
    }
}

if ($global_config['idsite'] > 0 and $row['idsite'] != $global_config['idsite'] and $admin_info['admin_id'] != $userid) {
    $allow = false;
}

if (!$allow) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

if ($admin_info['admin_id'] == $userid and $admin_info['safemode'] == 1) {
    $xtpl = new XTemplate('user_safemode.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('SAFEMODE_DEACT', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=users&amp;' . NV_OP_VARIABLE . '=editinfo/safeshow');
    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
    exit();
}

// Thêm vào menutop
$select_options[NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=edit&amp;userid=' . $row['userid']] = $nv_Lang->getModule('edit_title');
$select_options[NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=edit_oauth&amp;userid=' . $row['userid']] = $nv_Lang->getModule('user_openid_mamager');

$xtpl = new XTemplate('user_2step.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('FORM_ACTION', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;userid=' . $row['userid']);

if (empty($row['active2step'])) {
    $xtpl->parse('turnoff');
    $contents = $xtpl->text('turnoff');
} else {
    if (!empty($global_config['two_step_verification'])) {
        $xtpl->parse('main.turnoff_info');
    }

    // Tắt xác thực hai bước
    if ($nv_Request->isset_request('turnoff2step', 'post')) {
        $db->query('DELETE FROM ' . NV_MOD_TABLE . '_backupcodes WHERE userid=' . $row['userid']);
        $db->query('UPDATE ' . NV_MOD_TABLE . " SET active2step=0, secretkey='', last_update=" . NV_CURRENTTIME . ' WHERE userid=' . $row['userid']);
        nv_delete_notification(NV_LANG_DATA, $module_name, 'remove_2step_request', $row['userid']);

        // Gửi email thông báo
        if (!empty($global_users_config['admin_email'])) {
            $maillang = '';
            if (!empty($row['language']) and in_array($row['language'], $global_config['setup_langs'], true)) {
                if ($row['language'] != NV_LANG_INTERFACE) {
                    $maillang = $row['language'];
                }
            } elseif (NV_LANG_DATA != NV_LANG_INTERFACE) {
                $maillang = NV_LANG_DATA;
            }

            $url = urlRewriteWithDomain(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . NV_2STEP_VERIFICATION_MODULE, NV_MY_DOMAIN);
            $gconfigs = [
                'site_name' => $global_config['site_name'],
                'site_email' => $global_config['site_email']
            ];
            if (!empty($maillang)) {
                $in = "'" . implode("', '", array_keys($gconfigs)) . "'";
                $result = $db->query('SELECT config_name, config_value FROM ' . NV_CONFIG_GLOBALTABLE . " WHERE lang='" . $maillang . "' AND module='global' AND config_name IN (" . $in . ')');
                while ($row = $result->fetch()) {
                    $gconfigs[$row['config_name']] = $row['config_value'];
                }

                $nv_Lang->loadFile(NV_ROOTDIR . '/modules/' . $module_file . '/language/' . $maillang . '.php', true);

                $mail_subject = $nv_Lang->getModule('security_alert');
                $mail_message = $nv_Lang->getModule('security_alert_2stepoff', $row['username'], $url);

                $nv_Lang->changeLang();
            } else {
                $mail_subject = $nv_Lang->getModule('security_alert');
                $mail_message = $nv_Lang->getModule('security_alert_2stepoff', $row['username'], $url);
            }

            nv_sendmail_async([
                $global_config['site_name'],
                $global_config['site_email']
            ], $row['email'], $mail_subject, $mail_message, '', false, false, [], [], true, [], $maillang);
        }

        nv_insert_logs(NV_LANG_DATA, $module_name, 'log_turnoff_user2step', 'userid ' . $row['userid'], $admin_info['userid']);
        $nv_Cache->delMod($module_name);

        header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&userid=' . $row['userid']);
        exit();
    }

    // Tạo lại mã dự phòng
    if ($nv_Request->isset_request('resetbackupcodes', 'post')) {
        $db->query('DELETE FROM ' . NV_MOD_TABLE . '_backupcodes WHERE userid=' . $row['userid']);

        $new_code = [];
        while (sizeof($new_code) < 10) {
            $code = nv_strtolower(nv_genpass(8, 0));
            if (!in_array($code, $new_code, true)) {
                $new_code[] = $code;
            }
        }

        foreach ($new_code as $code) {
            $db->query('INSERT INTO ' . NV_MOD_TABLE . '_backupcodes (userid, code, is_used, time_used, time_creat) VALUES (
            ' . $row['userid'] . ', ' . $db->quote($code) . ', 0, 0, ' . NV_CURRENTTIME . ')');
        }

        if ($nv_Request->get_int('sendmail', 'post', 0) == 1) {
            $maillang = '';
            if (!empty($row['language']) and in_array($row['language'], $global_config['setup_langs'], true)) {
                if ($row['language'] != NV_LANG_INTERFACE) {
                    $maillang = $row['language'];
                }
            } elseif (NV_LANG_DATA != NV_LANG_INTERFACE) {
                $maillang = NV_LANG_DATA;
            }

            $send_data = [[
                'to' => $row['email'],
                'data' => [
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'username' => $row['username'],
                    'email' => $row['email'],
                    'gender' => $row['gender'],
                    'new_code' => $new_code,
                    'lang' => $maillang
                ]
            ]];
            nv_sendmail_template_async(NukeViet\Template\Email\Tpl::E_USER_NEW_2STEP_CODE, $send_data, '', $maillang);
        }

        nv_insert_logs(NV_LANG_DATA, $module_name, 'log_reset_user2step_codes', 'userid ' . $row['userid'], $admin_info['userid']);
        $nv_Cache->delMod($module_name);
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&userid=' . $row['userid']);
    }

    $sql = 'SELECT * FROM ' . NV_MOD_TABLE . '_backupcodes WHERE userid=' . $row['userid'];
    $result = $db->query($sql);
    while ($code = $result->fetch()) {
        $code['status'] = $nv_Lang->getModule('user_2step_codes_s' . $code['is_used']);
        $code['time_creat'] = $code['time_creat'] ? nv_date('H:i:s d/m/Y', $code['time_creat']) : '';
        $code['time_used'] = $code['time_used'] ? nv_date('H:i:s d/m/Y', $code['time_used']) : '';
        $xtpl->assign('CODE', $code);
        $xtpl->parse('main.code');
    }

    $xtpl->parse('main');
    $contents = $xtpl->text('main');
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
