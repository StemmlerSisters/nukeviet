<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

namespace NukeViet\Zalo;

use Zalo\Zalo;
use Zalo\ZaloEndPoint;
use Zalo\Builder\MessageBuilder;
use Zalo\Exceptions\ZaloSDKException;
use NukeViet\Http\Curl;

/**
 * NukeViet\Zalo\MyZalo
 *
 * @package NukeViet\Zalo
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @version 4.5.00
 * @access public
 */
class MyZalo
{
    const ERROR_OA_ID_EMPTY = 'oa_id_empty';
    const ERROR_REDIRECT_URI_EMPTY = 'redirect_uri_empty';
    const ERROR_APP_ID_EMPTY = 'app_id_empty';
    const ERROR_APP_SECKEY_EMPTY = 'app_seckey_empty';
    const ERROR_REFRESH_TOKEN_EMPTY = 'refresh_token_empty';
    const ERROR_NOT_RESPONSE = 'not_response';
    const ERROR_OA_ID_INCORRECT = 'oa_id_incorrect';
    const ERROR_REFRESH_TOKEN_EXP = 'refresh_token_expired';

    const OA_UPDATE_FOLLOWERINFO_URL = 'https://openapi.zalo.me/v2.0/oa/updatefollowerinfo';
    const QUOTA_MESSAGE_URL = 'https://openapi.zalo.me/v2.0/oa/quota/message';
    const UPLOAD_URL = 'https://openapi.zalo.me/v2.0/oa/upload/';
    const VIDEOUPLOAD_URL = 'https://openapi.zalo.me/v2.0/article/upload_video/preparevideo';
    const VIDEOUPLOAD_VERIFY_URL = 'https://openapi.zalo.me/v2.0/article/upload_video/verify';
    const ARTICLE_CREATE_URL = 'https://openapi.zalo.me/v2.0/article/create';
    const ARTICLE_GETID_URL = 'https://openapi.zalo.me/v2.0/article/verify';
    const ARTICLE_REMOVE_URL = 'https://openapi.zalo.me/v2.0/article/remove';
    const ARTICLE_VIDEO_UPDATE_URL = 'https://openapi.zalo.me/v2.0/article/video/update';
    const ARTICLE_UPDATE_URL = 'https://openapi.zalo.me/v2.0/article/update';
    const ARTICLE_GETDETAIL_URL = 'https://openapi.zalo.me/v2.0/article/getdetail';
    const ARTICLE_GETLIST_URL = 'https://openapi.zalo.me/v2.0/article/getslice?';
    const GET_ACCESSTOKEN_URL = 'https://oauth.zaloapp.com/v4/access_token';
    const GET_USERINO_URL = 'https://graph.zalo.me/v2.0/me?';

    private $oa_id = '';
    private $app_id = '';
    private $app_secret_key = '';
    private $oa_access_token = '';
    private $oa_refresh_token = '';
    private $oa_access_token_time = 0;

    private $error = '';
    private $error_code = '';

    public $zalo;

    /**
     * __construct()
     *
     * @param array $configs
     */
    public function __construct($configs)
    {
        $this->oa_id = $configs['zaloOfficialAccountID'];
        $this->app_id = $configs['zaloAppID'];
        $this->app_secret_key = $configs['zaloAppSecretKey'];
        $this->oa_access_token = $configs['zaloOAAccessToken'];
        $this->oa_refresh_token = $configs['zaloOARefreshToken'];
        $this->oa_access_token_time = (int) $configs['zaloOAAccessTokenTime'];

        $this->zalo = new Zalo([
            'app_id' => $this->app_id,
            'app_secret' => $this->app_secret_key
        ]);
    }

    /**
     * preCheckValid()
     *
     * @return false|void
     */
    private function preCheckValid()
    {
        if (empty($this->oa_id)) {
            $this->error = self::ERROR_OA_ID_EMPTY;

            return false;
        }

        if (empty($this->app_id)) {
            $this->error = self::ERROR_APP_ID_EMPTY;

            return false;
        }

        if (empty($this->app_secret_key)) {
            $this->error = self::ERROR_APP_SECKEY_EMPTY;

            return false;
        }

        $this->error = '';
        $this->error_code = '';

        return true;
    }

