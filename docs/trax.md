API Documentation-SONIC

## Sonic

```
By
```
_Version 2._

_April 18 , 20 22_


## Table of Contents

- Sonic
- (a) Pre-Requisites:
- 1. Add a Pickup Address
- 2.List of Pickup Addresses
- 3. City List and Information
- 4. Book a Shipment
- 5. Current Status of a Shipment
- 6. Tracking of a Shipment.......................................................................................................
- 7.Charges of a Shipment
- 9. Payment Details of a Shipment [Multiple]
- 9. Payment Details of a Shipment [Invoice]
- 10. Payment Details of a Shipment
- 11.Printing Air waybill (Consignment Note) of a Shipment
- 12. Cancelling a Booked Shipment
- 13. Calculating the Rates for a Destination
- 14. Creating a Receiving Sheet
- 15. View/Print a Receiving Sheet
- 16. Order ID Tracking
- 17. Shipment Status by Order ID
- 18. Return Confirmation Pending Status
- 19. Re-attempted Requested Status
- 20. Intercept/Rebook Request
- 21. CRM Request (Complaint)
- 22. CRM Request (Service Request)
- 23. CRM Request (Claim)
- 24. Shipment Status Webhooks
- 25. Payment Status Webhooks
- 26. Initial Charges Webhooks
- 27. Final Charges Webhooks


## (a) Pre-Requisites:

### TESTING URL

Live: [http://sonic.pk](http://sonic.pk)
Testing: [http://app.sonic.pk](http://app.sonic.pk)

### HOW TO GET API AUTHORIZATION KEY

Fig 1: Profile option

On the header section of the portal, go for the profile option at the top-right (by clicking on the company name).

```
Fig 2: API Key field in the profile screen
```
Upon clicking, the profile screen will be opened, where the API key can be seen at the bottom row, which you can
copy to use for authorization purposes.


## 1. Add a Pickup Address

```
METHOD - > POST
```
### HEADERS

### BODY

Add these variables and their values as ‘Body’ in the API.

```
S.no.
Variable
Description
Condition
Validation
Format
Sample
```
### 1

```
person_of
_contact
```
```
Name of the person
who will be
coordinating for
pickup
```
```
Mandatory
Character
limit:
```
```
String
Ali Baba
```
### 2

```
phone_number
```
```
Phone Number of
the coordinator for
pickup
```
```
Mandatory
The phone
number is bound
on this format
```
```
i.e.,
```
```
Integer
0300 - 1234567
```
### 3

```
Email_address
```
```
Email address of the
coordinator for
pickup
```
```
Mandatory
Email
hello@trax.pk
```
### 4

```
address
```
```
The address from
which the shipment
will be Picked
```
```
Mandatory
Character limit:
190
```
```
String
```
```
Shahra-e-Faisal,
Karachi, Pakistan.
```
### 5

```
city_id
```
```
Float ID of the city
from where the
shipment
will be picked
```
```
Mandatory
City IDs can be
viewed
From City List API
```
```
Integer
202
```
### RESULT

### {

"status": 0 ,

"message": "Pickup Address has been added",

"id": 3015

}

### URL

```
https://sonic.pk/api/pickup_address/add
```
```
Input Description
```
```
Authorization API Key to be provided individually
```

## 2.List of Pickup Addresses

```
METHOD -> GET
```
### HEADERS

### RESULT

### {

"status": 0 ,

"message": "Pickup Addresses",

"pickup_addresses": [

{

"id": 3012 ,

"person_of_contact": "Sahban",

"phone_number": "0349-1330874",

"Email_address": "sgk@mail.com",

"address": "Gulshan-e-Iqbal",

"status": 1 ,

"default": **false** ,

"city": {

"id": 202 ,

"name": "Karachi"

}

},

{

"id": 3015 ,

"person_of_contact": "ali baba",

"phone_number": "03001234567",

"Email_address": "Email@trax.pk",

"address": "shahra e faisal",

"status": 1 ,

"default": **false** ,

"city": {

"id": 202 ,

"name": "Karachi"

}

}

]

}

### URL

```
https://sonic.pk/api/pickup_addresses
```
```
Input Description
```
```
Authorization API Key to be provided individually
```

## 3. City List and Information

### METHOD -> GET

### HEADERS

### RESULT

### {

"status": 0 ,

"message": "Pickup and Delivery Information of Cities",

