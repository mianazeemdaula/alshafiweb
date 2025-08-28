# API DOCUMENTATION

```
Version 2.
```

## Contents


- Base URL
- Authentication
   - GET& POST Get All Cities
      - Description
      - API Request
      - API Response
   - GET& POST Track Booked Packet
      - Description
      - API Request
      - API Response
   - GET& POST Book a Packet
      - API Request
      - API Response
   - POST Batch Book Packet
      - API Request
      - API Response
   - POST Cancel Booked Packets
      - API Request
   - POST Generate Load Sheet
      - API Request
      - API Response
   - POST Download Load Sheet
      - API Request
      - API Response
   - GET Get Booked Packet Last Statuses By Date Range
      - API Request
   - POST Shipper Advice List
      - API Request
      - API Response
   - POST Get Shipment Details By Order ID(s)
   - API Response
- GET Get All Banks
   - API Request
- POST Create Shipper
   - API Request
   - API Response
- GET Get Payment Details By CN Number(s)
   - API Request
   - API Response
- GET Get Tariff Details
   - API Request
   - API Response
- GET Get Shipping Charges
   - API Request
   - API Response
- GET Get Shipper Details
   - API Request
   - API Response
- GET Get Electronic Proof Of Delivery
   - API Request
   - API Response
- POST Shipper Advice List
   - API Request
   - API Response
- POST Activity Log.....................................................................................................................
   - API Request
   - API Response
- POST Add Shipper Advices
   - API Request
   - API Response


## Base URL

```
Staging https://merchantapistaging.leopardscourier.com/api/^
Production https://merchantapi.leopardscourier.com/api/^
```
## Authentication

```
For the Get requests we will send these keys as parameters and for the post Api’s we will send these
parameters in request body these keys merchant can get from his account.
These are test account API credentials, do not use it for live/production environment.
For live API Credentials, please log in to your account & see API management option under API settings
```
**tabs. There,**^ **key will be required to generated & password will be chosen.**^

**api_password**^^123456

```
api_key c7ab1d5f6b35f23b496c9cc24d4715c^
```

### GET& POST Get All Cities

### Description:

To get list of all cities along with their origin and destination checks.
Staging Link:
https://merchantapistaging.leopardscourier.com/api/getAllCities/format/xml/ For 'XML' format
https://merchantapistaging.leopardscourier.com/api/getAllCities/format/json/ For 'JSON' format
Production Link:
https://merchantapi.leopardscourier.com/api/getAllCities/format/xml/ For 'XML' format
https://merchantapi.leopardscourier.com/api/getAllCities/format/json/ For 'JSON' format

#### API Request

The following is a sample API request using cURL in PHP.
$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL,
'https://merchantapistaging.leopardscourier.com/api/getAllCities/format/json/'); // Write here or
Production Link
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_POST, 1);
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode(array(
'api_key' => 'your_api_key'
'api_password' => 'your_api_password'
)));

$buffer = curl_exec($curl_handle);
curl_close($curl_handle);


#### API Response

The following is a JSON response with Error(s).
{
"status":0,
"error":"string",
"city_list":null
}

The following is a XML response with Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>0</status>
<error>string</error>
<city_list/>
</xml>

The following is a JSON response without Error(s).
{
"status":1,
"error":"0",
"city_list": [
{
"id" : int,
"name" : "string",
"shipment_type”: [
"string",


"string"
],
"allow_as_origin”: Boolean,
"allow_as_destination”: Boolean
},
{
"id" : int,
"name" : "string",
"shipment_type”: [
"string",
"string",
"string"
],
"allow_as_origin”: Boolean,
"allow_as_destination”: Boolean
}
]
}

The following is a XML response without Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>1</status>
<error>0</error>
<city_list>
<item>
<id>int</id>


<name>string</name>
<shipment_type>
<item>string</item>
<item>string</item>
</shipment_type>
</item>
<item>
<id>int</id>
<name>string</name>
<shipment_type>
<item>string</item>
<item>string</item>
<item>string</item>
</shipment_type>
</item>
</city_list>
</xml>


### GET& POST Track Booked Packet

### Description:

This resource will be used to track a single packet.
Staging Link:
https://merchantapistaging.leopardscourier.com/api/trackBookedPacket/format/xml/ For 'XML'
format
https://merchantapistaging.leopardscourier.com/api/trackBookedPacket/format/json/ For 'JSON'
format
Production Link:
https://merchantapi.leopardscourier.com/api/trackBookedPacket/format/xml/ For 'XML' format
https://merchantapi.leopardscourier.com/api/trackBookedPacket/format/json/ For 'JSON' format

#### API Request

The following is a sample API request using cURL in PHP.
$curl_handle = curl_init();

// For Direct Link Access use below commented link
//curl_setopt($curl_handle, CURLOPT_URL,
'https://merchantapistaging.leopardscourier.com/api/trackBookedPacket/?api_key=XXXX&api_passwor
d=XXXX&track_numbers=XXXXXXXX'); // For Get Mother/Direct Link

curl_setopt($curl_handle, CURLOPT_URL,
'https://merchantapistaging.leopardscourier.com/api/trackBookedPacket/format/json/'); // Write here
or Production Link
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_POST, 1);
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode(array(
'api_key' => 'your_api_key'
'api_password' => 'your_api_password'


#### API Response

'track_numbers' => 'string'
Digits each number

```
// E.g. 'XXYYYYYYYY' OR 'XXYYYYYYYY,XXYYYYYYYY,XXYYYYYY' 10
```
)));

$buffer = curl_exec($curl_handle);
curl_close($curl_handle);

The following is a JSON response with Error(s).
{
"status" :0,
"error" :"string",
"packet_list" :null
}

The following is a XML response with Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>0</status>
<error>string</error>
<packet_list/>
</xml>

