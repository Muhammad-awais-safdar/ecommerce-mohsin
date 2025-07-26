<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TrackingScriptsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tracking_scripts')->delete();
        
        \DB::table('tracking_scripts')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Meta Pixel',
                'location' => 'head',
                'script' => '<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version=\'2.0\';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,\'script\',
\'https://connect.facebook.net/en_US/fbevents.js\');
fbq(\'init\', \'1467665391074306\');
fbq(\'track\', \'PageView\');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1467665391074306&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->',
            'is_active' => 1,
            'created_at' => '2025-05-21 22:40:52',
            'updated_at' => '2025-07-02 22:49:17',
        ),
        1 => 
        array (
            'id' => 2,
            'name' => 'Google Analytics 4',
            'location' => 'head',
        'script' => '<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag(\'js\', new Date());

gtag(\'config\', \'G-XXXXXXXXXX\');
</script>',
            'is_active' => 1,
            'created_at' => '2025-05-21 22:40:52',
            'updated_at' => '2025-05-21 22:40:52',
        ),
        2 => 
        array (
            'id' => 3,
            'name' => 'TikTok Pixel',
            'location' => 'head',
            'script' => '<!-- TikTok Pixel -->
<script>
!function (w, d, t) {
w.TiktokAnalyticsObject = t;
var ttq = w[t] = w[t] || [];
ttq.methods = ["page", "track", "identify", "instances", "debug", "on", "off", "once", "ready", "alias", "group", "enableCookie", "disableCookie"];
ttq.setAndDefer = function (t, e) {
t[e] = function () {
t.push([e].concat(Array.prototype.slice.call(arguments, 0)))
}
};
for (var i = 0; i < ttq.methods.length; i++) {
ttq.setAndDefer(ttq, ttq.methods[i])
}
ttq.instance = function (t) {
var e = ttq._i[t] || [];
for (var n = 0; n < ttq.methods.length; n++) {
ttq.setAndDefer(e, ttq.methods[n])
}
return e
};
ttq.load = function (e, n) {
var i = "https://analytics.tiktok.com/i18n/pixel/events.js";
ttq._i = ttq._i || {};
ttq._i[e] = [];
ttq._i[e]._u = i;
ttq._t = ttq._t || {};
ttq._t[e] = +new Date;
ttq._o = ttq._o || {};
ttq._o[e] = n || {};
var o = document.createElement("script");
o.type = "text/javascript";
o.async = !0;
o.src = i;
var a = document.getElementsByTagName("script")[0];
a.parentNode.insertBefore(o, a)
};

ttq.load(\'YOUR_PIXEL_ID\');
ttq.page();
}(window, document, \'ttq\');
</script>
<!-- End TikTok Pixel -->',
            'is_active' => 1,
            'created_at' => '2025-05-21 22:40:52',
            'updated_at' => '2025-05-21 22:40:52',
        ),
    ));
        
        
    }
}