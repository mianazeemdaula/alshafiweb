@extends('layouts.guest')

@section('content')
    <!-- Header Section with Gradient -->
    <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-white mb-4">
                    <i class="fas fa-shield-alt mr-3"></i>Privacy Policy
                </h1>
                <p class="text-white/90 text-lg">Last Updated: {{ date('F d, Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 lg:p-12">

            <!-- Introduction -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Your Privacy Matters</h2>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                    Al-Shaafi Dawakhana ("us", "we", or "our") operates the Al-Shaafi Dawakhana website and services.
                    This page informs you of our policies regarding the collection, use, and disclosure of personal data
                    when you use our Service and the choices you have associated with that data.
                </p>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                    We use your data to provide and improve the Service. By using the Service, you agree to the collection
                    and use of information in accordance with this policy.
                </p>
            </div>

            <!-- Section 1: Information We Collect -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold mr-4">
                        1
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Information We Collect</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-4">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Personal Information</h4>
                        <p>When you use our Service, we may ask you to provide certain personally identifiable information:
                        </p>
                        <ul class="list-disc pl-6 space-y-1 mt-2">
                            <li>Name and contact information (email, phone number)</li>
                            <li>Billing and shipping address</li>
                            <li>Payment information (processed securely)</li>
                            <li>Account credentials (username, password)</li>
                            <li>Order history and preferences</li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Usage Data</h4>
                        <p>We may collect information about how the Service is accessed and used:</p>
                        <ul class="list-disc pl-6 space-y-1 mt-2">
                            <li>IP address and device information</li>
                            <li>Browser type and version</li>
                            <li>Pages visited and time spent</li>
                            <li>Referring/exit pages</li>
                            <li>Operating system</li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Location Data</h4>
                        <p>We may use and store information about your location to provide features and improve our Service,
                            particularly for accurate shipping and delivery.</p>
                    </div>
                </div>
            </section>

            <!-- Section 2: Third-Party Authentication -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold mr-4">
                        2
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Third-Party Authentication &
                        Verification</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-4">
                    <p>We offer the option to sign in using third-party authentication services. When you use these
                        services:</p>

                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">
                            <i class="fab fa-facebook text-blue-600 mr-2"></i>Facebook Login
                        </h4>
                        <ul class="list-disc pl-6 space-y-1">
                            <li>We collect your public profile information (name, profile picture)</li>
                            <li>Your email address (if made available)</li>
                            <li>User ID for authentication purposes</li>
                            <li>You can control what information Facebook shares through your Facebook privacy settings</li>
                            <li>We comply with Facebook's Platform Policy and Data Use Policy</li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">
                            <i class="fab fa-google text-red-600 mr-2"></i>Google Sign-In
                        </h4>
                        <ul class="list-disc pl-6 space-y-1">
                            <li>We collect your basic profile information (name, email, profile picture)</li>
                            <li>Google Account ID for authentication</li>
                            <li>You can review and manage permissions through your Google Account settings</li>
                            <li>We comply with Google's API Services User Data Policy</li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">
                            <i class="fab fa-apple text-gray-800 dark:text-white mr-2"></i>Apple Sign-In
                        </h4>
                        <ul class="list-disc pl-6 space-y-1">
                            <li>We collect your name and Apple-verified email address</li>
                            <li>Unique Apple user identifier</li>
                            <li>Apple may provide a private relay email address to protect your privacy</li>
                            <li>We comply with Apple's App Store Review Guidelines</li>
                        </ul>
                    </div>

                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border-l-4 border-blue-500">
                        <p class="font-semibold text-blue-900 dark:text-blue-300 mb-2">
                            <i class="fas fa-info-circle mr-2"></i>Important Note
                        </p>
                        <p class="text-blue-800 dark:text-blue-200">
                            We do not store or have access to your third-party account passwords. Authentication is handled
                            securely by the respective platforms. You can revoke our access at any time through your
                            account settings on the respective platform.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Section 3: How We Use Your Information -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold mr-4">
                        3
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">How We Use Your Information</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>We use the collected data for various purposes:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>To provide and maintain our Service</li>
                        <li>To process your orders and manage payments</li>
                        <li>To notify you about changes to our Service</li>
                        <li>To provide customer support</li>
                        <li>To gather analysis or valuable information to improve our Service</li>
                        <li>To monitor the usage of our Service</li>
                        <li>To detect, prevent and address technical issues</li>
                        <li>To provide you with news, special offers and general information (you can opt-out)</li>
                        <li>To verify your identity through third-party authentication services</li>
                        <li>To personalize your shopping experience</li>
                    </ul>
                </div>
            </section>

            <!-- Section 4: Data Sharing and Disclosure -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold mr-4">
                        4
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Data Sharing and Disclosure</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-4">
                    <p>We may share your personal information in the following situations:</p>

                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Service Providers</h4>
                        <p>We may share your information with third-party service providers to:</p>
                        <ul class="list-disc pl-6 space-y-1 mt-2">
                            <li>Process payments (payment gateways)</li>
                            <li>Deliver products (courier services: TCS, Trax, Leopards)</li>
                            <li>Provide customer support</li>
                            <li>Analyze service usage</li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Legal Requirements</h4>
                        <p>We may disclose your information if required by law or in response to valid requests by public
                            authorities.</p>
                    </div>

                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Business Transfers</h4>
                        <p>In the event of a merger, acquisition, or asset sale, your personal data may be transferred.</p>
                    </div>
                </div>
            </section>

            <!-- Section 5: Cookies and Tracking -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold mr-4">
                        5
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Cookies and Tracking Technologies</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>We use cookies and similar tracking technologies to track activity on our Service:</p>

                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Types of Cookies We Use:</h4>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><strong>Session Cookies:</strong> To operate our Service and maintain your session</li>
                            <li><strong>Preference Cookies:</strong> To remember your preferences and settings</li>
                            <li><strong>Security Cookies:</strong> For security purposes and authentication</li>
                            <li><strong>Analytics Cookies:</strong> To analyze how you use our Service (with your consent)
                            </li>
                        </ul>
                    </div>

                    <p class="mt-3">You can instruct your browser to refuse all cookies or to indicate when a cookie is
                        being sent. However, if you do not accept cookies, you may not be able to use some portions of our
                        Service.</p>
                </div>
            </section>

            <!-- Section 6: Data Security -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold mr-4">
                        6
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Data Security</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>The security of your data is important to us. We implement appropriate security measures including:
                    </p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>SSL/TLS encryption for data transmission</li>
                        <li>Secure password hashing</li>
                        <li>Regular security audits</li>
                        <li>Access controls and authentication</li>
                        <li>Secure data storage practices</li>
                    </ul>
                    <p class="mt-3 text-yellow-700 dark:text-yellow-300 font-semibold">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        However, no method of transmission over the Internet is 100% secure. While we strive to use
                        commercially acceptable means to protect your data, we cannot guarantee absolute security.
                    </p>
                </div>
            </section>

            <!-- Section 7: Your Data Rights -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold mr-4">
                        7
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Your Data Protection Rights</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>You have certain data protection rights. You have the right to:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li><strong>Access:</strong> Request copies of your personal data</li>
                        <li><strong>Rectification:</strong> Request correction of inaccurate or incomplete data</li>
                        <li><strong>Erasure:</strong> Request deletion of your personal data under certain conditions</li>
                        <li><strong>Restrict Processing:</strong> Request restriction of processing your personal data</li>
                        <li><strong>Object to Processing:</strong> Object to our processing of your personal data</li>
                        <li><strong>Data Portability:</strong> Request transfer of your data to another organization</li>
                        <li><strong>Withdraw Consent:</strong> Withdraw your consent at any time where we rely on consent
                        </li>
                    </ul>
                    <p class="mt-3">To exercise any of these rights, please contact us using the information provided
                        below.</p>
                </div>
            </section>

            <!-- Section 8: Data Retention -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold mr-4">
                        8
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Data Retention</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>We will retain your personal data only for as long as necessary for the purposes set out in this
                        Privacy Policy:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>To comply with legal obligations</li>
                        <li>To resolve disputes</li>
                        <li>To enforce our legal agreements and policies</li>
                        <li>For business and tax records as required by law</li>
                    </ul>
                    <p class="mt-3">Usage data is generally retained for a shorter period, except when used for security
                        purposes or to improve Service functionality.</p>
                </div>
            </section>

            <!-- Section 9: Children's Privacy -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold mr-4">
                        9
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Children's Privacy</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>Our Service does not address anyone under the age of 13. We do not knowingly collect personally
                        identifiable information from anyone under 13.</p>
                    <p>If you are a parent or guardian and you are aware that your child has provided us with personal data,
                        please contact us so we can take necessary action.</p>
                </div>
            </section>

            <!-- Section 10: International Data Transfers -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold mr-4">
                        10
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">International Data Transfers</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>Your information may be transferred to — and maintained on — computers located outside of your
                        country or jurisdiction where data protection laws may differ.</p>
                    <p>Your consent to this Privacy Policy followed by your submission of such information represents your
                        agreement to that transfer.</p>
                </div>
            </section>

            <!-- Section 11: Changes to Privacy Policy -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold mr-4">
                        11
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Changes to This Privacy Policy</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>We may update our Privacy Policy from time to time. We will notify you of any changes by:</p>
                    <ul class="list-disc pl-6 space-y-1">
                        <li>Posting the new Privacy Policy on this page</li>
                        <li>Updating the "Last Updated" date at the top</li>
                        <li>Sending you an email notification (for significant changes)</li>
                    </ul>
                    <p class="mt-3">You are advised to review this Privacy Policy periodically for any changes. Changes
                        are effective when posted on this page.</p>
                </div>
            </section>

            <!-- Third-Party Links -->
            <section class="mb-10">
                <div class="flex items-center mb-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold mr-4">
                        12
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Links to Other Sites</h3>
                </div>
                <div class="ml-14 text-gray-700 dark:text-gray-300 space-y-3">
                    <p>Our Service may contain links to other sites that are not operated by us. We strongly advise you to
                        review the Privacy Policy of every site you visit.</p>
                    <p>We have no control over and assume no responsibility for the content, privacy policies, or practices
                        of any third-party sites or services.</p>
                </div>
            </section>

            <!-- Contact Information -->
            <section
                class="mt-12 p-6 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-gray-700 dark:to-gray-600 rounded-xl">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-envelope mr-2"></i>Contact Us About Your Privacy
                </h3>
                <p class="text-gray-700 dark:text-gray-300 mb-4">
                    If you have any questions about this Privacy Policy, or wish to exercise your data protection rights,
                    please contact us:
                </p>
                <div class="space-y-2 text-gray-700 dark:text-gray-300">
                    <p><i class="fas fa-building mr-2 text-blue-600"></i><strong>Al-Shaafi Dawakhana</strong></p>
                    <p><i class="fas fa-phone mr-2 text-green-600"></i>Phone: +92 325 3257878</p>
                    <p><i class="fas fa-envelope mr-2 text-purple-600"></i>Email: info@alshaafi.com</p>
                    <p><i class="fas fa-map-marker-alt mr-2 text-red-600"></i>Address: Depal Pur, Pakistan</p>
                </div>

                <div class="mt-6 p-4 bg-white dark:bg-gray-800 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <i class="fas fa-clock mr-2"></i>
                        We aim to respond to all privacy-related inquiries within 30 days.
                    </p>
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