The following is a JSON response without Error(s).
{
"status" :1,
"error" :0,
"packet_list" : [


##### {

```
"booking_date" :"dd/mm/YY",
"track_number" :"string",
"track_number_short" :"int",
"booked_packet_weight" :"int",
"booked_packet_vol_weight_w" :"int",
"booked_packet_vol_weight_h" :"int",
"booked_packet_vol_weight_l" :"int",
"booked_packet_no_piece" :"int",
"booked_packet_collect_amount" :"int",
"booked_packet_order_id" :"string",
"origin_city_name" :"string",
"destination_city_name" :"string",
"invoice_number" :"string",
"invoice_date" :"string",
"shipment_name_eng" :"string",
"shipment_email" :"string",
"shipment_phone" :"int",
"shipment_address" :"string",
"consignment_name_eng" :"string",
"consignment_email" :"string",
"consignment_phone" :"int",
"consignment_phone_two" :"int",
"consignment_phone_three" :"int",
"consignment_address" :"string",
"special_instructions" :"string",
"booked_packet_status" :"string",
```

"activity_date" :"string",
"status_reamrks" :"string", /* it will show the receiver name in case of packet
delivery and reason if packet is pending/return with any reason*/
"reverseCN": "string(KI000000001)", /* if the tracked numbers is VPC CN, else
this will not appear */
/* Tracking detail will be in loop */
"Tracking Detail": [
{
"Staus"; : "string",
"Reciever Name" : "string",
"Activity Date" : "yyyy-mm-dd",
"Reason" : "string"
}
]
}
/* For more than One Track Numbers below section will repeated */
,{
"booking_date" :"dd/mm/YY",
"track_number" :"string",
"track_number_short" :"int",
"booked_packet_weight" :"int",
"booked_packet_vol_weight_w" :"int",
"booked_packet_vol_weight_h" :"int",
"booked_packet_vol_weight_l" :"int",
"booked_packet_no_piece" :"int",
"booked_packet_collect_amount" :"int",
"booked_packet_order_id" :"string",
"origin_city_name" :"string",


"destination_city_name" :"string",
"invoice_number" :"string",
"invoice_date" :"string",
"shipment_name_eng" :"string",
"shipment_email" :"string",
"shipment_phone" :"int",
"shipment_address" :"string",
"consignment_name_eng" :"string",
"consignment_email" :"string",
"consignment_phone" :"int",
"consignment_phone_two" :"int",
"consignment_phone_three" :"int",
"consignment_address" :"string",
"special_instructions" :"string",
"booked_packet_status" :"string",
"activity_date" :"string",
"status_remarks" :"string", /* it will show the receiver name in case of packet
delivery and reason, if packet is pending/return with any reason */
"reverseCN" :"string(KI000000001)", /* if the tracked numbers is VPC CN, else
this will not appear */
/* Tracking detail will be shown in loop */
"Tracking Detail": [
{
"Staus" : "string",
"Reciever Name" : "string",
"Activity Date" : "yyyy-mm-dd",
"Reason" : "string"
}


##### ]

##### }

##### ]

##### }

The following is a XML response without Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>1</status>
<error>0</error>
<packetList>
<item>
<booking_date>dd/mm/YY</booking_date>
<track_number>int</track_number>
<track_number_short>int</track_number_short>
<booked_packet_weight>int</booked_packet_weight>
<booked_packet_vol_weight_w>int</booked_packet_vol_weight_w>
found it will <booked_packet_vol_weight_w/> */

```
/* If no value
```
<booked_packet_vol_weight_h>int</booked_packet_vol_weight_h>
found it will <booked_packet_vol_weight_h/> */

```
/* If no value
```
<booked_packet_vol_weight_l>int</booked_packet_vol_weight_l>
it will <booked_packet_vol_weight_l/> */

```
/* If no value found
```
<booked_packet_no_piece>int</booked_packet_no_piece>
<booked_packet_collect_amount>int</booked_packet_collect_amount>
<booked_packet_order_id>string</booked_packet_order_id>
keep it empty), If no value found it will <booked_packet_order_id/> */

```
/* Optional Field (You can
```
```
<origin_city_name>string</origin_city_name>
```

<destination_city_name>string</destination_city_name>
<invoice_number>string</invoice_number>
<invoice_date>string</invoice_date>
<shipment_name_eng>string</shipment_name_eng>
<shipment_email>string</shipment_email>
<shipment_phone>int</shipment_phone>
<shipment_address>string</shipment_address>
<consignment_name_eng>string</consignment_name_eng>
<consignment_email>string</consignment_email>
<consignment_phone>int</consignment_phone>
<consignment_phone_two>int</consignment_phone>
<consignment_phone_three>int</consignment_phone>
<consignment_address>string</consignment_address>
<special_instructions>string</special_instructions>
<booked_packet_status>string</booked_packet_status>
<acitivity_date>string</acitivity_date>
<status_remarks>string</status_remarks> /* It will show the receiver name in case of packet
delivery and reason if packet is pending/return with any reason */
<reverseCN>string(KI000000001)</reverseCN> /* if the tracked numbers is VPC CN, else this will
not appear */
<TrackingDetail> /* Tracking detail will be shown in loop */
Æ<item>
<Status>string</Status>
<Reciever_Name>string</Reciever_Name>
<Activity_Date>Date</<Activity_Date>
<Activity_Time>Time</Activity_Time>
<Reason>string</Reason>
</item>


</TrackingDetail>
</item>
/* For more than One Track Numbers 'item' section will repeated */
<item>
<booking_date>dd/mm/YY</booking_date>
<track_number>int</track_number>
<track_number_short>int</track_number_short>
<booked_packet_weight>int</booked_packet_weight>
<booked_packet_vol_weight_w>int</booked_packet_vol_weight_w> /* If no value
found it will <booked_packet_vol_weight_w/> */
<booked_packet_vol_weight_h>int</booked_packet_vol_weight_h> /* If no value
found it will <booked_packet_vol_weight_h/> */
<booked_packet_vol_weight_l>int</booked_packet_vol_weight_l> /* If no value found
it will <booked_packet_vol_weight_l/> */
<booked_packet_no_piece>int</booked_packet_no_piece>
<booked_packet_collect_amount>int</booked_packet_collect_amount>
<booked_packet_order_id>string</booked_packet_order_id>
<origin_city_name>string</origin_city_name>
<destination_city_name>string</destination_city_name>
<invoice_number>string</invoice_number>
<invoice_date>string</invoice_date>
<shipment_name_eng>string</shipment_name_eng>
<shipment_email>string</shipment_email>
<shipment_phone>int</shipment_phone>
<shipment_address>string</shipment_address>
<consignment_name_eng>string</consignment_name_eng>
<consignment_email>string</consignment_email>
<consignment_phone>int</consignment_phone>


<consignment_phone_two>int</consignment_phone>
<consignment_phone_three>int</consignment_phone>
<consignment_address>string</consignment_address>
<special_instructions>string</special_instructions>
<booked_packet_status>string</booked_packet_status>
<acitivity_date>string</acitivity_date>
<stauts_remarks>string</stauts_remarks> /* It will show the receiver name in case of packet
delivery and reason if packet is pending/return with any reason */
<reverseCN>string(KI000000001)</reverseCN> /* if the tracked numbers is VPC CN, else this will
not appear */

<TrackingDetail> /* Tracking detail will be shown in loop */
<item>
<Status>string</Status>
<Reciever_Name>string</Reciever_Name>
<Activity_Date>Date</<Activity_Date>
<Activity_Time>Time</Activity_Time>
<Reason>string</Reason>
</item>
</TrackingDetail>
</item>
</packetList>
</xml>


### GET& POST Book a Packet

Staging Link:
https://merchantapistaging.leopardscourier.com/api/bookPacket/format/xml/ For 'XML' format
https://merchantapistaging.leopardscourier.com/api/bookPacket/format/json/ For 'JSON' format
Production Link:
https://merchantapi.leopardscourier.com/api/bookPacket/format/xml/ For 'XML' format
https://merchantapi.leopardscourier.com/api/bookPacket/format/json/ For 'JSON' format

#### API Request

```
'booked_packet_order_id' => 'string', // Optional Filed, (If any) Order ID of Given Product
```
```
'booked_packet_collect_amount' => int, // Collection Amount on Delivery
```
```
'booked_packet_no_piece' => int, // No. of Pieces should an Integer Value
```
'booked_packet_vol_weight_l' => int, // Optional Field (You can keep it empty), Volumetric
Weight Length

'booked_packet_vol_weight_h' => int, // Optional Field (You can keep it empty), Volumetric
Weight Height

'booked_packet_vol_weight_w' => int, // Optional Field (You can keep it empty),
Volumetric Weight Width

```
'booked_packet_weight' => int, // Weight should in 'Grams' e.g. '2000'
```
```
'api_password' => 'your_api_password'
```
```
'api_key' => 'your_api_key'
```
curl_setopt($curl_handle, CURLOPT_URL,
'https://merchantapistaging.leopardscourier.com/api/bookPacket/format/json/'); // Write here or
Production Link
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_POST, 1);
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode(array(

The following is a sample API request using cURL in PHP.
$curl_handle = curl_init();


'origin_city' => 'string', /** Params: 'self' or 'integer_value' e.g. 'origin_city' => 'self' or
'origin_city' => 789 (where 789 is Lahore ID)
* If 'self' is used then Your City ID will be used.
* 'integer_value' provide integer value (for integer values read 'Get All
Cities' api documentation)
*/

'destination_city' => 'string', /** Params: 'self' or 'integer_value' e.g. 'destination_city' =>
'self' or 'destination_city' => 789 (where 789 is Lahore ID)
* If 'self' is used then Your City ID will be used.
* 'integer_value' provide integer value (for integer values read 'Get All
Cities' api documentation)
*/

'shipment_id' => 'int',
'shipment_name_eng' => 'string', // Params: 'self' or 'Type any other Name here', If 'self'
will used then Your Company's Name will be Used here
'shipment_email' => 'string', // Params: 'self' or 'Type any other Email here', If 'self' will
used then Your Company's Email will be Used here
'shipment_phone' => 'string', // Params: 'self' or 'Type any other Phone Number here',
If 'self' will used then Your Company's Phone Number will be Used here
'shipment_address' => 'string', // Params: 'self' or 'Type any other Address here', If 'self'
will used then Your Company's Address will be Used here
'consignment_name_eng' => 'string', // Type Consignee Name here
'consignment_email' => 'string', // Optional Field (You can keep it empty), Type
Consignee Email here
'consignment_phone' => 'string', // Type Consignee Phone Number here
'consignment_phone_two' => 'string', // Optional Field (You can keep it empty), Type
Consignee Second Phone Number here


#### API Response

$buffer = curl_exec($curl_handle);
curl_close($curl_handle);

booked_packet_order_id should be a CN number
)));

```
'is_vpc' => 'int', // Optional Field (You can keep it empty) If is_vpc =1 then
```
empty, then shipper's origin city will ne return city

```
'return_city' => 'int', // Optional Field (You can keep it empty) - If 'return_city' is
```
'return_address' is empty, then the address of shipper will be added as return address

```
'return_address' => 'string', // Optional Field (You can keep it empty) - If
```
[{"key1":"value1","key2":value2,. .....}]

```
'custom_data' => 'json array', // Optional Field (You can keep it empty),
```
default value i.e. "overnight"), Type Shipment type name here

```
'shipment_type' => 'string', // Optional Field (You can keep it empty so It will pick
```
```
'special_instructions' => 'string', // Type any instruction here regarding booked packet
```
```
'consignment_address' => 'string', // Type Consignee Address here
```
Consignee Third Phone Number here

```
'consignment_phone_three' => 'string', // Optional Field (You can keep it empty), Type
```
The following is a JSON response with Error(s).
{
"status" : 0,
"error" : "string",
"track_number" : null
"slip_link" : null
}

The following is a XML response with Error(s).


<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>0</status>
<error>string</error>
<track_number/>
<slip_link/>
</xml>

The following is a JSON response without Error(s).
{
"status" : 1,
"error" : 0,
"track_number" : "string"

"slip_link" : "string" (^) // Copy this URL in Browser to Get Slip
}
The following is a XML response without Error(s).
<?xml version="1.0" encoding="utf- 8 "?>
<xml>
<status>1</status>
<error>0</error>
<track_number>string</track_number>
<slip_link>string</slip_link> /* Copy this URL in Browser to Get Slip */
</xml>


