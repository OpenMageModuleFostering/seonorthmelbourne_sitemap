<?php

class Studio45_Signifymap_Model_Signifymap extends Mage_Core_Model_Abstract
{

    public $google_url = "http://www.google.com/webmasters/tools/ping?sitemap=";
    public $yahoo_url = "http://www.bing.com/webmaster/ping.aspx?siteMap=";
    public $bing_url = "http://www.bing.com/webmaster/ping.aspx?siteMap=";
    public $window_url = "http://www.bing.com/webmaster/ping.aspx?siteMap=";

    public function _construct()
    {
        parent::_construct();
        $this->_init('signifymap/signifymap');
    }

    public function getRow()
    {
        $collection = $this->getCollection()
                ->setOrder('signifymap_id', 'DESC');
        $row = $collection->getFirstItem()->getData();
        return $row;
    }

    public function update()
    {
        $arr_row = $this->getRow();
        $this->submitSitemap($arr_row);
    }

    public function submitSitemap($data)
    {
		$data_dec = array("google"=>"", "yahoo"=>"", "bing"=>"","window"=>"");
		$data=(array_merge($data_dec,$data));
        $responses = array();
        $responses['google_response'] = 'Not Configured';
        $responses['yahoo_response'] = 'Not Configured';
        $responses['bing_response'] = 'Not Configured';
        $responses['window_response'] = 'Not Configured';

        $base_url = $this->get_url() . "sitemap.xml";
        $isCurl = function_exists('curl_init');
        if ($isCurl) {
            if ($data['google'] == 'yes') {
                $url_google = $this->google_url . $base_url;
                $string = $this->get_web_page($url_google);

                $DOM = new DOMDocument;
                @$DOM->loadHTML($string);

                $items = $DOM->getElementsByTagName('body');
                $array = array();
                for ($i = 0; $i < $items->length; $i++)
                    $array = $items->item($i)->nodeValue;
                $responses['google_response'] = substr($array, '0', 105);
            }

            if ($data['yahoo'] == 'yes') {
                $url_yahoo = $this->yahoo_url . $base_url;
                $responses['yahoo_response'] = strip_tags($this->get_web_page($url_yahoo));
            }

            if ($data['bing'] == 'yes') {
                $url_bing = $this->bing_url . $base_url;
                $responses['bing_response'] = strip_tags('Thanks for submitting your Sitemap. Join the Bing Webmaster Tools to see your Sitemaps status and more reports on how you are doing on Bing.');
            }

            if ($data['window'] == 'yes') {
                $url_window = $this->window_url . $base_url;
                $responses['window_response'] = strip_tags($this->get_web_page($url_window));
            }
        }

        if ($data['google'] == 'yes' || $data['bing'] == 'yes' || $data['window'] == 'yes' || $data['yahoo'] == 'yes') {
            $responses['date'] = date('Y-m-d h:i:s a', Mage::getModel('core/date')->timestamp(time()));
            $signifyresponse = Mage::getModel('signifyresponse/signifyresponse')->setData($responses);
            $signifyresponse->save();
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('signifymap')->__('sitemap was successfully submitted'));
        } else
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('signifymap')->__('Please choose at least 1 channel'));
    }

    function get_web_page($url)
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => true, // return web page
            CURLOPT_HEADER => false, // don't return headers
            CURLOPT_FOLLOWLOCATION => true, // follow redirects
            CURLOPT_ENCODING => "", // handle all encodings
            CURLOPT_AUTOREFERER => true, // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
            CURLOPT_TIMEOUT => 120, // timeout on response
            CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        $header = curl_getinfo($ch);
        curl_close($ch);
        $header['errno'] = $err;
        $header['errmsg'] = $errmsg;
        $header['content'] = $content;
        return $content;
    }

    public function get_url()
    {
        $string = Mage::getBaseURL();
        $string1 = str_replace("index.php/", "", $string);
        $string2 = str_replace('/', '%2F', $string1);
        $string3 = str_replace(':', '%3A', $string2);
        return $string3;
    }

    public function generateSitemapXML()
    {
        $objOfInterval = Mage::getModel('signifymap/signifymap');
        $signifyMapInterval = $objOfInterval->getRow();

        if ($signifyMapInterval['format'] == 'hours')
        {
            $changefreqInterval = '<changefreq>hourly</changefreq>';
        }

        if ($signifyMapInterval['format'] == 'days')
        {
            $changefreqInterval = '<changefreq>daily</changefreq>';
        }

        if ($signifyMapInterval['format'] == 'weeks')
        {
            $changefreqInterval = '<changefreq>weekly</changefreq>';
        }

        if ($signifyMapInterval['format'] == 'months')
        {
            $changefreqInterval = '<changefreq>monthly</changefreq>';
        }

        /*Start Site URL & SEO Rewrite URL*/
            $str = Mage::getStoreConfig(Mage_Core_Model_Url::XML_PATH_SECURE_URL);
            $SiteBaseUrl = rtrim($str, '/');

            $getRewriteUrlAdmin = Mage::getModel('core/config_data')->getCollection()->addFieldToFilter('path','web/seo/use_rewrites');
            foreach ($getRewriteUrlAdmin as $SeoValue)
            {
                $getSeoRewrite = $SeoValue->getValue();
            }
        /*End Site URL & SEO Rewrite URL*/

        $config = Mage::getModel('signifymap/config');
        $row = $config->getRow();
        if ($row['configured'] == 0)
            return false;
        $content = @file_get_contents('sitemap/sitemap.xml');
        $content = str_replace('</urlset>', '', $content);
        $content .= '<?xml version="1.0" encoding="utf-8"?><urlset>';

        $content .= '<url><loc>'.$SiteBaseUrl.'</loc>';
        $content .= '<lastmod>' . date('Y-m-d') . '</lastmod>';
        $content .= $changefreqInterval;
        $content .= '<priority>1.00</priority>';
        $content .= '</url>';

        $count = 0;
        if ($row['category'] == 'yes') {
            $catsCollation = Mage::getModel('catalog/category')->load(2)->getChildren();
            $catIdsCollation = explode(',', $catsCollation);
            foreach ($catIdsCollation as $catId) {
                if ($catId != '') {
                    $category = Mage::getModel('catalog/category')->load($catId);
                    $subCats = Mage::getModel('catalog/category')->load($category->getId())->getChildren();
                     $subCatIds = explode(',', $subCats);
                    
                    if($getSeoRewrite == '1')
                    {
                        $url = $str.$category->getRequestPath();
                    }else
                    {
                        $url = $category->getUrl();
                    }

                    if (strpos($content, $url) === false) {
                        $content .= '<url><loc>' . $url . '</loc>';
                        $content .= '<lastmod>' . date('Y-m-d') . '</lastmod>';
                        $content .= $changefreqInterval;
                        $content .= '<priority>0.60</priority>';
                        $content .= '</url>';
                        $count++;
                    }
                    
                    if (count($subCatIds) > 0) {
                        foreach ($subCatIds as $subCat) {
                            $subCategory = Mage::getModel('catalog/category')->load($subCat);
                            $url = $subCategory->getUrl();

                            $strcatalog = $str . 'index.php/catalog/category/view/';

                            if($strcatalog !=  $url)
                            {
                                if($getSeoRewrite == '1')
                                {
                                    $CategoryUrl = str_replace("index.php/", "", $url);
                                }else
                                {
                                    $CategoryUrl = $url;
                                }

                                if (strpos($content, $url) === false) {
                                    $content .= '<url><loc>' . $CategoryUrl . '</loc>';
                                    $content .= '<lastmod>' . date('Y-m-d') . '</lastmod>';
                                    $content .= $changefreqInterval;
                                    $content .= '<priority>0.50</priority>';
                                    $content .= '</url>';
                                    $count++;
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($row['product'] == 'yes') {
            $storeId = Mage::app()->getStore()->getId();
            $product = Mage::getModel('catalog/product');
            $productsCollation = $product->getCollection()->addStoreFilter($storeId)->getData();
            foreach ($productsCollation as $pro) {
                $Stock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($pro['entity_id'])->getIsinStock();
                if ($Stock) {
                    $_product = $product->load($pro['entity_id']);

                    if($getSeoRewrite == '1')
                    {
                        $url = $str . $_product->getUrlPath();
                    }else
                    {
                        $url = Mage::getUrl() . $_product->getUrlPath();
                    }

                    if (strpos($content, $url) === false && $_product->getStatus() != 2) {
                        $content .= '<url><loc>' . $url . '</loc>';
                        $content .= '<lastmod>' . date('Y-m-d') . '</lastmod>';
                        $content .= $changefreqInterval;
                        $content .= '<priority>0.90</priority>';
                        $content .= '</url>';
                        $count++;
                    }
                }
            }
        }

        if ($row['cms'] == 'yes') {
            $CmsCollection = Mage::getModel('cms/page')->getCollection()
                            ->addFieldToFilter('is_active', 1);
                            /* ->addStoreFilter(Mage::app()->getWebsite()->getId()); */

            foreach ($CmsCollection as $page) {
                $PageData = $page->getData();
                if ($PageData['identifier'] != 'no-route' && $PageData['identifier'] != 'enable-cookies' && $PageData['identifier'] != 'home') {
                    if($getSeoRewrite == '1')
                    {
                        $url = $str . $PageData['identifier'];
                    }else
                    {
                        $url = Mage::getUrl() . $PageData['identifier'];
                    }
                    if (strpos($content, $url) === false) {
                        $content .= '<url><loc>' . $url . '</loc>';
                        $content .= '<lastmod>' . date('Y-m-d') . '</lastmod>';
                        $content .= $changefreqInterval;
                        $content .= '<priority>0.80</priority>';
                        $content .= '</url>';
                        $count++;
                    }
                }
            }
        }
        $content .= '</urlset>';
        $url_dir = Mage::getBaseDir() . "/sitemap.xml";
        $file_handle = fopen($url_dir, 'w');
        fwrite($file_handle, $content);
        fclose($file_handle);
        return true;
    }

    public function changeInterval()
    {
        $obj = Mage::getModel('signifymap/signifymap');
        $signifymap = $obj->getRow();
        
        if ($signifymap['format'] == 'hours')
        {
            $ping_interval = $signifymap['ping_interval'];
            $cron = '0 */' . $ping_interval . ' * * *';
        }

        if ($signifymap['format'] == 'days')
        {
            $ping_interval = $signifymap['ping_interval'];
            $cron = '0 0 */' . $ping_interval . ' * *';
        }

        if ($signifymap['format'] == 'weeks')
        {
            $ping_interval = $signifymap['ping_interval'];
            if ($ping_interval == '')
            {
                $cron = '0 0 * * 0';
            }else
            {
                $cron = '0 0 * * ' . $ping_interval;
            }
        }

        if ($signifymap['format'] == 'months')
        {
            $ping_interval = $signifymap['ping_interval'];
            if ($ping_interval == '')
            {
                $cron = '0 0 0 * *';
            }else
            {
                $cron = '0 0 ' . $ping_interval . ' * *';
            }
        }
        $url = Mage::getBaseDir('code') . '/community/Studio45/Signifymap/etc/config.xml';
        $endreXML = simplexml_load_file($url);
        $endreXML->crontab[0]->jobs[0]->Studio45_Signifymap[0]->schedule[0]->cron_expr = $cron;
        file_put_contents($url, $endreXML->asXML());
    }
}