"cities": [

{

"id": 101 ,

"name": "Abbottabad",

"hub": {

"id": 101 ,

"name": "Abbottabad"

},

"zone": {

"id": 3 ,

"name": "North"

},

"pickup": **true** ,

"delivery": {

"Regular": [

"Rush",

"Saver Plus"

],

"Replacement": [

"Rush"

]

}

},

{

"id": 102 ,

"name": "Abdul Hakim",

"hub": {

"id": 251 ,

"name": "Multan"

### URL

```
https://sonic.pk/api/cities
```
```
Input Description
```
```
Authorization API Key to be provided individually
```

### },

"zone": {

"id": 2 ,

"name": "Central"

},

"pickup": **false** ,

"delivery": {

"Regular": [

"Rush",

"Saver Plus"

],

"Replacement": [

"Rush"

]

}

},


## 4. Book a Shipment

### METHOD -> POST

### HEADERS

### BODY

Add these variables and their values as ‘Body’ in the API.

### FOR REGULAR SHIPMENTS

```
S.n
o
```
```
Variable Description Condition Validation Forma
t
```
```
Sample
```
### 1

```
service_type_id
```
```
Defines the
service that
you are
going to use
i.e., Regular
Replacemen
t, or Try &
Buy.
```
```
Mandatory
Check
Appendix A
```
```
Integer
1
```
### 2

```
pickup_address_id
```
```
The address
from which
the
shipment
will be
picked
```
```
Mandatory
Address IDs
can be
viewed from
Addresses
API
```
```
Integer
123
```
### 3

```
information_display
```
```
Option to
show or hide
your contact
details on
the air
waybill
```
```
Mandatory
To hide enter
"0", to show
enter “1”
```
```
Integer
0
```
### 4

```
consignee_city_id
```
```
Float ID of
the city
where the
shipment
will be
delivered
```
```
Mandatory
```
```
City IDs can
be viewed
from City List
API. Only
cities allotted
for the
subjected
service can
be added
```
```
Integer
202
```
### URL

```
https://sonic.pk/api/shipment/book
```
```
Input Description
```
```
Authorization API Key to be provided individually
```

### 5

```
consignee_name
```
```
Name of the
receiver to
whom the
shipment
will be
delivered
```
```
Mandatory
Character
limit: 100
```
```
String
Abdullah
```
### 6

```
consignee_address
Address
where the
shipment
will be
delivered
```
```
Mandatory
Character
limit 190
```
```
String
Shahra-e-
Faisal, Karachi,
Pakistan.
```
### 7

```
consignee_phone_number_
1
```
```
Phone
Number of
the receiver
```
```
Mandatory
The Phone
Number is
bound on this
format i.e.,
03001234567
```
```
Phone
Numbe
r
```
### 0300 - 1234567

### 8

```
consignee_phone_number_
2
```
```
Another
Phone
Number of
the receiver
```
```
Optional
The Phone
Number is
bound on this
format i.e.,
0300 -
1234567
```
```
Phone
Numbe
r
```
### 0300 - 1234567

### 9

```
consignee_email_address
Email
address of
the
coordinator
for pickup
```
```
Mandatory
Email
hello@trax.pk
```
### 10

```
order_id
Shipper’s
own
reference ID
```
```
Optional
It must be
unique for
one shipper.
Character
Limit: 100
```
```
String
A- 148
```
### 11

```
item_product_type_id
Category of
the item(s)
in the order
to be
delivered
```
```
Mandatory
Check
Appendix B
```
```
Integer
12
```
### 12

```
item_description
Nature and
details of the
item(s) in
the order to
be delivered
```
```
Mandatory
Character
limit: 190
```
```
String
One black t-
shirt medium
```
### 13

```
item_quantity
Number of
item(s)
```
```
Mandatory
Integer
2
```

### 14

```
item_insurance
Provision to
opt
Insurance
claim in
case of loss
of item
```
```
Mandatory
This will only
be valid for
customers
whose
insurance is
authorized at
the time of
account
opening, to
deselect enter
"0", to select
enter "1"
```
```
Integer
0
```
### 15

```
item_price
Value of the
item(s) in
the order
```
```
Optional
Subjected to
selecting
item_insuranc
e
```
```
Integer
1000
```
### 16

```
pickup_date
Date at
which the
order is
requested to
be picked
```
```
Mandatory
YYYY-MM-
DD
```
```
Date
2018 - 08 - 07
```
### 17

```
special_instructions
Any reference or
remarks
regarding the
delivery
```
```
Optional
String
Please call
before delivery
```
### 18

```
estimated_weight
Estimated
mass of the
shipment
```
```
Mandatory
Please note
that this will
not be the
final weight
of the
shipment
and no
charges will
be
calculated
based on
this value
```
```
Float
1.
```
### 19

```
shipping_mode_id
The method of
shipping
through which
the shipment
will be
delivered
```
```
Mandatory
Check
Appendix C
```
```
Integer
1
```
### 20

```
same_day_timing_id
```
```
For same-day
shipping mode,
define the
timeline in
```
```
Optional
```
```
For "
hours" enter
"1",
```
```
Integer
1
```

```
which the
shipment will
be delivered
```
```
For "Same-
day" enter
"2"
```
### 21

```
amount
The amount to
be collected at
the time of
delivery
```
```
Mandatory
Do not use
commas or
dots for this
Parameter
```
```
Integer
1000
```
### 22

```
payment_mode_id
How the
amount will be
collected, either
COD, card or
mobile wallet
```
```
Mandatory
Check
Appendix C
```
```
Integer
1
```
### 23

```
charges_mode_id
How the
shipper would
want TRAX to
collect their
service
charges, either
from the
shipper or from
their
consignees via
2Pay option
```
```
Mandatory
Check
Appendix F
```
```
Integer
2 or 4 for
Reimburseme
nt Account
type, 2 or 3 for
Invoicing
Account type
```
### 24

```
open_shipment
Customer allows
to open the
shipment at the
time of delivery
```
```
Optional
To open box
"1"
```
```
Integer
0 and 1
```
### 25

```
pieces_quantity
To book a
shipment for
multiple pieces.
```
```
Optional
Integer
between 1 to
10
```
```
Integer
1 to 10
```
### 26

```
shipper_reference_number
_
```
```
be picked
respect to his
shipment
```
```
Optional be picked String Abdullah 1122
```
### 27

```
shipper_reference_number
_
```
```
If Shipper
wants to add
any reference
with respect to
his shipment
```
```
Optional Character
Limit: 190
```
```
String Abdullah 1122
```
### 28

```
shipper_reference_number
_
```
```
If Shipper wants
to add any
reference with
respect to his
shipment
```
```
Optional Character
Limit: 190
```
```
String Abdullah 1122
```

### 29

```
shipper_reference_number
_
```
```
If Shipper wants
to add any
reference with
respect to his
shipment
```
```
Optional Character
Limit: 190
```
```
String Abdullah 1122
```
### 30

```
shipper_reference_number
_
```
```
If Shipper
wants to add
any reference
with respect to
his shipment
```
```
Optional Character
Limit: 190
```
```
String Abdullah 1122
```
FOR REPLACEMENT SHIPMENTS

```
S.no
.
```
```
Variable Description Condition Validation Format Sample
```
```
1 service_type_id Defines the service
that you are going to
use i.e. Regular,
Replacement, or Try
& Buy
```
```
Mandatory Check
Appendix A
```
```
Integer 2
```
```
2 pickup_address_id The address from
which the shipment
will be picked
```
```
Mandatory Address
IDs can be
viewed
from
Addresses
API
```
```
Integer 123
```
```
3 information_display Option to show or
hide your contact
details on the air
waybill
```
```
Mandatory To hide
enter "0", to
show enter
"1"
```
```
Integer 0
```
```
4 consignee_city_id Float^ ID of the city
where the shipment
will be delivered
```
```
Mandatory City IDs
can be
viewed
from City
List API.
Only cities
allotted for
the
subjected
service can
be added
```
```
Integer 202
```
```
5 consignee_name Name of the receiver
to whom the
shipment will be
delivered
```
```
Mandatory Character
limit: 100
```
```
String Abdullah
```
```
6 consignee_address Address where the
shipment delivered
```
```
Mandatory Character
limit: 190
```
```
String Shahra-e-^
Faisal,
Karachi
```

7 consignee_phone_nu
mber_

```
Phone Number of the
receiver
```
```
Mandatory The Phone
Number is
bound on
this format
i.e. 0300-
1234567
```
```
Phone
Number
```
### 0300 -

### 1234567

8 consignee_phone_nu
mber_

```
Another Phone
Number of the
receiver
```
```
Optional The Phone
Number is
bound on
this format
i.e. 0300-
1234567
```
```
Phone
Number
```
### 0300 -

### 1234567

9 consignee_email_add
ress

```
Email address of the
coordinator for pickup
```
```
Mandatory Email hello@trax.
pk
```
10 order_id Shipper's own
reference ID

```
Optional It must be
unique for
one
shipper.
```
```
Character
limit: 100
```
```
String A- 148
```
11 item_product_type_id Category of the
item(s) in the order to
be delivered

```
Mandatory Check
Appendix B
```
```
Integer 12
```
12 item_description Nature and details of
the item(s) in the
order to be delivered

```
Mandatory Character
limit: 190
```
```
String one black t
shirt
medium
```
13 item_quantity Number of item(s) Mandatory Integer 2

14 item_insurance Provision to opt
Insurance claim in
case of loss of items

```
Mandatory This will
only be
valid for
customers
whose
insurance is
authorized
at the time
of account
opening, to
deselect
enter "0, to
select enter
"1"
```
```
Integer 0
```
15 item_price Value of the item(s)
in the ordesr

```
Mandatory Subjected
to selecting
item_insura
nce
```
```
Integer 100
```
16 replacement_item_pr
oduct_type_id

```
Category of the
item(s) in the order to
be exchanged
```
```
Mandatory Check
Appendix B
```
```
Integer 11
```

```
17 replacement_item_de
scription
```
```
Nature and details of
the item(s) in the
order to be
exchanged
```
```
Mandatory Character
limit: 190
```
```
String one blue t
shirt
medium
```
```
18 replacement_item_qu
antity
```
```
Number of item(s) Mandatory Integer 1
```
```
19 Replacement_item_i
mage
```
```
Add replacement
image
```
```
Optional Image
format
required
```
```
Png,
Jpeg
```
20 special_instructions Any reference or
remarks regarding
the delivery

```
Optional Character
limit: 250
```
```
String Please call
before
Delivery
```
21 estimated_weight Estimated mass of
the shipment

```
Mandatory Please note
that this will
not be the
final weight
of the
shipment
and no
charges will
be
calculated
based on
this value
```
```
Float 1.
```
22 shipping_mode_id The method of
shipping through
which the shipment
will be delivered

```
Mandatory Check
Appendix C
```
```
Integer 1
```
23 amount The amount to be
collected at the time
of delivery

```
Mandatory Do not use
commas or
dots for this
parameter
```
```
Integer
1000
```
24 charges_mode_id How the shipper
would want TRAX to
collect their service
charges, either from
the shipper or from
their consignees via
2Pay option

```
Mandatory Check
Appendix F
```
```
Integer 2 or 4 for^
Reimburse
ment
Account
type, 2 or 3
for
Invoicing
Account
type
```
25 payment_mode_id How the amount will
be collected, either
COD, card or mobile
wallet

```
Mandatory Check
Appendix D
```
```
Integer 1
```
26 open_shipment Customer allows to
open the shipment at

```
Optional To open box Integer 0 and 1
```

```
the time of delivery "1"
```
```
27 shipper_reference_nu
mber_
```
```
If Shipper wants to
add any reference
with respect to his
shipment
```
```
Optional Character
Limit: 190
```
```
String Abdullah 11
22
```
```
28 shipper_reference_nu
mber_
```
```
If Shipper wants to
add any reference
with respect to his
shipment
```
```
Optional Character
Limit: 190
```
```
String Abdullah 11
22
```
```
29 shipper_reference_nu
mber_
```
```
If Shipper wants to
add any reference
with respect to his
shipment
```
```
Optional Character
Limit: 190
```
```
String Abdullah 11
22
```
```
30 shipper_reference_nu
mber_
```
```
If Shipper wants to
add any reference
with respect to his
shipment
```
```
Optional Character
Limit: 190
```
```
String Abdullah 11
22
```
```
31 shipper_reference_nu
mber_
```
```
If Shipper wants to
add any reference
with respect to his
shipment
```
```
Optional Character
Limit: 190
```
```
String Abdullah 11
22
```
FOR TRY & BUY SHIPMENTS

```
S.no
.
```
```
Variable Description Condition Validation Format Sample
```
```
1 service_type_id Defines the service
that you are going
to use i.e. Regular,
Replacement, or
Try & Buy
```
```
Mandatory Check
Appendix A
```
```
Integer 3
```
```
2 pickup_address_id The address from
which the shipment
will be picked
```
```
Mandatory Address
IDs can be
viewed
from
Addresses
API
```
```
Integer 123
```
```
3 information_display Option to show or
hide your contact
details on the air
waybill
```
```
Mandatory To hide
enter "0", to
show enter
"1"
```
```
Integer 0
```

```
4 consignee_city_id Float^ ID of the city
where the shipment
will be delivered
```
```
Mandatory City IDs
can be
viewed
from City
List API.
Only cities
allotted for
the
subjected
service can
be added
```
```
Integer 202
```
5 consignee_name Name of the
receiver to whom
the shipment will be
delivered

```
Mandatory Character
limit: 100
```
```
String Abdullah
```
6 consignee_address Address where the
shipment will be
delivered

```
Mandatory Character
limit: 190
```
```
String Shahra^ e
Faisal,
Karachi,
Pakistan
```
7 consignee_phone_n
umber_

```
Phone Number of
the receiver
```
```
Mandatory The Phone
Number is
bound on
this format
i.e., 0300-
1234567
```
```
Phone
Number
```
### 0300 -

### 1234567

8 consignee_phone_n
umber_

```
Another Phone
Number of the
receiver
```
```
Optional The Phone
Number is
bound on
this format
i.e. 0300-
1234567
```
```
Phone
Number
```
### 0300 -

### 1234567

9 consignee_email_a
ddress

```
Email address of
the coordinator for
pickup
```
```
Mandatory "@" is
mandatory
to add
```
```
Email hello@trax.p
k
```
10 order_id Shipper's own
reference ID

```
Optional It must be
unique for
one
shipper.
```
```
Character
limit: 100
```
```
String A- 148
```
11.1 items[n][item_produ
ct_type_id]

```
Category of the
item no. "n" in the
order to be
delivered, where "n"
is any no. of items
in a Try & Buy
```
```
Mandatory Check
Appendix B
```
```
Integer 10
```

```
Shipment
```
```
11.2 items[n][item_descri
ption]
```
```
Nature and details
of the item no. "n"
in the order to be
delivered
```
```
Mandatory Character
limit: 190
```
```
String one black t
shirt medium
```
```
11.3 items[n][item_quanti
ty]
```
```
Number of item(s) Mandatory Integer 1
```
```
11.4 items[n][item_insura
nce]
```
```
Provision to opt
Insurance claim in
case of loss of
items
```
```
Mandatory This will
only be
valid for
customers
whose
insurance is
authorized
at the time
of account
opening, to
deselect
enter "0", to
select enter
"1"
```
```
Integer 1
```
11.5 Items[n]product_val
ue

```
Put the value of
each product
```
```
Mandatory Integer 1000
```
```
11.6 items[n][item_price] Value of the item
no. "n" in the order
```
```
Mandatory Subjected
to selecting
item_insura
nce
```
```
Integer 1000
```
```
12 package_type Defines either the
Try & Buy will be
complete i.e. all the
items will be
delivered or
returned, or partial
i.e. some of the
items will be
delivered and
remaining will be
returned
```
```
Mandatory For
complete
enter "1",
for partial
enter "2"
```
```
Integer 1
```
```
13 pickup_date Date at which the
order is requested
to be picked
```
```
Mandatory YYYY-MM-
DD
```
```
date 2018 - 08 - 07
```
15 try_and_buy_fess Fess that will
charges consignee

```
Mandatory Integer 1000
```
```
16 special_instructions Any reference or
remarks regarding
the delivery
```
```
Optional Character
limit: 190
```
```
String Please call
before
delivery
```

17 estimated_weight Estimated mass of
the shipment

```
Mandatory Please note
that this will
not be the
final weight
of the
shipment
and no
charges will
be
calculated
based on
this value
```
```
Float 1.
```
18 shipping_mode_id The method of
shipping through
which the shipment
will be delivered

```
Mandatory Check
Appendix C
```
```
Integer 1
```
19 amount The amount to be
collected at the time
of delivery

```
Mandatory Do not use
commas or
dots for this
parameter
```
```
Integer 1000
```
20 charges_mode_id How the shipper
would want TRAX
to collect their
service charges,
either from the
shipper or from
their consignees via
2Pay option

```
Mandatory Check
Appendix F
```
```
Integer 2 or 4 for
Reimbursem
ent Account
type, 2 or 3
for Invoicing
Account type
```
21 open_shipment Customer allows to
open the shipment
at the time of
delivery

```
Optional To open
box "1"
```
```
Integer 0 and 1
```
22 payment_mode_id How the amount
will be collected,
either COD, card or
mobile wallet

```
Mandatory Check
Appendix D
```
```
Integer 1
```
23 shipper_reference_
number_

```
If Shipper wants to
add any reference
with respect to his
shipment
```
```
Optional Character
Limit: 190
```
```
String Abdullah 11
22
```
```
24 shipper_reference_
number_
```
```
If Shipper wants to
add any reference
with respect to his
shipment
```
```
Optional Character
Limit: 190
```
```
String Abdullah 11
22
```
```
25 shipper_reference_
number_
```
```
If Shipper wants to
add any reference
with respect to his
shipment
```
```
Optional Character
Limit: 190
```
```
String Abdullah 11
22
```
```
26 shipper_reference_
number_
```
```
If Shipper wants to
add any reference
with respect to his
```
```
Optional Character
Limit: 190
```
```
String Abdullah 11
22
```

```
shipment
```
```
27 shipper_reference_
number_
```
```
If Shipper wants to
add any reference
with respect to his
shipment
```
```
Optional Character
Limit: 190
```
```
String Abdullah 11
22
```
### RESULT

### {

"status": 0 ,

"message": "Shipment has been Booked!",

"tracking number": “

}

### NOTE

If you are using Corporate Invoicing Account. Please be informed that you have to provide the type of

delivery (Door-Step/Hub to Hub).

```
S.no. Variable Description Condition Validation Format Sample
```
### 01

```
delivery_type_id
```
```
Define the type of delivery
that you are going to use
```
- delivery_type_id = 1
    (Door
    Step)
- delivery_type_id =
2 (Hub to Hub)

```
Mandatory
Input can be 1
OR 2
```
```
Integer
1
```

## 5. Current Status of a Shipment

```
METHOD -> GET
```
### HEADERS

### PARAMS

Add these variables and their values as ‘Params’ in the API.

```
S.no. Variable^ Description^ Condition Validation Format Sample
```
```
1 tracking_number The number generated
upon booking of the
shipment
```
```
Mandatory All digits
to be
entered
```
```
Integer 101101000405
```
```
2 type Defines the type of
status tracking, either for
shipper or general
```
```
Mandatory Check
Appendix
E
```
```
Integer 0
```
### RESULT

### {

"status": 0 ,

"message": "Status of Shipment#101101000392",

"current_status”:”Replacement-Exchanged”

}