### POST Batch Book Packet

Staging Link:
https://merchantapistaging.leopardscourier.com/api/batchBookPacketsv2/format/xml/ For 'XML' format
https://merchantapistaging.leopardscourier.com/api/batchBookPacketsv2/format/json/ For 'JSON' format
Production Link:
https://merchantapi.leopardscourier.com/api/batchBookPacketv2/format/xml/ For 'XML' format
https://merchantapi.leopardscourier.com/api/batchBookPacketv2/format/json/ For 'JSON' format

#### API Request

The following is a sample API request using cURL in PHP.
$curl_handle = curl_init();

curl_setopt($curl_handle, CURLOPT_URL,
'https://merchantapistaging.leopardscourier.com/api/batchBookPacket/format/json/'); // Write here
or Production Link
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_POST, 1);
curl_setopt($curl_handle, CURLOPT_POSTFIELDS,
json_encode(
array(
'api_key' => 'your_api_key'
'api_password' => 'your_api_password'
'packets' =>
array(
array(
'booked_packet_weight' => int, // Weight should in 'Grams' e.g. '2000'
'booked_packet_vol_weight_w' => int,
Volumetric Weight Width

```
// Optional Field (You can keep it empty),
```
'booked_packet_vol_weight_h' => int,
Volumetric Weight Height

```
// Optional Field (You can keep it empty),
```

'booked_packet_vol_weight_l' => int, // Optional Field (You can keep it empty),
Volumetric Weight Length
'booked_packet_no_piece' => int, // No. of Pieces should an Integer Value
'booked_packet_collect_amount' => int, // Collection Amount on Delivery
'booked_packet_order_id' => 'string', // Optional Filed, (If any) Order ID of Given
Product

'origin_city' => 'string', /** Params: 'self' or 'integer_value' e.g. 'origin_city'
=> 'self' or 'origin_city' => 789 (where 789 is Lahore ID)
* If 'self' is used then Your City ID will be used.
* 'integer_value' provide integer value (for integer values
read 'Get All Cities' api documentation)
*/

'destination_city' => 'string', /** Params: 'self' or 'integer_value' e.g.
'destination_city' => 'self' or 'destination_city' => 789 (where 789 is Lahore ID)
* If 'self' is used then Your City ID will be used.
* 'integer_value' provide integer value (for integer values
read 'Get All Cities' api documentation)
*/
'shipment_id' => 'int',
'shipment_name_eng' => 'string', // Params: 'self' or 'Type any other Name
here', If 'self' will used then Your Company's Name will be Used here
'shipment_email' => 'string', // Params: 'self' or 'Type any other Email here',
If 'self' will used then Your Company's Email will be Used here
'shipment_phone' => 'string', // Params: 'self' or 'Type any other Phone
Number here', If 'self' will used then Your Company's Phone Number will be Used here
'shipment_address' => 'string', // Params: 'self' or 'Type any other Address
here', If 'self' will used then Your Company's Address will be Used here
'consignment_name_eng' => 'string', // Type Consignee Name here


'consignment_email' => 'string', // Optional Field (You can keep it empty),
Type Consignee Email here
'consignment_phone' => 'string', // Type Consignee Phone Number here
'consignment_phone_two' => 'string', // Optional Field (You can keep it empty),
Type Consignee Second Phone Number here
'consignment_phone_three' => 'string', // Optional Field (You can keep it empty),
Type Consignee Third Phone Number here
'consignment_address' => 'string', // Type Consignee Address here
'special_instructions' => 'string', // Type any instruction here regarding booked
packet
'shipment_type' => 'string', // Optional Field (You can keep it empty so It
will pick default value i.e. "overnight"), Type Shipment type name here
'custom_data' => 'json array', // Optional Field (You can keep it empty),
[{"key1":"value1","key2":value2,. .... }]
'return_address' => 'string', // Optional Field (You can keep it empty) - If
'return_address' is empty, then the address of shipper will be added as return address
'return_city' => 'int', // Optional Field (You can keep it empty) - If
'return_city' is empty, then shipper's origin city will ne return city
'is_vpc' => 'int', // Optional Field (You can keep it empty) If is_vpc =1
then booked_packet_order_id should be a CN number
),

```
/* For more than One Booked Packet below section will repeated */
```
array(
'booked_packet_weight' => int, // Weight should in 'Grams' e.g. '2000'
'booked_packet_vol_weight_w' => int, // Optional Field (You can keep it empty),
Volumetric Weight Width
'booked_packet_vol_weight_h' => int, // Optional Field (You can keep it empty),
Volumetric Weight Height


'booked_packet_vol_weight_l' => int, // Optional Field (You can keep it empty),
Volumetric Weight Length
'booked_packet_no_piece' => int, // No. of Pieces should an Integer Value
'booked_packet_collect_amount' => int, // Collection Amount on Delivery
'booked_packet_order_id' => 'string', // Optional Filed, (If any) Order ID of Given
Product

'origin_city' => 'string', /** Params: 'self' or 'integer_value' e.g. 'origin_city'
=> 'self' or 'origin_city' => 789 (where 789 is Lahore ID)
* If 'self' is used then Your City ID will be used.
* 'integer_value' provide integer value (for integer values
read 'Get All Cities' api documentation)
*/

'destination_city' => 'string', /** Params: 'self' or 'integer_value' e.g.
'destination_city' => 'self' or 'destination_city' => 789 (where 789 is Lahore ID)
* If 'self' is used then Your City ID will be used.
* 'integer_value' provide integer value (for integer values
read 'Get All Cities' api documentation)
*/
'shipment_id' => 'int',
'shipment_name_eng' => 'string', // Params: 'self' or 'Type any other Name
here', If 'self' will used then Your Company's Name will be Used here
'shipment_email' => 'string', // Params: 'self' or 'Type any other Email here',
If 'self' will used then Your Company's Email will be Used here
'shipment_phone' => 'string', // Params: 'self' or 'Type any other Phone
Number here', If 'self' will used then Your Company's Phone Number will be Used here
'shipment_address' => 'string', // Params: 'self' or 'Type any other Address
here', If 'self' will used then Your Company's Address will be Used here
'consignment_name_eng' => 'string', // Type Consignee Name here


'consignment_email' => 'string', // Optional Field (You can keep it empty),
Type Consignee Email here
'consignment_phone' => 'string', // Type Consignee Phone Number here
'consignment_phone_two' => 'string', // Optional Field (You can keep it empty),
Type Consignee Second Phone Number here
'consignment_phone_three' => 'string', // Optional Field (You can keep it empty),
Type Consignee Third Phone Number here
'consignment_address' => 'string', // Type Consignee Address here
'special_instructions' => 'string', // Type any instruction here regarding booked
packet
'shipment_type' => 'string', // Optional Field (You can keep it empty so It
will pick default value i.e. "overnight"), Type Shipment type name here
'custom_data' => 'json array', // Optional Field (You can keep it empty),
[{"key1":"value1","key2":value2,. .... }]
'return_address' => 'string', // Optional Field (You can keep it empty) - If
'return_address' is empty, then the address of shipper will be added as return address
'return_city' => 'int', // Optional Field (You can keep it empty) - If
'return_city' is empty, then shipper's origin city will ne return city
'is_vpc' => 'int', // Optional Field (You can keep it empty) If is_vpc =1
then booked_packet_order_id should be a CN number
)

##### )

##### )

##### )

##### );

curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json'
));


#### API Response

$response = curl_exec($curl_handle);
curl_close($curl_handle);
echo $response;

The following is a JSON response with Error(s).
{
"status" : 0,
"error" : {

```
"bookPacket - 0": {
"booked_packet_weight": "Packet Weight is required",
"booked_packet_no_piece": "No. of Pieces is required",
"booked_packet_collect_amount": "COD Amount is required",
"origin_city": "Origin City is required",
"destination_city": "Destination City is required",
"shipment_name_eng": "Shipper Name is required",
"shipment_phone": "Shipper Phone is required",
"shipment_address": "Shipper Address is required",
"consignment_name_eng": "Consignee Name is required",
"consignment_phone": "Consignee Phone is required",
"consignment_address": "Consignee Address is required",
"special_instructions": "Special Instructions are required"
},
```
```
/* For more than One Booked Packet above section will repeated */
```

"bookPacket - 1": {
"booked_packet_weight": "Packet Weight is required",
"booked_packet_no_piece": "No. of Pieces is required",
"booked_packet_collect_amount": "COD Amount is required",
"origin_city": "Origin City is required",
"destination_city": "Destination City is required",
"shipment_name_eng": "Shipper Name is required",
"shipment_phone": "Shipper Phone is required",
"shipment_address": "Shipper Address is required",
"consignment_name_eng": "Consignee Name is required",
"consignment_phone": "Consignee Phone is required",
"consignment_address": "Consignee Address is required",
"special_instructions": "Special Instructions are required",
"custom_data": "Invalid Custom Data / Custom Data must be Json Array"
}
}
,
}

