<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

$lang_translator['author'] = 'VINADES.,JSC <contact@vinades.vn>';
$lang_translator['createdate'] = '04/03/2010, 15:22';
$lang_translator['copyright'] = '@Copyright (C) 2009-2021 VINADES.,JSC. All rights reserved';
$lang_translator['info'] = '';
$lang_translator['langtype'] = 'lang_module';

$lang_module['departments'] = 'List of departments';
$lang_module['department_no_home'] = 'Not shown in the main page module';
$lang_module['alias'] = 'Alias';
$lang_module['image'] = 'Image';
$lang_module['error_alias'] = 'Error: no static links';
$lang_module['duplicate_alias'] = 'Error: title or static link exists';
$lang_module['number'] = 'Number';
$lang_module['err_row_title'] = 'Not exists';
$lang_module['part_row_title'] = 'Department';
$lang_module['email_row_title'] = 'Email';
$lang_module['address'] = 'Address';
$lang_module['note_row_title'] = 'Description';
$lang_module['bt_save_row_title'] = 'Save';
$lang_module['bt_reset_row_title'] = 'Clear';
$lang_module['err_part_row_title'] = 'Department name missing';
$lang_module['err_email_row_title'] = 'Invalid email';
$lang_module['page_row_title'] = 'Page';
$lang_module['bt_del_row_title'] = 'Delete';
$lang_module['bt_edit_row_title'] = 'Edit';
$lang_module['bt_view_row_title'] = 'View';
$lang_module['tt1_row_title'] = 'Not reply';
$lang_module['tt2_row_title'] = 'Replied';
$lang_module['quesion_row_title'] = 'Do you want to delete';
$lang_module['send_suc_send_title'] = 'Email has been sent successfully.';
$lang_module['send_err_send_title'] = 'failed to send mail';
$lang_module['send_title'] = 'Reply';
$lang_module['back_title'] = 'Back';
$lang_module['infor_user_send_title'] = 'Sender information';
$lang_module['reply_user_send_title'] = 'Reply to';
$lang_module['reply_user_title'] = 'Subject';
$lang_module['name_user_send_title'] = 'Sender';
$lang_module['title_send_title'] = 'Subject';
$lang_module['send_time'] = 'Send time';
$lang_module['status_send_title'] = 'Status';
$lang_module['content'] = 'Content';
$lang_module['content_title'] = 'Content title';
$lang_module['save'] = 'Save';
$lang_module['errorsave'] = 'Failed to update content. Please check title';
$lang_module['error_content'] = 'Error: Empty content';
$lang_module['error_title'] = 'Error: Empty title';
$lang_module['saveok'] = 'Successfully updated';
$lang_module['list_admin_row_title'] = 'Admin list';
$lang_module['name_admin_row_title'] = 'Full name';
$lang_module['username_admin_row_title'] = 'User name';
$lang_module['bt_send_row_title'] = 'Send';
$lang_module['no_content_send_title'] = 'Error: Content empty';
$lang_module['admin_view_level'] = 'View feedback';
$lang_module['admin_reply_level'] = 'Right to reply to feedback';
$lang_module['admin_obt_level'] = 'Right to receive feedback';
$lang_module['admin_exec_level'] = 'Right to execute';
$lang_module['delall'] = 'Delete all';
$lang_module['siteinfo_new'] = 'Unread contact';
$lang_module['no_row_contact'] = 'Any Contact';
$lang_module['url_for_iframe'] = 'Url for iframe';
$lang_module['supporter'] = 'Supporter';
$lang_module['supporter_add'] = 'Add Supporter';
$lang_module['supporter_edit'] = 'Edit Supporter';
$lang_module['supporter_contact_add'] = 'Add information';
$lang_module['add'] = 'Add';
$lang_module['active'] = 'Active';
$lang_module['full_name'] = 'Full name';
$lang_module['notification_contact_new'] = '<strong />%s mailing contact title<strong />%s';
$lang_module['is_default'] = 'Default';
$lang_module['otherContacts'] = 'Other contact';
$lang_module['otherVar'] = 'Name';
$lang_module['otherVal'] = 'Value';
$lang_module['addNew'] = 'Add new';
$lang_module['cats'] = 'Related categories';
$lang_module['cat'] = 'Category';
$lang_module['mark_as_unread'] = 'Mark as unread';
$lang_module['mark_as_read'] = 'Mark as read';
$lang_module['mark_as_forward'] = 'Forward';
$lang_module['please_choose'] = 'Please choose at least one  letter in the list.';
$lang_module['error_required_departmentid'] = 'Please select the department';
$lang_module['error_required_full_name'] = 'Please enter the name of the supporter';
$lang_module['error_required_phone'] = 'Please enter supporter phone';
$lang_module['forwarded'] = 'Forwarded';
$lang_module['forward'] = 'Forward to: %s';
$lang_module['error_mail_empty'] = 'Error: Empty email';

