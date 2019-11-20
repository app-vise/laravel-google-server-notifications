<?php

return json_decode('{
        "version":"1.0",
        "packageName":"com.some.thing",
        "eventTimeMillis":"1503349566168",
        "subscriptionNotification":
        {
            "version":"1.0",
            "notificationType": 1,
            "purchaseToken":"PURCHASE_TOKEN",
            "subscriptionId":"my.sku"
        }
    }', true);