### URL

```
https://sonic.pk/api/shipment/status
```
```
Input Description
```
```
Authorization Authentication key which will be used for security purposes
```

## 6. Tracking of a Shipment.......................................................................................................

### METHOD -> GET

### HEADERS

### PARAMS

Add these variables and their values as ‘Params’ in the API

### FOR SHIPPERS TRACKING

### RESULT

### {

"status": 0 ,

"message": "Tracking of Shipment #202202366397",

"details": {

"tracking_number": "202202366397",

"order_id": **null** ,

"shipper": {

"name": "SGK Enterprises",

"account_number": 10374 ,

"phone_number_1": "0349-1663481",

"phone_number_2": **null** ,

"Email": "sgk@mail.com",

"city": "Karachi"

```
S.no. Variable Description Condition Validation Format Sample
```
```
1 tracking_number The number generated
upon booking of the
shipment
```
```
Mandatory All digits to
be entered
```
```
Integer 202202366397
```
```
2 type Defines^ the^ type^ of^ status^
tracking, either for
shipper or general
```
```
Mandatory Check
Appendix E
```
```
Integer 0
```
### URL

```
https://sonic.pk/api/shipment/track
```
```
Input Description
```
```
Authorization Authentication key which will be used for security purposes
```

### },

"pickup": {

"origin": "Karachi",

"person_of_contact": "Sahban",

"phone_number": "0349-1330874",

"Email": "sgk@mail.com",

"address": "Gulshan-e-Iqbal"

},

"consignee": {

"name": "saltanat",

"phone_number_1": "0312-2222222",

"phone_number_2": **null** ,

"destination": "Karachi",

"address": "asfjkgasfkjh"

},

"order_information": {

"items": [

{

"order_id": **null** ,

"product_type": "Personal Electronics (Mobile Phones, Laptops, etc

)",

"description": "1223xqw",

"quantity": 1

}

],

"weight": 2 ,

"shipping_mode": "Rush",

"amount": 0 ,

"instructions": **null**

},

"tracking_history": [

{

"date_time": "05/04/2022 12:44 PM",

"timestamp": 1649144698 ,

"status": "Shipment - Out for Delivery",

"status_reason": **null**

},

{

"date_time": "05/04/2022 12:44 PM",

"timestamp": 1649144698 ,

"status": "Shipment - Delivery Unsuccessful",

"status_reason": "Address Incomplete"

},

{

"date_time": "01/04/2022 11:03 AM",

"timestamp": 1648793031 ,

"status": "Shipment - Out for Delivery",

"status_reason": **null**


### },

### {

"date_time": "01/04/2022 11:03 AM",

"timestamp": 1648793031 ,

"status": "Shipment - Delivery Unsuccessful",

"status_reason": "Address Closed"

},

{

"date_time": "31/03/2022 02:41 PM",

"timestamp": 1648719671 ,

"status": "Shipment - Out for Delivery",

"status_reason": **null**

},

{

"date_time": "31/03/2022 02:31 PM",

"timestamp": 1648719107 ,

"status": "Shipment - Arrived at Origin",

"status_reason": **null**

},

{

"date_time": "31/03/2022 02:31 PM",

"timestamp": 1648719071 ,

"status": "Shipment - Arrival Service Center",

"status_reason": **null**

},

{

"date_time": "31/03/2022 10:56 AM",

"timestamp": 1648706190 ,

"status": "Shipment - Booked",

"status_reason": **null**

}

]

}

}