$lang_module['config'] = 'Configurer le module';
$lang_module['config_sendcopymode'] = 'Le droit d\'envoyer une copie à l\'email';
$lang_module['config_sendcopymode0'] = 'Les membres ont un email authentifié';
$lang_module['config_sendcopymode1'] = 'Tous les utilisateurs';

$lang_module['processed_by'] = 'The handler';
$lang_module['processed_time'] = 'Time';
$lang_module['mark_as_processed'] = 'Mark processed';
$lang_module['mark_as_unprocess'] = 'Mark unprocess';
$lang_module['tt3_row_title'] = 'Processed!';
$lang_module['process'] = 'Processed!';
$lang_module['row_new'] = 'New mail';

$lang_module['department_empty'] = 'General support';
$lang_module['department_delete_error'] = 'To delete this department, first delete or move its supporters to another department';
$lang_module['department_edit'] = 'Edit department';
$lang_module['department_add'] = 'Add department';
$lang_module['department_admin'] = 'Admin';
$lang_module['to_note'] = 'You can send to multiple email addresses. If they are separated by commas, messages will be sent to them simultaneously. If they are separated by semicolons, messages will be sent to them one by one (maximum 3 times)';
$lang_module['send_new_mail'] = 'Want to send new mail?';
$lang_module['supporter_avatar'] = 'Avatar';
$lang_module['supporter_avatar_note'] = 'The width and height of the avatar must be the same and be between 100 and 300 pixels';
$lang_module['user_info'] = 'User Information';
$lang_module['user_fullname'] = 'Fullname';
$lang_module['user_username'] = 'Username';
$lang_module['user_email'] = 'Email';
$lang_module['user_gender'] = 'Gender';
$lang_module['user_gender_M'] = 'Male';
$lang_module['user_gender_F'] = 'Female';
$lang_module['user_gender_N'] = 'Not declared';
$lang_module['user_birthday'] = 'Birthday';
$lang_module['user_regdate'] = 'Registered at';
$lang_module['user_last_login'] = 'Recently logged in at';
$lang_module['to_department'] = 'To the department';
$lang_module['your_authority'] = 'Your authority';
$lang_module['your_not_authority'] = 'You do not have any authority in this department';
$lang_module['compose_mail'] = 'Compose mail';
$lang_module['has_been_processed'] = 'Feedback has been processed';
$lang_module['reply_mail'] = 'Reply mail';
$lang_module['forwarding_mail'] = 'Forwarding mail';
$lang_module['sender'] = 'Sender';
$lang_module['receiver'] = 'Receiver';
$lang_module['cc'] = 'Send a copy to';
$lang_module['silent_mode'] = 'Silent mode';
$lang_module['silent_mode_note'] = 'This mode will remove notification mail to email addresses that are allowed to receive mail';
$lang_module['auto_forward_to'] = 'Messages are automatically forwarded to';
$lang_module['has_been_read'] = 'Message has been read';
$lang_module['feedback_phone'] = 'Declare the phone when sending feedback';
$lang_module['feedback_address'] = 'Declare the address when sending feedback';
$lang_module['option_0'] = 'No';
$lang_module['option_1'] = 'Required';
$lang_module['option_2'] = 'Optional';
$lang_module['department_parent'] = 'Belonging to the department';