The following is a XML response with Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>0</status>
<error>
<bookPacket-0>
<booked_packet_weight>string</booked_packet_weight>


<booked_packet_no_piece>string</booked_packet_no_piece>
<booked_packet_collect_amount>string</booked_packet_collect_amount>
<origin_city>string</origin_city>
<destination_city>string</destination_city>
<shipment_name_eng>string</shipment_name_eng>
<shipment_phone>string</shipment_phone>
<shipment_address>string</shipment_address>
<consignment_name_eng>string</consignment_name_eng>
<consignment_phone>string</consignment_phone>
<consignment_address>string</consignment_address>
<special_instructions>string</special_instructions>
</bookPacket-0>

/* For more than One Track Numbers 'item' section will repeated */

<bookPacket-1>
<booked_packet_weight>string</booked_packet_weight>
<booked_packet_no_piece>string</booked_packet_no_piece>
<booked_packet_collect_amount>string</booked_packet_collect_amount>
<origin_city>string</origin_city>
<destination_city>string</destination_city>
<shipment_name_eng>string</shipment_name_eng>
<shipment_phone>string</shipment_phone>
<shipment_address>string</shipment_address>
<consignment_name_eng>string</consignment_name_eng>
<consignment_phone>string</consignment_phone>
<consignment_address>string</consignment_address>


<special_instructions>string</special_instructions>
</bookPacket-1>
</error>
</xml>

##### }

##### ]

##### },

```
"slip_link" : "string" // Copy this URL in Browser to Get Slip
```
```
"booked_packet_order_id" : "string"
```
```
: "string"
```
##### {

```
"track_number"
```
```
/* For more than One Booked Packet above section will repeated */
```
##### },

```
"slip_link" : "string" // Copy this URL in Browser to Get Slip
```
```
"booked_packet_order_id" : "string"
```
```
"track_number" : "string"
```
The following is a JSON response without Error(s).
{
"status" : 1,
"error" : 0,
"data" : [
{


The following is a XML response without Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>1</status>
<error>0</error>
<data>
<item>
<track_number>string</track_number>
<booked_packet_order_id>string</booked_packet_order_id>
<slip_link>string</slip_link>
</item>

```
/* For more than One Track Numbers 'item' section will repeated */
```
<item>
<track_number>string</track_number>
<booked_packet_order_id>string</booked_packet_order_id>
<slip_link>string</slip_link>
</item>
</data>
</xml>


### POST Cancel Booked Packets

Staging Link:
https://merchantapistaging.leopardscourier.com/api/cancelBookedPackets/format/xml/ For 'XML'
format
https://merchantapistaging.leopardscourier.com/api/cancelBookedPackets/format/json/ For 'JSON'
format
Production Link:
https://merchantapi.leopardscourier.com/api/cancelBookedPackets/format/xml/ For 'XML' format
https://merchantapi.leopardscourier.com/api/cancelBookedPackets/format/json/ For 'JSON' format

#### API Request

The following is a sample API request using cURL in PHP.
$curl_handle = curl_init();

curl_setopt($curl_handle, CURLOPT_URL,
'https://merchantapistaging.leopardscourier.com/api/cancelBookedPackets/format/json/'); // Write
here or Production Link
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_POST, 1);
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode(array(
'api_key' => 'your_api_key',
'api_password' => 'your_api_password',
'cn_numbers' => 'string',
Digits each number

```
// E.g. 'XXYYYYYYYY' OR 'XXYYYYYYYY,XXYYYYYYYY,XXYYYYYY' 10
```
)));

$buffer = curl_exec($curl_handle);
curl_close($curl_handle);


### API Response

The following is a JSON response with Error(s).
{
"status": 0,
"error" :{
"provided_cn" : "error_string",
"provided_cn" : "error_string"
}
}

The following is a XML response with Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>0</status>
<error>
<provided_cn>"error_string"</provided_cn>
<provided_cn>"error_string"</provided_cn>
</error>
</xml>

The following is a JSON response without Error(s).
{
"status": "1",
"error" : "null",
}


The following is a XML response without Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>1</status>
<error>null</error>
</xml>


### POST Generate Load Sheet

Staging Link:
https://merchantapistaging.leopardscourier.com/api/generateLoadSheet/format/xml/ For 'XML'
format
https://merchantapistaging.leopardscourier.com/api/generateLoadSheet/format/json/ For 'JSON'
format
Production Link:
https://merchantapi.leopardscourier.com/api/generateLoadSheet/format/xml/ For 'XML' format
https://merchantapi.leopardscourier.com/api/generateLoadSheet/format/json/ For 'JSON' format

#### API Request

The following is a sample API request using cURL in PHP.
$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL,
'https://merchantapistaging.leopardscourier.com/api/generateLoadSheet/format/json/'); // Write here
or Production Link
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_POST, 1);
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode(array(
'api_key' => 'your_api_key',
'api_password' => 'your_api_password',
'cn_numbers' => array(), // E.g. array('XXYYYYYYYY') OR array('XXYYYYYYY1',
'XXYYYYYYY2', 'XXYYYYYYY3') 10 Digits each number
'courier_name' => 'courier_name',
'courier_code' => 'courier_code'
)));

$buffer = curl_exec($curl_handle);
curl_close($curl_handle);


#### API Response

The following is a JSON response with Error(s).
{
"status": 0,
"error" :{
"provided_cn" : "error_string",
"provided_cn" : "error_string"
}
}

The following is a XML response with Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>0</status>
<error>
<provided_cn>"error_string"</provided_cn>
<provided_cn>"error_string"</provided_cn>
</error>
</xml>

The following is a JSON response without Error(s).
{
"status" : "1",
"error" : "null",
"load_sheet_id" : "generated_loadsheet_id",
}


The following is a XML response without Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>1</status>
<error>null</error>
<load_sheet_id>generated_loadsheet_id</load_sheet_id>
</xml>


### POST Download Load Sheet

Staging Link:
https://merchantapistaging.leopardscourier.com/api/downloadLoadSheet/format/json For 'JSON'
format
https://merchantapistaging.leopardscourier.com/api/downloadLoadSheet/ For 'PDF' file
format
Production Link:
https://merchantapi.leopardscourier.com/api/downloadLoadSheet/format/json For 'JSON' format
https://merchantapi.leopardscourier.com/api/downloadLoadSheet/ For 'PDF' file format

#### API Request

The following is a sample API request using cURL in PHP.
$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL,
'https://merchantapistaging.leopardscourier.com/api/downloadLoadSheet/'); // Write here Production
Link
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_POST, 1);
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode(array(
'api_key' => 'your_api_key',
'api_password' => 'your_api_password',
'load_sheet_id' => int, // E.g. 123456
'response_type' => String // E.g. PDF or JSON
)));

$buffer = curl_exec($curl_handle);
curl_close($curl_handle);


#### API Response

The following is a JSON response with Error(s).
{
"status": "int",
"error" : "string"
}

The following is a XML response with Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>0</status>
<error>string</error>
</xml>

The following is a PDF resonse without Error(s), it will return binary data of PDF file so you can parse it
like:
file_put_contents("loadsheet.pdf", $response);
you want.

```
// You can change "loadsheet.pdf" to whatever
```
```
// $response is the API Response
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="'. basename("loadsheet.pdf"). '"');
readfile("loadsheet.pdf");
```
The following is a JSON response without Error(s).
{
"status": 1,
"error" : "",


"data" : [
{
"booking_date" : "YY/mm/dd",
"track_number" : "string",
"track_number_short" : "int",
"booked_packet_weight" : "int",
"booked_packet_no_piece" : "int",
"booked_packet_collect_amount" : "int",
"booked_packet_order_id" : "string",
"origin_city_id" : "int",
"destination_city_id" : "int",
"shipment_name_eng" : "string",
"shipment_email" : "string",
"shipment_phone" : "int",
"shipment_address" : "string",
"consignment_name_eng" : "string",
"consignment_email" : "string",
"consignment_phone" : "int",
"consignment_phone_two" : "int",
"consignment_phone_three" : "int",
"consignment_address" : "string",
"special_instructions" : "string",
"shipment_type_id" : "int",
"shipment_type_name" : "string"
},
/* For more than One Track Numbers below section will repeated */
{


"consignment_name_eng" : "string",
"consignment_email" : "string",
"consignment_phone" : "int",
"consignment_phone_two" : "int",
"consignment_phone_three" : "int",
"consignment_address" : "string",
"special_instructions" : "string",
"shipment_type_id" : "int",
"shipment_type_name" : "string"
}
]
}

```
: "int",
```
```
"booking_date" : "YY/mm/dd",
"track_number" : "string",
"track_number_short" : "int",
"booked_packet_weight" : "int",
"booked_packet_no_piece" : "int",
"booked_packet_collect_amount" : "int",
"booked_packet_order_id" : "string",
"origin_city_id"
```
```
: "string",
```
```
"destination_city_id" : "int",
"shipment_name_eng" : "string",
"shipment_email" : "string",
"shipment_phone" : "int",
"shipment_address"
```