### FOR CONSIGNEES’ AND GENERAL TRACKING

```
S.no. Variable Description Condition Validation Format Sample
```
```
1 tracking_number The number generated
upon booking of the
shipment
```
```
Mandatory All digits to
be entered
```
```
Integer 202202366397
```
```
2 type Defines the type of
status tracking, either
for shipper or general
```
```
Mandatory Check
Appendix E
```
```
Integer 1
```

### RESULT

### {

"status": 0 ,

"message": "Tracking of Shipment #202202366397",

"details": {

"tracking_number": "202202366397",

"order_id": **null** ,

"shipper": {

"name": "SGK Enterprises"

},

"pickup": {

"origin": "Karachi"

},

"consignee": {

"name": "saltanat",

"phone_number_1": "0312-2222222",

"phone_number_2": **null** ,

"destination": "Karachi",

"address": "asfjkgasfkjh"

},

"order_information": {

"items": [

{

"order_id": **null** ,

"product_type": "Personal Electronics (Mobile Phones, Laptops, etc

)",

"description": "1223xqw",

"quantity": 1

}

]

},

"tracking_history": [

{

"date_time": "05/04/2022 12:44 PM",

"timestamp": 1649144698 ,

"status": "Shipment - Out for Delivery",

"status_reason": **null**

},

{

"date_time": "05/04/2022 12:44 PM",

"timestamp": 1649144698 ,

"status": "Shipment - Delivery Unsuccessful",

"status_reason": "Address Incomplete"

},

{


"date_time": "01/04/2022 11:03 AM",

"timestamp": 1648793031 ,

"status": "Shipment - Out for Delivery",

"status_reason": **null**

},

{

"date_time": "01/04/2022 11:03 AM",

"timestamp": 1648793031 ,

"status": "Shipment - Delivery Unsuccessful",

"status_reason": "Address Closed"

},

{

"date_time": "31/03/2022 02:41 PM",

"timestamp": 1648719671 ,

"status": "Shipment - Out for Delivery",

"status_reason": **null**

},

{

"date_time": "31/03/2022 02:31 PM",

"timestamp": 1648719107 ,

"status": "Shipment - Arrived at Origin",

"status_reason": **null**

},

{

"date_time": "31/03/2022 02:31 PM",

"timestamp": 1648719071 ,

"status": "Shipment - Arrival Service Center",

"status_reason": **null**

},

{

"date_time": "31/03/2022 10:56 AM",

"timestamp": 1648706190 ,

"status": "Shipment - Booked",

"status_reason": **null**

}

]

}

}