    /**
     * getError()
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * getErrorCode()
     *
     * @return string
     */
    public function getErrorCode()
    {
        return $this->error_code;
    }

    /**
     * isValid()
     *
     * @return true
     */
    public function isValid()
    {
        return $this->preCheckValid();
    }

    /**
     * refreshToken_isExp()
     *
     * @param int $accessTokenTime
     * @return bool
     */
    public static function refreshToken_isExp($accessTokenTime)
    {
        return (NV_CURRENTTIME - $accessTokenTime) > 7344000; // 85 days
    }

    /**
     * accessToken_isExp()
     *
     * @param int $accessTokenTime
     * @return bool
     */
    public static function accessToken_isExp($accessTokenTime)
    {
        return (NV_CURRENTTIME - $accessTokenTime) > 90000; // 25 hour
    }

    /**
     * base64url_encode()
     *
     * @param mixed $plainText
     * @return string
     */
    private static function base64url_encode($plainText)
    {
        $base64 = base64_encode($plainText);
        $base64 = trim($base64, '=');

        return strtr($base64, '+/', '-_');
    }

    /**
     * stateCreate()
     *
     * @param int $num
     * @return string
     */
    private static function stateCreate($num = 8)
    {
        return substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', 5)), $num, $num);
    }

    /**
     * codeVerifierCreate()
     *
     * @return array
     */
    private static function codeVerifierCreate()
    {
        $random = bin2hex(openssl_random_pseudo_bytes(32));
        $code_verifier = self::base64url_encode(pack('H*', $random));
        $code_challenge = self::base64url_encode(pack('H*', hash('sha256', $code_verifier)));

        return [$code_verifier, $code_challenge];
    }

    /**
     * format_text()
     *
     * @param mixed $text
     * @return string|string[]|null
     */
    public static function format_text($text)
    {
        $text = preg_replace('/\<br(\s*)?\/?(\s*)?\>/i', "\n", $text);
        $text = str_replace("\r\n", "\n", $text);
        $text = str_replace("\r", "\n", $text);
        // JSON requires new line characters be escaped
        $text = str_replace("\n", '\\n', $text);
        $text = str_replace('&amp;', '&', $text);
        $text = str_replace('&#039;', "\\'", $text);

        return str_replace('&quot;', '\\"', $text);
    }

    /**
     * getResponse()
     *
     * @param mixed $url
     * @param mixed $args
     * @return mixed
     */
    private static function getResponse($url, $args)
    {
        $NV_Curl = new Curl();

        return $NV_Curl->request($url, $args);
    }

    /**
     * get_json_response()
     *
     * @param mixed $response
     * @param array $args
     * @return mixed
     */
    private function get_json_response($response, $args = [])
    {
        if (!is_array($response)) {
            $this->error = self::ERROR_NOT_RESPONSE;

            return false;
        }

        if (empty($response['body'])) {
            $this->error = self::ERROR_NOT_RESPONSE;

            return false;
        }

        $response = json_decode($response['body'], true);
        if (empty($response)) {
            $this->error = self::ERROR_NOT_RESPONSE;

            return false;
        }

        if (!empty($response['error'])) {
            //print_r($response);exit;
            $this->error = !empty($response['error_name']) ? $response['error_name'] : $response['message'];
            $this->error_code = $response['error'];

            return false;
        }

        if (empty($args)) {
            return $response;
        }

        $args = array_flip($args);

        return array_intersect_key($response, $args);
    }

    /**
     * accesstoken_new_result()
     *
     * @param mixed $url
     * @param mixed $args
     * @return array|false
     */
    private function accesstoken_new_result($url, $args)
    {
        $response = self::getResponse($url, $args);

        return $this->get_json_response($response, ['access_token', 'refresh_token']);
    }

