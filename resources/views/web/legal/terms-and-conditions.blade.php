@extends('layouts.guest')

@section('content')
    <!-- Header Section -->
    <div class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="max-w-2xl">
                <span class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 dark:text-emerald-400">Legal</span>
                <h1 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                    Terms and Conditions
                </h1>
                <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">Last Updated: {{ date('F d, Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 lg:p-12">

            <!-- Introduction -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Welcome to Al-Shaafi Dawakhana</h2>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                    These Terms and Conditions ("Terms", "Terms and Conditions") govern your relationship with
                    the Al-Shaafi Dawakhana website and services operated by Al-Shaafi Dawakhana ("us", "we", or "our").
                </p>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                    Please read these Terms and Conditions carefully before using our Service. Your access to and use
                    of the Service is conditioned on your acceptance of and compliance with these Terms.
                </p>
            </div>

            <!-- Section 1: Acceptance of Terms -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold mr-4">
                        1
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Acceptance of Terms</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>By accessing or using our services, you agree to be bound by these Terms. If you disagree with any
                        part of the terms, you may not access the service.</p>
                    <p>These Terms apply to all visitors, users, and others who access or use the Service.</p>
                </div>
            </section>

            <!-- Section 2: Use of Service -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold mr-4">
                        2
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Use of Service</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>You agree to use our services only for lawful purposes and in accordance with these Terms. You agree
                        not to use the service:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>In any way that violates any applicable national or international law or regulation</li>
                        <li>To transmit, or procure the sending of, any advertising or promotional material without our
                            prior written consent</li>
                        <li>To impersonate or attempt to impersonate the Company, a Company employee, another user, or any
                            other person or entity</li>
                        <li>In any way that infringes upon the rights of others, or in any way is illegal, threatening,
                            fraudulent, or harmful</li>
                    </ul>
                </div>
            </section>

            <!-- Section 3: Account Registration -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold mr-4">
                        3
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Account Registration</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>To access certain features of our Service, you may be required to create an account. You agree to:
                    </p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Provide accurate, current, and complete information during registration</li>
                        <li>Maintain and promptly update your account information</li>
                        <li>Maintain the security of your password and account</li>
                        <li>Accept all responsibility for activities that occur under your account</li>
                        <li>Notify us immediately of any unauthorized use of your account</li>
                    </ul>
                </div>
            </section>

            <!-- Section 4: Products and Services -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold mr-4">
                        4
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Products and Services</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>All products and services are subject to availability. We reserve the right to:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Limit the quantities of any products or services we offer</li>
                        <li>Discontinue any product at any time</li>
                        <li>Refuse any order you place with us</li>
                        <li>Make changes to or discontinue the Service without notice</li>
                    </ul>
                    <p class="mt-3">Product images are for illustration purposes only. Actual products may vary.</p>
                </div>
            </section>

            <!-- Section 5: Pricing and Payment -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold mr-4">
                        5
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Pricing and Payment</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>All prices are listed in Pakistani Rupees (PKR) and are subject to change without notice.</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Prices include applicable taxes unless otherwise stated</li>
                        <li>Payment is due at the time of purchase or as specified</li>
                        <li>We accept Cash on Delivery (COD) and other payment methods as indicated</li>
                        <li>We reserve the right to refuse or cancel orders at our discretion</li>
                    </ul>
                </div>
            </section>

            <!-- Section 6: Shipping and Delivery -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold mr-4">
                        6
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Shipping and Delivery</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>We ship products using various courier services including TCS, Trax, and Leopards.</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Delivery times are estimates and not guaranteed</li>
                        <li>We are not responsible for delays caused by courier services</li>
                        <li>You must provide accurate shipping information</li>
                        <li>Risk of loss passes to you upon delivery to the courier service</li>
                        <li>Tracking information will be provided when available</li>
                    </ul>
                </div>
            </section>

            <!-- Section 7: Returns and Refunds -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold mr-4">
                        7
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Returns and Refunds</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>Our return and refund policy is subject to the following conditions:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Products must be returned in original condition and packaging</li>
                        <li>Return requests must be made within the specified timeframe</li>
                        <li>Refunds will be processed according to our refund policy</li>
                        <li>Certain products may not be eligible for return due to health and safety reasons</li>
                    </ul>
                </div>
            </section>

            <!-- Section 8: Intellectual Property -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold mr-4">
                        8
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Intellectual Property</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>The Service and its original content, features, and functionality are and will remain the exclusive
                        property of Al-Shaafi Dawakhana.</p>
                    <p>Our trademarks and trade dress may not be used in connection with any product or service without our
                        prior written consent.</p>
                </div>
            </section>

            <!-- Section 9: User Content -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold mr-4">
                        9
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">User Content and Reviews</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>You may submit reviews, comments, and other content. By submitting content, you grant us:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>A worldwide, non-exclusive, royalty-free license to use, reproduce, and display such content
                        </li>
                        <li>The right to moderate, edit, or remove content that violates these Terms</li>
                        <li>You represent that you own or have the necessary rights to the content you submit</li>
                    </ul>
                </div>
            </section>

            <!-- Section 10: Third-Party Verification Services -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold mr-4">
                        10
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Third-Party Verification Services</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>When you use third-party services (such as Facebook Login, Google Sign-In, etc.) to access our
                        platform:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>You authorize us to access and use certain information from your third-party account as
                            permitted by that service</li>
                        <li>We are not responsible for the privacy practices or content of third-party services</li>
                        <li>Your use of third-party services is subject to their respective terms and privacy policies</li>
                        <li>We may collect profile information, email address, and other publicly available information as
                            permitted</li>
                        <li>You can revoke our access to your third-party account at any time through that service's
                            settings</li>
                    </ul>
                    <p class="mt-3 font-semibold">Supported Verification Platforms:</p>
                    <ul class="list-disc pl-6 space-y-1">
                        <li>Facebook - Subject to Facebook's Terms of Service and Data Policy</li>
                        <li>Google - Subject to Google's Terms of Service and Privacy Policy</li>
                        <li>Apple - Subject to Apple's Terms of Service and Privacy Policy</li>
                    </ul>
                </div>
            </section>

            <!-- Section 11: Limitation of Liability -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold mr-4">
                        11
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Limitation of Liability</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>In no event shall Al-Shaafi Dawakhana be liable for any indirect, incidental, special, consequential,
                        or punitive damages resulting from:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Your access to or use of the Service</li>
                        <li>Any content obtained from the Service</li>
                        <li>Unauthorized access to or alteration of your data</li>
                        <li>Any other matter relating to the Service</li>
                    </ul>
                </div>
            </section>

            <!-- Section 12: Disclaimer -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold mr-4">
                        12
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Disclaimer</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>Your use of the Service is at your sole risk. The Service is provided on an "AS IS" and "AS
                        AVAILABLE" basis without warranties of any kind.</p>
                    <p class="font-semibold text-red-600 dark:text-red-400">Health Disclaimer:</p>
                    <p>Our products are traditional herbal remedies. Always consult with a qualified healthcare professional
                        before using any herbal products, especially if you have existing medical conditions or are taking
                        medications.</p>
                </div>
            </section>

            <!-- Section 13: Governing Law -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold mr-4">
                        13
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Governing Law</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>These Terms shall be governed by and construed in accordance with the laws of Pakistan, without
                        regard to its conflict of law provisions.</p>
                </div>
            </section>

            <!-- Section 14: Changes to Terms -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold mr-4">
                        14
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Changes to Terms</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>We reserve the right to modify or replace these Terms at any time. We will provide notice of any
                        material changes by:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Posting the new Terms on this page</li>
                        <li>Updating the "Last Updated" date</li>
                        <li>Sending you an email notification (if applicable)</li>
                    </ul>
                    <p class="mt-3">Your continued use of the Service after changes constitutes acceptance of the new
                        Terms.</p>
                </div>
            </section>

            <!-- Contact Information -->
            <section
                class="mt-12 p-6 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-gray-700 dark:to-gray-600 rounded-xl">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-envelope mr-2"></i>Contact Us
                </h3>
                <p class="text-gray-700 dark:text-gray-300 mb-4">
                    If you have any questions about these Terms and Conditions, please contact us:
                </p>
                <div class="space-y-2 text-gray-700 dark:text-gray-300">
                    <p><i class="fas fa-building mr-2 text-blue-600"></i><strong>Al-Shaafi Dawakhana</strong></p>
                    <p><i class="fas fa-phone mr-2 text-green-600"></i>Phone: +92 325 325 55 55</p>
                    <p><i class="fas fa-envelope mr-2 text-purple-600"></i>Email: info@alshaafi.com</p>
                    <p><i class="fas fa-map-marker-alt mr-2 text-red-600"></i>Address: Depal Pur, Pakistan</p>
                </div>
            </section>
        </div>

        <!-- Back to Home Button -->
        <div class="text-center mt-8">
            <a href="{{ route('web.home') }}"
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                <i class="fas fa-home mr-2"></i>
                Back to Home
            </a>
        </div>
    </div>
@endsection