### GET Get Booked Packet Last Statuses By Date Range

Staging Link:
https://merchantapistaging.leopardscourier.com/api/getBookedPacketLastStatus/format/xml/ For
'XML' format
https://merchantapistaging.leopardscourier.com/api/getBookedPacketLastStatus/format/json/ For
'JSON' format
Production Link:
https://merchantapi.leopardscourier.com/api/getBookedPacketLastStatus/format/xml/ For 'XML'
format
https://merchantapi.leopardscourier.com/api/getBookedPacketLastStatus/format/json/ For 'JSON'
format

#### API Request

The following is a sample API request using cURL in PHP.
$params = http_build_query (array(
'api_key' => 'your_api_key',
'api_password' => 'your_api_password',
'from_date' => 'string', // E.g. 2019 - 12 - 31
'to_date' => 'string' // E.g. 2019 - 12 - 31
));

$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL,
"https://merchantapistaging.leopardscourier.com/api/getBookedPacketLastStatus/format/json/?{$para
ms}");
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);

$buffer = curl_exec($curl_handle);
curl_close($curl_handle);


### API Response

The following is a JSON response with Error(s).
{
"status" : 0,
"error" : "string",
"packet_list" : null
}

The following is a XML response with Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>0</status>
<error>string</error>
<packet_list/>
</xml>

The following is a JSON response without Error(s).
{
"status" : 1,
"error" : 0,
"packet_list" : [
{
"booking_date": "2020- 01 - 01",
"delivery_date": "2020- 01 - 01",
"tracking_number": "KI123456789",
"booked_packet_weight": "250",


"arival_dispatch_weight": "0",
"booked_packet_order_id": "Order ID",
"origin_city": "Karachi",
"destination_city": "Lahore",
"consignment_name_eng": "Jhon Doe",
"consignment_phone": "03451234567",
"consignment_address": "House no. 420, ABC street",
"booked_packet_status": "Pickup Request not Send",
"cod_value": "1.00"
},
{
"booking_date": "2020- 01 - 01",
"delivery_date": "2020- 01 - 01",
"tracking_number": "KI123456789",
"booked_packet_weight": "250",
"arival_dispatch_weight": "0",
"booked_packet_order_id": "Order ID",
"origin_city": "Karachi",
"destination_city": "Lahore",
"consignment_name_eng": "Jhon Doe",
"consignment_phone": "03451234567",
"consignment_address": "House no. 420, ABC street",
"booked_packet_status": "Pickup Request not Send",
"cod_value": "1.00"
}
]
}


The following is a XML response without Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>1</status>
<error>null</error>
<packet_list>
<item>
<booking_date>2020- 01 - 01</booking_date>
<delivery_date>2020- 01 - 02</delivery_date>
<tracking_number>KI123456789</tracking_number>
<booked_packet_weight>250</booked_packet_weight>
<arival_dispatch_weight>0</arival_dispatch_weight>
<booked_packet_order_id>Order ID</booked_packet_order_id>
<origin_city>Karachi</origin_city>
<destination_city>Lahore</destination_city>
<consignment_name_eng>Jhon Doe</consignment_name_eng>
<consignment_phone>03451234567</consignment_phone>
<consignment_address>House no. 420 , ABC street</consignment_address>
<booked_packet_status>Pickup Request not Send</booked_packet_status>
<cod_value>1.00</cod_value>
</item>
<item>
<booking_date>2020- 01 - 01</booking_date>
<delivery_date>2020- 01 - 02</delivery_date>
<tracking_number>KI123456789</tracking_number>
<booked_packet_weight>250</booked_packet_weight>


<arival_dispatch_weight>0</arival_dispatch_weight>
<booked_packet_order_id>Order ID</booked_packet_order_id>
<origin_city>Karachi</origin_city>
<destination_city>Lahore</destination_city>
<consignment_name_eng>Jhon Doe</consignment_name_eng>
<consignment_phone>03451234567</consignment_phone>
<consignment_address>House no. 420, ABC street</consignment_address>
<booked_packet_status>Pickup Request not Send</booked_packet_status>
<cod_value>1.00</cod_value>
</item>
</packet_list>
</xml>


### POST Shipper Advice List

Staging Link:
https://merchantapistaging.leopardscourier.com/api/shipperAdviceList/format/xml/ For 'XML' format
https://merchantapistaging.leopardscourier.com/api/shipperAdviceList/format/json/ For 'JSON' format
Production Link:
https://merchantapi.leopardscourier.com/api/shipperAdviceList/format/xml/ For 'XML' format
https://merchantapi.leopardscourier.com/api/shipperAdviceList/format/json/ For 'JSON' format

#### API Request

The following is a sample API request using cURL in PHP.
$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL,
'https://merchantapistaging.leopardscourier.com/api/shipperAdviceList/format/json/'); // Write here
Production Link
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_POST, 1);
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode(array(
'api_key' => 'your_api_key',
'api_password' => 'your_api_password',
'from_date' => date, // E.g. 2019 - 12 - 24
'to_date' => date, // E.g. 2020 - 01 - 24
'origin_city' => int, // (Optional) E.g. Origin City ID 592
'destination_city' => int // (Optional) E.g. Destination City ID 592
)));

$buffer = curl_exec($curl_handle);
curl_close($curl_handle);


#### API Response

```
"destination_city_id" : "int",
```
```
"origin_city_id" : "int",
```
```
"booked_packet_collect_amount" : "string",
```
```
"consignment_address" : "string",
```
```
"consignment_phone" : "string",
```
```
"consignment_name_eng" : "string",
```
```
"booked_packet_date" : "YY/mm/dd",
```
```
"track_number" : "string",
```
The following is a JSON response with Error(s).
{
"status": "int",
"error" : "string"
}
The following is a XML response with Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>0</status>
<error>string</error>
</xml>
The following is a JSON response without Error(s).
{
"status": 1,
"error" : "",
"packet_list" : [
{


"origin_city_name" : "string",
"destination_city_name" : "string",
"booked_packet_status" : "string",
"pending_reason" : "string",
"shipment_name_eng" : "string",
"advice_text" : "int",
"advice_date_created" : "int"
},
/* For more than One Track Numbers below section will repeated */
{
"track_number" : "string",
"booked_packet_date" : "YY/mm/dd",
"consignment_name_eng" : "string",
"consignment_phone" : "string",
"consignment_address" : "string",
"booked_packet_collect_amount" : "string",
"origin_city_id" : "int",
"destination_city_id" : "int",
"origin_city_name" : "string",
"destination_city_name" : "string",
"booked_packet_status" : "string",
"pending_reason" : "string",
"shipment_name_eng" : "string",
"advice_text" : "int",
"advice_date_created" : "int"
} ]
}


### POST Get Shipment Details By Order ID(s)

Staging Link:
https://merchantapistaging.leopardscourier.com/api/getShipmentDetailsByOrderID/format/xml/ For
'XML' format
https://merchantapistaging.leopardscourier.com/api/getShipmentDetailsByOrderID/format/json/ For
'JSON' format
Production Link:
https://merchantapi.leopardscourier.com/api/getShipmentDetailsByOrderID/format/xml/ For 'XML'
format
https://merchantapi.leopardscourier.com/api/getShipmentDetailsByOrderID/format/json/ For 'JSON'
format

### API Request

The following is a sample API request using cURL in PHP.
$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL,
'https://merchantapistaging.leopardscourier.com/api/getShipmentDetailsByOrderID/format/json/'); //
Write here Production Link
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode(array(
'api_key' => 'your_api_key',
'api_password' => 'your_api_password',
'shipment_order_id' => array(),
'Order Id-3')

```
// E.g. array('Order Id') OR array('Order Id-1', 'Order Id-2',
```
)));

$buffer = curl_exec($curl_handle);
curl_close($curl_handle);


### API Response

The following is a JSON response with Error(s).
{
"status": "int",
"error" : "string"
}

The following is a XML response with Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>0</status>
<error>string</error>
</xml>

The following is a JSON response without Error(s).
{
"status": 1,
"error" : "",
"data" : [
{
"booking_date" : "YYYY/mm/dd",
"track_number" : "string",
"booked_packet_weight" : "string",
"booked_packet_no_piece" : "string",
"booked_packet_collect_amount" : "string",
"booked_packet_order_id" : "string",


"origin_city" : "string",
"destination_city" : "string",
"shipment_name_eng" : "string",
"shipment_email" : "string",
"shipment_phone" : "string",
"shipment_address" : "string",
"consignment_name_eng" : "string",
"consignment_email" : "string",
"consignment_phone" : "string",
"consignment_phone_two" : "string",
"consignment_phone_three" : "string",
"consignment_address" : "string",
"special_instructions" : "string",
"shipment_type_name" : "string",
"booked_packet_status" : "string",
"delivery_date" : "string",
"return_date" : "string",
"invoice_number" : "string",
"invoice_date" : "string",
},
/* For more than One Order Numbers, above section will repeated like this */
{
"booking_date" : "YYYY/mm/dd",
"track_number" : "string",
"booked_packet_weight" : "string",
"booked_packet_no_piece" : "string",
"booked_packet_collect_amount" : "string",


```
: "string",
```
"consignment_phone_three" : "string",
"consignment_address" : "string",
"special_instructions" : "string",
"shipment_type_name" : "string",
"booked_packet_status" : "string",
"delivery_date"
"return_date" : "string",
"invoice_number" : "string",
"invoice_date" : "string",
}
]
}

