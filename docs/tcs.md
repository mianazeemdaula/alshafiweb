#### Version 1.

# API User Guide

## Version 1.


## Table of Contents

      - Version 1.
- API Listing
   - Our List of API includes the following APIs with relevant details:
   - Authorization
   - E-COM API Listing
   - Authentication
   - Booking – Create
   - Booking – Create Cost Center Code
   - Booking – Cancel
   - Booking – Payment Invoice
   - Booking – Reverse
   - Booking – Get CN Update
   - CN Print
   - Inquiry – Cost Center Inquiry
   - Payment – Status
   - Payment – Detail
   - Setup – Area Code
   - Setup – Block Code
   - Setup – Country List
   - Setup – City list by Country
   - Setup – Route List
   - Setup – Delivery Status List
   - Tracking
   - Status Codes


#### Version 1.

#### Overview:

To test the complete set of product APIs & get better understanding of TCS API integration visit, please visit:
https://ociconnect.tcscourier.com/ecom/index.html

#### Available APIs:

Check the list of available APIs at: https://ociconnect.tcscourier.com/ecom/index.html

#### Sandbox Access:

Below is the link for UAT and production portals.

https://devconnect.tcscourier.com/ecom/index.html

#### Production Access:

If you need production access, you must proceed with the successful UAT phase. Please note that production access approval/setup will take at
least three working days.

https://ociconnect.tcscourier.com/ecom/index.html


#### Version 1.

#### API Listing

Our List of API includes the following APIs with relevant details:

Authorization

```
API Name Authorization
```
```
Description To get bearer token to access authorized APIs
Sandbox/Developer Link https://devconnect.tcscourier.com/auth/api/auth
Production Link https://ociconnect.tcscourier.com/auth/api/auth
API Method GET
```
API Body (^) S No. Parameter Mandatory Data Type Remarks
1 clientId Yes Number To be provided by TCS
2 clientsecret Yes String To be provided by TCS
Response Parameters
1 accesstoken Yes String
2 expiry Yes Date Token expiry date and time
3 userinformation^ No^ String^
JSON Body Request/Payload {^
"clientid": "205659575",
"clientsecret": "YWxuYXNlZWJkYWlyeWZvb2RAdGNzYm9va=="
}
API Success Response {^
"result": {
"accessToken":
"eyJhbGciOipXVCJ9.eyJjbGllbnRpZCI6IjIzIjoiMzcwLDM3MS2x1ZpK0O9Zv7slp9-
q7mwPXlXFzfk8A",
"expiry": "2027- 01 - 04T05:08:47Z",
"userInformation": **null**
},
"status": **true** ,
"code": "0200"
}
Failure Response

##### {

```
"result": null ,
"status": false ,
"code": "401"
}
```

#### Version 1.

E-COM API Listing

Authentication

```
API Name Authentication
Description To obtain access token and gain access to permitted APIs, utilize this API.
```
```
Sandbox/Developer Link https://devconnect.tcscourier.com/ecom/api/authentication/token
Production Link https://ociconnect.tcscourier.com/ecom/api/authentication/token
API Method GET
Access Token
Provided in Authentication API
```
API Body (^) S No. Parameter Mandatory Data Type Remarks
1 username Yes String To be provided by TCS
2 password Yes String To be provided by TCS
Response Parameters
1 accesstoken Yes String
2 expiry Yes Date Token expiry date & time
3 message^ No^ String^
JSON Body Request/Payload {^
"username": "abc",
"password": "123”
}
API Success Response {
"accesstoken":
"jcgwsU85g+loIFikVpysWUQ/0sycayn1fOKUHbanhNc4Hix21+9FtBgTNT+17xcw8hCA/m0WK
WvjlWdkCRRamFiwoEIcst9yGRPksWtzlYzAeo2sIQBv6vbf8H2yFRSc4bD4oCpQznmOuzRLumY
Gj0B15qJnVczoG1WHo=",
"expiry": "2027- 06 - 08T09:01:25.0704875Z",
"message": "success",
"traceid": "f6a5843c-e60a-40d7-8cf1-607d26d8a4f2"
}
Failure Response

##### {

```
"result": null ,
"status": false ,
"code": "401"
}
```

#### Version 1.

Booking – Create

```
API Name Create Booking
Description To schedule and confirm new shipments.
```
```
Sandbox/Developer Link https://devconnect.tcscourier.com/ecom/api/booking/create
Production Link https://ociconnect.tcscourier.com/ecom/api/booking/create
API Method POST
Bearer Token
Provided in Authorization API
```
API Body (^) S.No. Parameter Date Type Mandatory Remarks
1 accesstoken^ String^ Yes^ Provided by TCS^
2 consignmentno^ Number^ No^ Not mapped^
**Shipper Info**
1 tcsaccount^ String^ (12)^ Yes^
Provided by TCS
Max Length: 12
Min Length: 3
2 shippername^ String^ (50)^ Yes^
Max Length: 50
Min Length: 3
3 address1^ String^ (120)^ Yes^
Max Length: 120
Min Length: 3
4 address2^ String^ (120)^ No^
Max Length: 120
Min Length: 3
5 address3^ String^ (120)^ No^
Max Length: 120
Min Length: 3
6 Zip^ String^ (6)^ No^
Max Length: 6
Min Length: 3
7 countrycode^ String^ (2)^ Yes^
Max Length: 2
Min Length: 2
8 countryname^ String^ (50)^ Yes^
Max Length: 50
Min Length: 3
9 citycode^ String^ (5)^ No^ Max Length: 5^


