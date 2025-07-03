@extends('layouts.guest')
@section('title', 'Contact Us')
@section('content')

    <div class="p-8">
        <x-breadcrumb :links="[['name' => 'Home', 'link' => '/'], ['name' => 'Contact Us']]" />
        <div>
            Love to hear from you
        </div>
        <div>
            Feel free to contact us. We will get back to as soon as we can.
        </div>
        <div class="flex">
            <div class="w-8/12 bg-slate-50">
                <form action="" method="post" class="p-4">
                    <div class="flex flex-col space-y-2">
                        <div>
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="w-full border p-2 rounded">
                        </div>
                        <div>
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="w-full border p-2 rounded">
                        </div>
                        <div>
                            <label for="message">Message</label>
                            <textarea name="message" id="message" class="w-full border p-2 rounded"></textarea>
                        </div>
                        <div>
                            <button type="submit" class="bg-primary text-white p-2 rounded">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="flex-1">
                <div class="p-4">
                    <div class="text-xl font-light">Contact Information</div>
                    <div class="flex items center ">
                        <i class="fa fa-phone mx-1"></i>
                        <div>Helpline 4534345656</div>
                    </div>
                    <div class="border border-slate-100 h-4"></div>
                    <div class="flex items-center ">
                        <i class="fa fa-envelope mx-1"></i>
                        <div>
                            <a href="mailto:info@alshafi.com" class="hover:text-primary">info@alshafi.com
                            </a>
                        </div>
                    </div>
                    <div class="border border-slate-100 h-4"></div>
                    <div class="flex items-center ">
                        <i class="fa fa-map-marker-alt mx-1"></i>
                        <div>Address: 123, Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
