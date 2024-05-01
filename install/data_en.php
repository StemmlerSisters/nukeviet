<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

$install_lang['modules'] = [];
$install_lang['modules']['about'] = 'About';
$install_lang['modules']['about_for_acp'] = '';
$install_lang['modules']['news'] = 'News';
$install_lang['modules']['news_for_acp'] = '';
$install_lang['modules']['users'] = 'Users';
$install_lang['modules']['users_for_acp'] = 'Users';
$install_lang['modules']['myapi'] = 'My APIs';
$install_lang['modules']['myapi_for_acp'] = '';
$install_lang['modules']['inform'] = 'Notification';
$install_lang['modules']['inform_for_acp'] = '';
$install_lang['modules']['contact'] = 'Contact';
$install_lang['modules']['contact_for_acp'] = '';
$install_lang['modules']['statistics'] = 'Statistics';
$install_lang['modules']['statistics_for_acp'] = '';
$install_lang['modules']['voting'] = 'Voting';
$install_lang['modules']['voting_for_acp'] = '';
$install_lang['modules']['banners'] = 'Banners';
$install_lang['modules']['banners_for_acp'] = '';
$install_lang['modules']['seek'] = 'Search';
$install_lang['modules']['seek_for_acp'] = '';
$install_lang['modules']['menu'] = 'Navigation Bar';
$install_lang['modules']['menu_for_acp'] = '';
$install_lang['modules']['comment'] = 'Comment';
$install_lang['modules']['comment_for_acp'] = '';
$install_lang['modules']['siteterms'] = 'Terms & Conditions';
$install_lang['modules']['siteterms_for_acp'] = '';
$install_lang['modules']['feeds'] = 'RSS-feeds';
$install_lang['modules']['Page'] = 'Page';
$install_lang['modules']['Page_for_acp'] = '';
$install_lang['modules']['freecontent'] = 'Introduction';
$install_lang['modules']['freecontent_for_acp'] = '';
$install_lang['modules']['two_step_verification'] = '2-Step Verification';
$install_lang['modules']['two_step_verification_for_acp'] = '';

$install_lang['modfuncs'] = [];
$install_lang['modfuncs']['users'] = [];
$install_lang['modfuncs']['users']['login'] = 'Login';
$install_lang['modfuncs']['users']['register'] = 'Register';
$install_lang['modfuncs']['users']['lostpass'] = 'Password recovery';
$install_lang['modfuncs']['users']['lostactivelink'] = 'Retrieve activation link';
$install_lang['modfuncs']['users']['r2s'] = 'Turn off 2-step authentication';
$install_lang['modfuncs']['users']['active'] = 'Active account';
$install_lang['modfuncs']['users']['editinfo'] = 'Account Settings';
$install_lang['modfuncs']['users']['memberlist'] = 'Members list';
$install_lang['modfuncs']['users']['logout'] = 'Logout';
$install_lang['modfuncs']['users']['groups'] = 'Group management';

$install_lang['modfuncs']['statistics'] = [];
$install_lang['modfuncs']['statistics']['allreferers'] = 'By referrers';
$install_lang['modfuncs']['statistics']['allcountries'] = 'By countries';
$install_lang['modfuncs']['statistics']['allbrowsers'] = 'By browsers ';
$install_lang['modfuncs']['statistics']['allos'] = 'By operating system';
$install_lang['modfuncs']['statistics']['allbots'] = 'By search engines';
$install_lang['modfuncs']['statistics']['referer'] = 'By month';

$install_lang['blocks_groups'] = [];
$install_lang['blocks_groups']['news'] = [];
$install_lang['blocks_groups']['news']['module.block_newscenter'] = 'Breaking news';
$install_lang['blocks_groups']['news']['global.block_category'] = 'Category';
$install_lang['blocks_groups']['news']['global.block_tophits'] = 'Top Hits';
$install_lang['blocks_groups']['banners'] = [];
$install_lang['blocks_groups']['banners']['global.banners1'] = 'Center Banner';
$install_lang['blocks_groups']['banners']['global.banners2'] = 'Left Banner';
$install_lang['blocks_groups']['banners']['global.banners3'] = 'Right Banner';
$install_lang['blocks_groups']['statistics'] = [];
$install_lang['blocks_groups']['statistics']['global.counter'] = 'Statistics';
$install_lang['blocks_groups']['about'] = [];
$install_lang['blocks_groups']['about']['global.about'] = 'About';
$install_lang['blocks_groups']['voting'] = [];
$install_lang['blocks_groups']['voting']['global.voting_random'] = 'Voting';
$install_lang['blocks_groups']['inform'] = [];
$install_lang['blocks_groups']['inform']['global.inform'] = 'Notification';
$install_lang['blocks_groups']['users'] = [];
$install_lang['blocks_groups']['users']['global.user_button'] = 'Member login';
$install_lang['blocks_groups']['theme'] = [];
$install_lang['blocks_groups']['theme']['global.company_info'] = 'Managing company';
$install_lang['blocks_groups']['theme']['global.menu_footer'] = 'Main categories';
$install_lang['blocks_groups']['freecontent'] = [];
$install_lang['blocks_groups']['freecontent']['global.free_content'] = 'Introduction';

