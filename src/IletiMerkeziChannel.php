<?php
/**
 * Created by PhpStorm.
 * User: orhangazibasli
 * Date: 23.03.2017
 * Time: 19:21
 */
namespace UnlemBilisim\IletiMerkezi;

use SoapBox\Formatter\Formatter;
use Illuminate\Events\Dispatcher;
use Illuminate\Notifications\Notification;

final class IletiMerkeziChannel
{

    /** @var string */
    protected $username;
    /** @var string */
    protected $password;
    /** @var string */
    protected $title;
    /** @var string */
    protected $endpoint;

    /** @var \Illuminate\Events\Dispatcher */
    protected $events;

    /**
     * @param \GuzzleHttp|Client $client
     * @param \Illuminate\Events\Dispatcher $events
     * @param string $username
     * @param string $password
     * @param string $title
     * @param string $endpoint
     */
    public function __construct(
        Dispatcher $events,
        $username,
        $password,
        $title,
        $endpoint
    ) {
        $this->events = $events;
        $this->username = $username;
        $this->password = $password;
        $this->title = $title;
        $this->endpoint = $endpoint;
    }

    /**
     * Send the notification to Apple Push Notification Service.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \Exception
     */
    public function send($notifiable, Notification $notification)
    {
        $tokens = $notifiable->routeNotificationFor('IletiMerkezi');
        if (! $tokens) {
            return;
        }
        $message = $notification->toIletiMerkezi($notifiable);
        if (! $message) {
            return;
        }
        $request = '<?xml version="1.0" encoding="UTF-8" ?>
        <request>
            <authentication>
                <username>' . $this->username . '</username>
                <password>' . $this->password . '</password>
            </authentication>
            <order>
                <sender>' . $this->title . '</sender>
        
                <message>
                    <text>'.$message->message.'</text>
                    <receipents>
                        <number> ' . $tokens . '</number>
                    </receipents>
                </message>
        
            </order>
        </request>';

        $result = $this->call($this->endpoint, $request, array('Content-Type: text/xml'));
        $formatter = Formatter::make($result, Formatter::XML);
        if (!isset($formatter->toArray()['status']['code']) && $formatter->toArray()['status']['code'] != 200) {
            throw Exception("Sistemsel bir hata oluştu.");
        }



    }

    private function call($site_name,$send_xml,$header_type)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$site_name);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$send_xml);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$header_type);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $result = curl_exec($ch);


        return $result;
    }

}