    /**
     * Lấy access token từ refresh token
     * oa_accesstoken_from_refreshtoken()
     *
     * @param string $refreshtoken
     * @param int    $accessTokenTime
     * @return array
     */
    private function oa_accesstoken_from_refreshtoken($refreshtoken, $accessTokenTime)
    {
        if (empty($refreshtoken)) {
            $this->error = self::ERROR_REFRESH_TOKEN_EMPTY;

            return false;
        }

        if (self::refreshToken_isExp($accessTokenTime)) {
            $this->error = self::ERROR_REFRESH_TOKEN_EXP;

            return false;
        }

        $oAuth2Client = $this->zalo->getOAuth2Client();
        $result = (array) $oAuth2Client->getZaloTokenFromRefreshTokenByOA($refreshtoken);
        $prefix = chr(0).'*'.chr(0);

        return [
            'access_token' => $result[$prefix. 'accessToken'],
            'refresh_token' => $result[$prefix. 'refreshToken'],
            'expire_time' => $result[$prefix. 'accessTokenExpiresAt']->getTimestamp()
        ];
    }

    /**
     * permissionURLCreate()
     *
     * @param mixed  $redirect_uri
     * @param string $level
     * @return array|false
     */
    public function permissionURLCreate($redirect_uri, $level = 'oa')
    {
        if (!$this->preCheckValid()) {
            return false;
        }

        if (empty($redirect_uri)) {
            $this->error = self::ERROR_REDIRECT_URI_EMPTY;

            return false;
        }

        $state = self::stateCreate(8);
        [$code_verifier, $code_challenge] = self::codeVerifierCreate();
        $helper = $this->zalo->getRedirectLoginHelper();
        if ($level == 'oa') {
            $url = $helper->getLoginUrlByOA($redirect_uri, $code_challenge, $state);
        } else {
            $url = $helper->getLoginUrl($redirect_uri, $code_challenge, $state);
        }

        return [
            'code_verifier' => $code_verifier,
            'permission_url' => $url
        ];
    }

    /**
     * oa_accesstoken_create()
     *
     * @param mixed  $redirect_uri
     * @param string $refreshtoken
     * @param int    $accesstoken_time
     * @return array|false
     */
    public function oa_accesstoken_create($redirect_uri, $refreshtoken = '', $accesstoken_time = 0)
    {
        if (!$this->preCheckValid()) {
            return false;
        }

        try {
            empty($refreshtoken) && $refreshtoken = $this->oa_refresh_token;
            empty($accesstoken_time) && $accesstoken_time = $this->oa_access_token_time;
            $result = $this->oa_accesstoken_from_refreshtoken($refreshtoken, $accesstoken_time);

            return $result;
        } catch (ZaloSDKException $e) {
            return $this->permissionURLCreate($redirect_uri, 'oa');
        }
    }

    /**
     * oa_accesstoken_new()
     *
     * @param mixed $code_verifier
     * @return array|false
     */
    public function oa_accesstoken_new($code_verifier)
    {
        if (!$this->preCheckValid()) {
            return false;
        }

        try {
            $helper = $this->zalo->getRedirectLoginHelper();
            $zaloToken = $helper->getZaloTokenByOA($code_verifier);

            return [
                'access_token' => $zaloToken->getAccessToken(),
                'refresh_token' => $zaloToken->getRefreshToken(),
                'expire_time' => $zaloToken->getAccessTokenExpiresAt()->getTimestamp()
            ];
        } catch (ZaloSDKException $e) {
            $this->error = $e->getMessage();

            return false;
        }
    }

    /**
     * accesstokenGet()
     *
     * @param mixed $authorization_code
     * @param mixed $code_verifier
     * @return array|false
     */
    public function accesstokenGet($authorization_code, $code_verifier)
    {
        if (!$this->preCheckValid()) {
            return false;
        }
        $args = [
            'method' => 'POST',
            'headers' => [
                'secret_key' => $this->app_secret_key
            ],
            'body' => http_build_query([
                'code' => $authorization_code,
                'app_id' => $this->app_id,
                'grant_type' => 'authorization_code',
                'code_verifier' => $code_verifier
            ])
        ];

        return $this->accesstoken_new_result(self::GET_ACCESSTOKEN_URL, $args);
    }

