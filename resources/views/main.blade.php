
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

{{--Buttons--}}
<div class="grid grid-cols-5 gap-4  mt-4">

    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 1</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 2</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 3</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 4</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 5</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 6</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 7</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 8</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 9</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 10</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 11</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 12</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 13</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 14</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 15</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 16</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 17</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 18</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 19</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 20</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 21</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 22</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 23</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 24</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 25</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 26</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 27</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 28</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 29</button>
    <button class="bg-gray-200 hover:bg-gray-300 rounded-lg p-4">Table 30</button>

</div>
{{--end buttonds--}}




</body>
</html>
