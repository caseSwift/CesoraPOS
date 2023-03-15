@vite('C:\Users\veljk\OneDrive\Desktop\cesora1\resources\css\app.css')

{{--Header--}}
<header class="bg-gray-800 text-gray-100 py-4">
    <div class="container mx-auto flex justify-between items-center px-4">
        <h1 class="text-2xl font-bold">Restaurant POS</h1>
        <nav>
            <ul class="flex space-x-4">
                <li><a href="#" class="hover:text-gray-300">Menu</a></li>
                <li><a href="#" class="hover:text-gray-300">Orders</a></li>
                <li><a href="#" class="hover:text-gray-300">Settings</a></li>
                @if(auth()->check() && auth()->user()->hasRole('administrator'))
                    <li><a href="#" class="hover:text-gray-300">Administrator</a></li>
                @endif
                <li><a href="#" class="hover:text-gray-300"><form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit">Logout</button>
                        </form>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>
{{--End of Header--}}
<div class="grid grid-cols-2 grid-rows-2 h-full">
    <div class="bg-gray-100 col-span-1 row-span-1">quad
        <input type="search" id="search-dropdown" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg border-l-gray-100 border-l-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Search" required="">
    </div>
{{--    quad 2--}}
    <div class="bg-gray-200 col-span-1 row-span-1">
        <div class="bg-gray-200 col-span-1 row-span-1">
            <h2 class="text-lg font-medium mb-4">Articles</h2>
            <div class="flex space-x-2">
                @foreach($articleTypes as $articleType)
                    <form action="{{ route('table.show', ['id' => request()->route('id')]) }}" method="get">

                    <button type="submit" class="p-2 flex-grow bg-blue-500 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">{{ $articleType }}</button>
                        <input type="hidden" name="type" value="{{ $articleType }}">
                    </form>
                @endforeach
            </div>
            <div class="mt-4">
                @if($type)
                    <h3 class="text-md font-medium mb-2">Articles of type {{ $type }}</h3>
                    @foreach($articles as $article)
                        <button class="bg-orange-500 p-2 flex-grow  hover:bg-orange-600 text-white font-bold py-2 px-4 rounded">{{ $article->name }}</button>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
{{--    end quad2--}}
    <div class="bg-gray-300 col-span-1 row-span-1">3 </div>
    <div class="bg-gray-400 col-span-1 row-span-1">4</div>
</div>

