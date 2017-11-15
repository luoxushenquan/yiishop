<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/13
 * Time: 11:53
 */
namespace frontend\components;

use yii\base\Component;
use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\QuerySendDetailsRequest;


Config::load();
class Sms extends Component{


    static $acsClient = null;

    /**
     * ȡ��AcsClient
     *
     * @return DefaultAcsClient
     */
    public static function getAcsClient() {
        //��Ʒ����:��ͨ����������API��Ʒ,�����������滻
        $product = "Dysmsapi";

        //��Ʒ����,�����������滻
        $domain = "dysmsapi.aliyuncs.com";

        $accessKeyId = "LTAIQjkMnbxD4LMR"; // AccessKeyId

        $accessKeySecret = "98XzdclbaWbhzdGUFiTf9qRJSDS8Xy"; // AccessKeySecret


        // ��ʱ��֧�ֶ�Region
        $region = "cn-hangzhou";

        // ������
        $endPointName = "cn-hangzhou";


        if(static::$acsClient == null) {

            //��ʼ��acsClient,�ݲ�֧��region��
            $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);

            // ���ӷ�����
            DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);

            // ��ʼ��AcsClient���ڷ�������
            static::$acsClient = new DefaultAcsClient($profile);
        }
        return static::$acsClient;
    }

    /**
     * ���Ͷ���
     *
     * @param string $signName <p>
     * ����, ����ǩ����Ӧ�ϸ�"ǩ������"��д���ο���<a href="https://dysms.console.aliyun.com/dysms.htm#/sign">����ǩ��ҳ</a>
     * </p>
     * @param string $templateCode <p>
     * ����, ����ģ��Code��Ӧ�ϸ�"ģ��CODE"��д, �ο���<a href="https://dysms.console.aliyun.com/dysms.htm#/template">����ģ��ҳ</a>
     * (e.g. SMS_0001)
     * </p>
     * @param string $phoneNumbers ����, ���Ž��պ��� (e.g. 12345678901)
     * @param array|null $templateParam <p>
     * ѡ��, ����ģ���д��ڱ�����Ҫ�滻��Ϊ������ (e.g. Array("code"=>"12345", "product"=>"����ͨ��"))
     * </p>
     * @param string|null $outId [optional] ѡ��, ���Ͷ�����ˮ�� (e.g. 1234)
     * @param string|null $smsUpExtendCode [optional] ѡ����ж�����չ�루��չ���ֶο�����7λ�����£������������û�����Դ��ֶΣ�
     * @return stdClass
     */
    public static function sendSms($signName, $templateCode, $phoneNumbers, $templateParam = null, $outId = null, $smsUpExtendCode = null) {

        // ��ʼ��SendSmsRequestʵ���������÷��Ͷ��ŵĲ���
        $request = new SendSmsRequest();

        // ������������Ž��պ���
        $request->setPhoneNumbers($phoneNumbers);

        // �������ǩ������
        $request->setSignName($signName);

        // �������ģ��CODE
        $request->setTemplateCode($templateCode);

        // ��ѡ������ģ�����
        if($templateParam) {
            $request->setTemplateParam(json_encode($templateParam));
        }

        // ��ѡ��������ˮ��
        if($outId) {
            $request->setOutId($outId);
        }

        // ѡ����ж�����չ��
        if($smsUpExtendCode) {
            $request->setSmsUpExtendCode($smsUpExtendCode);
        }

        // �����������
        $acsResponse = static::getAcsClient()->getAcsResponse($request);

        // ��ӡ������
        // var_dump($acsResponse);

        return $acsResponse;

    }

    /**
     * ���ŷ��ͼ�¼��ѯ
     *
     * @param string $phoneNumbers ����, ���Ž��պ��� (e.g. 12345678901)
     * @param string $sendDate ������ŷ������ڣ���ʽYmd��֧�ֽ�30���¼��ѯ (e.g. 20170710)
     * @param int $pageSize �����ҳ��С
     * @param int $currentPage �����ǰҳ��
     * @param string $bizId ѡ����ŷ�����ˮ�� (e.g. abc123)
     * @return stdClass
     */
    public function queryDetails($phoneNumbers, $sendDate, $pageSize = 10, $currentPage = 1, $bizId=null) {

        // ��ʼ��QuerySendDetailsRequestʵ���������ö��Ų�ѯ�Ĳ���
        $request = new QuerySendDetailsRequest();

        // ������Ž��պ���
        $request->setPhoneNumber($phoneNumbers);

        // ѡ����ŷ�����ˮ��
        $request->setBizId($bizId);

        // ������ŷ������ڣ�֧�ֽ�30���¼��ѯ����ʽYmd
        $request->setSendDate($sendDate);

        // �����ҳ��С
        $request->setPageSize($pageSize);

        // �����ǰҳ��
        $request->setCurrentPage($currentPage);

        // �����������
        $acsResponse = static::getAcsClient()->getAcsResponse($request);

        // ��ӡ������
        // var_dump($acsResponse);

        return $acsResponse;
    }

}