#### Version 1.

```
Min Length: 0
```
10 cityname^ String^ (50)^ Yes^

```
Max Length: 50
```
```
Min Length: 3
```
11 mobile^ Number^ (11)^ Yes^

```
Like (0300xxxxxxx)
```
```
Max Length: 11
```
```
Min Length: 11
```
```
Consignee Info
```
```
1 consigneecode^ String^ (10)^ No^
```
```
Max Length: 10
```
```
Min Length: 2
```
```
2 firstname^ String^ (50)^ Yes^
```
```
Max Length: 50
```
```
Min Length: 3
```
```
3 middlename^ String^ (50)^ Yes^
```
```
Max Length: 50
```
```
Min Length: 3
```
```
4 lastname^ String^ (50)^ No^
```
```
Max Length: 50
```
```
Min Length: 3
```
```
5 address1^ String^ (120)^ Yes^
```
```
Max Length: 120
```
```
Min Length: 3
```
```
6 address2^ String^ (120)^ No^
```
```
Max Length: 120
```
```
Min Length: 3
```
```
7 address3^ String^ (120)^ No^
```
```
Max Length: 120
```
```
Min Length: 3
```
```
8 zip^ String^ (6)^ No^
```
```
Max Length: 6
```
```
Min Length: 0
```
```
9 countrycode^ String^ (2)^ Yes^
```
```
Max Length: 2
```
```
Min Length: 2
```
10 countryname^ String^ (50)^ Yes^

```
Max Length: 50
```
```
Min Length: 3
```
11 citycode^ String^ (5)^ No^

```
Max Length: 5
```
```
Min Length: 3
```

#### Version 1.

12 cityname^ String^ (50)^ Yes^

```
Max Length: 50
```
```
Min Length: 3
```
13 Email^ String^ (50)^ No^

```
Max Length: 50
```
```
Min Length: 3
```
14 areacode^ String^ (5)^ No^

```
Max Length: 5
```
```
Min Length: 3
```
15 areaname^ String^ (50)^ No^

```
Max Length: 50
```
```
Min Length: 3
```
16 blockcode^ String^ (5)^ No^

```
Max Length: 5
```
```
Min Length: 3
```
17 blockname^ String^ (50)^ No^

```
Max Length: 50
```
```
Min Length: 3
```
18 lat^ String^ (50)^ No^

```
Max Length: 50
```
```
Min Length: 3
```
19 lng^ String^ (50)^ No^

```
Max Length: 50
```
```
Min Length: 3
```
20 landmark^ String (200)^ No^

```
Max Length: 200
Min Length: 0
```
21 mobile^ Number^ (11)^ Yes^

```
Like (0300xxxxxxx)
```
```
Max Length: 11
```
```
Min Length: 11
```
```
Vendor Info
```
```
1 name^ String^ (50)^ No^
```
```
Max Length: 50
```
```
Min Length: 1
```
```
2 address1^ String^ (120)^ No^
```
```
Max Length: 120
```
```
Min Length: 3
```
```
3 address2^ String^ (120)^ No^
```
```
Max Length: 120
```
```
Min Length: 3
```
```
4 address3^ String^ (120)^ No^ Max Length: 120^
```

#### Version 1.

```
Min Length: 3
```
5 citycode^ String^ (5)^ No^

```
Max Length: 5
```
```
Min Length: 3
```
6 cityname^ String^ (50)^ No^

```
Max Length: 50
```
```
Min Length: 3
```
7 mobile^ Number^ (11)^ No^

```
Like (0300xxxxxxx)
```
```
Max Length: 11
```
```
Min Length: 11
```
```
Shipment Info
```
1 costcentercode^ String^ (20)^ Yes^

```
Max Length: 20
```
```
Min Length: 2
```
2 referenceno^ String^ (50)^ No^

```
Max Length: 50
```
```
Min Length: 3
```
3 contentdesc^ String^ (50)^ No^

```
Max Length: 999
```
```
Min Length: 3
```
4 servicecode^ String^ (6)^ Yes^

```
Max Length: 6
```
```
Min Length: 1
```
5 parametertype^ String^ (50)^ No^

```
Max Length: 50
```
```
Min Length: 1
```
6 shipmentdate^ String^ (20)^ No^

##### DD-MM-YYYY

```
Max Length: 20
```
```
Min Length: 1
```
7 shippingtype^ String^ No^

```
Maximum: 10
Minimum: 0
```
8 currency^ String^ (5)^ Yes^

```
PKR, USD and so on
```
```
Max Length: 5
```
```
Min Length: 3
```
9 codamount^ Number^ (int32)^ Yes^

```
maximum: 250000
```
```
minimum: 0
```

#### Version 1.

10 declaredvalue^ Number^ (int32)^ No^

```
maximum: 250000
```
```
minimum: 0
```
11 insuredvalue^ Number^ (int32)^ No^

```
maximum: 250000
```
```
minimum: 0
```
12 transactiontype^ String^ No^

```
Maximum: 10
Minimum: 0
```
13 dsflag^ String^ (50)^ No^

```
Max Length: 50
```
```
Min Length: 0
```
14 carrierslug^ String^ (50)^ No^

