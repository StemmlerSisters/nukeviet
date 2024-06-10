<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_AUTHORS')) {
    exit('Stop!!!');
}

if (!defined('NV_IS_SPADMIN')) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

$admin_id = $nv_Request->get_int('admin_id', 'get', 0);

if (empty($admin_id) or $admin_id == $admin_info['admin_id']) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

$sql = 'SELECT * FROM ' . NV_AUTHORS_GLOBALTABLE . ' WHERE admin_id=' . $admin_id;
$row = $db->query($sql)->fetch();
if (empty($row)) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

if ($row['lev'] == 1 or (!defined('NV_IS_GODADMIN') and $row['lev'] == 2)) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

/**
 * @param string $adminpass
 * @return bool
 */
function nv_checkAdmpass($adminpass)
{
    global $db, $admin_info, $crypt;

    $sql = 'SELECT password FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $admin_info['userid'];
    $pass = $db->query($sql)->fetchColumn();

    return $crypt->validate_password($adminpass, $pass);
}

$access_admin = $db->query('SELECT content FROM ' . NV_USERS_GLOBALTABLE . "_config WHERE config='access_admin'")->fetchColumn();
$access_admin = unserialize($access_admin);
$level = $admin_info['level'];

$array_action_account = [];
$array_action_account[0] = $nv_Lang->getModule('action_account_nochange');
if (isset($access_admin['access_waiting'][$level]) and $access_admin['access_waiting'][$level] == 1) {
    $array_action_account[1] = $nv_Lang->getModule('action_account_suspend');
}
if (isset($access_admin['access_delus'][$level]) and $access_admin['access_delus'][$level] == 1) {
    $array_action_account[2] = $nv_Lang->getModule('action_account_del');
}

$sql = 'SELECT * FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $admin_id;
$row_user = $db->query($sql)->fetch();