```
: "string",
```
```
"booked_packet_order_id" : "string",
"origin_city" : "string",
"destination_city" : "string",
"shipment_name_eng" : "string",
"shipment_email" : "string",
"shipment_phone"
```
```
: "string",
```
```
"shipment_address" : "string",
"consignment_name_eng" : "string",
"consignment_email" : "string",
"consignment_phone" : "string",
"consignment_phone_two"
```

## GET Get All Banks

Staging Link:
https://merchantapistaging.leopardscourier.com/api/getBankList/format/xml/ For 'XML' format
https://merchantapistaging.leopardscourier.com/api/getBankList/format/json/ For 'JSON' format
Production Link:
https://merchantapi.leopardscourier.com/api/getBankList/format/xml/ For 'XML' format
https://merchantapi.leopardscourier.com/api/getBankList/format/json/ For 'JSON' format

### API Request

### API Response

The following is a sample API request using cURL in PHP.
$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL,
'https://merchantapistaging.leopardscourier.com/api/getBankList/format/json/'); // Write here or
Production Link
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_POST, 1);
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode(array(
'api_key' => 'your_api_key'
'api_password' => 'your_api_password'
)));

$buffer = curl_exec($curl_handle);
curl_close($curl_handle);

The following is a JSON response with Error(s).
{
"status":0,


"error":"string",
"bank_list":null
}

The following is a XML response with Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>0</status>
<error>string</error>
<bank_list/>
</xml>

The following is a JSON response without Error(s).
{
"status":1,
"error":"0",
"bank_list":[
{
"bank_id" : int,
"bank_name_eng" : "string",
},
{
"bank_id" : int,
"bank_name_eng" : "string",
}
]
}


The following is a XML response without Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>1</status>
<error>0</error>
<bank_list>
<item>
<bank_id>int</bank_id>
<bank_name_eng>string</bank_name_eng>
</item>
<item>
<bank_id>int</bank_id>
<bank_name_eng>string</bank_name_eng>
</item>
</bank_list>
</xml>


## POST Create Shipper

Production Link:
https://merchantapiStaging.leopardscourier.com/api/createShipper/format/xml/ For 'XML' format
https://merchantapiStaging.leopardscourier.com/api/createShipper/format/json/ For 'JSON' format
Production Link:
https://merchantapi.leopardscourier.com/api/createShipper/format/xml/ For 'XML' format
https://merchantapi.leopardscourier.com/api/createShipper/format/json/ For 'JSON' format

### API Request

The following is a sample API request using cURL in PHP.
$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL,
'https://merchantapistaging.leopardscourier.com/api/createShipper/format/json/'); // Write here
Production Link
'https://merchantapi.leopardscourier.com/api/createShipper/format/json/');
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_POST, 1);
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode(array(
'api_key' => 'your_api_key',
'api_password' => 'your_api_password',
'shipment_name' => string,
'shipment_email' => string, // Optional Field (You can keep it empty)
'shipment_phone' => string,
'shipment_address' => string,
'bank_id' => int, // Provide Bank ID integer value (for integer values read 'Get All Banks'
API documentation)

```
'bank_account_no' => string, // Optional Field (You can keep it empty)
'bank_account_title' => string, // Optional Field (You can keep it empty)
'bank_branch' => string, // Optional Field (You can keep it empty)
```

### API Response

```
'bank_account_iban_no' => string, // Optional Field (You can keep it empty)
'city_id' => string
API documentation)
```
```
// Provide City ID integer value (for integer values read 'Get All Cities'
```
'cnic' => string // Optional Field (You can keep it empty)
'return_address' => string // Optional Field (You can keep it empty) -
)));
curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json'
));

$response = curl_exec($curl_handle);
curl_close($curl_handle);
echo $response;

The following is a JSON response with Error(s).
{
"status": "int",
"error" : "string"
}

The following is a XML response with Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>0</status>
<error>string</error>
</xml>


The following is a JSON response without Error(s). And in case of New User.
{
"status": 1,
"error" : "0",
"message": "Shipper added successfully.",
"data" : [
{
"shipment_id" : "int",
"shipment_name" : "string",
"shipment_email" : "string",
"shipment_phone" : "string",
"shipment_address" : "string",
"city_id" : "int",
"bank_id" : "int",
"bank_account_no" : "string",
"bank_account_title" : "string",
"bank_branch" : "string",
"bank_account_iban_no": "string",
"username" : "string",
"user_password" : "string",
"cnic" : "string",
"return_address" : "string"
}
]
}
The following is a JSON response without Error(s). And in case of User already exists.
{


"status": 1,
"error" : "0",
"message": "Shipper already exists.",
"data" : [
{
"shipment_id" : "int",
"shipment_name" : "string",
"shipment_email" : "string",
"shipment_phone" : "string",
"shipment_address" : "string",
"city_id" : "int",
"bank_id" : "int",
"bank_account_no" : "string",
"bank_account_title" : "string",
"bank_branch" : "string",
"bank_account_iban_no": "string",
"cnic" : "string",
"return_address" : "string"
}
]
}
The following is a XML response without Error(s). And in case of New User.
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>1</status>
<error>"0"</error>
<message>"Shipper added successfully."</error>


<data>
<item>
<shipment_id>string</shipment_id>
<shipment_name>string</shipment_name>
<shipment_email>string</shipment_email>
<shipment_phone>string</shipment_phone>
<shipment_address>string</shipment_address>
<city_id>int</city_id>
<bank_id>int</bank_id>
<bank_account_no>string</bank_account_no>
<bank_account_title>string</bank_account_title>
<bank_branch>string</bank_branch>
<bank_account_iban_no>string</bank_account_iban_no>
<username>string</username>
<user_password>string</user_password>
<cnic>string</cnic>
<return_address>string</return_address>
</item>
</data>
</xml>
The following is a XML response without Error(s). And in case of User already exists.
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>1</status>
<error>"0"</error>
<message>"Shipper already exists."</error>
<data>


<item>
<shipment_id>string</shipment_id>
<shipment_name>string</shipment_name>
<shipment_email>string</shipment_email>
<shipment_phone>string</shipment_phone>
<shipment_address>string</shipment_address>
<city_id>int</city_id>
<bank_id>int</bank_id>
<bank_account_no>string</bank_account_no>
<bank_account_title>string</bank_account_title>
<bank_branch>string</bank_branch>
<bank_account_iban_no>string</bank_account_iban_no>
<cnic>string</cnic>
<return_address>string</return_address>
</item>
</data>
</xml>


## GET Get Payment Details By CN Number(s)

Staging Link:
https://merchantapistaging.leopardscourier.com/api/getPaymentDetails/format/xml/ For 'XML' format
https://merchantapistaging.leopardscourier.com/api/getPaymentDetails/format/json/ For 'JSON'
format
Production Link:
https://merchantapi.leopardscourier.com/api/getPaymentDetails/format/xml/ For 'XML' format
https://merchantapi.leopardscourier.com/api/getPaymentDetails/format/json/ For 'JSON' format

### API Request

### API Response

The following is a sample API request using cURL in PHP.
$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL,
'https://merchantapistaging.leopardscourier.com/api/getPaymentDetails/format/json/?
api_key=your_api_key
&api_password=your_api_password
&cn_numbers=CN number'); // Write Production Link here.
// you can provide multiple comma separated cn numbers
// 50 CN Numbers can be provided once
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);

$buffer = curl_exec($curl_handle);
curl_close($curl_handle);

The following is a JSON response with Error(s).
{
"status":0,
"error":"string",


"payment_list":null
}
The following is a XML response with Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>0</status>
<error>string</error>
<payment_list/>
</xml>

The following is a JSON response without Error(s).
{
"status":1,
"error":"0",
"payment_list":[
{
"booked_packet_cn" : int,
"billing_method" : "string",
"status" : "string",
"invoice_cheque_no" : "string",
"invoice_cheque_date" : "string",
"payment_method" : "string",
"message" : "string",
"slip_link" : "string"
},
/* For more than One CN Numbers, above section will repeated like this */
{


"booked_packet_cn" : int,
"billing_method" : "string",
"status" : "string",
"invoice_cheque_no" : "string",
"invoice_cheque_date" : "string",
"payment_method" : "string",
"message" : "string",
"slip_link" : "string"
}
]
}
The following is a XML response without Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>1</status>
<error>0</error>
<payment_list>
<item>
<booked_packet_cn>int</booked_packet_cn>
<billing_method>string</billing_method>
<status>string</status>
<invoice_cheque_no>string</invoice_cheque_no>
<invoice_cheque_date>string</invoice_cheque_date>
<payment_method>string</payment_method>
<message>string</message>
<slip_link>string</slip_link>
</item>