    /**
     * Truy xuất thông tin cơ bản của người dùng Zalo đã cấp quyền cho ứng dụng
     * https://developers.zalo.me/docs/api/social-api/tai-lieu/thong-tin-ten-anh-dai-dien-post-28
     *
     * getUserInfo()
     *
     * @param mixed $accesstoken
     * @return array|false
     */
    public function getUserInfo($accesstoken)
    {
        if (!$this->preCheckValid()) {
            return false;
        }
        $args = [
            'method' => 'GET',
            'headers' => [
                'access_token' => $accesstoken
            ]
        ];

        $url = self::GET_USERINO_URL . 'fields=id,birthday,name,gender,picture';
        $response = self::getResponse($url, $args);
        if (empty($response['body'])) {
            $this->error = self::ERROR_NOT_RESPONSE;

            return false;
        }

        $response = json_decode($response['body'], true);
        if (empty($response)) {
            $this->error = self::ERROR_NOT_RESPONSE;

            return false;
        }

        if (!empty($response['error'])) {
            $this->error = $response['message'];
            $this->error_code = $response['error'];

            return false;
        }

        return [
            'id' => $response['id'],
            'name' => $response['name'],
            'gender' => $response['gender'],
            'birthday' => $response['birthday'],
            'picture' => $response['picture']['data']['url']
        ];
    }