$action_account = $nv_Request->get_int('action_account', 'post', 0);
$action_account = (isset($array_action_account[$action_account])) ? $action_account : 0;
$error = '';
$checkss = md5(NV_CHECK_SESSION . '_' . $module_name . '_' . $op . '_' . $admin_id);
if ($nv_Request->get_title('checkss', 'post') == $checkss) {
    $sendmail = $nv_Request->get_int('sendmail', 'post', 0);
    $reason = $nv_Request->get_title('reason', 'post', '', 1);
    $adminpass = $nv_Request->get_title('adminpass_iavim', 'post');

    if (empty($adminpass)) {
        $error = $nv_Lang->getGlobal('admin_password_empty');
    } elseif (!nv_checkAdmpass($adminpass)) {
        $error = $nv_Lang->getGlobal('adminpassincorrect', $adminpass);
        $adminpass = '';
    } else {
        if ($row['lev'] == 3) {
            foreach ($global_config['setup_langs'] as $l) {
                $is_delCache = false;
                $_site_mods = nv_site_mods($l);
                $array_keys = array_keys($_site_mods);
                foreach ($array_keys as $mod) {
                    if (!empty($mod)) {
                        if (!empty($_site_mods[$mod]['admins'])) {
                            $admins = array_map('intval', explode(',', $_site_mods[$mod]['admins']));
                            if (in_array($admin_id, $admins, true)) {
                                $admins = array_diff($admins, [$admin_id]);
                                $admins = implode(',', $admins);

                                $sth = $db->prepare('UPDATE ' . $db_config['prefix'] . '_' . $l . '_modules SET admins= :admins WHERE title= :mod');
                                $sth->bindParam(':admins', $admins, PDO::PARAM_STR);
                                $sth->bindParam(':mod', $mod, PDO::PARAM_STR);
                                $sth->execute();

                                $is_delCache = true;
                            }
                        }
                    }
                }
                if ($is_delCache) {
                    $nv_Cache->delMod('modules', $l);
                }
            }
        }

        $db->query('DELETE FROM ' . NV_AUTHORS_GLOBALTABLE . ' WHERE admin_id = ' . $admin_id);

        if ($action_account == 1) {
            $db->query('UPDATE ' . NV_USERS_GLOBALTABLE . ' SET active=0 WHERE userid=' . $admin_id);
        } elseif ($action_account == 2) {
            try {
                $db->query('UPDATE ' . NV_GROUPS_GLOBALTABLE . ' SET numbers = numbers-1 WHERE group_id IN (SELECT group_id FROM ' . NV_GROUPS_GLOBALTABLE . '_users WHERE userid=' . $admin_id . ' AND approved = 1)');
            } catch (PDOException $e) {
                trigger_error(print_r($e, true));
            }
            $db->query('DELETE FROM ' . NV_GROUPS_GLOBALTABLE . '_users WHERE userid=' . $admin_id);
            $db->query('DELETE FROM ' . NV_USERS_GLOBALTABLE . '_openid WHERE userid=' . $admin_id);
            $db->query('DELETE FROM ' . NV_USERS_GLOBALTABLE . '_info WHERE userid=' . $admin_id);
            $db->query('DELETE FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $admin_id);
            if (!empty($row_user['photo']) and is_file(NV_ROOTDIR . '/' . $row_user['photo'])) {
                @nv_deletefile(NV_ROOTDIR . '/' . $row_user['photo']);
            }
            // Xóa API
            $db->query('DELETE FROM ' . $db_config['prefix'] . '_api_role_credential WHERE userid=' . $admin_id);
        }

        if ($action_account != 2) {
            // Xóa API cho admin
            $db->sqlreset()
                ->select('COUNT(*)')
                ->from($db_config['prefix'] . '_api_role_credential tb1')
                ->join('INNER JOIN ' . $db_config['prefix'] . '_api_role tb2 ON (tb2.role_id =tb1.role_id)')
                ->where('tb1.userid = ' . $admin_id . " AND tb2.role_object='admin'");
            $count = $db->query($db->sql())
                ->fetchColumn();
            if ($count) {
                $db->select('tb1.id');
                $result = $db->query($db->sql());
                $credential_ids = [];
                while ($row = $result->fetch()) {
                    $credential_ids[] = $row['id'];
                }

                $credential_ids = implode(', ', $credential_ids);
                $db->query('DELETE FROM ' . $db_config['prefix'] . '_api_role_credential WHERE id IN (' . $credential_ids . ') AND userid=' . $admin_id);
            }

            nv_groups_del_user($row['lev'], $admin_id);

            // Cập nhật lại nhóm nếu không xóa tài khoản
            if ($row_user['group_id'] == $row['lev']) {
                // Nếu nhóm mặc định là quản trị này thì chuyển về thành viên chính thức
                $row_user['group_id'] = 4;
            }
            $row_user['in_groups'] = explode(',', $row_user['in_groups']);
            $row_user['in_groups'] = array_diff($row_user['in_groups'], [$row['lev']]);
            $row_user['in_groups'] = array_filter(array_unique(array_map('trim', $row_user['in_groups'])));
            $row_user['in_groups'] = empty($row_user['in_groups']) ? '' : implode(',', $row_user['in_groups']);

            $sql = 'UPDATE ' . NV_USERS_GLOBALTABLE . ' SET group_id=' . $row_user['group_id'] . ', in_groups=' . $db->quote($row_user['in_groups']) . ' WHERE userid=' . $admin_id;
            $db->query($sql);
        }
        nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('nv_admin_del'), 'Username: ' . $row_user['username'] . ', ' . $array_action_account[$action_account], $admin_info['userid']);

        $db->query('OPTIMIZE TABLE ' . NV_AUTHORS_GLOBALTABLE);

        if ($sendmail) {
            $maillang = NV_LANG_INTERFACE;
            if (!empty($row_user['language']) and in_array($row_user['language'], $global_config['setup_langs'], true)) {
                if ($row_user['language'] != NV_LANG_INTERFACE) {
                    $maillang = $row_user['language'];
                }
            } elseif (NV_LANG_DATA != NV_LANG_INTERFACE) {
                $maillang = NV_LANG_DATA;
            }

            $send_data = [[
                'to' => $row_user['email'],
                'data' => [
                    'lang' => $maillang,
                    'time' => NV_CURRENTTIME,
                    'note' => $reason,
                    'email' => $admin_info['view_mail'] ? $admin_info['email'] : $global_config['site_email'],
                    'sig' => (!empty($admin_info['sig']) ? $admin_info['sig'] : 'All the best'),
                    'position' => $admin_info['position'],
                    'username' => $admin_info['username']
                ]
            ]];
            $send = nv_sendmail_from_template(NukeViet\Template\Email\Tpl::E_AUTHOR_DELETE, $send_data, $maillang);
            if (!$send) {
                $page_title = $nv_Lang->getGlobal('error_info_caption');

                include NV_ROOTDIR . '/includes/header.php';
                echo nv_admin_theme($nv_Lang->getGlobal('error_sendmail_admin') . '<meta http-equiv="refresh" content="10;URL=' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '" />');
                include NV_ROOTDIR . '/includes/footer.php';
            }
        }
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
    }
} else {
    $sendmail = 1;
    $reason = $adminpass = '';
}

$contents = [];
$contents['is_error'] = (!empty($error)) ? 1 : 0;
$contents['title'] = (!empty($error)) ? $error : $nv_Lang->getModule('delete_sendmail_info', $row_user['username']);
$contents['action'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=del&amp;admin_id=' . $admin_id;
$contents['sendmail'] = $sendmail;
$contents['admin_password'] = [$nv_Lang->getGlobal('admin_password'), $adminpass];

$page_title = $nv_Lang->getModule('nv_admin_del');

// Parse content
$xtpl = new XTemplate('del.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);

$class = $contents['is_error'] ? 'class="alert alert-danger"' : 'class="alert alert-info"';

$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('CHECKSS', $checkss);

$xtpl->assign('CLASS', $contents['is_error'] ? 'class="alert alert-danger"' : 'class="alert alert-info"');
$xtpl->assign('TITLE', $contents['title']);
$xtpl->assign('ACTION', $contents['action']);
$xtpl->assign('CHECKED', $contents['sendmail'] ? ' checked="checked"' : '');

$xtpl->assign('REASON', $reason);

$xtpl->assign('ADMIN_PASSWORD0', $contents['admin_password'][0]);
$xtpl->assign('ADMIN_PASSWORD1', $contents['admin_password'][1]);
foreach ($array_action_account as $key => $value) {
    $xtpl->assign('ACTION_ACCOUNT_KEY', $key);
    $xtpl->assign('ACTION_ACCOUNT_CHECK', ($key == $action_account) ? ' checked="checked"' : '');
    $xtpl->assign('ACTION_ACCOUNT_TITLE', $value);
    $xtpl->parse('del.action_account');
}

$xtpl->parse('del');
$contents = $xtpl->text('del');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';