## 7.Charges of a Shipment

```
METHOD -> GET
```
### HEADERS

### PARAMS

Add these variables and their values as ‘Params’ in the API

```
S.no. Variable Description Condition Validation Format Sample
```
```
1 tracking_number The number generated
upon booking of the
shipment
```
```
Mandatory All digits to be
entered
```
```
Integer 202202366397
```
### RESULT

### {

"status": 0 ,

"message": "Charges of Shipment #202202366397",

"charges": {

"weight_charges": "250.00",

"fuel_surcharge": "32.50",

"cash_handling_charges": "0.00",

"net_payable": "-319.23",

"total_charges": "282.50",

"gst": "36.73"

}

}

### URL

```
https://sonic.pk/api/shipment/charges
```
```
Input Description
```
```
Authorization Authentication key which will be used for security purposes
```

8. Payment Status of a Shipment

METHOD -> GET

### HEADERS

### PARAMS

Add these variables and their values as ‘Params’ in the API

```
S.no. Variable Description Condition Validation Format Sample
```
```
1 Tracking_number The number generated
upon booking of the
shipment
```
```
Mandatory All digits to be
entered
```
```
Integer 144154365851
```
### RESULT

### {

"status": 0 ,

"message": "Payment Status of Shipment #144154365851",

"current_payment_status": "Payment - Processed"

}

### URL

```
https://sonic.pk/api/shipment/payment_status
```
```
Input Description
```
```
Authorization Authentication key which will be used for security purposes
```

## 9. Payment Details of a Shipment [Multiple]

```
METHOD -> GET
```
### HEADERS

### PARAMS

Add these variables and their values as ‘Params’ in the API. You can add multiple tracking numbers in array.

### RESULT

### {

"status": 0 ,

"payments": {

"144154365851": [

{

"payment_status": "Processed",

"billing_method": "Reimbursement Account",

"payment_date": "2022- 04 - 14 11:10:47",

"payment_method": "IBFT",

"payment_type": "Delivered",

"payment_id": 5463

}

]

}

}

```
S.no. Variable Description Condition Validation Format Sample
```
### 1

```
tracking_number[]
Input multiple
tracking numbers
```
```
Mandatory
All digits to
be entered
```
```
Integer
144154365851
```
### URL

```
https://sonic.pk/api/payments
```
```
Input Description
```
```
Authorization Authentication key which will be used for security purposes
```

## 9. Payment Details of a Shipment [Invoice]

```
METHOD -> GET
```
### HEADERS

### PARAMS

Add these variables and their values as ‘Params’ in the API

```
S.no. Variable Description Condition Validation Format Sample
```
```
1 id Invoice id and payment id Mandatory
```
```
All digits to be
entered Integer^930
```
### 2

```
type
For Invoice 1 and for payment 2
Mandatory
```
```
1 for invoice
2 for payment
Integer
1, 2
```
### RESULT

### {

"status": 0 ,

"payments": {

"billing_method": "Corporate Invoicing Account",

"invoice_date": "2021- 06 - 21 00:00:00",

"shipments": [

{

"202202360876": {

"payment_type": "Delivered",

"weight_charges": "500.00",

"cash_handling_charges": "0.00",

"insurance_charges": **null** ,

"return_charges": 0 ,

"fuel_surcharge": "50.00",

"replacement_charges": **null** ,

"try_and_buy_charges": **null** ,

"intercept_charges": **null** ,

### URL

```
https://sonic.pk/api/invoice
```
```
Input Description
```
```
Authorization Authentication key which will be used for security purposes
```

"osa_charges": **null** ,

"adjustment_charges": 0 ,

"total_charges": "550.00",

"gst": "71.50",

"invoice_amount": "621.50"

}

},

{

"202223364138": {

"payment_type": "Delivered",

"weight_charges": "999999.99",

"cash_handling_charges": **null** ,

"insurance_charges": **null** ,

"return_charges": 0 ,

"fuel_surcharge": **null** ,

"replacement_charges": **null** ,

"try_and_buy_charges": **null** ,

"intercept_charges": **null** ,

"osa_charges": **null** ,

"adjustment_charges": 0 ,

"total_charges": "999999.99",

"gst": "130000.00",

"invoice_amount": "1129999.99"

}

}

]

}

}


## 10. Payment Details of a Shipment

```
METHOD -> GET
```
### HEADERS

### PARAMS

Add these variables and their values as ‘Params’ in the API

```
S.no. Variable Description Condition Validation Format Sample
```
```
1 tracking_number^ The number^
generated upon
booking of the
shipment
```
```
Mandatory All digits to
be entered
```
```
Integer 202202364291
```
### RESULT

### {