    /**
     * Lấy thông tin Official Account
     *
     * @param mixed $accesstoken
     * @return mixed
     */
    public function get_oa_info($accesstoken)
    {
        try {
            $response = $this->zalo->get(ZaloEndPoint::API_OA_GET_PROFILE, $accesstoken, []);
            return $response->getDecodedBody();
        } catch (ZaloSDKException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * @param string $redirect_uri
     * @param string $accesstoken
     * @param string $refreshtoken
     * @param int    $accesstoken_time
     * @return array
     */
    public function oa_accesstoken_info($redirect_uri = '', $accesstoken = '', $refreshtoken = '', $accesstoken_time = 0)
    {
        empty($accesstoken) && $accesstoken = $this->oa_access_token;
        empty($refreshtoken) && $refreshtoken = $this->oa_refresh_token;
        empty($accesstoken_time) && $accesstoken_time = $this->oa_access_token_time;

        if (!empty($accesstoken) and !self::accessToken_isExp($accesstoken_time)) {
            return [
                'result' => 'ok',
                'access_token' => $accesstoken
            ];
        }

        if (!empty($refreshtoken) and !self::refreshToken_isExp($accesstoken_time)) {
            $result = $this->oa_accesstoken_from_refreshtoken($refreshtoken, $accesstoken_time);
            if (!empty($result)) {
                return ['result' => 'update'] + $result;
            }
        }

        if (empty($redirect_uri)) {
            return ['result' => 'error', 'mess' => self::ERROR_REFRESH_TOKEN_EXP];
        }

        $result = $this->permissionURLCreate($redirect_uri, 'oa');
        if (!empty($result)) {
            return ['result' => 'new'] + $result;
        }

        return ['result' => 'error', 'mess' => $this->getError()];
    }

    /**
     * Lấy danh sách người quan tâm
     * https://developers.zalo.me/docs/api/official-account-api/quan-ly-thong-tin-official-account/lay-danh-sach-nguoi-quan-tam-post-5133
     *
     * get_followers()
     *
     * @param mixed $accesstoken
     * @param mixed $data
     * @return mixed
     */
    public function get_followers($accesstoken, $data)
    {
        $_data = [
            'offset' => 0,
            'count' => 50,
            'tag_name' => ''
        ];

        if (!empty($data['offset'])) {
            $_data['offset'] = (int) $data['offset'];
        }
        if (!empty($data['count'])) {
            $count = (int) $data['count'];
            if ($count && $count < 50) {
                $_data['count'] = $count;
            }
        }
        if (!empty($data['tag_name'])) {
            $_data['tag_name'] = $data['tag_name'];
        } else {
            unset($_data['tag_name']);
        }

        $data = ['data' => json_encode($_data)];

        try {
            $response = $this->zalo->get(ZaloEndPoint::API_OA_GET_LIST_FOLLOWER, $accesstoken, $data);
            return $response->getDecodedBody();
        } catch (ZaloSDKException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Lấy thông tin người quan tâm
     * https://developers.zalo.me/docs/api/official-account-api/quan-ly-thong-tin-official-account/lay-thong-tin-nguoi-quan-tam-post-5129
     *
     * get_follower_profile()
     *
     * @param mixed $accesstoken
     * @param mixed $user_id
     * @return mixed
     */
    public function get_follower_profile($accesstoken, $user_id)
    {
        $data = ['data' => json_encode([
            'user_id' => $user_id
        ])];
        try {
            $response = $this->zalo->get(ZaloEndPoint::API_OA_GET_USER_PROFILE, $accesstoken, $data);
            return $response->getDecodedBody();
        } catch (ZaloSDKException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Cập nhật thông tin người quan tâm
     * https://developers.zalo.me/docs/api/official-account-api/quan-ly-thong-tin-official-account/cap-nhat-thong-tin-nguoi-quan-tam-post-5125
     *
     * updatefollowerinfo()
     *
     * @param mixed $accesstoken
     * @param mixed $data
     * @return mixed
     */
    public function updatefollowerinfo($accesstoken, $data)
    {
        try {
            $response = $this->zalo->post(self::OA_UPDATE_FOLLOWERINFO_URL, $accesstoken, $data);
            return $response->getDecodedBody();
        } catch (ZaloSDKException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Gắn nhãn người quan tâm
     *
     * @param mixed $accesstoken
     * @param mixed $user_id
     * @param mixed $tag_name
     * @return mixed
     */
    public function tagfollower($accesstoken, $user_id, $tag_name)
    {
        $data = [
            'user_id' => $user_id,
            'tag_name' => $tag_name
        ];
        try {
            $response = $this->zalo->post(ZaloEndpoint::API_OA_TAG_USER, $accesstoken, $data);
            return $response->getDecodedBody();
        } catch (ZaloSDKException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Gỡ nhãn khỏi người quan tâm
     *
     * @param mixed $accesstoken
     * @param mixed $user_id
     * @param mixed $tag
     * @param mixed $tag_name
     */
    public function rmfollowerfromtag($accesstoken, $user_id, $tag_name)
    {
        $data = [
            'user_id' => $user_id,
            'tag_name' => $tag_name
        ];
        try {
            $response = $this->zalo->post(ZaloEndPoint::API_OA_REMOVE_USER_FROM_TAG, $accesstoken, $data);
            return $response->getDecodedBody();
        } catch (ZaloSDKException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Lấy danh sách nhãn
     * https://developers.zalo.me/docs/api/official-account-api/quan-ly-thong-tin-official-account/quan-ly-nhan-post-5119
     *
     * @param mixed $accesstoken
     * @return mixed
     */
    public function gettagsofoa($accesstoken)
    {
        try {
            $response = $this->zalo->get(ZaloEndPoint::API_OA_GET_LIST_TAG, $accesstoken, []);
            return $response->getDecodedBody();
        } catch (ZaloSDKException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Xóa nhãn
     * https://developers.zalo.me/docs/api/official-account-api/quan-ly-thong-tin-official-account/quan-ly-nhan-post-5119
     *
     * @param mixed $accesstoken
     * @param mixed $tag_name
     * @return mixed
     */
    public function rmtag($accesstoken, $tag_name)
    {
        $data = ['tag_name' => $tag_name];
        try {
            $response = $this->zalo->post(ZaloEndPoint::API_OA_REMOVE_TAG, $accesstoken, $data);
            return $response->getDecodedBody();
        } catch (ZaloSDKException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Lấy danh sách các hội thoại với người quan tâm
     * https://developers.zalo.me/docs/api/official-account-api/quan-ly-tin-nhan-nguoi-quan-tam/lay-danh-sach-cac-hoi-thoai-voi-nguoi-quan-tam-post-5140
     *
     * @param mixed $accesstoken
     * @param mixed $user_id
     * @param mixed $offset
     * @param mixed $count
     * @return mixed
     */
    public function conversation($accesstoken, $user_id, $offset, $count)
    {
        $count = (int) $count;
        if ($count < 1 or $count > 10) {
            $count = 10;
        }

        $data = ['data' => json_encode([
            'user_id' => $user_id,
            'offset' => $offset,
            'count' => $count
        ])];

        try {
            $response = $this->zalo->get(ZaloEndPoint::API_OA_GET_CONVERSATION, $accesstoken, $data);
            return $response->getDecodedBody();
        } catch (ZaloSDKException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Lấy danh sách các hội thoại gần nhất
     * https://developers.zalo.me/docs/api/official-account-api/quan-ly-tin-nhan-nguoi-quan-tam/lay-danh-sach-cac-hoi-thoai-gan-nhat-post-5144
     *
     * listrecentchat()
     *
     * @param mixed $accesstoken
     * @param mixed $offset
     * @param mixed $count
     * @return mixed
     */
    public function listrecentchat($accesstoken, $offset, $count)
    {
        $count = (int) $count;
        if ($count < 1 or $count > 10) {
            $count = 10;
        }

        $data = ['data' => json_encode([
            'offset' => $offset,
            'count' => $count
        ])];

        try {
            $response = $this->zalo->get(ZaloEndPoint::API_OA_GET_LIST_RECENT_CHAT, $accesstoken, $data);
            return $response->getDecodedBody();
        } catch (ZaloSDKException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Lấy thông tin quota lệnh chủ động miễn phí
     * Không có trong Zalo SDK
     *
     * getquota()
     *
     * @param mixed $accesstoken
     * @return mixed
     */
    public function getquota($accesstoken)
    {
        $args = [
            'method' => 'POST',
            'headers' => [
                'Content-Type' => 'application/json',
                'access_token' => $accesstoken
            ]
        ];

        $response = self::getResponse(self::QUOTA_MESSAGE_URL, $args);

        return $this->get_json_response($response);
    }

    /**
     * Gửi thông báo văn bản
     * https://developers.zalo.me/docs/api/official-account-api/gui-tin-va-thong-bao-qua-oa/gui-thong-bao-van-ban-post-5072
     *
     * send_text()
     *
     * @param mixed $accesstoken
     * @param mixed $user_id
     * @param mixed $chat_text
     * @param mixed $message_id
     * @return mixed
     */
    public function send_text($accesstoken, $user_id, $message_id, $chat_text)
    {
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_TXT);
        $msgBuilder->withUserId($user_id);
        $msgBuilder->withText($chat_text);

        if (!empty($message_id)) {
            $msgBuilder->withQuoteMessage($message_id);
        }

        $msgText = $msgBuilder->build();

        try {
            $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_CONSULTATION_MESSAGE_V3, $accesstoken, $msgText);
            return $response->getDecodedBody();
        } catch (ZaloSDKException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Gửi thông báo đính kèm ảnh mới
     * https://developers.zalo.me/docs/api/official-account-api/gui-tin-va-thong-bao-qua-oa/gui-thong-bao-theo-mau-dinh-kem-anh-post-5068
     *
     * send_sitephoto()
     *
     * @param mixed $accesstoken
     * @param mixed $user_id
     * @param mixed $chat_text
     * @param mixed $attachment
     * @param mixed $message_id
     * @return mixed
     */
    public function send_sitephoto($accesstoken, $user_id, $message_id, $chat_text, $attachment)
    {
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_MEDIA);
        $msgBuilder->withUserId($user_id);
        $msgBuilder->withText($chat_text);
        if (!empty($message_id)) {
            $msgBuilder->withQuoteMessage($message_id);
        }
        $msgBuilder->withMediaUrl($attachment);
        $msgImage = $msgBuilder->build();

        try {
            $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_CONSULTATION_MESSAGE_V3, $accesstoken, $msgImage);
            return $response->getDecodedBody();
        } catch (ZaloSDKException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Gửi thông báo theo mẫu đính kèm ảnh đã upload lên zalo trước đó
     * https://developers.zalo.me/docs/api/official-account-api/gui-tin-va-thong-bao-qua-oa/gui-thong-bao-theo-mau-dinh-kem-anh-post-5068
     *
     * send_zaloimage()
     *
     * @param mixed $accesstoken
     * @param mixed $user_id
     * @param mixed $chat_text
     * @param mixed $attachment_id
     * @param mixed $message_id
     * @return mixed
     */
    public function send_zaloimage($accesstoken, $user_id, $message_id, $chat_text, $attachment_id)
    {
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_MEDIA);
        $msgBuilder->withUserId($user_id);
        $msgBuilder->withText($chat_text);
        if (!empty($message_id)) {
            $msgBuilder->withQuoteMessage($message_id);
        }
        $msgBuilder->withAttachment($attachment_id);
        $msgImage = $msgBuilder->build();

        try {
            $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_CONSULTATION_MESSAGE_V3, $accesstoken, $msgImage);
            return $response->getDecodedBody();
        } catch (ZaloSDKException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Gửi thông báo đính kèm file
     * https://developers.zalo.me/docs/api/official-account-api/gui-tin-va-thong-bao-qua-oa/gui-thong-bao-dinh-kem-file-post-5049
     *
     * send_zalofile()
     *
     * @param mixed $accesstoken
     * @param mixed $user_id
     * @param mixed $token
     * @param mixed $message_id
     * @return mixed
     */
    public function send_zalofile($accesstoken, $user_id, $message_id, $token)
    {
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_FILE);
        $msgBuilder->withUserId($user_id);
        if (!empty($message_id)) {
            $msgBuilder->withQuoteMessage($message_id);
        }
        $msgBuilder->withFileToken($token);
        $msgFile = $msgBuilder->build();
        try {
            $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_CONSULTATION_MESSAGE_V3, $accesstoken, $msgFile);
            return $response->getDecodedBody();
        } catch (ZaloSDKException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Upload hình ảnh/Gif/File lên zalo
     * https://developers.zalo.me/docs/api/official-account-api/upload-hinh-anh/upload-hinh-anh-post-5091
     * https://developers.zalo.me/docs/api/official-account-api/upload-hinh-anh/upload-anh-gif-post-5089
     * https://developers.zalo.me/docs/api/official-account-api/upload-hinh-anh/upload-file-post-5087
     *
     * upload()
     *
     * @param mixed $accesstoken
     * @param mixed $type
     * @param mixed $file
     * @param mixed $cfile
     * @return mixed
     */
    public function upload($accesstoken, $type, $cfile)
    {
        $args = [
            'method' => 'POST',
            'headers' => [
                'Content-Type' => 'multipart/form-data',
                'access_token' => $accesstoken
            ],
            'body' => [
                'file' => $cfile
            ]
        ];

        $response = self::getResponse(self::UPLOAD_URL . $type, $args);

        return $this->get_json_response($response);
    }

    /**
     * Gửi thông báo theo mẫu yêu cầu thông tin người dùng
     * https://developers.zalo.me/docs/api/official-account-api/gui-tin-va-thong-bao-qua-oa/gui-thong-bao-theo-mau-yeu-cau-thong-tin-nguoi-dung-post-5055
     *
     * send_request_user_info()
     *
     * @param mixed $accesstoken
     * @param mixed $user_id
     * @param mixed $request_info
     * @param mixed $message_id
     * @return mixed
     */
    public function send_request_user_info($accesstoken, $user_id, $message_id, $request_info)
    {
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_REQUEST_USER_INFO);
        $msgBuilder->withUserId($user_id);
        $msgBuilder->addElement($request_info);
        $msgText = $msgBuilder->build();

        try {
            $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_CONSULTATION_MESSAGE_V3, $accesstoken, $msgText);
            return $response->getDecodedBody();
        } catch (ZaloSDKException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Kiểm tra trạng thái của video cho bài viết
     * https://developers.zalo.me/docs/api/article-api/api/tai-len-video-cho-article-post-3007
     *
     * video_verify()
     *
     * @param mixed $accesstoken
     * @param mixed $token
     * @return mixed
     */
    public function video_verify($accesstoken, $token)
    {
        $args = [
            'method' => 'GET',
            'headers' => [
                'Content-Type' => 'application/json',
                'access_token' => $accesstoken,
                'token' => $token
            ]
        ];

        $response = self::getResponse(self::VIDEOUPLOAD_VERIFY_URL, $args);

        return $this->get_json_response($response);
    }

    /**
     * Tạo bài viết
     * https://developers.zalo.me/docs/api/article-api/api/tao-bai-viet-post-2756
     *
     * article_create()
     *
     * @param mixed $accesstoken
     * @param mixed $save_article
     * @return mixed
     */
    public function article_create($accesstoken, $save_article)
    {
        try {
            $response = $this->zalo->post(self::ARTICLE_CREATE_URL, $accesstoken, $save_article);
            return $response->getDecodedBody();
        } catch (ZaloSDKException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Lấy id bài viết
     * https://developers.zalo.me/docs/api/article-api/api/lay-id-bai-viet-kiem-tra-ket-qua-tien-trinh-tao-bai-viet-post-2977
     *
     * get_article_id()
     *
     * @param mixed $accesstoken
     * @param mixed $token
     * @return mixed
     */
    public function get_article_id($accesstoken, $token)
    {
        try {
            $response = $this->zalo->post(self::ARTICLE_GETID_URL, $accesstoken, ['token' => $token]);
            return $response->getDecodedBody();
        } catch (ZaloSDKException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Xóa bài viết
     * https://developers.zalo.me/docs/api/article-api/api/xoa-bai-viet-post-2927
     *
     * delete_article()
     *
     * @param mixed $accesstoken
     * @param mixed $zalo_id
     * @return mixed
     */
    public function delete_article($accesstoken, $zalo_id)
    {
        try {
            $response = $this->zalo->post(self::ARTICLE_REMOVE_URL, $accesstoken, ['id' => $zalo_id]);
            return $response->getDecodedBody();
        } catch (ZaloSDKException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Cập nhật bài viết
     * https://developers.zalo.me/docs/api/article-api/api/cap-nhat-bai-viet-post-2925
     *
     * article_update()
     *
     * @param mixed $accesstoken
     * @param mixed $save_article
     * @return mixed
     */
    public function article_update($accesstoken, $save_article)
    {
        try {
            $response = $this->zalo->post(self::ARTICLE_UPDATE_URL, $accesstoken, $save_article);
            return $response->getDecodedBody();
        } catch (ZaloSDKException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Lấy chi tiết của bài viết
     * https://developers.zalo.me/docs/api/article-api/api/lay-chi-tiet-cua-bai-viet-post-2936
     *
     * article_getdetail()
     *
     * @param mixed $accesstoken
     * @param mixed $zalo_id
     * @return mixed
     */
    public function article_getdetail($accesstoken, $zalo_id)
    {
        $url = self::ARTICLE_GETDETAIL_URL . '?id=' . $zalo_id;

        try {
            $response = $this->zalo->get($url, $accesstoken, []);
            return $response->getDecodedBody();
        } catch (ZaloSDKException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Lấy danh sách bài viết
     * https://developers.zalo.me/docs/api/article-api/api/lay-danh-sach-bai-viet-post-2930
     *
     * get_articlelist()
     *
     * @param mixed $accesstoken
     * @param mixed $offset
     * @param mixed $limit
     * @param mixed $type
     * @return mixed
     */
    public function get_articlelist($accesstoken, $offset, $limit, $type)
    {
        $url = self::ARTICLE_GETLIST_URL . 'offset=' . $offset . '&limit=' . $limit . '&type=' . $type;

        try {
            $response = $this->zalo->get($url, $accesstoken, []);
            return $response->getDecodedBody();
        } catch (ZaloSDKException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }
}