/* For more than One CN Numbers, above section will repeated like this */
<item>
<booked_packet_cn>int</booked_packet_cn>
<billing_method>string</billing_method>
<status>string</status>
<invoice_cheque_no>string</invoice_cheque_no>
<invoice_cheque_date>string</invoice_cheque_date>
<payment_method>string</payment_method>
<message>string</message>
<slip_link>string</slip_link>
</item>
</payment_list>
</xml>


## GET Get Tariff Details

Staging Link:
https://merchantapistaging.leopardscourier.com/api/getTariffDetails/format/xml/ For 'XML' format
https://merchantapistaging.leopardscourier.com/api/getTariffDetails/format/json/ For 'JSON' format
Production Link:
https://merchantapi.leopardscourier.com/api/getTariffDetails/format/xml/ For 'XML' format
https://merchantapi.leopardscourier.com/api/getTariffDetails/format/json/ For 'JSON' format

### API Request

The following is a sample SOAP request using cURL in PHP.
$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL,
'https://merchantapistaging.leopardscourier.com/api/getTariffDetails/format/json/?
Production Link here.

```
// Write
```
api_key=Your API Key
&api_password=Your API Password
&packet_weight=Your Weight
&shipment_type=Your Shipment Type ID
&origin_city=Your Origin City ID
&destination_city=Your Destination City ID');
&cod_amount=Your COD Amount
insert zero or in other case,

```
// If your shipment is prepaid, please
```
//please insert amount to get actual charges including
cash handling charges.
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);

$buffer = curl_exec($curl_handle);
curl_close($curl_handle);


### API Response

The following is a JSON response with Error(s).
{
"status":0,
"error":"string",
"packet_charges":null
}
The following is a XML response with Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>0</status>
<error>string</error>
<packet_charges/>
</xml>
The following is a JSON response without Error(s).
{
"status":1,
"error":"0",
"packet_charges": {
"shipment_charges" : string,
"cash_handling" : "string",
"insurance_charges" : "string",
"gst_percentage" : "string",
"gst_amount" : "string",
"fuel_surcharge_percentage" : "string",
"fuel_surcharge_amount" : "string"


##### }

##### }

The following is a XML response without Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>1</status>
<error>0</error>
<packet_charges>
<item>
<shipment_charges>string</shipment_charges>
<cash_handling>string</cash_handling>
<insurance_charges>string</insurance_charges>
<gst_percentage>string</gst_percentage>
<gst_amount>string</gst_amount>
<fuel_surcharge_percentage>string</fuel_surcharge_percentage>
<fuel_surcharge_amount>string</fuel_surcharge_amount>
</item>
</packet_charges>
</xml>


## GET Get Shipping Charges

Staging Link:
https://merchantapistaging.leopardscourier.com/api/getShippingCharges/format/xml/ For 'XML'
format
https://merchantapistaging.leopardscourier.com/api/getShippingCharges/format/json/ For 'JSON'
format
Production Link:
https://merchantapi.leopardscourier.com/api/getShippingCharges/format/xml/ For 'XML' format
https://merchantapi.leopardscourier.com/api/getShippingCharges/format/json/ For 'JSON' format

### API Request

### API Response

The following is a sample API request using cURL in PHP.
$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL,
'https://merchantapistaging.leopardscourier.com/api/getShippingCharges/format/json/?
api_key=your_api_key
&api_password=your_api_password
&cn_numbers=CN number'); // Write Production Link here.
// you can provide multiple comma separated cn numbers
// 50 CN Numbers can be provided once
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);

$buffer = curl_exec($curl_handle);
curl_close($curl_handle);

The following is a JSON response with Error(s).
{
"status": "int",


"error" : "string"
}

The following is a XML response with Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>0</status>
<error>string</error>
</xml>
The following is a JSON response without Error(s).
{
"status": 1,
"error" : "0",
"data" : [
{
"cn_number" : "string",
"billing_method" : "string",
"invoice_cheque_no" : "string",
"invoice_cheque_date" : "yyyy-mm-dd",
"weight_charged" : "int",
"shipment_charges" : "int",
"cash_handling_charges" : "int",
"return_charges" : "int",
"insurance_charges" : "int",
"fuel_surcharge_percentage" : "int",
"fuel_surcharge_amount" : "int",
"gst" : "int",


"gst_amount" : "int",
"booked_packet_collect_amount": "int",
" billed_charges": " int",
"old_invoice_no": "string",
"net_charges" : "int",
"gross_charges" : "int",
}
]
}
The following is a XML response without Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>1</status>
<error>"0"</error>
<data>
<item>
<cn_number>string</cn_number>
<billing_method>string</billing_method>
<invoice_cheque_no>string</invoice_cheque_no>
<invoice_cheque_date>yyyy-mm-dd</invoice_cheque_date>
<weight_charged>int</weight_charged>
<shipment_charges>int</shipment_charges>
<cash_handling_charges>int</cash_handling_charges>
<return_charges>int</return_charges>
<insurance_charges>int</insurance_charges>
<fuel_surcharge_percentage>int</fuel_surcharge_percentage>
<fuel_surcharge_amount>int</fuel_surcharge_amount>


```
<gst>int</gst>
<gst_amount>int</gst_amount>
```
```
< booked_packet_collect_amount >int</booked_packet_collect_amount >
```
```
< billed_charges >int</billed_charges>
```
< old_invoice_no >int</old_invoice_no>
<net_charges>int</net_charges>
<gross_charges>int</gross_charges>
</item>
</data>
</xml>


```
GET Invoices List
Staging Link:
https://merchantapistaging.leopardscourier.com/api/getInvoices/format/xml/ For 'XML' format
https://merchantapistaging.leopardscourier.com/api/getInvoices/format/json/ For 'JSON' format
Production Link:
https://merchantapi.leopardscourier.com/api/getInvoices /format/xml/ For 'XML' format
https://merchantapi.leopardscourier.com/api/getInvoices/format/json/ For 'JSON' format
```
### API Request

### API Response

The following is a sample API request using cURL in PHP.
$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL,
'https://merchantapistaging.leopardscourier.com/api/getInvoices/format/json/? api_key=your_api_key
&api_password=your_api_password); // Write Production Link here.
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
$buffer = curl_exec($curl_handle);
curl_close($curl_handle);

The following is a JSON response.
{
status": 1 ,
"error": "0",
"data": [{
"invoice_cheque_no": "string",
"invoice_cheque_date": "date",
"invoice_cheque_holder_name": "string",
"invoice_cheque_amount": "int",
"bank_name": "string",
"payment_method_name": "string",
"pay_status_name": "string"
}]
}


## GET Get Shipper Details

Staging Link:

https://merchantapistaging.leopardscourier.com/api/getShipperDetails/format/xml/ For 'XML' format
https://merchantapistaging.leopardscourier.com/api/getShipperDetails/format/json/ For 'JSON' format
Production Link:
https://merchantapi.leopardscourier.com/api/getShipperDetails/format/xml/ For 'XML' format
https://merchantapi.leopardscourier.com/api/getShipperDetails/format/json/ For 'JSON' format

### API Request

The following is a sample API request using cURL in PHP.
$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL,
'https://merchantapistaging.leopardscourier.com/api/getShipperDetails/format/json/?
api_key=your_api_key
&api_password=your_api_password
&request_param=request_param
&request_value=request_value);
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json'
));

$response = curl_exec($curl_handle);
curl_close($curl_handle);
echo $response;


### API Response

The following is a JSON response with Error(s).
{


"status": "int",
"error" : "string"
}
The following is a XML response with Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>0</status>
<error>
<request_param>string</request_param>
<request_value>string</request_value>
</error>

