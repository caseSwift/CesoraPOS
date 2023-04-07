
<html>
<head>
    @vite('C:\Users\veljk\OneDrive\Desktop\cesora1\resources\css\app.css')
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>




</head>
<body>

{{--Header--}}
<header class="bg-gray-800 text-gray-100 py-4">
    <div class="container mx-auto flex justify-between items-center px-4">
        <a href="{{ route('main') }}"><h1 class="text-2xl font-bold">Restaurant POS</h1></a>
        <nav>
            <ul class="flex space-x-4">
                <li><a href="/inventory" class="hover:text-gray-300">Inventory</a></li>
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

{{--Buttons--}}
<div class="grid grid-cols-5 gap-4  mt-4">


        @for ($i = 1; $i <= 30; $i++)
            <a class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4" href="{{ route('table.show', ['id' => $i]) }}">
                <button  >Table {{ $i }}</button>
            </a>
        @endfor

</div>
{{--end buttonds--}}




</body>
</html>
