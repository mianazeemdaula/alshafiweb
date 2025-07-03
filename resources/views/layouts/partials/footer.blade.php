<footer>
    <div class="bg-gray-200 p-4">
        <div class="grid lg:grid-cols-4 grid-cols-2 gap-4">
            <div>
                <h1 class="text-lg font-bold mb-4">About Us</h1>
                {{-- links --}}
                <ul class="text-sm space-y-2">
                    <li>
                        <a href="#">About Us</a>
                    </li>
                    <li>
                        <a href="#">Contact Us</a>
                    </li>
                    <li>
                        <a href="#">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="#">Terms & Conditions</a>
                    </li>
                </ul>
            </div>
            <div>
                <h1 class="text-lg font-bold mb-4">Categories</h1>
                {{-- links --}}
                <ul class="text-sm space-y-2">
                    @foreach (\App\Models\Category::take(4)->get() as $item)
                        <li>
                            <a href="#">{{ $item->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h1 class="text-lg font-bold mb-4">About Us</h1>
                <p class="text-sm">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.</p>
            </div>
            <div>
                <h1 class="text-lg font-bold mb-4">Social Medias</h1>
                <ul class="text-sm space-y-2">
                    <li>
                        <a href="#">
                            <i class="fa-brands fa-facebook"></i> Facebook
                        </a>
                    </li>
                    <li>
                        <a href="#"><i class="fa-brands fa-twitter"></i> Twitter</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa-brands fa-instagram"></i> Instagram</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa-brands fa-youtube"></i> Youtube</a>
                    </li>
            </div>
        </div>
    </div>
</footer>