"status": 0 ,

"message": "Payment(s) of Shipment #202202364291",

"charges": {

"cash_handling_charges": "0.00"

},

"current_payment_status": "Payment - Processed",

"payments": [

{

"id": 5457 ,

"datetime": "2022- 01 - 07 13:04:58",

"type": 0 ,

"amount": 1020 ,

"charges": "0.00",

"gst": "0.00",

"payable": "1020.00"

}

]

### URL

```
https://sonic.pk/api/shipment/payments
```
```
Input Description
```
```
Authorization Authentication key which will be used for security purposes
```

## 11.Printing Air waybill (Consignment Note) of a Shipment

METHOD -> GET

### HEADERS

### PARAMS

Add these variables and their values as ‘Params’ in the API.

### RESULT

```
S.no. Variable Description Condition Validation Format Sample
```
```
1 tracking_number The number
generated upon
booking of the
shipment
```
```
Mandatory All digits to be
entered
```
```
Integer 202202366396
```
```
2 type Type of print, whether
pdf or jpeg
```
```
Mandatory for jpeg, enter
type=0, for pdf
enter type=1
```
```
Integer 0
```
### URL

```
https://sonic.pk/api/shipment/air_waybill
```
```
Input Description
```
```
Authorization Authentication key which will be used for security purposes
```

## 12. Cancelling a Booked Shipment

```
METHOD -> POST
```
### HEADERS

### BODY

Add these variables and their values as ‘Body’ in the API.

```
S.no. Variable Description Condition Validation Format Sample
```
```
1 tracking_number The number generated
upon booking of the
shipment
```
```
Mandatory All digits to be
entered
```
```
Integer 202202366396
```
RESULT

### {

"status": 0 ,

"message": "Shipment #202202366396 is Cancelled"

}

### URL

```
https://sonic.pk/api/shipment/cancel
```
```
Input Description
```
```
Authorization Authentication key which will be used for security purposes
```

## 13. Calculating the Rates for a Destination

METHOD -> POST

### HEADERS

BODY

Add these variables and their values as ‘Body’ in the API.

```
S.no. Variable Description Condition Validation Format Sample
```
```
1 service_type_id Defines the service
that you are going to
use i.e., Regular,
Replacement, or Try
& Buy
```
```
Mandatory Check Appendix A Integer 1
```
```
2 origin_city_id Float^ ID of the city
from where the
shipment will be
picked
```
```
Mandatory City IDs can be viewed
from City List API
```
```
Integer 202
```
```
3 destination_city_id Float^ ID of the city
from where the
shipment will be
picked
```
```
Mandatory City IDs can be viewed
from City List API
```
```
Integer 202
```
```
4 estimated_weight Estimated mass of
the shipment
```
```
Mandatory Please note that this
will not be the final
weight of the shipment
and no charges will be
calculated based on
this value
```
```
Float 1.05
```
```
5 shipping_mode_id The method of
shipping through
which the shipment
will be delivered
```
```
Mandatory Check Appendix C^ Integer 1
```
```
6 amount
The amount to be
collected at the time
of delivery
```
```
Mandatory Do not use commas or
dots for this parameter
```
```
Integer 1000
```
### URL

```
https://sonic.pk/api/charges_calculate
```
```
Input Description
```
```
Authorization Authentication key which will be used for security purposes
```

RESULT

### {

"status": 0 ,

"message": "Charges Calculated",

"information": {

"origin": {

"city": "Karachi",

"zone": "South"

},

"destination": {

"city": "Karachi",

"class": "Local"

},

"charges": {

"weight": 250 ,

"cash_handling": 0 ,

"fuel_surcharge": 57.5,

"total_charges": 307.5,

"gst": 39.97,

"net_payable": 652.53

},

"chargeable_weight": 2

}

}


## 14. Creating a Receiving Sheet

METHOD -> POST

### HEADERS

### BODY

Add these variables and their values as ‘Body’ in the API. You have to add multiple tracking numbers in array.

```
S.no. Parameter Description Condition Validation Format Sample
```
```
1 tracking_numbers[] The number generated
upon booking of the
shipment
```
```
Mandatory All digits to
be entered
```
```
Integer 202202366396
```
```
2 tracking_numbers[] The number generated
upon booking of the
shipment
```
```
Mandatory All digits to
be entered
```
```
Integer 202202366396
```
NOTE: Here, tracking numbers will be entered in an array i.e., multiple tracking numbers can be added

RESULT

### {

"status": 0 ,

"message": "Receiving Sheet has been Created",

"receiving_sheet_id": 6158

}

### URL

```
https://sonic.pk/api/receiving_sheet/create
```
```
Input Description
```
```
Authorization Authentication key which will be used for security purposes
```

## 15. View/Print a Receiving Sheet

METHOD -> GET

### HEADERS

### PARAMS

Add these variables and their values as ‘Params’ in the API.

```
S.no. Variable Description Condition Validation Format Sample
```
```
1 receiving_sheet_id The number generated
upon the creation of
receiving sheet
```
```
Mandatory All digits to be
entered
```
```
Integer 405
```
```
2 type Type of print, whether
pdf or jpeg
```
```
Mandatory for jpeg, enter
type=0,
```
```
for pdf enter type=1
```
```
Integer 0
```
RESULT

### URL

```
https://sonic.pk/api/receiving_sheet/view
```
```
Input Description
```
```
Authorization Authentication key which will be used for security purposes
```

## 16. Order ID Tracking

METHOD -> GET

### HEADERS

### PARAMS

Add these variables and their values as ‘Params’ in the API

```
S.no. Variable Description Condition Format Sample
```
```
1 order_id The serials generated by user Mandatory Integer 405
```
```
2 type Defines the type of status tracking, either for shipper or^
general
```
```
Mandatory Integer 0
```
### RESULT

### {

"status": 0 ,

"message": "Tracking of Shipment(s) - Order ID #000654",

"details": [

{

"tracking_number": 144154365854 ,

"order_id": "000654",

"shipper": {

"name": "Digikhata.pk Test",

"account_number": 10372 ,

"phone_number_1": "0313-7979999",

"phone_number_2": **null** ,

"Email": "umair.qayyum@digikhata.pk",

"city": "Faisalabad"

},

"pickup": {

"origin": "Faisalabad",

"person_of_contact": "Kashif Mehmood",

### URL

```
https://sonic.pk/api/shipment/track/order_id
```
```
Input Description
```
```
Authorization Authentication key which will be used for security
purposes
```

"phone_number": "03007749150",

"Email": "couriers@digikhata.pk",

"address": "Main bazar road block 3"

},

"consignee": {

"name": "ali raza",

"phone_number_1": "0304-4470811",

"phone_number_2": **null** ,

"destination": "Gojra",

"address": "gojra dawakhri"

},

"order_information": {

"items": [

{

"order_id": "000654",

"product_type": "Other",

"description": "Eggs",

"quantity": 1

}

],

"weight": 1 ,

"shipping_mode": "Rush",

"amount": 3000 ,

"instructions": "handle"

},

"tracking_history": [

{

"date_time": "24/03/2022 03:54 PM",

"timestamp": 1648119261 ,

"status": "Shipment - Out for Delivery",

"status_reason": **null**

},

{

"date_time": "24/03/2022 03:46 PM",

"timestamp": 1648118780 ,

"status": "Shipment - Arrived at Origin",

"status_reason": **null**

},

{

"date_time": "24/03/2022 03:35 PM",

"timestamp": 1648118122 ,

"status": "Shipment - Booked",

"status_reason": **null**

}

}

]

}


