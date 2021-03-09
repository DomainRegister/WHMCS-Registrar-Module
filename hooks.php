<?php
/**
 *   DomainRegister Account Status Widget
 *
 *   Documentation: https://github.com/DomainRegister/
 *
 *   Copyright (c) PERSOLVO doo 2020
 * 
 */

add_hook('AdminHomeWidgets', 1, function() {
    return new DomainRegisterWidgetasHook();
});

/**
 * Sample Registrar Module Admin Dashboard Widget.
 *
 * @see https://developers.whmcs.com/addon-modules/admin-dashboard-widgets/
 */
class DomainRegisterWidgetasHook extends \WHMCS\Module\AbstractWidget
{
    protected $title = 'DomainRegister Account Overview';
    protected $description = 'v. 1.0';
    protected $weight = 150;
    protected $columns = 1;
    protected $cache = false;
    protected $cacheExpiry = 120;
    protected $requiredPermission = '';

    public function getData()
    {
        return array();
    }

    public function generateOutput($data)
    {          require_once __DIR__ . '/../../../includes/registrarfunctions.php';
       $params = getRegistrarConfigOptions('DomainRegister');
       $data = array(
            "action"		=> "CreditAmount",
            "token"         => $params['api_key'],
            "authemail"     => $params['api_email']
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://domainregister.international/domainsResellerAPI/api.php");
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        $result = array();
        $result['response_body'] = curl_exec($ch);
        $result['info']          = curl_getinfo($ch);
        $curlHeaderSize          = $result['info']['header_size'];
        $result['headers']       = substr($result['response_body'], 0, $curlHeaderSize);
        $result['response_body'] = substr($result['response_body'], $curlHeaderSize); 
        $res= json_decode($result['response_body'],true);
        $balance=$res["value"];
        curl_close($ch);
        $logo_url = "https://domainregister.international/templates/dr3/assets/images/dr-logo.svg";
        return (
            '<div class="widget-billing">' .
              '<div class="row" style="display: flex; flex-wrap: wrap; align-items: center;">' .
                '<div class="col-sm-6 bordered-right">' .
                    '<div class="item text-right">' .
                        '<div class="data color-' . ($balance >= 100 ? "green" : "pink") . '"> € ' .
                            $balance .
                        '</div>' .
                        '<div class="note">Account Balance</div>' .
                    '</div>' .
                 '</div>' .
                '<div class="col-sm-6 bordered-right">' .
                    ($stats ? $stats : '<div class="text-center"><img src="' . $logo_url . '" width="125" height="40"/></div>') .
                '</div>' .
              '</div>' .
            '</div>'
        );
    }
}