</xml>
The following is a JSON response without Error(s).
{
"status": 1,
"error" : "0",
"data" : [
{
"shipment_id" : "int",
"shipment_name_eng" : "string",
"shipment_contact_person" : "string",
"shipment_email" : "string",
"shipment_phone" : "int",
"shipment_address" : "string",
"bank_id" : "int",
"bank_name_eng" : "string",


```
"bank_account_no" : "string",
"bank_account_title" : "string",
"bank_branch" : "string",
"bank_account_iban_no" : "string",
"is_settlement" : "int",
"cnic" : "string",
"return_address" : "string",
"shipper_city_id" : "int",
```
##### }

##### ]

##### }

The following is a XML response without Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>1</status>
<error>"0"</error>
<data>
<item>
<shipment_id>int</shipment_id>
<shipment_name_eng>string</shipment_name_eng>
<shipment_contact_person>string</shipment_contact_person>
<shipment_email>string</shipment_email>
<shipment_phone>int</shipment_phone>
<shipment_address>string</shipment_address>
<bank_id>int</bank_id>
<bank_name_eng>string</bank_name_eng>


<bank_account_no>string</bank_account_no>
<bank_account_title>string</bank_account_title>
<bank_branch>string</bank_branch>
<bank_account_iban_no>string</bank_account_iban_no>
<is_settlement>int</is_settlement>
<cnic>string</cnic>
<return_address>string</return_address>
<shipper_city_id>int</shipper_city_id>
</item>
</data>
</xml>


## GET Get Electronic Proof Of Delivery

Staging Link:
https://merchantapistaging.leopardscourier.com/api/getElectronicProofOfDelivery/format/json For
'JSON' format
https://merchantapistaging.leopardscourier.com/api/getElectronicProofOfDelivery/format/xml For
'XML' format
Production Link:
https://merchantapi.leopardscourier.com/api/getElectronicProofOfDelivery/format/json For 'JSON'
format
https://merchantapi.leopardscourier.com/api/getElectronicProofOfDelivery/format/xml For 'XML'
format

### API Request

### API Response

The following is a sample API request using cURL in PHP.
$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL,
'https://merchantapistaging.leopardscourier.com/api/getElectronicProofOfDelivery/format/json/?
api_key=your_api_key
&api_password=your_api_password
&cn_number=cn_number); // Write Production Link here.
// you can provide multiple comma separated cn numbers
// 50 CN Numbers can be provided once
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
$buffer = curl_exec($curl_handle);
curl_close($curl_handle);

The following is a JSON response with Error(s).
{
"status": "int",


"error" : "string"
}

The following is a XML response with Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>0</status>
<error>
<cn_number>string</cn_number>

```
</error>
```
</xml>

The following is a JSON response without Error(s).

##### {

```
"status": 1,
"error" : "0",
"data" : [
'cn_number':{
"City_Name" : "string",
"CN_Number" : "string",
"Arrival_Date" : "date",
"Status" : "string",
"Status_Detail" : "string",
"Cour_Code" : "int",
```

```
"Cour_Name" : "string",
"Receiver_Name" : "string",
"Relation" : "string",
"Reason" : "string",
"Pcs" : "string",
"Weight" : "int",
"Latitude" : "int",
"Longitude" : "int",
"Sig_Url" : "string",
"Activity" : "string",
```
##### }

##### ]

##### }

The following is a XML response without Error(s).
<?xml version="1.0" encoding="utf-8"?>
<xml>
<status>1</status>
<error>"0"</error>
<data>
<cn_number>
<City_Name>string</City_Name>;
<CN_Number>string</CN_Number>;
<Arrival_Date>date</Arrival_Date>;
<Status>string</Status>;
<Status_Detail>string</Status_Detail>


<Cour_Code>int</Cour_Code>
<Cour_Name>string</Cour_Name>
<Receiver_Name>string</Receiver_Name>
<Relation>string</Relation>
<Reason>string</Reason>
<Pcs>string</Pcs>
<Weight>int</Weight>
<Latitude>int</Latitude>
<Longitude>int</Longitude>
<Sig_Url>string</Sig_Url>
<Activity>string</Activity>
</cn_number>
</data>
</xml>


## POST Shipper Advice List

Staging Link:
https://merchantapistaging.leopardscourier.com/api/shipperAdviceList/format/xml/ For 'XML' format
https://merchantapistaging.leopardscourier.com/api/shipperAdviceList/format/json/ For 'JSON' format
Production Link:
https://merchantapi.leopardscourier.com/api/shipperAdviceList/format/xml/ For 'XML' format
https://merchantapi.leopardscourier.com/api/shipperAdviceList/format/json/ For 'JSON' format

### API Request

The following is a sample API request using cURL in PHP.

$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL =>
'https://merchantapistaging.leopardscourier.com/api/shipperAdviceList/format/json/',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => '',
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 0,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => 'POST',
CURLOPT_POSTFIELDS =>'{
"api_key": "your_api_key",
"api_password": "your_api_password",
"product": "",
"status": "",
"origionID": "",
"destinationID": "",


### API Response

```
"dateFrom": "",
"toDate": "",
"Cn_number": "",
"start": 0,
"length": 100
}',
CURLOPT_HTTPHEADER => array(
'Content-Type: application/json',
'Accept: application/json',
'Cookie: '
),
));
```
```
$response = curl_exec($curl);
```
```
curl_close($curl);
echo $response;
```
The following is a JSON response with Error(s).
{
"status": "int",
"error" : "string"
}
The following is a JSON response without Error(s).
{
"status": "1",


"error": "0",
"totalrecords": 1,
"data": [
{
"id": int,
"cn_number": "string",
"origin_id": int,
"courier_id": int,
"cour_date": "string",
"cour_time": null,
"dest_id": int,
"product": "string",
"shipper_name": "string",
"shipper_address": "string",
"shipper_mobile": "string",
"consignee_name": "string",
"consignee_address": "string",
"consignee_mobile": "string",
"status": "string",
"reason": "string",
"client_id": null,
"shipper_advice_status": "string",
"shipper_remarks": "string",
"created_date": "string",
"created_time": null,
"remarks": "",
"delete_type": null,


"attempt_counter": 0,
"user_id": int,
"station_id": int,
"activity": "string,
"orgncityid": string,
"origin_name": string,
"dstncityid": string,
"dst_name": string,
"status_description": string,
"outcome_status": string,
"oms_status": string"
}
]
}


## POST Activity Log.....................................................................................................................

Staging Link:
https://merchantapistaging.leopardscourier.com/api/activityLog/format/xml/ For 'XML' format
https://merchantapistaging.leopardscourier.com/api/activityLog/format/json/ For 'JSON' format
Production Link:
https://merchantapi.leopardscourier.com/api/activityLog/format/xml/ For 'XML' format
https://merchantapi.leopardscourier.com/api/activityLog/format/json/ For 'JSON' format

### API Request

The following is a sample API request using CURL in PHP.

```
$curl = curl_init();
```
curl_setopt_array($curl, array(
CURLOPT_URL =>
'https://merchantapistaging.leopardscourier.com/api/activityLog/format/json/',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => '',
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 0,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => 'POST',
CURLOPT_POSTFIELDS =>'{
"api_key": "your_api_key",
"api_password": "your_api_password",
"product": "",
"status": "",
"Cn_number": "",


### API Response

```
"start": 0,
"length": 100
}',
CURLOPT_HTTPHEADER => array(
'Content-Type: application/json',
'Cookie:
),
));
```
```
$response = curl_exec($curl);
```
```
curl_close($curl);
echo $response;
```
The following is a JSON response with Error(s).
{
"status": "int",
"error" : "string"
}

The following is a JSON response without Error(s).
{
"status": "1",
"error": "0",
"totalrecords": 1,
"data": [


##### {

```
"id": int,
"cn_number": "string",
"origin_id": int,
"courier_id": int,
"cour_date": "string",
"cour_time": null,
"dest_id": int,
"product": "string",
"shipper_name": "string",
"shipper_address": "string",
"shipper_mobile": "string",
"consignee_name": "string",
"consignee_address": "string",
"consignee_mobile": "string",
"status": "string",
"reason": "string",
"client_id": null,
"shipper_advice_status": "string",
"shipper_remarks": "string",
"created_date": "string",
"created_time": null,
"remarks": "",
"delete_type": null,
"attempt_counter": 0,
"user_id": int,
"station_id": int,
```

"activity": "string,
"orgncityid": string,
"origin_name": string,
"dstncityid": string,
"dst_name": string,
"status_description": string,
"outcome_status": string,
"oms_status": string"
}
]
}


## POST Add Shipper Advices

Staging Link:
https://merchantapistaging.leopardscourier.com/api/updateShipperAdvice/format/xml/ For 'XML'
format
https://merchantapistaging.leopardscourier.com/api/updateShipperAdvice/format/json/ For 'JSON'
format
Production Link:
https://merchantapi.leopardscourier.com/api/updateShipperAdvice/format/xml/ For 'XML' format
https://merchantapi.leopardscourier.com/api/updateShipperAdvice/format/json/ For 'JSON' format

### API Request

The following is a sample API request using cURL in PHP.
$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL =>
'https://merchantapistaging.leopardscourier.com/api/updateShipperAdvice/format/json/',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => '',
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 0,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => 'POST',
CURLOPT_POSTFIELDS =>'{
"api_key": "your_api_key",
"api_password": "your_api_password",
"data": [
{
"id": ,


"cn_number": "",
"shipper_advice_status": "", // allowed statuses are ('RA', 'RT')
"shipper_remarks": ""
},
{
"id": ,
"cn_number": "",
"shipper_advice_status": "", // allowed statuses are ('RA', 'RT')
"shipper_remarks": ""
},
{
"id": ,
"cn_number": "",
"shipper_advice_status": "", // allowed statuses are ('RA', 'RT')
"shipper_remarks": ""
}
]
}',
CURLOPT_HTTPHEADER => array(
'Content-Type: application/json',
'Cookie: '
),
));
$response = curl_exec($curl);

curl_close($curl);
echo $response;


### API Response

The following is a JSON response with Error(s).
{
"status": "int",
"error" : "string"
}

The following is a JSON response without Error(s).
{
"status": "1",
"error": "0",
"data": "Shipper Advice Updated successfully"
}