## 17. Shipment Status by Order ID

METHOD -> GET

### HEADERS

### PARAMS

Add these variables and their values as ‘Params’ in the API.

```
S.no. Variable Description Condition Format Sample
```
```
1 order_id The serials generated by user Mandatory Integer 405
```
```
2 type Defines the type of status tracking, either for shipper or
general
```
```
Mandatory Integer 0
```
RESULT

### {

"status": 0 ,
"message": "Status of Shipment(s) - Order ID #03057171238",
"details": [
{
"origin": "Karachi",
"destination": "Lahore",
"tracking_number": 20222315751328 ,
"status": "Shipment - Out for Delivery",
"reason": null,
"current_status_datetime": "07/04/2022 01:49 PM"
}
]
}

### URL

```
https://sonic.pk/api/shipment/status/order_id
```
```
Input Description
```
```
Authorization Authentication key which will be used for security purposes
```

## 18. Return Confirmation Pending Status

METHOD -> POST

### HEADERS

### BODY

Add these variables and their values as ‘Body’ in the API

```
S.no. Variable Condition Format Sample
```
```
1 tracking_number Mandatory Integer 564864998
```
```
2 type Mandatory Integer Check Appendix J
```
```
3 remarks Optional String remarks
```
RESULT

### {

"status": 0 ,

"message": "Shipment successfully marked as Shipment - Return Confirm"

}

### URL

```
https://sonic.pk/api/request/rcp
```
```
Input Description
```
```
Authorization Authentication key which will be used for security purposes
```

## 19. Re-attempted Requested Status

METHOD -> POST

### HEADERS

### BODY

Add these variables and their values as ‘Body’ in the API

```
S.no. Variable Condition Format Sample
```
```
1 tracking_number Mandatory Integer 435231300
```
```
2 type Mandatory Integer Check Appendix J
```
```
3 remarks Optional String Remarks
```
RESULT

### {

"status": 0 ,

"message": "Shipment successfully updated as (Re-Attempt - Requested)"

}

### URL

```
https://sonic.pk/api/request/rcp
```
```
Input Description
```
```
Authorization Authentication key which will be used for security purposes
```

## 20. Intercept/Rebook Request

METHOD -> POST

HEADERS

### HEADERS

### BODY

Add these variables and their values as ‘Body’ in the API

Parameters for consignee_type = 1

```
S.no. Variable Condition Format Sample
```
```
1 tracking_number Mandatory Integer 54546464
```
```
2 type Mandatory Integer Check Appendix J
```
```
3 remarks Optional String Remarks
```
```
4 consignee_address Mandatory String Address
```
```
5 consignee_type Mandatory Integer Check Appendix K
```
```
6 consignee_phone_number_1 Mandatory Number Format number
```
### URL

```
https://sonic.pk/api/request/rcp
```
```
Input Description
```
```
Authorization Authentication key which will be used for security purposes
```

Parameters for consignee_type = 2

```
S.no. Variable Condition Format Sample
```
```
1 tracking_number Mandatory Integer 64564871
```
```
2 type Mandatory Integer Check Appendix J
```
```
3 remarks Optional String Remarks
```
```
4 consignee_address Mandatory String Block/ area no
```
```
5 consignee_phone_number_1 Mandatory Number Format 030055443
```
```
6 consignee_city_id Mandatory String Karachi
```
```
7 consignee_type Mandatory Integer Check Appendix K
```
```
7 consignee_name Mandatory String Name
```
```
8 amount Mandatory Integer 5400
```
```
9 consignee_phone_number_2 Optional Number Format 0300254978
```
RESULT

### {

"status": 0 ,

"message": "Intercept/Re-Book request submitted against Tracking Number:

2022021723441"

}


## 21. CRM Request (Complaint)

### METHOD -> POST

### HEADERS

### BODY

Add these variables and their values as ‘Body’ in the API

```
S.no. Variable Condition Format Sample
```
```
1 case_nature_id Mandatory Integer Check Appendix H
```
```
2 tracking_number Mandatory Integer 564674891
```
```
3 case_nature_type_id Mandatory Integer Check Appendix I
```
```
4 description Mandatory String Description
```
RESULT

### {

"status": 0 ,

"message": "CRM Request has been added",

"id": 533

}

### URL

```
https://sonic.pk/api/request/crm
```
```
Input Description
```
```
Authorization Authentication key which will be used for security purposes
```

## 22. CRM Request (Service Request)

METHOD -> POST

### HEADERS

### BODY

Add these variables and their values as ‘Body’ in the API

```
S.no. Variable Condition Format Sample
```
```
1 case_nature_id Mandatory Integer Appendix I
```
```
2 tracking_number Mandatory Integer 564674891
```
```
3 case_nature_type_id Mandatory Integer Appendix J
```
```
4 description Mandatory String Description
```
RESULT

### {

"status": 0 ,

"message": "CRM Request has been added",

"id": 533

}

### URL

```
https://sonic.pk/api/request/crm
```
```
Input Description
```
```
Authorization Authentication key which will be used for security purposes
```

## 23. CRM Request (Claim)

METHOD -> POST

### HEADERS

### BODY

Add these variables and their values as ‘Body’ in the API

```
S.no. Variable Condition Format Sample
```
```
1 case_nature_id Mandatory Integer Appendix H
```
```
2 tracking_number Mandatory Integer 5468779845
```
```
3 case_nature_type_id Optional Integer Appendix I
```
```
4 description^ Mandatory^ String^ description^
```
```
5 product_picture^ Should be image^ Image^ Image^
```
```
6 invoice_picture^ Should be image^ Image^ Image^
```
```
7 product_cost^ Mandatory^ Integer^300
```
```
8 damage_product_price^ Mandatory^ Integer^ Image^
```
```
9 actual_product_picture^ Should be image^ Image^ Image^
```
```
10 product_packaging_picture^ Should be image^ Image^ Image^
```
```
11 damage_product_picture^ Should be image^ Image^ Image^
```
```
12 missing_product_picture^ Should be image^ Image^ Image^
```
```
13 missing_product_price^ Mandatory^ Integer^1256
```
### URL

```
https://sonic.pk/api/request/crm
```
```
Input Description
```
```
Authorization Authentication key which will be used for security purposes
```

RESULT

### {

"status": 0 ,

"message": "CRM Request has been added",

"id": 533

}


## 24. Shipment Status Webhooks