```
Max Length: 50
```
```
Min Length: 0
```
15 weightinkg^ Number^ (double)^ Yes^ Minimum weight is 0.^

16 pieces^ Number^ (int32)^ Yes^

```
maximum: 2147483647
```
```
minimum: 1
```
17 remarks^ String^ (500)^ No^

```
Max Length: 500
```
```
Min Length: 3
```
18 fragile^ Boolean^ Yes^ Value should be true or false^

```
SKU
```
```
1 description^ String^ (50)^ No^
```
```
Max Length: 200
```
```
Min Length: 3
```
```
2 quantity^ Number(int32)^ Yes^
```
```
Quantity should be greater than or equals
to 1.
```
```
3 weight^ Number(double)^ Yes^ Minimum weight is 0.^
```
```
4 uom^ String^ No^
```
```
5 unitprice^ Number(int32)^ Yes^
```
```
maximum: 250000
```
```
minimum: 1
```
```
6 declaredvalue^ Number(int32)^ No^
```
```
maximum: 250000
```
```
minimum: 0
```
```
7 insuredvalue^ Number(int32)^ No^
```
```
maximum: 250000
```
```
minimum: 0
```
```
Response Parameters
```

#### Version 1.

```
S. No. Response^ Remarks^
```
```
1 Consignment #^ To be provided by TCS^
```
```
2 Response Code^ Response code based on provided information^
```
```
3 Status^ True or False^
```
```
4 Message^ API response^
```
```
5 Request Time^
```
```
6 Response Time^
```
JSON Body Request/Payload {
"accesstoken": "",
"consignmentno": "",
"shipperinfo": {
"tcsaccount": "04011K1",
"shippername": "Test",
"address1": "Test address 1",
"address2": "Test address 2",
"address3": "Test address 3",
"zip": "75800",
"countrycode": "PK",
"countryname": "Pakistan",
"citycode": "KHI",
"cityname": "Karachi",
"mobile": "03451234567"
},
"consigneeinfo": {
"consigneecode": "C103",
"firstname": "First name",
"middlename": "Middle name",
"lastname": "Last name",
"address1": "Test address 1",
"address2": "Test address 2",
"address3": "Test address 3",
"zip": "75800",
"countrycode": "PK",
"countryname": "Pakistan",
"citycode": "KHI",
"cityname": "Karachi",
"email": "test@test.com",
"areacode": "KHI00001",
"areaname": "Gulshan",
"blockcode": "",
"blockname": "Gulshan block 6 PECHS",
"lat": "24.920733",
"lng": "67.088162",
"landmark": "Baloch Hospital",


#### Version 1.

```
"mobile": "03451234567"
},
"vendorinfo": {
"name": "Test Vendor",
"address1": "Test address 1",
"address2": "Test address 2",
"address3": "Test address 3",
"citycode": "KHI",
"cityname": "Karachi",
"mobile": "03451234567"
},
"shipmentinfo": {
"costcentercode": "Test-01",
"referenceno": "123456789",
"contentdesc": "Cost center description",
"servicecode": "O",
"parametertype": "Parameter Type",
"shipmentdate": "28/08/2023 01:04:02",
"shippingtype": "",
"currency": "PKR",
"codamount": 250 ,
"declaredvalue": null ,
"insuredvalue": null ,
"transactiontype": "",
"dsflag": "",
"carrierslug": "",
"weightinkg": 0.5,
"pieces": 1 ,
"fragile": false ,
"remarks": "Test remarks",
"skus": [
{
"description": "SKU description",
"quantity": 1 ,
"weight": 0.5,
"uom": "KG",
"unitprice": 250 ,
"declaredvalue": null ,
"insuredvalue": null
}
]
}
}
```
API Success Response {
"response": "SUCCESS",
"consignmentNo": "99210301520",
"code": "200",
"status": **true** ,


#### Version 1.

```
"message": "success",
"requestTime": "07:27:43",
"responseTime": "07:27:44"
}
Failure Response
```
##### {

```
"error": [
{
"errorname": "error description"
}
],
"message": "Summary of error",
"traceid": "00-b5059f8935daf8f3d75e-3d58b17af9ab812-00"
}
OR
{
"code": 401 ,
"message": "Invalid Bearer token. Mismatch configuration.",
"status": "UnAuthorized"
}
```
Booking – Create Cost Center Code

```
API Name Create Cost Center Code
```
```
Description To generate and assign cost center codes for bookings.
```
```
Sandbox/Developer Link https://devconnect.tcscourier.com/ecom/api/booking/createcostcentercode
Production Link https:/ociconnect.tcscourier.com/ecom/api/booking/createcostcentercode
API Method POST
Bearer Token
Provided in Authorization API
```
API Body (^) S No. Parameter Mandatory Data Type Remarks
1 costcentercitname Yes String To be provided by TCS
2 costcentercode Yes String
3 costcentername Yes String
4 pickupaddress Yes String
5 returnaddress Yes String
6 islabelprint Yes String
7 accountNumber Yes String
8 phoneNumber No String
9 email No String
Response Parameters
1 accesstoken^ String^ (400)^ Yes^


#### Version 1.

```
JSON Body Request/Payload {
"costcentercityname": "KARACHI",
"costcentercode": " 9211 ",
"costcentername": "Kathryn Poole1",
"pickupaddress": "KHI Airport",
"returnaddress": "KHI Airport",
"islabelprint": "yes",
"accountNumber": "04011K1",
"phoneNumber": "32122457457",
"email": "test@abc.com",
"accesstoken": ""
}
API Success Response {
"message": "SUCCESS",
"costcentercode": " 9211 ",
"traceid": "49a5e1e7-2f47-430e- 9443 - 8227acba134c"
}
Failure Response
{
"message": "FAILURE: Cost Center Already Exists",
"costcentercode": null ,
"traceid": "0b131f86-ee51-4a11-abdc-4266e08b65ab"
}
```
Booking – Cancel

```
API Name Cancel Booking
Description To cancel an existing booking in TCS system
```
```
Sandbox/Developer Link https://devconnect.tcscourier.com/ecom/api/booking/cancel
Production Link https:/ociconnect.tcscourier.com/ecom/api/booking/cancel
API Method POST
Bearer Token
Provided in Authorization API
```
```
API Body S No. Parameter Mandatory Data Type Remarks
1 ConsignmentNu
mber
```
```
Yes Number To be provided by Customer
```
```
Response Parameters
1 accesstoken^ String^ (400)^ Yes^
JSON Body Request/Payload {
"consignmentNumber": "173000008151",
"accesstoken": ""
}
```

#### Version 1.

```
API Success Response {
"message": "SUCCESS",
"traceid": "294d5e4f-913c-45a4-bf90-e00993157c0b"
}
Failure Response
{
"message": "Failure: No Record Founds",
"traceid": "e291bead-5a51- 4669 - 87eb-6f65535da994"
}
```
Booking – Payment Invoice

```
API Name Payment Invoice
```
```
Description To generate and retrieve payment invoices against bookings
```
```
Sandbox/Developer Link https://devconnect.tcscourier.com/ecom/api/booking/paymentinvoice
Production Link https:/ociconnect.tcscourier.com/ecom/api/booking/paymentinvoice
API Method GET
Bearer Token
Provided in Authorization API
```
API Body (^) S No. Parameter Mandatory Data Type Remarks
1 Invoiceno Yes Number To be provided by TCS
Response Parameters
1 accesstoken^ String^ (400)^ Yes^
JSON Body Request/Payload {
"invoiceno": "543777",
"accesstoken": ""
}
API Success Response {
"message": "SUCCESS",
"traceid": "94a05367-5a0d-44e1-8dd1-d2ba01b344cd",
"data": [
{
"cnsg_no": "779412314605",
"cust_ref": "Internet 570372",
"bkg_dat": "2024- 08 - 07T00:00:00",
"consignee": "Muhib Ali",
"orgn": "LHE",
"dstn": "HSL",
"wtt_bkg": 2 ,
"paymentperiod": "08_Aug_to_14_Aug_2024",
"status": "Return To Origin",


#### Version 1.

```
"codamount": 2057 ,
"courier_charges": 116 ,
"gst": 18.56,
"cus_no": "882161",
"invoiceno": "LHEGEW888257"
},
{
"cnsg_no": "779412315161",
"cust_ref": "Internet 571197",
"bkg_dat": "2024- 08 - 07T00:00:00",
"consignee": "Khalid Bashir",
"orgn": "LHE",
"dstn": "LHE",
"wtt_bkg": 0.5,
"paymentperiod": "08_Aug_to_14_Aug_2024",
"status": "Delivered",
"codamount": 0 ,
"courier_charges": 83 ,
"gst": 13.28,
"cus_no": "882161",
"invoiceno": "LHEGEW888257"
},
{
"cnsg_no": "779412315162",
"cust_ref": "Internet 571299",
"bkg_dat": "2024- 08 - 07T00:00:00",
"consignee": "Marism Shahid",
"orgn": "LHE",
"dstn": "LHE",
"wtt_bkg": 1 ,
"paymentperiod": "08_Aug_to_14_Aug_2024",
"status": "Delivered",
"codamount": 2559 ,
"courier_charges": 83 ,
"gst": 13.28,
"cus_no": "882161",
"invoiceno": "LHEGEW888257"
}
]
}
```
Failure Response
{
"code": "UnAuthorized",
"message": "Invalid access token",
"status": 401
}


#### Version 1.

Booking – Reverse

```
API Name Reverse
```
```
Description To book a reverse pickup for your shipments.
```
```
Sandbox/Developer Link https://devconnect.tcscourier.com/ecom/api/booking/reverse
Production Link https:/ociconnect.tcscourier.com/ecom/api/booking/reverse
API Method POST
Bearer Token
Provided in Authorization API
```
```
API Body S No. Parameter Mandatory Data Type Remarks
```
```
1
```
```
costcentercod
e
No String To be provided by Customer
```
##### 2

```
consignmentn
o
```
```
Yes String To be provided by Customer
```
##### 3

```
consigneemob
ileno
No String -
```
```
Response Parameters
```
```
1 accesstoken^ Yes^ String^
JSON Body Request/Payload {
"costcentercode": "",
"consignmentno": "99555303992",
"consigneemobno": "",
"accesstoken": ""
}
```
```
API Success Response
```
##### {

```
"message": "SUCCESS",
"status": "true”,
"accesstoken":
"4563d2ejhfberbfkejfbkejrfb322dhdjdjjdf2532ggfjfj325djjfj6"
}
Failure Response
{
"code": 401 ,
"message": "Invalid Bearer token. Mismatch configuration. "
"status": "UnAuthorized"
}
```

#### Version 1.

Booking – Get CN Update

```
API Name Get CN Update
Description To retrieves the latest update on the status of a consignment note (CN) based on the provided CN Number.
```
```
Sandbox/Developer Link https://devconnect.tcscourier.com/ecom/api/booking/getcnupdate
Production Link https://ociconnect.tcscourier.com/ecom/api/booking/getcnupdate
API Method GET
Bearer Token
Provided in Authorization API
```
API Body (^) S No. Parameter Mandatory Data Type Remarks
1 ID Yes String To be provided
2 Flag Yes Number To be provided
Response Parameters
1 accesstoken^ Yes^ String^ (400)^
JSON Body Request/Payload (^) {
"ID": " 779416038409 ",
"flag": " 2 "
}
API Success Response

##### {

```
"MESSAGE": "MSG01- CN 779416038409 Succesfully Updated ",
"status": "true",
"traceid": "2ac10ba8- 5679 - 4bb2-8a9a-407e37ea7647"
}
Failure Response
{
"MESSAGE": "ERR01-No Data Found against 7794160384 10 ",
"status": "true",
"traceid": "5354d4d5- 4800 - 4ae8-a9b1-070daae8c7f8"
}
```
CN Print

```
API Name CN print
```
```
Description To facilitate all your CN printing needs efficiently and effectively.
```
```
Sandbox/Developer Link https://devconnect.tcscourier.com/ecom/api/print/label
Production Link https://ociconnect.tcscourier.com/ecom/api/print/label
API Method GET
Bearer Token
Provided in Authorization API
```

#### Version 1.

```
API Body S No. Parameter Mandatory Data Type Remarks
1 consignmentno Yes String To be provided
2 shipperdetail Yes Dropdown To be provided
Response Parameters
```
```
1 accesstoken^ Yes^ String (400)^
```
```
JSON Body Request/Payload {
"consignmentno": "99555303992",
"shipperdetail": "true",
"accesstoken": ""
}
API Success Response A PDF file will be available for downloading as per below sample:
```
```
779412322995.pdf
```
```
Failure Response
{
"message": "CN not found",
"url": "",
"traceid": "6e621297- 3881 - 40c1-b611-d03717827690"
}
```
Inquiry – Cost Center Inquiry

```
API Name Cost Center Inquiry
```
```
Description To fetch cost center details against customer account Number
```
```
Production Link https://devconnect.tcscourier.com/ecom/inquiry/costcenterinquiry
```
```
Sandbox/Developer Link https://ociconnect.tcscourier.com/ecom/inquiry/costcenterinquiry
```
```
API Method GET
```
```
Bearer Token Provided in Authorization API
```

#### Version 1.

**API Body
S.No. Parameter Data Type Mandatory Remarks**
1 accesstoken String ( 400 ) Yes Generated through provided Envio credentials

```
2 customerno
```
```
Number
(20)
Yes TCS account Number
```
```
Response Parameters
```
```
1 costcentercode
```
```
Number
(20)
Yes
```
```
2 costcentercity String (^30 )^ Yes^
```
```
3 costcentername String^ (50)^ Yes^
```
```
4 phoneno
```
```
Number
(11)
No
```
```
5 email String (50)^ No^
```
```
6 pickupaddress String (120)^ Yes^
```
```
7 returnaddress String (120)^ Yes^
```
```
8 printonlabel String (1)^ Yes^
```
```
Yes -> Y
```
```
No -> N
```
**JSON Body Request/Payload** {

```
"accessToken":
"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9eyJjbGlbnRpZCI6IjIxNTYxMDgxNyIsInNlcn
ZpY2VzIjoiMzcwLDM3MSIsIm",
```
```
"customerno": “ 217698 ”
```
```
)
```
**API Success Response** {
"detail": [
{
"costcentercode": "001 - LHR",
"costcentercity": "LAHORE",
"costcentername": "Dubuy LHR",
"phoneno": "03447274889",
"email": "info@dubuypk.com",
"pickupaddress": " AGRICS TOWN RAIWIND ROAD LAHORE ,",
"returnaddress": " AGRICS TOWN RAIWIND ROAD LAHORE ,",
"printonlabel": "Y"
},
{
"costcentercode": "002 - KHI",
"costcentercity": "LAHORE",
"costcentername": "Dubuy KHI",


#### Version 1.0

```
"phoneno": "03112313616",
"email": "info@dubuypk.com",
"pickupaddress": "Lasbella Garden Karachi",
"returnaddress": "Lasbella Garden Karachi",
"printonlabel": "Y"
},
{
"costcentercode": "003 - GUJ",
"costcentercity": "LAHORE",
"costcentername": "Sharif Fabrics Gujranwala",
"phoneno": "03237466222",
"email": "info@dubuypk.com",
"pickupaddress": "M sharif 276 A model town back side of
Jinnah hospital band Gali Gujranwala",
"returnaddress": "M sharif 276 A model town back side of
Jinnah hospital band Gali Gujranwala",
"printonlabel": "Y"
}
],
"message": "success",
"traceid": "15f62e2d-bccf-44ae- 9928 - 63996b4bcc22"
}
Failure Response {
"code": "UnAuthorized",
"message": "Invalid access token",
"status": 401
}
```
Payment – Status

```
API Name Payment Status
```
```
Description To retrieve the current status of a payment transaction.
```
```
Sandbox/Developer Link https://devconnect.tcscourier.com/ecom/api/Payment/status
Production Link https://ociconnect.tcscourier.com/ecom/api/Payment/status
API Method GET
Bearer Token
Provided in Authorization API
```
```
API Body S No. Parameter Mandatory Data Type Remarks
1 customerno Yes Number To be provided by Shipper
```
```
2 consignmentno^ Yes^ Number^ To be provided by Shipper^
JSON Body Request/Payload {^
"customerno": "1234"
"consignmentno": " 779412323079 "
}
```

#### Version 1.0

```
API Success Response {^
"detail": [
{
"booking date": "09/09/2024",
"cn by courier": "779412323079",
"cn status": "RO",
"order no": "Internet 591139",
"payment status": "N",
"amount paid": 0 ,
"parcel weight": 0.5,
"city": "TMK",
"delivery charges": 116 ,
"delivery date": "16/09/2024",
"payment date": null
}
],
"message": "SUCCESS",
"status": "true",
"traceid": "7cc65dfc-8b8b- 4186 - 9259 - aae6ba9f7d66"
}
Failure Response
{
"detail": null,
"message": "Invalid CN",
"status": "true",
"traceid": "3a52a19c-84cc- 4416 - b7f9-b05d38051eb4"
}
```
Payment – Detail

```
API Name Payment Detail
```
```
Description To retrieve detailed information about a specific payment transaction.
```
```
Sandbox/Developer Link https://devconnect.tcscourier.com/ecom/api/Payment/detail
Production Link https://ociconnect.tcscourier.com/ecom/api/Payment/detail
```
```
API Method GET
Bearer Token
Provided in Authorization API
```
```
API Body S. No. Parameter Mandatory Data Type Remarks
1 accesstoken Yes String (400) To be provided by Customer
2 customerno Yes Number To be provided by Customer
3 fromdate Yes Number -
```
```
4 todate^ Yes^ Number^ -^
```

#### Version 1.0

JSON Body Request/Payload {^
"accesstoken": ""
"customerno": " 123456 "
"fromdate": " 2024 - 09 - 08 "
"todate": " 2024 - 09 - 14 "
}

API Success Response {^
"detail": [
{
"booking date": "09/09/2024",
"cn by courier": "779412322995",
"cn status": "OK",
"order no": "Internet 591128",
"payment status": "N",
"amount paid": 0 ,
"parcel weight": 1 ,
"city": "KHI",
"delivery charges": 118 ,
"delivery date": "10/09/2024",
"payment date": null
},
{
"booking date": "09/09/2024",
"cn by courier": "779412323054",
"cn status": "OK",
"order no": "Internet 590823",
"payment status": "N",
"amount paid": 0 ,
"parcel weight": 2 ,
"city": "SLT",
"delivery charges": 174 ,
"delivery date": "13/09/2024",
"payment date": null
},
{
"booking date": "09/09/2024",
"cn by courier": "779412323079",
"cn status": "RO",
"order no": "Internet 591139",
"payment status": "N",
"amount paid": 0 ,
"parcel weight": 0.5,
"city": "TMK",
"delivery charges": 116 ,
"delivery date": "16/09/2024",
"payment date": null


#### Version 1.0

##### }

##### ],

```
"message": "SUCCESS",
"status": "true",
"traceid": "7cc65dfc-8b8b- 4186 - 9259 - aae6ba9f7d66"
}
Failure Response
{
"code": 401 ,
"message": "Invalid Bearer token. Mismatch configuration.",
"status": "UnAuthorized"
}
```
Setup – Area Code

```
API Name Area code
```
```
Description To retrieve area codes by area description
```
```
Sandbox/Developer Link https://devconnect.tcscourier.com/ecom/api/setup/areacode
Production Link https://ociconnect.tcscourier.com/ecom/api/setup/areacode
API Method GET
Bearer Token
Provided in Authorization API
```
API Body (^) S No. Parameter Mandatory Data Type Remarks
1 citycode No String To be provided by TCS
2 area^ No^ String^ To be provided by TCS^
JSON Body Request/Payload {^
"citycode": "KHI",
"area": ""
}
API Success Response {^
"message": "SUCCESS",
"count": "9",
"data": [
{
"srl": 1 ,
"areaid": 163 ,
"citycode": "HSL",
"areacode": "R80302402",
"areaname": "Jamalpur"
},
{
"srl": 2 ,


#### Version 1.0

"areaid": 164 ,
"citycode": "JMP",
"areacode": "R80302762",
"areaname": "Jampur"
},
{
"srl": 3 ,
"areaid": 165 ,
"citycode": "PEW",
"areacode": "RPK5773",
"areaname": "Jamrud - Khyber Agency"
},
{
"srl": 4 ,
"areaid": 166 ,
"citycode": "JND",
"areacode": "R80302688",
"areaname": "Jand"
},
{
"srl": 5 ,
"areaid": 167 ,
"citycode": "QML",
"areacode": "R80302947",
"areaname": "Jandala"
},
{
"srl": 6 ,
"areaid": 168 ,
"citycode": "NRL",
"areacode": "R80302434",
"areaname": "Jassar"
},
{
"srl": 7 ,
"areaid": 169 ,
"citycode": "NOW",
"areacode": "R80302362",
"areaname": "Jehangira"
},
{
"srl": 8 ,
"areaid": 170 ,
"citycode": "HZD",
"areacode": "R80302556",
"areaname": "Jhairanwala"
},


#### Version 1.0

##### {

```
"srl": 9 ,
"areaid": 171 ,
"citycode": "SGD",
"areacode": "R80306616",
"areaname": "Jhal Chakian"
}
],
"traceid": "83351973- 9924 - 4133 - ab3-007ead38e62f"
}
Failure Response
{
"code": 401 ,
"message": "Invalid Bearer token. Mismatch configuration.",
"status": "UnAuthorized"
}
```
Setup – Block Code

```
API Name Block code
```
```
Description To retrieve block code by block description
```
```
Sandbox/Developer Link https://devconnect.tcscourier.com/ecom/api/setup/blockcode
Production Link https://ociconnect.tcscourier.com/ecom/api/setup/blockcode
API Method GET
Bearer Token
Provided in Authorization API
```
```
API Body S No. Parameter Mandatory Data Type Remarks
1 area Yes String To be provided by TCS
2 blockcode^ No^ String^ To be provided by TCS^
JSON Body Request/Payload {^
"area": "R80306631",
"blockcode": ""
}
```
```
API Success Response {
"message": "SUCCESS",
"count": "2",
"data": [
{
"srl": 1 ,
"blockid": 19396 ,
"citycode": "LHE",
"areaid": 593 ,
```

#### Version 1.0

```
"areacode": "R80306631",
"blockcode": "R80306632",
"blockname": "Abdul Karim Road"
},
{
"srl": 2 ,
"blockid": 19397 ,
"citycode": "LHE",
"areaid": 593 ,
"areacode": "R80306631",
"blockcode": "R80306633",
"blockname": "Shaheen Complex"
}
],
"traceid": "ef12bf80-9cd9-46f1-a060-c3b73c4f011e"
}
Failure Response
{
"code": 401 ,
"message": "Invalid Bearer token. Mismatch configuration.",
"status": "UnAuthorized"
}
```
Setup – Country List

```
API Name Country list
```
```
Description To retrieve a list of countries for setup using the Country List API.
```
```
Sandbox/Developer Link https://devconnect.tcscourier.com/ecom/api/setup/countrylist
Production Link https://ociconnect.tcscourier.com/ecom/api/setup/countrylist
API Method GET
Bearer Token
Provided in Authorization API
```
```
API Body This API runs without any input parameters
```
```
JSON Body Request/Payload N/A^
```
```
API Success Response {
"message": "SUCCESS",
"data": [
{
"countrycode": "PK",
"countryname": "PAKISTAN"
```

#### Version 1.0

##### },

##### {

```
"countrycode": "DXB",
"countryname": "UAE"
}
],
"traceid": "20aeb-72fc-4b21-92c8-8abc5eb163b9"
}
```
```
Failure Response
```
##### {

```
"result": null ,
"status": false ,
"code": "401"
}
```
Setup – City list by Country

```
API Name City list by Country
```
```
Description To retrieve a list of cities for a specified country using the CityListByCountry API.
```
```
Sandbox/Developer Link https://devconnect.tcscourier.com/ecom/api/setup/citylistbycountry
Production Link https://ociconnect.tcscourier.com/ecom/api/setup/citylistbycountry
API Method GET
Bearer Token
Provided in Authorization API
```
```
API Body S No. Parameter Mandatory Data Type Remarks
```
```
1 countrycode^ Yes^ String^ To be provided by TCS^
```
```
JSON Body Request/Payload {^
```
```
"countrycode": ["PK"]
```
```
}
```
```
API Success Response {
"message": "SUCCESS",
"data": [
{
"citycode": "TAL",
"cityname": "TALL"
},
{
"citycode": "TDJ",
"cityname": "TANDO JAM"
},
{
```

#### Version 1.0

```
"citycode": "TOP",
"cityname": "TOPI"
}
],
"traceid": "e52914aa-1f71-4a0a-b899-b4edd7361b72"
}
Failure Response
{
"result": null ,
"status": false ,
"code": "401"
}
```
Setup – Route List

```
API Name Route list
```
```
Description To fetch or set up a list of routes for a specified system or module, The request can include various filtering or
sorting parameters to customize the output based on the route list requirements.
```
```
Sandbox/Developer Link https://devconnect.tcscourier.com/ecom/api/setup/routelist/
Production Link https://ociconnect.tcscourier.com/ecom/api/setup/routelist/
API Method GET
Bearer Token
Provided in Authorization API
```
```
API Body S No. Parameter Mandatory Data Type Remarks
```
```
1 countrycode^ Yes^ String^ To be provided by Customer^
```
JSON Body Request/Payload (^) {
"countrycode": "SKT",
}
API Success Response {
"message": "SUCCESS",
"data": [
{
"stA_NO": "SKT",
"routE_CODE": "X24118",
"routE_TYPE": "COCO",
"exP_NAME": "Khurrianwala Express Center",
"address": "TCS Express Center Shop No. 707 Khilot No. 1029
Khrrianwals Shahkot",
"contacT_NUMBER": "3169992870",
"areA_NO": "FSD",


#### Version 1.0

```
"latitude": "31.496388",
"longitude": "73.269244",
"flaG_HAZIR": "N",
"flaG_EC": "Y"
},
{
"stA_NO": "SKT",
"routE_CODE": "X24203",
"routE_TYPE": "Franchise",
"exP_NAME": "Shahkot Express Center",
"address": "TCS Express Center Opposite Govt. Elementary
School No. 3 Nankana Road Shahkot ",
"contacT_NUMBER": "3169992870",
"areA_NO": "FSD",
"latitude": "31.575158",
"longitude": "73.483265",
"flaG_HAZIR": "N",
"flaG_EC": "Y"
},
{
"stA_NO": "SKT",
"routE_CODE": "X24404",
"routE_TYPE": "Shop in Shop",
"exP_NAME": "Adda Jhol ",
"address": "TCS Express Center Bismillah Market Sheikhupura
Faisalabad ",
"contacT_NUMBER": "3169992870",
"areA_NO": "FSD",
"latitude": "31.522127",
"longitude": "73.371926",
"flaG_HAZIR": "N",
"flaG_EC": "Y"
}
],
"status": "true",
"traceid": "21291a14- 8232 - 4e5b-a24b-de90a0b13d0f"
}
```
Failure Response
{
"code": 401 ,
"Message": "Invalid.",
"status": "UnAuthorized"
}


#### Version 1.0

Setup – Delivery Status List

```
API Name Delivery Status List
```
```
Description To fetch available tracking status for orders
```
```
Production Link https://devconnect.tcscourier.com/ecom/setup/deliverystatuslist
```
```
Sandbox/Developer Link https://ociconnect.tcscourier.com/ecom/setup/deliverystatuslist
```
```
API Method GET
```
```
Bearer Token Provided in Authorization API
```
```
API Body This API runs without any input parameters
```
```
JSON Body Request/Payload
N/A
```
```
API Success Response {^
"detail": [
{
"statuscode": "DBC",
"description": "Delay Beyond Our Control"
},
{
"statuscode": "DFC",
"description": "Delay due to Flight Cancelled"
},
{
"statuscode": "DAE",
"description": "Delay due To Airline Handling Error"
},
{
"statuscode": "DFM",
"description": "Delay due To Force Majeure"
}
],
"message": "SUCCESS",
"traceid": "7c9dbc4b-5edb-457f- 9343 - 7e89e422025c"
}
Failure Response {
"code": "UnAuthorized",
"message": "Invalid access token",
"status": 401
}
```

#### Version 1.0

Tracking

```
API Name Tracking
Descriptio To efficiently monitor and manage tracking needs.
```
```
Sandbox/Developer Link https://devconnect.tcscourier.com/tracking/api/Tracking/GetDynamicTrackDetail
Production Link https://ociconnect.tcscourier.com/tracking/api/Tracking/GetDynamicTrackDetail
API Method GET
Bearer Token
Provided in Authorization API
```
API Body (^) S No. Parameter Mandatory Data Type Remarks
1 consignee^ Yes^ String^ TCS^ CN Number^
JSON Body Request/Payload {^
"consignee": [” 779412326902 ”]
}
API Success Response {
"shipmentinfo": [
{
"consignmentno": "779412326902",
"bookingdate": "Oct 14, 2024",
"shipper": "Imrooz Haider",
"consignee": "Imrooz Haider",
"origin": "LAHORE",
"origincountry": "PAK",
"destination": "BAGH",
"destinationcountry": "PAK",
"referenceno": "NA"
}
],
"deliveryinfo": [
{
"consignmentno": "779412326902",
"station": "BAGH",
"datetime": "Thursday Oct 17, 2024 12:58",
"recievedby": "IMROOZ",
"status": "Delivered",
"code": "OK",
"allowshow": "Y"
},
{
"consignmentno": "779412326902",
"station": "BAGH",
"datetime": "Wednesday Oct 16, 2024 11:58",
"recievedby": **null** ,
"status": "Awaiting Receiver Collection",


#### Version 1.0

```
"code": "SC",
"allowshow": "Y"
}
],
"checkpoints": [
{
"consignmentno": "779412326902",
"datetime": "Thursday Oct 17, 2024 12:58",
"recievedby": "IMROOZ",
"status": "Shipment Delivered"
},
{
"consignmentno": "779412326902",
"datetime": "Thursday Oct 17, 2024 09:35",
"recievedby": null ,
"status": "Out For Delivery"
},
{
"consignmentno": "779412326902",
"datetime": "Wednesday Oct 16, 2024 10:52",
"recievedby": "BAGH",
"status": "Arrived at TCS Facility"
},
{
"consignmentno": "779412326902",
"datetime": "Monday Oct 14, 2024 23:19",
"recievedby": "LAHORE",
"status": "Arrived at TCS Facility"
}
],
"shipmentsummary": "Current Status: DELIVERED\nDelivered On:
Thursday Oct 17, 2024 12:58\nSigned By: Imrooz",
"message": "SUCCESS",
"traceid": "111c95db-9d3b-4b6d- 8509 - 6b116fd372a5"
}
```
Failure Response
{
"shipmentinfo": **null** ,
"deliveryinfo": **null** ,
"checkpoints": **null** ,
"shipmentsummary": "No Data Found/Invalid CN",
"message": "FAIL",
"traceid": "8aded596- 4811 - 408d-b4f7-7481d0602a75"
}


#### Version 1.0

Status Codes

```
Status Code Description
```
##### 200 OK

```
201 Created
```
```
400 Bad request
```
```
401 Authentication failure
```
```
403 Forbidden
```
```
404 Resource not found
```
```
405 Method Not Allowed
```
```
500 Internal Server Error
```
```
501 Not Implemented
```
```
503 Service Unavailable
```