$install_lang['cron'] = [];
$install_lang['cron']['cron_online_expired_del'] = 'Delete expired online status';
$install_lang['cron']['cron_dump_autobackup'] = 'Automatic backup database';
$install_lang['cron']['cron_auto_del_temp_download'] = 'Empty temporary files';
$install_lang['cron']['cron_del_ip_logs'] = 'Delete IP log files';
$install_lang['cron']['cron_auto_del_error_log'] = 'Delete expired error_log log files';
$install_lang['cron']['cron_auto_sendmail_error_log'] = 'Send error logs to admin';
$install_lang['cron']['cron_ref_expired_del'] = 'Delete expired referer';
$install_lang['cron']['cron_auto_check_version'] = 'Check NukeViet version';
$install_lang['cron']['cron_notification_autodel'] = 'Delete old notification';
$install_lang['cron']['cron_remove_expired_inform'] = 'Remove expired notifications';
$install_lang['cron']['cron_apilogs_autodel'] = 'Remove expired API-logs';
$install_lang['cron']['cron_expadmin_handling'] = 'Handling expired admins';

$install_lang['groups']['NukeViet-Fans'] = 'NukeViet-Fans';
$install_lang['groups']['NukeViet-Admins'] = 'NukeViet-Admins';
$install_lang['groups']['NukeViet-Programmers'] = 'NukeViet-Programmers';

$install_lang['groups']['NukeViet-Fans-desc'] = 'NukeViet System Fans Group';
$install_lang['groups']['NukeViet-Admins-desc'] = 'Group of administrators for sites built by the NukeViet system';
$install_lang['groups']['NukeViet-Programmers-desc'] = 'NukeViet System Programmers Group';

$install_lang['vinades_fullname'] = 'Vietnam Open Source Development Joint Stock Company';
$install_lang['vinades_address'] = '6th floor, Song Da building, No. 131 Tran Phu street, Van Quan ward, Ha Dong district, Hanoi city, Vietnam';
$install_lang['nukeviet_description'] = 'Sharing success, connect passions';
$install_lang['disable_site_content'] = 'For technical reasons Web site temporary not available. we are very sorry for that inconvenience!';

// Ngôn ngữ dữ liệu cho phần mẫu email
use NukeViet\Template\Email\Cat as EmailCat;
use NukeViet\Template\Email\Tpl as EmailTpl;

$install_lang['emailtemplates'] = [];
$install_lang['emailtemplates']['cats'] = [];
$install_lang['emailtemplates']['cats'][EmailCat::CAT_SYSTEM] = 'System Messages';
$install_lang['emailtemplates']['cats'][EmailCat::CAT_USER] = 'User Messages';
$install_lang['emailtemplates']['cats'][EmailCat::CAT_AUTHOR] = 'Admin Messages';
$install_lang['emailtemplates']['cats'][EmailCat::CAT_MODULE] = 'Module Messages';

$install_lang['emailtemplates']['emails'] = [];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_EMAIL_ACTIVE] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Account activation via email',
    's' => 'Activate information',
    'c' => '{$greeting_user}<br /><br />Your account at website {$site_name} waitting to activate. To activate, please click link follow:<br /><br />URL: <a href="{$active_link}">{$active_link}</a><br /><br />Account information:<br /><br />Username: {$username}<br />Email: {$email}<br /><br />Activate expired on {$active_deadline}<br /><br />This is email automatic sending from website {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_DELETE] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Email notification to delete account',
    's' => 'Email notification to delete account',
    'c' => '{$greeting_user}<br /><br />We are so sorry to delete your account at website {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_NEW_2STEP_CODE] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Send new backup code',
    's' => 'New backup code',
    'c' => '{$greeting_user}<br /><br /> backup code to your account at the website {$site_name} has been changed. Here is a new backup code: <br /><br />{foreach from=$new_code item=code}{$code}<br />{/foreach}<br />You keep your backup safe. If you lose your phone and lose your backup code, you will no longer be able to access your account.<br /><br />This is an automated message sent to your e-mail from website {$site_name}. If you do not understand the content of this letter, simply delete it.'
];

$menu_rows_lev0['about'] = [
    'title' => $install_lang['modules']['about'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=about',
    'groups_view' => '6',
    'op' => ''
];
$menu_rows_lev0['news'] = [
    'title' => $install_lang['modules']['news'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=news',
    'groups_view' => '6',
    'op' => ''
];
$menu_rows_lev0['users'] = [
    'title' => $install_lang['modules']['users'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=users',
    'groups_view' => '6',
    'op' => ''
];
$menu_rows_lev0['voting'] = [
    'title' => $install_lang['modules']['voting'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=voting',
    'groups_view' => '6',
    'op' => ''
];
$menu_rows_lev0['contact'] = [
    'title' => $install_lang['modules']['contact'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=contact',
    'groups_view' => '6',
    'op' => ''
];

$menu_rows_lev1['users'] = [];
$menu_rows_lev1['users'][] = [
    'title' => $install_lang['modfuncs']['users']['login'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=users&op=login',
    'groups_view' => '5',
    'op' => 'login'
];
$menu_rows_lev1['users'][] = [
    'title' => $install_lang['modfuncs']['users']['register'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=users&op=register',
    'groups_view' => '5',
    'op' => 'register'
];
$menu_rows_lev1['users'][] = [
    'title' => $install_lang['modfuncs']['users']['lostpass'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=users&op=lostpass',
    'groups_view' => '5',
    'op' => 'lostpass'
];
$menu_rows_lev1['users'][] = [
    'title' => $install_lang['modfuncs']['users']['editinfo'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=users&op=editinfo',
    'groups_view' => '4,7',
    'op' => 'editinfo'
];
$menu_rows_lev1['users'][] = [
    'title' => $install_lang['modfuncs']['users']['memberlist'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=users&op=memberlist',
    'groups_view' => '4,7',
    'op' => 'memberlist'
];
$menu_rows_lev1['users'][] = [
    'title' => $install_lang['modfuncs']['users']['logout'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=users&op=logout',
    'groups_view' => '4,7',
    'op' => 'logout'
];