Follow the steps below...

Click on the toggle to get start and enter the URL of your website.

You will get the current status in response like
{
‘tracking_number’ => ‘2232231721462’,
‘status’ => ‘Shipment-Arrived at origin’,
‘date_time’ => ‘2021- 06 - 11’, ‘17:29:36’,
}

Important Points:

- System will attempt the request 5 times.
- Request time out is 3 seconds.
- After 5 attempts your subscription will be blocked and then again you must activate the subscription.
- Your URL should be active when you are activating the subscription.


## 25. Payment Status Webhooks

Follow the steps below...

Click on the toggle to get start and enter the URL of your website.

You will get the current status in response like
{

'tracking_number' => ‘2232231721462’,
'status' => ‘Payment-Processed’
'date_time' => ‘2021- 06 - 11’, ‘17:29:36’,
'payment_id' => ‘ 123456 ’

### }

Important Points:

- System will attempt the request 5 times.
- Request time out is 3 seconds.
- After 5 attempts your subscription will be blocked and then again you must activate the subscription.
- Your URL should be active when you are activating the subscription.


## 26. Initial Charges Webhooks

Follow the steps below...

Click on the toggle to get start and enter the URL of your website.

You will get the current status in response like
{
'tracking_number' => ‘2232231721462’,
'origin' => ‘Lahore’,
'destination' => ‘Lahore’,
'cod_amount' => ‘1000’,
'actual_weight' => ‘1.0’
'chargeable_weight' => ‘1.0’
'weight_charges' => ‘120’
'cash_handling_charges' => ‘0’
'insurance_charges' => ‘0’
'fuel_surcharges' => ‘12’
'gst' => ’15.86’
'total_charges' => ‘137.86’
'net_payable' => ‘862.14’


Important Points:

- System will attempt the request 5 times.
- Request time out is 3 seconds.
- After 5 attempts your subscription will be blocked and then again you must activate the subscription.
- Your URL should be active when you are activating the subscription.

## 27. Final Charges Webhooks

Follow the steps below...

Click on the toggle to get start and enter the URL of your website.

You will get the current status in response like
{
'tracking_number' => ‘2232231721462’,
'origin' => ‘Lahore’,
'destination' => ‘Lahore’,
'cod_amount' => ‘ 1000 ’
'actual_weight' => ‘1.0’
'chargeable_weight' => ‘1.0’
'weight_charges' => ‘ 120 ’


'cash_handling_charges' => ‘ 0 ’
'insurance_charges' => ‘ 0 ’
'fuel_surcharges' => ‘ 12 ’
'packaging_charges' => ‘ 0 ’
'return_charges' => ‘ 0 ’
'replacement_charges' => ‘ 0 ’
'try_buy_charges' => ‘ 0 ’
'intercept_charges' => ‘ 0 ’
'nsa_charges' => ‘ 0 ’
'gst' => ’15.86’
'total_charges' => ‘137.86’
'net_payable' => ‘862.14’

Important Points:

- System will attempt the request 5 times.
- Request time out is 3 seconds.
- After 5 attempts your subscription will be blocked and then again you must activate the subscription.
- Your URL should be active when you are activating the subscription.


Appendix A- Service Type (service_type_id)

### ID

```
Description
```
```
1 Regular
```
```
2 Replacement
```
```
3 Try & Buy
```
Appendix B **–** Item Product Type (item_product_type_id)

```
ID Description
```
```
1 Apparel
```
```
2 Automotive Parts
```
```
3 Accessories
```
```
4 Personal Electronics (Mobile Phones, Laptops, etc.)
```
```
5 Electronics Accessories (Cases, Chargers, etc.)
```
```
6 Gadgets
```
```
7 Jewellery
```
```
8 Cosmetics
```
```
9 Stationery
```
```
10 Handicrafts
```
```
11 Home-made Items
```
```
12 Footwear
```
```
13 Watches
```
```
14 Leather Items
```
```
15 Organic and Health Products
```
```
16 Appliances and Consumer Electronics
```
```
17 Home Decor and Interior Items
```
```
18 Toys
```
```
19 Pet Supplies
```

```
20 Athletics and Fitness Items
```
```
21 Vouchers and Coupons
```
```
22 Marketplace
```
```
23 Documents and Letters
```
```
24 Other
```
Appendix C **–** Shipping Mode (shipping_mode_id)

```
ID Description
```
```
1 Rush
```
```
2 Saver plus
```
```
3 Swift
```
```
4 Same day
```
Appendix D **–** Payment Mode (payment_mode_id)

### ID

```
Description
```
```
1 COD
```
### 2 CCD

```
4 Prepaid
```
Appendix E **–** Status Type (type)

(^)
ID
Description
0 Shipper-related tracking (includes weight and payment
statuses)
1 General Tracking (for consignees, excludes weight and
payment statuses)


Appendix F **–** Mode of collecting Shipping Charges (charges_mode_id)

(^)
ID
Description
3 Invoicing; Note: This mode is only acceptable for a
Corporate Invoicing Account (the account type where
the charges are being invoiced to the shipper and the
shipper would pay the charges on that invoice
4 Reimbursement; Note: This mode is only acceptable
for Reimbursement Account (the account type where
the charges are being deducted during payment of
COD amounts)
Appendix G **–** Delivery Type (delivery_type_id)

### ID

```
Description
```
```
1 Doorstep
```
```
2 Hub to Hub
```
Appendix H **–** Case Nature(case_nature_id)

```
ID Description
```
```
1 Complaint
```
```
2 Service Request
```
```
4 Claim
```
Appendix I **–** Case Nature Type (case_nature_type_id)

```
ID Case Nature ID Case Nature Type
```
```
1 1 Payments
```
```
2 1 Delay in Delivery
```
```
3 1 Delay in Pickup
```
```
4 1 Incorrect COD
```
```
5 1 Return
```
```
6 1 Courier Misbehavior
```
```
7 1 Wrong COD
```

8 1 Booking Portal Issue

9 1 Other

10 1 Fake Reason

11 2 Address Change

12 2 COD Change

13 2 Alternate Contact Number

14 2 Urgent Delivery

15 1 Flyers

16 1 Product/Quality Issue

17 2 Intercept

18 1 Short Contents

19 1 Wrong Delivery/Misroute

20 2 Hold for Self-Collection

21 4 Shipment Damage

22 4 Content Short

23 4 Lost

24 4 Theft & Snatching

25 4 Tariff

26 4 Weight Disputes

27 1 Open Parcel

28 1 Open Parcel Complaint

29 4 Open Parcel Claim

30 1 Issue with Salesperson

31 1 Sales Lead

32 2 Allow to Open Shipment


Appendix J **–** Status Type (type)

```
ID Description
```
```
1 Return Confirm
```
```
2 Re-Attempt Request
```
```
3 Intercept / Rebook
```
Appendix K **–** Consignee Type (consignee_type)

```
ID Description
```
```
1 Same Consignee
```
```
2 Different Consignee
```

